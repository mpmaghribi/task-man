<html>
    <head>
        <title>upload tes</title>
    </head>
    <body>
        <form action="<?php echo base_url(); ?>testing/do_upload">
            <input type="file" name="berkas[]" id="berkas0" >
            <br>
            <div style="display: none">
                <input type="file" name="fail" id="fal"  multiple="" style="">
            </div>
            <input type="button" id="pilihfile" value="pilih file">
            <br>
            <input type="submit">
        </form>
    </body>
    <?php $this->load->view("taskman_footer_page") ?>
    <script >
        $('#pilihfile').click(function() {
            alert($('#fal').val());
            $('#fal').trigger('click');
        });
    </script>
