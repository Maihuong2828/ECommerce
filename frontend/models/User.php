<?php
require_once 'models/Model.php';

class User extends Model
{
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $phone;
    public $address;
    public $email;
    public $avatar;
    public $jobs;
    public $created_at;
    public $updated_at;
    public $is_admin;

    public $str_search;

    public function __construct()
    {
        parent::__construct();
        if (isset($_GET['username']) && !empty($_GET['username'])) {
            $this->str_search .= " AND `username` LIKE '%{$_GET['username']}%'";
        }
    }

    /**
     * ======================================================
     * PHƯƠNG THỨC MỚI ĐƯỢC THÊM VÀO
     * ======================================================
     * Lấy thông tin user dựa theo username
     * Dùng để kiểm tra username đã tồn tại hay chưa (Rule 2)
     */
    public function getUserByUsername($username)
    {
        $sql_select_one = "SELECT * FROM users WHERE `username` = :username";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $selects = [
            ':username' => $username
        ];
        $obj_select_one->execute($selects);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    
    // Phương thức này có thể đã tồn tại, nếu chưa có thì bạn thêm vào
    public function getUser($username, $password)
    {
        $sql_select_one = "SELECT * FROM users WHERE `username` = :username AND `password` = :password";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $selects = [
            ':username' => $username,
            ':password' => $password,
        ];
        $obj_select_one->execute($selects);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function insert()
    {
        $sql_insert = "INSERT INTO users(`username`, `password`, `first_name`, `last_name`, `phone`, `address`, `email`)
VALUES (:username, :password, :first_name, :last_name, :phone, :address, :email)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':username' => $this->username,
            ':password' => $this->password,
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':phone' => $this->phone,
            ':address' => $this->address,
            ':email' => $this->email,
        ];
        return $obj_insert->execute($arr_insert);
    }
    
    // ... (Giữ nguyên các phương thức khác nếu có) ...
}