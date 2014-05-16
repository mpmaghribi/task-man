<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <body>
        <p>Put your html here, or generate it with your favourite '.
  'templating system.</p>
        <ul class="dropdown-menu pull-right">
                                        <li><a href="#" onclick="window.print()">Print</a></li>
                                        <li><a href="#" onclick="window.open('<?= site_url('laporan/exportToPDF')?>','_blank')">Save as PDF</a></li>
                                    </ul>
<!--        <form action="<?php echo site_url()?>laporan/exportToPDF" method="POST">
            <button type="submit" >Export</button>
        </form>-->
    </body>
</html>
