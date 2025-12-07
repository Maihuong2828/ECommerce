<?php
//models/Category
require_once 'models/Model.php';
class Category extends Model {
    //khai báo các thuộc tính cho model trùng với các trường
//    của bảng categories
    public $id;
    public $name;
    public $avatar;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    //insert dữ liệu vào bảng categories
    public function insert() {
        $sql_insert =
"INSERT INTO categories(`name`, `avatar`, `description`, `status`)
VALUES (:name, :avatar, :description, :status)";
        //cbi đối tượng truy vấn
        $obj_insert = $this->connection
            ->prepare($sql_insert);
        //gán giá trị thật cho các placeholder
        $arr_insert = [
            ':name' => $this->name,
            ':avatar' => $this->avatar,
            ':description' => $this->description,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }

    /**
     * LẤy thông tin danh mục trên hệ thống
     * @param $params array Mảng các tham số search
     * @return array
     */
    public function getAll($params = []) {
//        echo "<pre>";
//        print_r($params);
//        echo "</pre>";
        //tạo 1 chuỗi truy vấn để thêm các điều kiện search
        //dựa vào mảng params truyền vào
        $str_search = 'WHERE TRUE';
        //check mảng param truyền vào để thay đổi lại chuỗi search
        if (isset($params['name']) && !empty($params['name'])) {
            $name = $params['name'];
            //nhớ phải có dấu cách ở đầu chuỗi
            $str_search .= " AND `name` LIKE '%$name%'";
        }
        if (isset($params['status'])) {
            $status = $params['status'];
            $str_search .= " AND `status` = $status";
        }
        //tạo câu truy vấn
        //gắn chuỗi search nếu có vào truy vấn ban đầu
        //tạo biến gán cho các key start và limit của mảng params
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 1000;
        $sql_select_all =
            "SELECT * FROM categories $str_search LIMIT $start,$limit";
        //cbi đối tượng truy vấn
        $obj_select_all = $this->connection
            ->prepare($sql_select_all);
        $obj_select_all->execute();

        $categories = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getById($id) {
        $sql_select_one = "SELECT * FROM categories WHERE id = $id";
        $obj_select_one = $this->connection
            ->prepare($sql_select_one);
        $obj_select_one->execute();
        $category = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $category;
    }

  /**
   * Lấy category theo id truyền vào
   * @param $id
   * @return array
   */
  public function getCategoryById($id)
  {
    $obj_select = $this->connection
        ->prepare("SELECT * FROM categories WHERE id = $id");
    $obj_select->execute();
    $category = $obj_select->fetch(PDO::FETCH_ASSOC);

    return $category;
  }

  /**
   * Update bản ghi theo id truyền vào
   * @param $id
   * @return bool
   */
  public function update($id)
  {
    $obj_update = $this->connection->prepare("UPDATE categories SET `name` = :name, `avatar` = :avatar, `description` = :description, `status` = :status, `updated_at` = :updated_at 
         WHERE id = $id");
    $arr_update = [
        ':name' => $this->name,
        ':avatar' => $this->avatar,
        ':description' => $this->description,
        ':status' => $this->status,
        ':updated_at' => $this->updated_at,
    ];

    return $obj_update->execute($arr_update);
  }

   /**
   * Xóa bản ghi theo id truyền vào (bao gồm các dữ liệu liên quan)
   * @param $id
   * @return bool
   */
  public function delete($id)
  {
    // Bắt đầu transaction để đảm bảo an toàn dữ liệu
    try {
      $this->connection->beginTransaction();

      // Xóa các bản ghi trong bảng news liên quan đến danh mục này
      $obj_delete_news = $this->connection
          ->prepare("DELETE FROM news WHERE category_id = :id");
      $obj_delete_news->execute([':id' => $id]);

      // Xóa toàn bộ sản phẩm thuộc danh mục này
      $obj_delete_products = $this->connection
          ->prepare("DELETE FROM products WHERE category_id = :id");
      $obj_delete_products->execute([':id' => $id]);

      // Xóa danh mục chính
      $obj_delete_category = $this->connection
          ->prepare("DELETE FROM categories WHERE id = :id");
      $is_delete = $obj_delete_category->execute([':id' => $id]);

      // Commit transaction nếu không lỗi
      $this->connection->commit();
      return $is_delete;

    } catch (PDOException $e) {
      // Nếu có lỗi, rollback để dữ liệu không bị hỏng
      $this->connection->rollBack();
      error_log("Lỗi khi xóa danh mục: " . $e->getMessage());
      return false;
    }
  }

  //trả về tổng số bản ghi của bảng categories
  public function getTotal() {
      //count tổng số bản ghi sẽ thì count dựa trên khóa chính
      $sql_select_count =
          "SELECT COUNT(id) AS count_id FROM categories";
      $obj_select_count = $this->connection
          ->prepare($sql_select_count);
      $obj_select_count->execute();
      //vì mục đích là trả về 1 số và câu truy vấn
      // chỉ select duy nhất 1 trường là tổng số bản ghi
      //nên sẽ gọi phương thức fetchColmn để trả về giá trị
      //của cột trong câu truy vấn select luôn
      $count = $obj_select_count->fetchColumn();
//      var_dump($count);
      return $count;
  }
  
}
