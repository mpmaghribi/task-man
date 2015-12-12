<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of file_upload_parser
 *
 * @author Oktri Raditya
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class file_upload_parser extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("berkas_model");
    }

    public function index() {
        if (isset($_FILES["file1"])) {
            $temp = $this->session->userdata("logged_in");
            $path = './uploads/progress/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $_POST["id_pekerjaan"] . '/';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $fileName = $_FILES["file1"]["name"];
// The file name 
            $fileTmpLoc = $_FILES["file1"]["tmp_name"];
// File in the PHP tmp folder 
            $fileType = $_FILES["file1"]["type"];
// The type of file it is 
            $fileSize = $_FILES["file1"]["size"];
// File size in bytes 
            $fileErrorMsg = $_FILES["file1"]["error"];
// 0 for false... and 1 for true 
        }

        if (!isset($fileTmpLoc)) {
            echo "ERROR: Please browse for a file before clicking the upload button.";
            exit();
        } if (move_uploaded_file($fileTmpLoc, $path . $_POST["nama_file"])) {
            $this->berkas_model->upload_file($temp['user_id'], $path.$_POST["nama_file"], $_POST["id_pekerjaan"]);
            echo "$fileName upload is complete";
        } else {
            echo "move_uploaded_file function failed";
        }
        //$this->load->view('file_upload_parser');
    }

}
