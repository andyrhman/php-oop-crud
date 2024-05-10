<?php
include_once "lib/Database.php";

class Register
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addRegister($data, $file)
    {
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
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $upload_image = "upload/" . $unique_image;

        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($file_name)) {
            $msg = "Field must not be empty";
            return $msg;
        } elseif ($file_size > 1048567) {
            $msg = "File size must be less than 1 MB";
            return $msg;
        } elseif (!in_array($file_ext, $permitted)) {
            $msg = "You can only upload " . implode(",", $permitted);
            return $msg;
        } else {
            // Corrected usage of move_uploaded_file
            if (move_uploaded_file($file_temp, $upload_image)) {
                $query = "INSERT INTO `tbl_register`(`name`, `email`, `phone`, `photo`, `address`) 
                VALUES ('$name', '$email', '$phone', '$upload_image', '$address')";

                $result = $this->db->insert($query);

                if ($result) {
                    $msg = "Registration Successfull";
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

    // public function allStudent()
    // {
    //     $query = "SELECT * FROM `tbl_register` ORDER BY id DESC";
    //     $result = $this->db->select($query);
    //     return $result;
    // }
    public function allStudent($limit, $offset)
    {
        $query = "SELECT * FROM `tbl_users` ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $result = $this->db->select($query);
        return $result;
    }

    public function countStudents()
    {
        $query = "SELECT COUNT(*) as count FROM `tbl_users`";
        $result = $this->db->select($query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }


    public function getStudentById($id)
    {
        $query = "SELECT * FROM `tbl_register` WHERE id='$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateStudent($data, $file, $id)
    {
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
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $upload_image = "upload/" . $unique_image;

        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $msg = "Field must not be empty";
            return $msg;
        }
        if (!empty($file_name)) {
            if ($file_size > 1048567) {
                $msg = "File size must be less than 1 MB";
                return $msg;
            } elseif (!in_array($file_ext, $permitted)) {
                $msg = "You can only upload " . implode(",", $permitted);
                return $msg;
            } else {

                $img_query = "SELECT * FROM tbl_register WHERE id = '$id'";
                $img_res = $this->db->select($img_query);
                if ($img_res) {
                    while ($row = mysqli_fetch_assoc($img_res)) {
                        $photo = $row["photo"];
                        unlink($photo);
                    }
                }

                move_uploaded_file($file_temp, $upload_image);
                $query = "UPDATE `tbl_register` SET `name`='$name',`email`='$email',
                    `phone`='$phone',`photo`='$upload_image',`address`='$address' WHERE id=$id";

                $result = $this->db->insert($query);

                if ($result) {
                    $msg = "Student Updated Successfull";
                    return $msg;
                } else {
                    $msg = "Update Failed";
                    return $msg;
                }

            }
        } else {
            $query = "UPDATE `tbl_register` SET `name`='$name',`email`='$email',
            `phone`='$phone',`address`='$address' WHERE id=$id";

            $result = $this->db->insert($query);

            if ($result) {
                $msg = "Student Updated Successfull";
                return $msg;
            } else {
                $msg = "Update Failed";
                return $msg;
            }
        }

    }

    public function deleteStudent($id)
    {
        $img_query = "SELECT * FROM tbl_register WHERE id = '$id'";
        $img_res = $this->db->select($img_query);
        if ($img_res) {
            while ($row = mysqli_fetch_assoc($img_res)) {
                $photo = $row["photo"];
                unlink($photo);
            }
        }

        $query = "DELETE FROM `tbl_register` WHERE id='$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $msg = "Deleted Successfully";
            return $msg;
        } else {
            $msg = "Delete Failed";
            return $msg;
        }
    }
}
