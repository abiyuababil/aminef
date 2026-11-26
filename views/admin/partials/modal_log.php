
<div class="modal fade" id="modal-payment-log" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Logs</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="model-payment-log">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Action</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="email-recommendation-loading" style="text-align: center; padding: 30px; display: none;">
                        <i class="fa fa-spinner fa-spin fa-2x" style="color: #20639b;"></i>
                        <p style="margin-top: 10px; color: #666;">Loading data...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-center" id="mdl_detail_log" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-6" id="old_data_section">
                        <div class="alert alert-warning">Old Data</div>                    
                    </div>
                    <div class="col-lg-6" id="new_data_section">
                        <div class="alert alert-info">New Data</div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6" id="old_data_section">
                        <div id="old-data">

                        </div>                       
                    </div>
                    <div class="col-lg-6" id="new_data_section">
                        <div id="new-data">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>