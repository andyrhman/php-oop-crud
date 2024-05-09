<?php 
include_once "lib/Database.php";

class Register {
    public $db;
    
    public function __construct(){
        $this->db = new Database();
    }

    public function addRegister($data, $file) {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);

        $permitted = array("jpg", "jpeg", "png", "gif");
        $file_name = $file['photo']['name'];
        $file_size = $file['photo']['size'];
        $file_temp = $file['photo']['tmp_name'];
    
        $div = explode(".", $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
        $upload_image = "upload/".$unique_image;
    
        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($file_name)) {
            $msg = "Field must not be empty";
            return $msg;
        } elseif($file_size > 1048567){
            $msg = "File size must be less than 1 MB";
            return $msg;
        } elseif(!in_array($file_ext, $permitted)){
            $msg = "You can only upload ".implode(",", $permitted);
            return $msg;
        } else {
            // Corrected usage of move_uploaded_file
            if (move_uploaded_file($file_temp, $upload_image)) {
                $query = "INSERT INTO `tbl_register`(`name`, `email`, `phone`, `photo`, `address`) 
                VALUES ('$name', '$email', '$phone', '$upload_image', '$address')";
            
                $result = $this->db->insert($query);

                if ($result) {
                    $msg = "Registration Successful";
                    return $msg;
                } else {
                    $msg = "Registration Failed";
                    return $msg;
                }
            } else {
                $msg = "File upload failed";
                return $msg;
            }
        }
    }

    public function allStudent() {
        $query = "SELECT * FROM `tbl_register` ORDER BY id DESC";
        $result = $this->db->findAll($query);
        return $result;
    }
}
