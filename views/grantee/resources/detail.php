<div class="offcanvas-content">
    <div class="row p-0">
        <?php
        $url = site_url($resource->filepath);
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        $file_extendsions = strtolower(pathinfo($resource->filepath, PATHINFO_EXTENSION));

        if (in_array($file_extendsions, $image_extensions)) {
            $url = site_url('assets/fileicons/image.png?v=' . VERSION);
        } else {
            switch ($file_extendsions) {
                case 'pdf':
                    $url = site_url('assets/fileicons/pdf.png?v=' . VERSION);
                    break;
                case 'xls':
                case 'xlsx':
                    $url = site_url('assets/fileicons/excel.png?v=' . VERSION);
                    break;
                case 'doc':
                case 'docx':
                    $url = site_url('assets/fileicons/doc.png?v=' . VERSION);
                    break;
                case 'zip':
                    $url = site_url('assets/fileicons/zip.png?v=' . VERSION);
                    break;
                default:
                    $url = site_url('assets/fileicons/file.png?=' . VERSION);
                    break;
            }
        }
        ?>
        <div>
            <img id="file_icon" src="<?php echo $url; ?>" style="width: 100px;">
        </div>
        <div class="p-4">
            <table>
                <tr>
                    <td width="100" style="vertical-align: top;"><b>File Name</b></td>
                    <td><?php echo $resource->filename; ?></td>
                </tr>
                <tr>
                    <td width="100" style="vertical-align: top;"><b>Added at</b></td>
                    <td> <?php echo date('d F Y H:i:s', strtotime($resource->created_at)); ?></td>
                </tr>
                <tr>
                    <td width="100" style="vertical-align: top;"></td>
                    <td><a class="btn btn-success btn-xs" onclick="update_download_counter(<?php echo $resource->id; ?>);" href="<?php echo site_url($resource->filepath); ?>" download><i class="fa fa-download"></i> Download</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="offcanvas-footer p-4">
    <a class="btn btn-default close-offcanvas">Close</a>
</div>