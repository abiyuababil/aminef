<div class="header-note">
    <h4>
        <?= $fullname ?> <?= $country == INDONESIAN_DATABASE ? 'Notes' : '' ?>
    </h4>
    <?php if($category) { ?>
    <p style="width:85%"><?= $category?></p>
    <?php } ?>
    <p style="width:85%"><?= $grant_name?> - <?= $period ?></p>
</div>

<div class="offcanvas-content">
    <div class="row mt-2 p-4">
        <form action="<?= base_url('admin/notes/add') ?>" method="post" id="form-note" enctype="multipart/form-data">
            <div class="col-lg-12">
                <input type="hidden" name="grantee_grant_id" id="grantee_grant_note" value="<?= $grantee_grant_id ?>">
                <input type="hidden" name="section" id="section_note" value="<?= $section ?>">
                <input type="hidden" name="section_id" id="section_id_note" value="<?= $section_id ?>">
                <?php if($category) { ?>
                    <input type="hidden" name="category" id="category" value="<?= $category ?>">
                <?php } ?>
                <textarea name="description" id="description" class="form-control" rows="5" style="border-radius:8px;"></textarea>
            </div>
            <?php if($country == INDONESIAN_DATABASE) { ?>
            <div class="col-lg-12">
                <input type="file" id="attachment_note" name="attachment_note" class="hide form-control mt-2" style="border-radius:8px;" onchange="preview_note(this)">
                <label for="attachment_note" id="attachment_label"
                    class="btn btn-outline-secondary w-100 text-start"
                    style="border-radius:8px;color:#3e80be;">
                    <i class="fa fa-paperclip me-2"></i>
                    <span>Choose Attachment</span>
                </label>
            </div>
            <?php } ?>
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary mt-3" style="width:100%;border-radius:8px;">Add Note</button>
            </div>
        </form>
    </div>
    <hr />

    <div class="row mt-2 notes_area" id="notes_area">
        <div id="notes-wrapper" data-total="<?= $len; ?>">
            <?php foreach($notes as $note){ ?>
            <div class="media note-wrapper">
                <div class="media-left">
                    <span class="user-avatar-note"><?= get_initial_name($note->full_name) ?></span>
                </div>
                <div class="media-body">
                    <small class="text-muted display-block"><?= $note->insert_date ?></small>
                    <?php if($note->staff_id == $this->session->userdata('user_id')) { ?>
                    <a href="#" class="pull-right text-danger" onclick="delete_note(this,<?= $note->id; ?>, <?= $note->grantee_grant_id ?>, <?= $note->section_id ?>);return false;"><i class="fa fa fa-times"></i></a>
                    <a href="#" class="pull-right mr-3" onclick="toggle_edit_note(<?= $note->id; ?>, <?= $note->grantee_grant_id ?>);return false;"><i class="fa fa-pencil-square-o"></i></a>
                    <?php } ?>

                    <h5 class="media-heading bold"><a href="#"><?= $note->full_name ?></a></h5>
                    <div data-note-description="<?= $note->id; ?>">
                        <?= $note->description ?>
                    </div>

                    <?php if($note->file) { ?>
                    <div data-note-file="<?= $note->file; ?>">
                        <a class="lightbox" target="_blank" href="<?= base_url($note->file) ?>"><?= file_name($note->file)?></a>
                    </div>
                    <?php } ?>

                    <div data-note-edit-textarea="<?= $note->id; ?>" class="hide mtop15">
                        <textarea name="" id="" class="form-control" style="border-radius:8px;"></textarea>
                        <button type="button" class="btn btn-info btn-xs pull-right mt-2" onclick="edit_note(<?= $note->id; ?>, <?= $note->grantee_grant_id ?>);">Edit Note</button>
                        <button type="button" class="btn btn-default btn-xs pull-right mt-2 mr-2" onclick="toggle_edit_note(<?php echo $note->id; ?>, <?= $note->grantee_grant_id ?>);return false;">Cancel</button>
                    </div>
                </div>
            </div>
            <?php
            $i++;
            } ?>
        </div>
    </div>
</div>

<div class="offcanvas-footer mt-5">
    <hr />
    <div class="btn-close-note">
        <a class="btn btn-default close-offcanvas-note">Close</a>
    </div>
</div>