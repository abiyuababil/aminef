<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default mt-4" style="background-color: white !important;">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div id="collapse_user_grantee" class="collapse in" aria-labelledby="headingOne" aria-expanded="true" data-parent="#accordionExample">
                                <div class="card-body p-4" style="background-color: white; position: relative; z-index: 1;">
                                    <div class="form-group">
                                        <label>Search Grantee Name</label>
                                        <input type="text" class="form-control" id="search_grantee" name="search_grantee">
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                                    </div>
                                    
                                </div>
                                <div class="card-body p-4" style="background-color: white; position: relative; z-index: 1;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td width="2%">
                                                    <label for="select-all-applicant">
                                                        <input type="checkbox" id="select-all-applicant" disabled>
                                                    </label>
                                                </td>
                                                <td>Full Name</td>
                                                <td>Email</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody class="applicant-list">
                                            <tr>
                                                <td width="100%" colspan="4" class="text-center">No data.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-md-12 p-0 mb-2 mt-5">
                                        <button class="btn btn-success hide pull-right" id="save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>