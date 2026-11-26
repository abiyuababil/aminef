

<div class="modal fade" id="mdl_note_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason Reject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_reject" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_reject" name="temp_attachment_reject" class="hide" onchange="show_preview_attach(this, 'attachment_reject', 'attachment_reject');">
                            <input type="text" id="attachment_reject" name="attachment_reject" class="hide">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_reject" id="note_reject" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_note_drop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason Drop</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment" name="temp_attachment[]" multiple class="hide fields_reject" onchange="show_preview_attach(this, 'attachment_drop', 'attachment_drop');">
                            <input type="text" id="attachment_drop" name="attachment_drop" class="hide fields_reject">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_drop" id="note_drop" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note-drop" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_edit_note" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_edit" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_edit" name="temp_attachment[]" multiple class="hide fields_reject" onchange="show_preview_attach_edit(this, 'attachment_drop_edit', 'attachment_drop_edit');">
                            <input type="text" id="attachment_drop_edit" name="attachment_drop_edit" class="hide fields_reject">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center" id="old_attachments">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>

                    </div>
                    <div class="col-lg-12">
                        <textarea class="form-control" name="note_drop" id="note_drop_edit" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-save-note-drop-edit" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>