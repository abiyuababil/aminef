<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
    .dropzone {
        border: 1px dashed #013473 !important;
        border-radius: 10px;
        min-height: 150px;
    }
</style>
<script>
    var importFile = null;

    Dropzone.options.fileDropzone = {
        url: '<?php echo site_url('admin/university/manage') ?>',
        paramName: 'file-excel',
        autoProcessQueue: false,
        maxFiles: 1,
        acceptedFiles: '.xls,.xlsx',
        addRemoveLinks: true,
        dictRemoveFile: 'Remove File',
        dictDefaultMessage: '<i class="fa fa-cloud-upload fa-3x"></i><br>Drop file .xls / .xlsx here or click to browse',
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
                importFile = file;
            });
            this.on('removedfile', function(file) {
                if (importFile === file) {
                    importFile = null;
                }
            });
        }
    };

    function open_import_modal() {
        importFile = null;
        if (Dropzone.instances.length > 0) {
            Dropzone.instances.forEach(function(dz) {
                dz.removeAllFiles(true);
            });
        }
        $('#modalImport').modal('show');
    }

    $(document).ready(function() {
        $('#file-excel').change(function() {
            var ext = $(this).val().replace(/^.*\./, '');
            if (ext == $(this).val()) {
                ext = '';
            } else {
                ext = ext.toLowerCase();
            }

            switch (ext) {
                case 'xls':
                case 'xlsx':
                    $('#frm-import-excel').submit();
                    break;
                default:
                    alert('Sorry, only .xls / .xlsx file has allowed to be uploaded');
            }
        });

        $('#btn-upload-import').click(function() {
            if (!importFile) {
                alert('Please choose a file to upload.');
                return;
            }

            var hiddenInput = document.getElementById('file-excel');
            var dt = new DataTransfer();
            dt.items.add(importFile);
            hiddenInput.files = dt.files;

            $('#btn-upload-import').prop('disabled', true);
            $('#btn-cancel-import').prop('disabled', true);

            $('#frm-import-excel').submit();
        });
    });
</script>
