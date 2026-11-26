<style>
        #wrap-filter .select2 {
            border-radius: 0px !important;
            width: 250px !important;
            height: 35px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        #wrap-filter span.select2.select2-container{
            border-radius: 0px !important;
            width: 250px !important;
            height: 34px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        #wrap-filter .select2-selection.select2-selection--single {
            border-radius: 0px !important;
            width: 250px !important;
            height: 34px !important;
            padding-top: 2px !important;
            border: 1px solid #ccc;
        }

        #wrap-filter .select2-selection__arrow {
            margin-top: 5px !important;
        }
</style>
<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    }

    .data-header {
        padding-top: 10px !important;
    }

    .program-filter-section {
        display: flex;
    }

    .program-filter-section > .form-group {
        width: 350px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 5px !important;
    }

    .select2-selection--single > .select2-selection__rendered {
        margin-top: 5px !important;
    }

    .select2-selection--single {
        overflow: hidden !important;
    }

    label {
        font-weight: normal !important;
    }

    .program-filter-section {
        background-color: #f6f6f6;
        padding: 20px;
        border-radius: 8px;
    }

    /* Container utama menggunakan Grid agar responsif */
.modern-legend-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
    margin-top: 20px;
    font-family: system-ui, -apple-system, sans-serif;
}

/* Desain Card Legend */
.legend-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 14px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease-in-out;
}

/* Efek Hover Mikro */
.legend-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-color: #ced4da;
}

.legend-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Titik warna indikator */
.legend-dot {
    width: 8px;
    height: 8px;
    background-color: #3498db; /* Sesuaikan dengan warna chart bar Anda */
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-label {
    font-size: 13px;
    font-weight: 500;
    color: #495057;
}

/* Badge Angka Nilai */
.legend-value {
    font-size: 14px;
    font-weight: 700;
    color: #212529;
    background: #f1f3f5;
    padding: 2px 8px;
    border-radius: 6px;
    min-width: 28px;
    text-align: center;
}

/* Style khusus untuk data yang kosong (bernilai 0) agar tidak mengalihkan fokus */
.legend-zero {
    opacity: 0.5;
    background: #f8f9fa;
}

.legend-zero .legend-dot {
    background-color: #dee2e6;
}

.legend-zero .legend-value {
    font-weight: 500;
    color: #6c757d;
    background: #e9ecef;
}

table th {
    text-align:center;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard Grantee
            <button id="btn-export-csv" class="btn btn-primary pull-right">Export Excel</button>
        </h1> 
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="row mb-4 program-filter-section">
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control select2" name="period" onchange="document.forms.frm_manage.submit()">
                        <option value="">All</option>
                        <option value="">&nbsp;</option>
                        <?php $_period = isset($_GET['period']) ? $_GET['period'] : ''; ?>
                        <?php foreach($available_period as $period) { ?>
                            <?php if (empty($period->fiscal_year) || $period->fiscal_year <= 0) continue; ?>
                            <option value="<?php echo $period->fiscal_year; ?>" <?php echo $_period == $period->fiscal_year ? 'selected' : ''; ?>><?php echo $period->fiscal_year; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hide">
                    <label>Status</label>
                    <select class="form-control select2" id="filter-status" name="status">
                        <option value="all">All</option>
                        <?php if(!empty($available_status)) { foreach($available_status as $st) { ?>
                            <option value="<?php echo $st->id; ?>"><?php echo html_escape($st->name); ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
        </form>

    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="panel-group" id="accordionPrograms" role="tablist" aria-multiselectable="true">
            <?php foreach($program_available as $index => $program) { ?>
                <div class="panel panel-default mb-4" style="border: 1px solid #eaedf1; border-radius: 8px; overflow: hidden; margin-bottom: 20px; background-color: white;">
                    <div class="panel-heading" role="tab" id="heading-<?= $program->id ?>" style="background-color: #f8fafc; padding: 15px; cursor: pointer; border-bottom: 1px solid #eaedf1;" data-toggle="collapse" data-parent="#accordionPrograms" href="#collapse-<?= $program->id ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse-<?= $program->id ?>" class="<?= $index === 0 ? '' : 'collapsed' ?>">
                        <h4 class="panel-title" style="margin: 0; font-weight: 600; color: #1e293b; display: flex; justify-content: space-between; align-items: center;">
                            <span><?= html_escape($program->name) ?></span>
                            <div>
                                <span class="label label-primary" id="total-badge-<?= $program->id ?>" style="display: none; margin-right: 15px; font-size: 11px; padding: 4px 8px; border-radius: 4px; background-color: #013473;">0 Applicants</span>
                                <i class="fa <?= $index === 0 ? 'fa-chevron-down' : 'fa-chevron-down' ?>"></i>
                            </div>
                        </h4>
                    </div>
                    <div id="collapse-<?= $program->id ?>" data-degree="<?= $program->show_attrition_detail ? 'true' : 'false' ?>" class="panel-collapse collapse <?= $index === 0 ? '' : '' ?>" role="tabpanel" aria-labelledby="heading-<?= $program->id ?>">
                        <div class="panel-body" style="padding: 20px; background-color: white;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <?php if($staff->access_detail_dashboard) { ?>
                                <button class="btn btn-primary btn-sm btn-export-excel" data-program-id="<?= $program->id ?>" data-degree="<?= $program->show_attrition_detail ? 'true' : 'false' ?>">
                                    <i class="fa fa-file-excel-o"></i> Export Excel for <?= html_escape($program->name) ?>
                                </button>
                                <h4 style="margin: 0; font-weight: 700; color: #013473;">
                                    Total Applicants: <span id="total-count-<?= $program->id ?>">0</span>
                                </h4>
                                <?php } ?>
                            </div>

                            <?php if($program->show_attrition_detail) { ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div id="grantee-stats-eec-<?= $program->id ?>"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="grantee-stats-fsb-<?= $program->id ?>"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div id="grantee-stats-resume-<?= $program->id ?>"></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($staff->access_detail_dashboard) { ?>
                                aadad
                            <div id="grantee-stats-chart-<?= $program->id ?>">
                                <div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading stats...</div>
                            </div>
                            <?php } ?>

                            <?php if($staff->access_detail_dashboard || $program->show_attrition_detail) { ?>
                            <hr style="margin: 25px 0; border-top: 1px solid #e2e8f0;" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped grantee-stats-table" id="grantee-stats-table-<?= $program->id ?>" style="width: 100% !important;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Fullname</th>
                                                    <th>Program</th>
                                                    <th>Period</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="5" class="text-center">Select cells in the grid above to load data</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>