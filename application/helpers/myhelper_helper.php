<?php
if (!function_exists('pg_escape')) {

    function pg_escape($text) {
        $text2="";
        $panjang = strlen($text);
        for($i=0;$i<$panjang;$i++){
            $text2.=$text[$i];
        }
        return $text2;
    }
}
?>