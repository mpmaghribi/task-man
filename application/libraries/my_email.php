<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of my_email
 *
 * @author mozar
 */
class my_email {

    function kirim_email($to, $subject, $message) {
        mail($to, $subject, $message);
    }

}
