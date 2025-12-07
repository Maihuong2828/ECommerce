<?php
require_once 'helpers/Helper.php';
?>
<h2>Chi tiết đơn hàng</h2>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $order['id'] ?></td>
    </tr>
    <tr>
        <th>Tên khách hàng</th>
        <td><?php echo $order['fullname'] ?></td>
    </tr>
    <tr>
        <th>Địa chỉ</th>
        <td><?php echo $order['address'] ?></td>
    </tr>
    <tr>
        <th>SĐT</th>
        <td><?php echo $order['mobile'] ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $order['email'] ?></td>
    </tr>
    <tr>
        <th>Ghi chú</th>
        <td><?php echo $order['note'] ?></td>
    </tr>
    <tr>
        <th>Tổng tiền</th>
        <td>
            <?php echo number_format($order['price_total'], 0, '.', '.') ?> đ
        </td>
    </tr>

    <tr>
        <th>Trạng thái đơn hàng</th>
        <td>
            <?php
            $status_text = '';
            // SỬA LỖI: Đã đổi $order['payment_status'] thành $order['order_status']
            switch ($order['order_status']) {
                case 0:
                    $status_text = 'Chờ xác nhận';
                    break;
                case 1:
                    $status_text = 'Chờ giao hàng';
                    break;
                case 2:
                    $status_text = 'Đang giao';
                    break;
                case 3:
                    $status_text = 'Đã giao';
                    break;
                case 4:
                    $status_text = 'Huỷ hàng';
                    break;
                default: // Thêm default để tránh lỗi nếu trạng thái không xác định
                    $status_text = 'Không xác định';
            }
            echo $status_text;
            ?>
        </td>
    </tr>
    <tr>
        <th>Tạo lúc</th>
        <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
    </tr>
    <tr>
        <th>Cập nhật lúc</th>
        <td>
            <?php
            if (!empty($order['updated_at'])) {
                echo date('d-m-Y H:i:s', strtotime($order['updated_at']));
            }
            ?>
        </td>
    </tr>
</table>
<a href="index.php?controller=order" class="btn btn-default">Back</a>