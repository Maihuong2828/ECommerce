<?php
require_once 'models/Model.php';

class Order_Detail extends Model {
    public $order_id;
    public $product_id;
    public $quality;

    public function delete_order_detail($order_id) {
        //cbi truy vấn
        $obj_delete = $this->connection
            ->prepare("DELETE FROM order_details WHERE order_id= $order_id ");
        //gắn giá trị cho tham số


        //thực thi truy vấn
        return $obj_delete->execute();
    }

    public function get_order_detail(){
//        1 - chuẩn bị truy vấn
        $obj_select = $this->connection
            ->prepare(" select *
                      FROM order_details");

        //2 - truyền giá trị cho tham số và
        // thực thi truy vấn
        $obj_select->execute();

        //3 - lấy dữ liệu trả về dưới dạng mảng
        $order_details = $obj_select->fetchAll(PDO::FETCH_ASSOC);
        return $order_details;
    }

    /**
     * ======================================================
     * PHƯƠNG THỨC MỚI ĐƯỢC THÊM VÀO
     * ======================================================
     * Lấy tên sản phẩm (title) và số lượng (quality) dựa trên order_id
     * từ CSDL bạn cung cấp.
     */
    public function getProductsByOrderId($order_id) {
        try {
            // Sử dụng JOIN để kết nối order_details với products
            // Lấy p.title (tên sản phẩm) và od.quality (số lượng)
            $sql = "SELECT p.title, od.quality 
                    FROM order_details AS od
                    INNER JOIN products AS p ON od.product_id = p.id
                    WHERE od.order_id = :order_id";
            
            $obj_select = $this->connection->prepare($sql);
            
            $params = [':order_id' => $order_id];
            
            $obj_select->execute($params);
            
            // Lấy tất cả sản phẩm
            return $obj_select->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Ghi log lỗi nếu cần
            error_log("Error fetching products for order ID $order_id: " . $e->getMessage());
            return []; // Trả về mảng rỗng nếu có lỗi
        }
    }
}