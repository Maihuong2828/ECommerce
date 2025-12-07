<?php
require_once 'helpers/Helper.php';
// BƯỚC 1: Khởi tạo model Order_Detail
require_once 'models/Order_detail.php';
$order_detail_model = new Order_Detail();

// Mảng để chuyển đổi trạng thái
$status_mapping = [
    0 => 'Chờ xác nhận',
    1 => 'Chờ giao hàng',
    2 => 'Đang giao',
    3 => 'Đã giao',
    4 => 'Huỷ hàng'
];

// Lấy giá trị tìm kiếm và lọc cũ để hiển thị lại
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : ''; // Lấy trạng thái đã lọc
?>

<form action="" method="get">
    <input type="hidden" name="controller" value="order">
    <input type="hidden" name="action" value="index">
    
    <div class="form-group row">
        <div class="col-md-4">
            <label for="query">Tìm kiếm (ID, Tên, SĐT, Email)</label>
            <input type="text" name="query" id="query" class="form-control" 
                   placeholder="Nhập từ khóa..."
                   value="<?php echo htmlspecialchars($search_query); ?>">
        </div>
        
        <div class="col-md-4">
            <label for="status">Lọc theo trạng thái</label>
            <select name="status" id="status" class="form-control">
                <option value="">-- Tất cả trạng thái --</option>
                <?php foreach ($status_mapping as $value => $text): ?>
                    <option value="<?php echo $value; ?>" 
                            <?php echo ($filter_status !== '' && $filter_status == $value) ? 'selected' : ''; ?>>
                        <?php echo $text; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label>&nbsp;</label><br> 
            <input type="submit" value="Tìm kiếm / Lọc" class="btn btn-primary">
            <a href="index.php?controller=order" class="btn btn-default">Xóa lọc</a>
        </div>
    </div>
</form>
<h2>Danh sách đơn hàng</h2>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Customer_fullname</th>
        
        <th>Sản phẩm đã đặt</th>
        
        <th>Address</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Price_total</th>
        <th>Trạng thái đơn hàng</th> 
        <th>Order_date</th>
        <th>Cập nhật lúc</th>
        <th></th>
    </tr>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['id'] ?></td>
                <td><?php echo $order['fullname'] ?></td>
                
                <td>
                    <?php
                    // Gọi hàm mới để lấy sản phẩm
                    $products = $order_detail_model->getProductsByOrderId($order['id']);
                    
                    if (!empty($products)) {
                        echo '<ul style="margin: 0; padding-left: 15px; list-style-type: disc;">'; // Thêm kiểu danh sách
                        foreach ($products as $product) {
                            // Hiển thị tên SP (title) và số lượng (quality)
                            echo '<li>';
                            echo htmlspecialchars($product['title']); // Dùng 'title' từ CSDL
                            echo ' (SL: ' . $product['quality'] . ')'; // Dùng 'quality' từ CSDL
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo 'Không có sản phẩm';
                    }
                    ?>
                </td>
                
                <td><?php echo $order['address'] ?></td>
                <td><?php echo $order['mobile'] ?></td>
                <td><?php echo $order['email'] ?></td>
                <td><?php echo $order['price_total'] ?></td>
                
                <td>
                    <?php
                    $status = $order['order_status']; 
                    echo isset($status_mapping[$status]) ? $status_mapping[$status] : 'Không xác định';
                    ?>
                </td>
                
                <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                <td><?php echo !empty($order['updated_at']) ? date('d-m-Y H:i:s', strtotime($order['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=order&action=detail&id=" . $order['id'];
                    $url_update = "index.php?controller=order&action=update&id=" . $order['id'];
                    $url_delete = "index.php?controller=order&action=delete&id=" . $order['id'];
                    ?>
                    <a title="Chi tiết" href="<?php echo $url_detail ?>"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;
                    <a title="Update" href="<?php echo $url_update ?>"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                </td>
            </tr>
        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="11">No data found</td>
        </tr>
    <?php endif; ?>
</table>