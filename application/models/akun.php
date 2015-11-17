<?php

class akun extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function my_staff($id_akun) {

        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/bawahan/id/" . $id_akun . "/format/json";
        $list_staff = json_decode(
                file_get_contents(
                        $url
        ));
        //var_dump($list_staff);
        return $list_staff;
    }

    public function akun_user($id_akun) {
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/user/id/" . $id_akun . "/format/json";
        $akun = json_decode(
                file_get_contents(
                        $url
        ));
        return $akun;
    }

}

?>