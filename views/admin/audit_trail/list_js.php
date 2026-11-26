<script>
function submitFilter(e) {
	if (e.keyCode === 13) {
		document.forms.frm_manage.submit();
		return false;
	}

	return true;
}

$(function () {
	var detailUrl = '<?= $detail_url ?>';
	var siteUrl = '<?= site_url() ?>';

	function escapeHtml(value) {
		return $('<div>').text(value === null || typeof value === 'undefined' ? '' : String(value)).html();
	}

	function escapeAttr(value) {
		return String(value)
			.replace(/&/g, '&amp;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;');
	}

	function parseJson(value) {
		if (value === null || value === '' || typeof value === 'undefined') {
			return {};
		}

		if (typeof value === 'object') {
			return value;
		}

		try {
			return JSON.parse(value) || {};
		} catch (e) {
			return { _raw: value };
		}
	}

	function isSensitive(key) {
		return /(password|passwd|pass_hash|token|secret|api_key|authorization|remember_token)/i.test(key);
	}

	function isFileValue(key, value) {
		if (typeof value !== 'string' || value === '') {
			return false;
		}

		if (/^(https?:\/\/|\/)/i.test(value)) {
			return true;
		}

		return /^(uploads|assets|files|temp)\//i.test(value) ||
			/(file|attachment|photo|image|img|document|passport|loa|statement|cv)/i.test(key);
	}

	function renderValue(key, value) {
		if (value === null || typeof value === 'undefined' || value === '') {
			return '-';
		}

		if (isSensitive(key)) {
			return '&bull;&bull;&bull;&bull;';
		}

		if (typeof value === 'object') {
			return '<pre class="audit-json">' + escapeHtml(JSON.stringify(value, null, 2)) + '</pre>';
		}

		if (typeof value === 'boolean') {
			return value ? 'Yes' : 'No';
		}

		if (isFileValue(key, value)) {
			var href = /^https?:\/\//i.test(value) ? value : siteUrl + String(value).replace(/^\/+/, '');
			return '<a href="' + escapeAttr(href) + '" target="_blank" rel="noopener"><i class="fa fa-paperclip"></i> View file</a>';
		}

		var text = String(value);
		if (text.indexOf('\n') !== -1 || text.length > 120) {
			return '<pre class="audit-json">' + escapeHtml(text) + '</pre>';
		}

		return escapeHtml(text);
	}

	function renderMeta(data) {
		var role = data.role_label || data.role || '';
		if (data.staff_role_name) {
			role += ' - ' + data.staff_role_name;
		}

		var lines = [];

		lines.push('Event: ' + (data.event || '-'));
		lines.push('Table: ' + (data.table_name || '-'));
		lines.push('Record ID: ' + (data.table_id || '-'));
		lines.push('Changed By: ' + (data.created_name || '-') + (role ? ' (' + role + ')' : ''));
		if (data.country_label) {
			lines.push('Country: ' + data.country_label);
		}
		lines.push('Changed At: ' + (data.created_at || '-'));

		if (data.url) {
			lines.push('Source: ' + data.url);
		}

		return lines.map(escapeHtml).join('<br>');
	}

	function renderTable(data) {
		var oldData = parseJson(data.old_values);
		var newData = parseJson(data.new_values);
		var keys = [];

		$.each([oldData, newData], function (_, object) {
			$.each(Object.keys(object || {}), function (_, key) {
				if (keys.indexOf(key) === -1) {
					keys.push(key);
				}
			});
		});

		keys.sort();

		if (!keys.length) {
			return '<tr><td colspan="3" class="text-center">No value recorded.</td></tr>';
		}

		var html = '';
		$.each(keys, function (_, key) {
			var oldValue = Object.prototype.hasOwnProperty.call(oldData, key) ? oldData[key] : null;
			var newValue = Object.prototype.hasOwnProperty.call(newData, key) ? newData[key] : null;

			html += '<tr>';
			html += '<td>' + escapeHtml(key) + '</td>';
			html += '<td>' + renderValue(key, oldValue) + '</td>';
			html += '<td>' + renderValue(key, newValue) + '</td>';
			html += '</tr>';
		});

		return html;
	}

	$(document).on('click', '.btn-audit-detail', function () {
		var id = $(this).data('id');

		$('#audit-detail-meta').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
		$('#audit-detail-table tbody').html('');
		$('#auditDetailModal').modal('show');

		$.ajax({
			url: detailUrl + id,
			dataType: 'json',
			success: function (response) {
				if (!response || !response.status) {
					$('#audit-detail-meta').html('Audit trail not found.');
					return;
				}

				$('#audit-detail-meta').html(renderMeta(response.data));
				$('#audit-detail-table tbody').html(renderTable(response.data));
			},
			error: function () {
				$('#audit-detail-meta').html('Failed to load audit detail.');
			}
		});
	});
});
</script>
