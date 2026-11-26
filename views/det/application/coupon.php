<style>
.success-banner{
    background:linear-gradient(135deg,#1a8aa6,#0991b2);
    color:#fff;
    border-radius:16px;
    padding:10px;
    text-align:center;
    box-shadow:0 12px 30px rgba(37,99,235,.25);
    margin-bottom:30px
}
.panel{
    border:0;
    border-radius:14px !important;
    box-shadow:0 4px 18px rgba(0,0,0,.08);
    overflow:hidden
}
.panel-heading{
    padding:16px 20px !important;
    font-weight:bold;
    border:0
}
.panel-default .panel-heading{
    background:#f8fafc;
    color: #64748b;
    text-align : left;
}
.panel-danger .panel-heading{
    background:#ef4444;
    color:#fff
}
.panel-primary .panel-heading{
    background:#2563eb;
    color:#fff
}
.panel-info .panel-heading{
    background:#0891b2;
    color:#fff
}
.panel-body{
    padding:22px;
    border-radius : 0px !important;
}
.info-box{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:12px;
    padding:18px;
    margin-bottom:15px
}
.info-box label{
    font-size:12px;
    text-transform:uppercase;
    color:#64748b
}
.value{
    font-size:22px;
    font-weight:bold
}
.coupon{
    letter-spacing:3px;
    color:#2563eb
}
.alert{
    border:0;
    border-radius:10px
}
.ul-panel li{
    padding:4px 0
}

.hero-banner {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border-radius: 8px;
    padding: 24px 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15);
    margin-bottom: 20px;
}
.hero-icon {
    width: 44px;
    height: 44px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 8px;
}
.hero-title { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
.hero-desc { font-size: 13px; color: #e0f2fe; max-width: 600px; margin: 0 auto; }

/* Coupon Voucher Ticket Card */
.voucher-card {
    background: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 8px;
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    margin-bottom: 20px;
}
.voucher-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 6px;
    padding: 16px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.voucher-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
.voucher-value { font-size: 18px; font-weight: 700; color: #1e293b; }

.coupon-highlight {
    font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
    font-size: 22px;
    font-weight: 800;
    color: #0284c7;
    letter-spacing: 2px;
    background: #e0f2fe;
    padding: 6px 14px;
    border-radius: 6px;
    display: inline-block;
    margin-bottom: 8px;
}

.btn-copy {
    background-color: #003366;
    color: #ffffff;
    border: none;
    padding: 6px 14px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-copy:hover { background-color: #002244; }

/* 2-Column Info Grid */
.grid-layout-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-card {
    background: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.info-header {
    padding: 12px 18px;
    font-size: 13px;
    font-weight: 700;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-header.primary { background-color: #f8fafc; color: #1e293b; }
.info-header.terms { background-color: #fffbeb; color: #92400e; border-bottom-color: #fef3c7; }
.info-body { padding: 18px; font-size: 13px; flex-grow: 1; }

.info-body ul {
    padding-left: 18px;
    color: #475569;
    margin: 0;
}
.info-body ul li {
    margin-bottom: 8px;
    line-height: 1.4;
}
.info-body ul li:last-child { margin-bottom: 0; }

/* Contact Table inside Card */
.contact-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.contact-table td {
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}
.contact-table tr:last-child td { border-bottom: none; }
.contact-name { font-weight: 600; color: #1e293b; width: 35%; }
.contact-email a { color: #0284c7; text-decoration: none; font-weight: 500; }
.contact-email a:hover { text-decoration: underline; }

/* Callout Notice */
.callout-warning {
    background-color: #fffdf0;
    border: 1px solid #fef08a;
    border-left: 4px solid #eab308;
    color: #854d0e;
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 13px;
    margin-top: 14px;
}

/* Locked State (Agreement belum selesai) */
.locked-card {
    background: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 8px;
    padding: 40px 20px;
    text-align: center;
    color: #64748b;
}
.locked-icon { font-size: 40px; margin-bottom: 12px; }
</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Duolingo English Test - Coupon Code</h2>
    </div>
</div>


<div class="container mt-5">
    <div class="hero-banner">
        <div class="hero-icon">✓</div>
        <div class="hero-title">Congratulations!</div>
        <div class="hero-desc">
            You have been selected to receive an official Duolingo English Test (DET) fee coupon sponsored by AMINEF.
        </div>
    </div>

    <!-- LAYOUT OPTION A: VOUCHER TICKET STYLE -->
    <div id="layoutA">
        <!-- Voucher Card Box -->
        <div class="voucher-card">
            <div class="voucher-box">
                <div class="voucher-label">Assigned Testing Period</div>
                <?php 
                    $today = new DateTime();
                    $today->setTime(0, 0, 0);
                    $end_date = new DateTime($application->testing_date_end);
                    $end_date->setTime(0, 0, 0);
                ?>
                <?php if($today > $end_date) { ?>
                    <div class="voucher-value" id="periodText" style="color: rgb(239, 68, 68);">Expired on <?= formatDateRange($application->testing_date_end) ?></div>
                <?php } else { ?>
                    <div class="voucher-value" id="periodText"><?= formatDateRange($application->testing_date, $application->testing_date_end) ?></div>
                <?php } ?>
                <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Schedule is fixed & cannot be extended</div>
            </div>
            <div class="voucher-box">
                <div class="voucher-label">Official Coupon Code</div>
                <div>
                    <?php if($today > $end_date) { ?>
                        <span class="coupon-highlight" id="couponText" style="color: rgb(239, 68, 68); background: rgb(254, 226, 226);">EXPIRED</span>
                    <?php } else { ?>
                        <span class="coupon-highlight" id="couponText"><?= $application->coupon ?></span>
                    <?php } ?>
                </div>
                <button type="button" class="btn-copy" onclick="copyCouponCode()">Copy Code</button>
            </div>
        </div>

        <!-- Info 2 Columns -->
        <div class="grid-layout-2">
            <!-- Left: Preparation -->
            <div class="info-card">
                <div class="info-header primary">Before Taking the Test</div>
                <div class="info-body">
                    <ul>
                        <li>Prepare a valid government-issued Passport or National ID (KTP).</li>
                        <li>Read the official DET preparation guide thoroughly before starting.</li>
                        <li>Check your computer, camera, microphone, and internet at least 2 days prior.</li>
                        <li>Scores are typically verified and available within 48 hours after test completion.</li>
                    </ul>
                </div>
            </div>

            <!-- Right: Terms & Contact -->
            <div class="info-card">
                <div class="info-header terms">Coupon Terms & Inquiries</div>
                <div class="info-body">
                    <ul style="margin-bottom: 14px;">
                        <li>Coupon is issued strictly once and cannot be transferred or exchanged.</li>
                        <li>Unauthorized use or no-show requires fee reimbursement of USD 70.</li>
                    </ul>
                    <hr style="border: 0; border-top: 1px solid #f1f5f9; margin-bottom: 10px;">
                    <div style="font-weight: 700; font-size: 12px; color: #1e293b; margin-bottom: 6px;">Program Contact Persons:</div>
                    <table class="contact-table">
                        <tr>
                            <td class="contact-name">Ms. Kiki</td>
                            <td class="contact-email"><a href="mailto:kiki@aminef.or.id">kiki@aminef.or.id</a></td>
                        </tr>
                        <tr>
                            <td class="contact-name">Ms. Intan</td>
                            <td class="contact-email"><a href="mailto:intan@aminef.or.id">intan@aminef.or.id</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-7">

            <div class="panel panel-default">
                <div class="panel-heading">Test Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-box">
                                <label>Testing Period</label>
                                <div class="value"><?= formatDateRange($application->testing_date, $application->testing_date_end) ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-box">
                                <label>Coupon Code</label>
                                <div class="value coupon"><?= $application->coupon ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation"></i> <b>Important:</b> The testing schedule is final and cannot be changed. You must attend during the assigned period.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Before Taking the Test</div>
                <div class="panel-body">
                    <ul class="ul-panel">
                        <li>Prepare a valid Passport or National ID.</li>
                        <li>Read the DET preparation guide carefully.</li>
                        <li>Follow all testing procedures.</li>
                        <li>Check your computer and internet at least two days before the test.</li>
                        <li>Scores are normally available within two days after the test.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-5">

            <div class="panel panel-danger">
                <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Coupon Terms</div>
                <div class="panel-body">
                    <ul class="ul-panel">
                        <li>Coupon is issued only once.</li>
                        <li>Coupon cannot be transferred or exchanged for cash.</li>
                        <li>Unauthorized use requires reimbursement of USD 70.</li>
                        <li>The coupon expires if unused within the assigned testing period.</li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">Contact</div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <td width="100">Ms. Kiki</td>
                            <td>kiki@aminef.or.id</td>
                        </tr>
                        <tr>
                            <td>Ms. Intan</td>
                            <td>intan@aminef.or.id</td>
                        </tr>
                        <tr>
                            <td>Ms. Mada</td>
                            <td>indonesianprogram.intern@aminef.or.id</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
</div>