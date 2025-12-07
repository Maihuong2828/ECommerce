<?php

require_once 'models/Model.php';

class Order extends Model
{
    public $id;
    public $user_id;
    public $fullname;
    public $address;
    public $mobile;
    public $email;
    public $note;
    public $order_status; 
    public $created_at;
    public $updated_at;

    // Sửa hàm này để nhận 2 tham số
    public function getAll($search_query = null, $filter_status = null)
    {
        // 1 - Chuẩn bị câu truy vấn cơ bản
        $sql_select = "SELECT * FROM orders";
        
        $params = []; // Mảng chứa các tham số
        $where_conditions = []; // Mảng chứa các điều kiện WHERE

        // 2 - Xử lý điều kiện TÌM KIẾM
        if (!empty($search_query)) {
            $search_like_value = '%' . $search_query . '%';
            
            // Nhóm điều kiện tìm kiếm (Tên, SĐT, Email)
            $search_condition_group = "(fullname LIKE :query_like OR mobile LIKE :query_like OR email LIKE :query_like)";
            $params[':query_like'] = $search_like_value;

            // Nếu là SỐ, tìm thêm cả ID
            if (is_numeric($search_query)) {
                $search_condition_group = "(" . $search_condition_group . " OR id = :query_numeric)";
                $params[':query_numeric'] = (int)$search_query;
            }
            
            // Thêm vào mảng điều kiện chung
            $where_conditions[] = $search_condition_group;
        }

        // 3 - Xử lý điều kiện LỌC TRẠNG THÁI
        // (kiểm tra !== null để cho phép lọc status 0 - 'Chờ xác nhận')
        if ($filter_status !== null) {
            $where_conditions[] = "order_status = :status";
            $params[':status'] = $filter_status;
        }

        // 4 - Nối các điều kiện WHERE (nếu có)
        if (!empty($where_conditions)) {
            // Dùng 'AND' để nối các điều kiện (VD: tìm kiếm ... AND trạng thái ...)
            $sql_select .= " WHERE " . implode(' AND ', $where_conditions);
        }

        // 5 - Thêm sắp xếp
        $sql_select .= " ORDER BY created_at DESC";

        // 6 - Chuẩn bị và thực thi truy vấn
        $obj_select = $this->connection->prepare($sql_select);
        $obj_select->execute($params); // Truyền mảng params vào execute

        // 7 - Lấy dữ liệu trả về
        $orders = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    }

    public function getById($id)
    {
        $obj_select_one = $this->connection->prepare("SELECT * FROM orders WHERE id = $id");
        $obj_select_one->execute();
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }



    public function insert()
    {
        //1 - chuẩn bị câu truy vấn
        $obj_insert = $this
            ->connection
            ->prepare("INSERT INTO
orders(fullname, address, mobile, email, note, order_status)
VALUES(:fullname, :address, :mobile, :email, :note, :order_status)
");
        $arr_insert = [
            ':fullname' => $this->fullname,
            ':address' => $this->address,
            ':mobile' => $this->mobile,
            ':email' => $this->email,
            ':note' => $this->note,
            ':order_status' => $this->order_status
        ];
        //        2 - thực thi bằng cách truyền tham số
        $is_insert = $obj_insert->execute($arr_insert);

        return $is_insert;
    }

    public function update($id)
    {
        $obj_update = $this->connection
            ->prepare("UPDATE orders SET fullname=:fullname, address=:address, mobile=:mobile, email=:email, 
            note=:note, order_status=:order_status, updated_at=:updated_at WHERE id = $id
");
        $arr_update = [
            ':fullname' => $this->fullname,
            ':address' => $this->address,
            ':mobile' => $this->mobile,
            ':email' => $this->email,
            ':note' => $this->note,
            ':order_status' => $this->order_status,
            ':updated_at' => $this->updated_at,
        ];
        return $obj_update->execute($arr_update);
    }
public function delete($id)
{
    try {
        // 1️⃣ Xóa các chi tiết đơn hàng trước (bảng order_details)
        $sql_delete_details = "DELETE FROM order_details WHERE order_id = :order_id";
        $stmt_details = $this->connection->prepare($sql_delete_details);
        $stmt_details->execute([':order_id' => $id]);

        // 2️⃣ Sau đó mới xóa đơn hàng chính
        $sql_delete_order = "DELETE FROM orders WHERE id = :id";
        $stmt_order = $this->connection->prepare($sql_delete_order);
        $stmt_order->execute([':id' => $id]);

        return true;
    } catch (PDOException $e) {
        // Nếu có lỗi khóa ngoại hoặc lỗi khác, có thể log ra hoặc trả false
        error_log("Delete order failed: " . $e->getMessage());
        return false;
    }
}
    
}