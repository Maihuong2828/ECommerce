<?php
// Mảng map trạng thái
$status_mapping = [
    0 => 'Chờ xác nhận',
    1 => 'Chờ giao hàng',
    2 => 'Đang giao',
    3 => 'Đã giao',
    4 => 'Huỷ hàng'
];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-top: 20px; margin-bottom: 20px;">Lịch sử đơn hàng của bạn</h2>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success auto-hide-alert" style="margin-top: 15px;">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger auto-hide-alert" style="margin-top: 15px;">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($orders)): ?>
                <div class="alert alert-info">
                    Bạn chưa có đơn hàng nào.
                </div>
            <?php else: ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #f5f5f5;">
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            
                            <th>Sản phẩm</th>
                            
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td style="vertical-align: middle;">#<?php echo $order['id']; ?></td>
                                <td style="vertical-align: middle;"><?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></td>
                                
                                <td>
                                    <?php if (!empty($order['products'])): ?>
                                        <?php foreach ($order['products'] as $product): ?>
                                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                                <img src="../backend/assets/uploads/<?php echo $product['product_avatar']; ?>" 
                                                     alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                                                     width="50" height="50" style="margin-right: 10px; object-fit: cover;">
                                                <span>
                                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                                    (x <?php echo $product['quantity']; ?>)
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                                
                                <td style="vertical-align: middle;"><?php echo number_format($order['price_total'], 0, '.', '.'); ?> đ</td>
                                <td style="vertical-align: middle;">
                                    <?php
                                    $status = $order['order_status'];
                                    echo isset($status_mapping[$status]) ? $status_mapping[$status] : 'Không xác định';
                                    ?>
                                </td>
                                
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                    // Chỉ hiển thị nút khi trạng thái là 0 (Chờ xác nhận) hoặc 1 (Chờ giao hàng)
                                    if ($order['order_status'] == 0 || $order['order_status'] == 1):
                                    ?>
                                        <a href="index.php?controller=user&action=cancel&id=<?php echo $order['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc chắn muốn huỷ đơn hàng #<?php echo $order['id']; ?>?');">
                                            Huỷ hàng
                                        </a>
                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    (function() {
        var alerts = document.querySelectorAll('.auto-hide-alert');
        if (alerts.length > 0) {
            setTimeout(function() {
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                });
            }, 3000); // 3000ms = 3 giây
        }
    })();
</script>