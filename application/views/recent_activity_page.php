<?php foreach ($activity as $value){?>
<?php if ($temp['user_id'] == $value->id_akun){?>
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
            <a href="#"><?php echo $value->nama_activity?></a>
            <p style="font-size: small">
                <?php echo $value->deskripsi_activity?>
            </p>
        </p>
    </div>
</div>
<?php }}?>