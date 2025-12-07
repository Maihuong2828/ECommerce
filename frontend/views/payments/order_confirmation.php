<?php
// frontend/views/payments/order_confirmation.php
require_once 'helpers/Helper.php';
?>
<div class="container" style="margin: 40px auto;">
    <h2 style="text-align: center; margin-bottom: 20px;">Cảm ơn bạn đã đặt hàng!</h2>
    <p style="text-align: center;">Chúng tôi đã nhận được đơn hàng của bạn và sẽ xử lý trong thời gian sớm nhất.</p>

    <?php if (isset($_SESSION['order_info']) && isset($_SESSION['order_cart'])): ?>
        <?php
        $order = $_SESSION['order_info'];
        $cart = $_SESSION['order_cart'];
        ?>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Chi tiết đơn hàng #<?php echo $order['order_id']; ?></strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><strong>Thông tin giao hàng:</strong></h4>
                                <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['mobile']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                                <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order['note']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <h4><strong>Sản phẩm đã đặt:</strong></h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-right">Đơn giá</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td class="text-center"><?php echo $item['quality']; ?></td>
                                        <td class="text-right"><?php echo number_format($item['price'], 0, '.', '.'); ?> đ</td>
                                        <td class="text-right"><?php echo number_format($item['price'] * $item['quality'], 0, '.', '.'); ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Tổng giá trị đơn hàng:</strong></td>
                                    <td class="text-right" style="color: red; font-weight: bold;"><?php echo number_format($order['price_total'], 0, '.', '.'); ?> đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="index.php?controller=home" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>

        <?php
        // Xóa thông tin đơn hàng khỏi session sau khi đã hiển thị để tránh hiển thị lại ở lần sau
        unset($_SESSION['order_info']);
        unset($_SESSION['order_cart']);
        ?>
    <?php else: ?>
        <p>Không có thông tin đơn hàng để hiển thị.</p>
    <?php endif; ?>
</div>