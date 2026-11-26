<table style="width: 100%; position: absolute; top: 0px;">
    <tr><div style="position:absolute; right: 80px; top: 30px;">
            <?php 
                $photo_url = FCPATH . 'img/top-right-cover-img.jpeg';
            ?>
            <img style="width: 1.6cm; height: 2.7cm;" src="<?php echo $photo_url; ?>">
        </div>
    </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="text-align: center;">
            <?php for ($i = 0; $i < 10; $i++) { ?>
                <br>
            <?php } ?>
            <?php 
                $photo_url = FCPATH . 'img/logo-fulbright-color.png';
            ?>
            <?php 
                $grant = get_row_db('am_user_grantee_grant', ['id' => $this->input->get('grants_id')]);
                if ($grant && $grant->show_pdf_logo) {
            ?>
                <img style="width: 8.5cm; height: 2.3cm;" src="<?php echo $photo_url; ?>">
            <?php } else { ?>
                <?php for ($i = 0; $i < 9; $i++) { ?>
                    <br>
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
</table>

<table style="width: 100%;">
    <tr>
        <td style="font-size: 36pt; text-align: center; padding: 100px; color: #266aad;">
            <?php echo strtoupper($document_title); ?>
        </td>
    </tr>
</table>

<?php for ($i = 0; $i < 50; $i++) { ?>
<br>
<?php } ?>
