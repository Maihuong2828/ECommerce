<?php
require_once 'models/Model.php';
class User extends Model {
    // Khai báo các thuộc tính
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $phone;
    public $address;
    public $email;
    public $is_admin;
    public $created_at;
    public $updated_at;

    // Chuỗi search
    public $str_search = '';

    // Hàm khởi tạo để xây dựng chuỗi tìm kiếm
    public function __construct() {
        parent::__construct(); // Gọi hàm khởi tạo của class cha

        $keyword = '';
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            // Xử lý để tránh lỗi SQL-injection cơ bản và lỗi LIKE
            $keyword = str_replace('%', '\%', $keyword);
            $keyword = str_replace('_', '\_', $keyword);
            
            $this->str_search .= " AND (
                `username` LIKE '%$keyword%' OR 
                `first_name` LIKE '%$keyword%' OR 
                `last_name` LIKE '%$keyword%' OR 
                `email` LIKE '%$keyword%' OR 
                `phone` LIKE '%$keyword%'
            )";
        }
        
        if (isset($_GET['is_admin']) && $_GET['is_admin'] !== '') {
            $is_admin = (int)$_GET['is_admin'];
            $this->str_search .= " AND `is_admin` = $is_admin";
        }
    }

    // Lấy user theo username (dùng cho check trùng)
    public function getUser($username) {
        $sql_select_once = "SELECT * FROM users WHERE `username` = :username";
        $obj_select_one = $this->connection->prepare($sql_select_once);
        $arr_select = [
            ':username' => $username
        ];
        $obj_select_one->execute($arr_select);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    // (Hàm này có thể dùng cho backend register nếu cần)
    public function register() {
        $sql_insert = "INSERT INTO users (`username`, `password`) VALUES(:username, :password)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':username' => $this->username,
            ':password' => $this->password
        ];
        return $obj_insert->execute($arr_insert);
    }

    // Lấy user để login (dùng cho backend login)
    public function getUserLogin($username, $password) {
        $sql_select_one = "SELECT * FROM users WHERE `username` = :username AND `password` = :password";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $arr_select = [
            ':username' => $username,
            ':password' => $password
        ];
        $obj_select_one->execute($arr_select);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * MỚI: Đếm tổng số user (trừ admin đang đăng nhập)
     */
    public function countTotal($current_admin_id) {
        $sql_count = "SELECT COUNT(id) FROM users WHERE id != :current_admin_id $this->str_search";
        $obj_count = $this->connection->prepare($sql_count);
        $obj_count->execute([':current_admin_id' => $current_admin_id]);
        return $obj_count->fetchColumn();
    }

    /**
     * MỚI: Lấy tất cả user (trừ admin đang đăng nhập) CÓ PHÂN TRANG
     */
    public function getAllPagination($arr_params, $current_admin_id) {
        $limit = $arr_params['limit'];
        $page = $arr_params['page'];
        $start = ($page - 1) * $limit;
        
        // LƯU Ý: Không bao giờ SELECT cột password
        $sql_select = "SELECT id, username, first_name, last_name, phone, address, email, is_admin, created_at, updated_at 
                       FROM users 
                       WHERE id != :current_admin_id $this->str_search
                       ORDER BY id ASC
                       LIMIT $start, $limit";
        
        $obj_select = $this->connection->prepare($sql_select);
        $obj_select->execute([':current_admin_id' => $current_admin_id]);
        return $obj_select->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * MỚI: Lấy user theo ID (dùng cho Sửa)
     */
    public function getById($id) {
        $sql_select = "SELECT id, username, first_name, last_name, phone, address, email, is_admin FROM users WHERE id = :id";
        $obj_select = $this->connection->prepare($sql_select);
        $obj_select->execute([':id' => $id]);
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * MỚI: Cập nhật user (Admin sửa)
     */
    public function update($id) {
        $sql_update = "UPDATE users SET 
            first_name = :first_name, 
            last_name = :last_name, 
            phone = :phone, 
            address = :address, 
            email = :email, 
            is_admin = :is_admin,
            updated_at = :updated_at 
            WHERE id = :id";
        
        $obj_update = $this->connection->prepare($sql_update);
        $arr_update = [
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':phone' => $this->phone,
            ':address' => $this->address,
            ':email' => $this->email,
            ':is_admin' => $this->is_admin,
            ':updated_at' => $this->updated_at,
            ':id' => $id
        ];
        return $obj_update->execute($arr_update);
    }

    /**
     * MỚI: Xóa user
     */
    public function delete($id) {
        $sql_delete = "DELETE FROM users WHERE id = :id";
        $obj_delete = $this->connection->prepare($sql_delete);
        return $obj_delete->execute([':id' => $id]);
    }
}
?>