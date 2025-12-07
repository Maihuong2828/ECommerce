<?php
require_once 'models/Model.php';
require_once 'models/OrderDetail.php'; 

class Order extends Model
{
    /**
     * ✅ ĐÃ SỬA LỖI: Loại bỏ tham số $payment_method (tham số thứ 8)
     * Hàm insert() giờ chỉ nhận 7 tham số.
     */
    public function insert($user_id, $fullname, $address, $mobile, $email, $note, $price_total)
    {
        /**
         * ✅ ĐÃ SỬA LỖI: Loại bỏ cột 'payment_method' khỏi câu SQL
         */
        $sql_insert = "INSERT INTO orders(user_id, fullname, address, mobile, email, note, price_total)
                        VALUES (:user_id, :fullname, :address, :mobile, :email, :note, :price_total)";
        
        $obj_insert = $this->connection->prepare($sql_insert);
        
        $arr_insert = [
            ':user_id' => $user_id,
            ':fullname' => $fullname,
            ':address' => $address,
            ':mobile' => $mobile,
            ':email' => $email,
            ':note' => $note,
            ':price_total' => $price_total
            // ✅ ĐÃ SỬA LỖI: Loại bỏ ':payment_method' khỏi mảng
        ];
        
        $obj_insert->execute($arr_insert);
        $order_id = $this->connection->lastInsertId();
        return $order_id;
    }

    // (Các hàm getOrdersByUserId, getOrderByIdAndUserId, cancelOrder giữ nguyên như cũ)
    
    public function getOrdersByUserId($user_id)
    {
        $sql_select = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $obj_select = $this->connection->prepare($sql_select); 
        $obj_select->execute([':user_id' => $user_id]);
        $orders = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        $order_detail_model = new OrderDetail();
        foreach ($orders as &$order) {
            $order['products'] = $order_detail_model->getProductsForOrder($order['id']);
        }

        return $orders;
    }

    public function getOrderByIdAndUserId($order_id, $user_id) {
        $sql_select = "SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id";
        $obj_select = $this->connection->prepare($sql_select); 
        $obj_select->execute([
            ':order_id' => $order_id,
            ':user_id' => $user_id
        ]);
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($order_id, $user_id) {
        $sql_update = "UPDATE orders 
                       SET order_status = 4 
                       WHERE id = :order_id 
                         AND user_id = :user_id
                         AND (order_status = 0 OR order_status = 1)";
        
        $obj_update = $this->connection->prepare($sql_update); 
        $result = $obj_update->execute([
            ':order_id' => $order_id,
            ':user_id' => $user_id
        ]);
        
        return $result && $obj_update->rowCount() > 0;
    }
}