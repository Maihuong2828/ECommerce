<?php
//models/Product.php
require_once 'models/Model.php';
class Product extends Model
{

    //Lấy tất cả sản phẩm đang có trên hệ thống
    public function getAll($params = [])
    {

        $str_category_id = '';
        $str_price = '';
        $str_product_name = " ";
        if (isset($_POST['str-product-name'])) {
            $str_product_name = $_POST['str-product-name'];
        }
        $str_product_name = "'%" . $str_product_name . "%'";

        if (isset($params['str_category_id'])) {
            $str_category_id = " AND " . $params['str_category_id'];
        }
        if (isset($params['str_price'])) {
            $str_price = " AND " . $params['str_price'];
        }
        //với truy vấn mà có join bảng, thì luôn cần sử dụng
        //tên bảng trước tên trường, vd: products.price
        $sql_select_all =
            "SELECT products.*, categories.name AS category_name
            FROM products
            INNER JOIN categories 
            ON products.category_id = categories.id 
            WHERE products.title like $str_product_name AND TRUE $str_category_id $str_price ";
        //comment lại điều kiện WHere cho việc test,
        // tuy nhiên thực tế sẽ dùng
        //            WHERE categories.status=1 AND products.status=1";
        $obj_select_all =
            $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $products = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getById($id)
    {
            $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories 
                ON products.category_id = categories.id
                WHERE products.id = :id";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $product ?: null;
    }

    public function getByHot()
    {
        $sql_select_hot = "SELECT products.*, categories.name AS category_name
            FROM products
            INNER JOIN categories 
            ON products.category_id = categories.id
            WHERE hot = 1
             ORDER BY id DESC LIMIT 8";
        $obj_select_hot = $this->connection->prepare($sql_select_hot);
        $obj_select_hot->execute();
        $product = $obj_select_hot->fetchAll(PDO::FETCH_ASSOC);
        return $product;
    }
    public function updateQuantityAfterOrder($product_id, $quantity_ordered)
{
    $sql_update = "UPDATE products 
                   SET quantity = quantity - :quantity 
                   WHERE id = :id AND quantity >= :quantity";
    $stmt = $this->connection->prepare($sql_update);
    return $stmt->execute([
        ':quantity' => $quantity_ordered,
        ':id' => $product_id
    ]);
}

}
