"""
Lightweight Python CodeIgniter View Mock-Renderer for AMINEF Portal
Renders real .php files from ../views (Original) and ./views (Revamped)
with dummy data so they can be previewed and compared in the browser without PHP/DB.
"""
import html
import os
import re
import urllib.parse
from http.server import HTTPServer, SimpleHTTPRequestHandler

REVAMP_DIR = os.path.dirname(os.path.abspath(__file__))
ROOT_DIR = os.path.dirname(REVAMP_DIR)
ORIG_VIEWS = os.path.join(ROOT_DIR, "views")
REVAMP_VIEWS = os.path.join(REVAMP_DIR, "views")

DUMMY_VARS = {
    "title": "Leave Request",
    "page_title": "AMINEF Portal",
    "state": "California",
    "state_id": "1",
    "country_id": "2",
    "q": "",
    "sort_by": "name",
    "sort": "asc",
    "display_name": "Abiyu Brin1",
    "initials": "AB",
    "announcement": "",
    "total_users": "1482",
    "total_programs": "24",
    "total_study_fields": "96",
}

CDN_HEAD_INJECT = """
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Minimal SB Admin 2 layout fallback for standalone views */
  body.legacy-view { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background: #f8f8f8; }
  body.legacy-view .navbarheader { background: #013473; min-height: 71px; margin-bottom: 0; border: 0; }
  body.legacy-view .sidebar { background: #f8f8f8; border-right: 1px solid #e7e7e7; }
  @media (min-width: 768px) {
    .sidebar { position: absolute; width: 250px; }
    #page-wrapper { margin-left: 250px; padding: 20px 30px; min-height: 100vh; }
    body.aminef-revamp .sidebar { width: 252px; }
    body.aminef-revamp #page-wrapper { margin-left: 252px; }
  }
  .huge { font-size: 36px; font-weight: 700; }
  .panel-green { border-color: #5cb85c; }
  .panel-green > .panel-heading { background-color: #5cb85c; color: #fff; border-color: #5cb85c; }
  .panel-red { border-color: #d9534f; }
  .panel-red > .panel-heading { background-color: #d9534f; color: #fff; border-color: #d9534f; }
</style>
"""

CDN_SCRIPTS_INJECT = """
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/aminef-ui.js"></script>
"""


def mock_php_to_html(php_code: str, prog: str = "indo") -> str:
    """Replace common CodeIgniter PHP tags with readable mock HTML."""
    country_label = "Indonesian" if prog == "indo" else "American"
    active_country_val = "1" if prog == "indo" else "2"

    # Strip PHP comments /* ... */ inside <?php ?>
    code = re.sub(r"<\?php\s*/\*.*?\*/\s*\?>", "", php_code, flags=re.S)

    # Replace echo / <?= ... ?> expressions
    def repl_echo(match):
        expr = match.group(1).strip()
        if "base_url" in expr or "site_url" in expr:
            m = re.search(r"['\"]([^'\"]+)['\"]", expr)
            return "/" + m.group(1).lstrip("/") if m else "/"
        if "active_country" in expr or "grantee_country_id" in expr:
            return f"{country_label} Database"
        if "display_name" in expr or "get_full_name" in expr:
            return "Abiyu Brin1" if prog == "indo" else "Michael Miller"
        if "initials" in expr:
            return "AB" if prog == "indo" else "MM"
        if "paging['html']" in expr:
            return '<ul class="pagination pagination-sm pull-right"><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li></ul>'
        if "paging['start_row']" in expr:
            return "1"
        if "paging['end_row']" in expr or "paging['total_rows']" in expr:
            return "10"
        for k, v in DUMMY_VARS.items():
            if f"${k}" in expr:
                return v
        if "number_format" in expr:
            return "1,250"
        if "date(" in expr:
            return "25 Nov 2026"
        if "->name" in expr or "->title" in expr:
            return "Sample Program / City (2026)" if prog == "indo" else "U.S. Fulbright Program (2026)"
        if "->fiscal_year" in expr or "->year" in expr:
            return "2026"
        if "->status" in expr:
            return "Approved"
        if "$no" in expr:
            return "1"
        if "$row->" in expr or "$item->" in expr or "$user->" in expr or "$grantee_grant->" in expr:
            return "Sample Data"
        return ""

    code = re.sub(r"<\?=\s*(.*?)\s*\?>", repl_echo, code, flags=re.S)
    code = re.sub(r"<\?php\s+echo\s+(.*?);?\s*\?>", repl_echo, code, flags=re.S)

    # Handle simple Indonesian vs American database check in navbar
    if prog == "indo":
        code = code.replace("INDONESIAN_DATABASE", "1").replace("AMERICAN_DATABASE", "2")
    else:
        code = code.replace("INDONESIAN_DATABASE", "2").replace("AMERICAN_DATABASE", "1")

    # Strip remaining <?php ... ?> control blocks so HTML renders cleanly
    code = re.sub(r"<\?php.*?\?>", "", code, flags=re.S)
    code = re.sub(r"<\?.*?\?>", "", code, flags=re.S)
    return code


def resolve_view_path(view_rel: str, mode: str) -> str:
    clean = view_rel.lstrip("/").replace("..", "")
    if mode == "revamp":
        candidate = os.path.join(REVAMP_VIEWS, clean)
        if os.path.isfile(candidate):
            return candidate
    return os.path.join(ORIG_VIEWS, clean)


def render_full_view(view_rel: str, mode: str, prog: str) -> str:
    view_path = resolve_view_path(view_rel, mode)
    if not os.path.isfile(view_path):
        return f"<h2>View not found: {html.escape(view_rel)}</h2>"

    with open(view_path, "r", encoding="utf-8", errors="replace") as f:
        raw_view = f.read()

    body_html = mock_php_to_html(raw_view, prog=prog)
    is_grantee = view_rel.startswith("grantee/")
    is_revamp = mode == "revamp"

    ctx_label = (
        ("Indonesian Database" if prog == "indo" else "American Database")
        if not is_grantee
        else ("Indonesian Program" if prog == "indo" else "American Program")
    )
    if is_revamp:
        ctx_cls = "aminef-context-pill--indo" if prog == "indo" else "aminef-context-pill--us"
        ctx_html = f'<span class="aminef-context-pill {ctx_cls}"><span class="ctx-dot"></span>{ctx_label}</span>'
    else:
        ctx_html = f'<div style="color:#fff;font-size:20px;">{ctx_label}</div>'

    revamp_css = '<link rel="stylesheet" href="/assets/css/aminef-revamp.css">' if is_revamp else ""
    body_cls = "aminef-revamp" if is_revamp else "legacy-view"

    return f"""<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{html.escape(view_rel)} ({mode})</title>
  {CDN_HEAD_INJECT}
  {revamp_css}
</head>
<body class="{body_cls}">
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top navbarheader" role="navigation" style="margin-bottom:0">
      <div class="admin-navbar-main" style="display:flex;align-items:center;padding:0 20px;min-height:56px;gap:14px;">
        <span class="brand-lockup-text" style="color:#fff;font-weight:800;font-size:17px;">AMINEF</span>
        {ctx_html}
        <span class="topbar-path-label" style="margin-left:auto;color:#fff;font-size:12.5px;">{html.escape(view_rel)}</span>
      </div>
    </nav>
    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
          <li><a class="{'active' if 'dashboard' in view_rel else ''}" href="/render?view=admin/dashboard/dashboard.php&mode={mode}&prog={prog}"><i class="fa fa-dashboard fa-fw"></i> Admin: Dashboard</a></li>
          <li><a class="{'active' if 'announcement' in view_rel else ''}" href="/render?view=admin/announcement/list.php&mode={mode}&prog={prog}"><i class="fa fa-bullhorn fa-fw"></i> Admin: Announcement</a></li>
          <li><a class="{'active' if 'city' in view_rel else ''}" href="/render?view=admin/city/list.php&mode={mode}&prog={prog}"><i class="fa fa-map-marker fa-fw"></i> Admin: City List</a></li>
          <li><a class="{'active' if 'allowance' in view_rel else ''}" href="/render?view=admin/allowance/list.php&mode={mode}&prog={prog}"><i class="fa fa-money fa-fw"></i> Admin: Allowance</a></li>
          <li><a class="{'active' if 'payment' in view_rel else ''}" href="/render?view=grantee/payment/list.php&mode={mode}&prog={prog}"><i class="fa fa-credit-card fa-fw"></i> Grantee: Payment</a></li>
          <li><a class="{'active' if 'leaves' in view_rel else ''}" href="/render?view=grantee/leaves/list.php&mode={mode}&prog={prog}"><i class="fa fa-calendar fa-fw"></i> Grantee: Leaves</a></li>
        </ul>
      </div>
    </div>
    <div id="page-wrapper">
      {body_html}
    </div>
  </div>
  {CDN_SCRIPTS_INJECT}
</body>
</html>"""


class AminefViewHandler(SimpleHTTPRequestHandler):
    def translate_path(self, path):
        parsed = urllib.parse.urlparse(path).path
        rel = parsed.lstrip("/")
        return os.path.join(REVAMP_DIR, rel)

    def do_GET(self):
        parsed = urllib.parse.urlparse(self.path)
        if parsed.path == "/render":
            qs = urllib.parse.parse_qs(parsed.query)
            view = qs.get("view", ["admin/city/list.php"])[0]
            mode = qs.get("mode", ["revamp"])[0]
            prog = qs.get("prog", ["indo"])[0]
            output = render_full_view(view, mode, prog).encode("utf-8")
            self.send_response(200)
            self.send_header("Content-Type", "text/html; charset=utf-8")
            self.send_header("Content-Length", str(len(output)))
            self.end_headers()
            self.wfile.write(output)
            return

        if parsed.path == "/api/views":
            all_views = []
            for area in ("admin", "grantee"):
                base = os.path.join(ORIG_VIEWS, area)
                for root, _, files in os.walk(base):
                    for fn in sorted(files):
                        if fn.endswith(".php") and not fn.endswith("_js.php"):
                            rel = os.path.relpath(os.path.join(root, fn), ORIG_VIEWS).replace("\\", "/")
                            all_views.append(rel)
            import json
            payload = json.dumps(all_views).encode("utf-8")
            self.send_response(200)
            self.send_header("Content-Type", "application/json")
            self.send_header("Content-Length", str(len(payload)))
            self.end_headers()
            self.wfile.write(payload)
            return

        return super().do_GET()


if __name__ == "__main__":
    server = HTTPServer(("127.0.0.1", 8766), AminefViewHandler)
    print("AMINEF View Mock-Renderer running at http://localhost:8766")
    server.serve_forever()
