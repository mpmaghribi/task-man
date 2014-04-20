<?php foreach ($activity as $value){?>
<div class="prog-row">
    <div class="user-thumb rsn-activity">
        <i class="fa fa-clock-o"></i>
    </div>
    <div class="rsn-details ">
        <p class="text-muted">
            <?php date_default_timezone_set('Asia/Jakarta'); echo date('d M Y h:i:s',strtotime($value->tanggal_activity))?>
            <?php //$delta = strtotime(date('d M Y h:i:s')) - strtotime(date('d M Y h:i:s',strtotime($value->tanggal_activity))); ?>
            <?php //echo $delta / 86400;?>
        </p>
        <p>
            <a href="#"><?php echo $value->nama?> </a><?php echo $value->nama_activity?>
            <p>
                <?php echo $value->deskripsi_activity?>
            </p>
        </p>
    </div>
</div>
<?php }?>