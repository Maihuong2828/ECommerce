<?php
//models/OrderDetail.php
require_once 'models/Model.php';
class OrderDetail extends Model {
    public $order_id;
    public $product_id;
    public $quality;

    public function insert() {
        $sql_insert = "INSERT INTO order_details(`order_id`, `product_id`, `quality`)
                        VALUES (:order_id, :product_id, :quality)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':order_id' => $this->order_id,
            ':product_id' => $this->product_id,
            ':quality' => $this->quality,
        ];
        return $obj_insert->execute($arr_insert);
    }
    
    /**
     * HÀM MỚI: Lấy tất cả sản phẩm (tên, ảnh, số lượng) cho 1 đơn hàng
     */
    public function getProductsForOrder($order_id) {
        $sql_select = "SELECT 
                            p.title AS product_name, 
                            p.avatar AS product_avatar, 
                            od.quality AS quantity
                       FROM order_details od
                       INNER JOIN products p ON od.product_id = p.id
                       WHERE od.order_id = :order_id";
        
        $obj_select = $this->connection->prepare($sql_select);
        $params = [':order_id' => $order_id];
        $obj_select->execute($params);
        return $obj_select->fetchAll(PDO::FETCH_ASSOC);
    }
}