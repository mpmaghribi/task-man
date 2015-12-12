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
            <input type="button" id="pilihfile" value="pilih file" >
            <br>
            <input type="submit">
        </form>
    </body>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>
    <script >
        var pf=$('#fal');
        $('#pilihfile').click(function() {
            //alert(pf.val());
            console.log(pf.val());
            console.log('file click');
            pf.trigger('click');
        });
        pf.change(function(){
            console.log('file berubah');
            console.log(pf);
        });
    </script>
