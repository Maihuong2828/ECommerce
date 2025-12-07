<?php
require_once 'helpers/Helper.php';
?>
<div class="timeline-items container">
    <h2>Giỏ hàng của bạn</h2>

    <?php
    //  SỬA: Logic hiển thị lỗi và kiểm soát nút thanh toán
    
    // Biến $has_error sẽ quyết định nút thanh toán
    $has_error = false;
    
    // 1. Kiểm tra lỗi từ POST (vừa thất bại)
    // Lỗi này có ưu tiên cao nhất
    if (isset($_SESSION['error'])):
        $has_error = true;
    ?>
        <div class="alert alert-danger auto-hide-alert" style="margin-top: 15px;">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php
    endif;
    
    // 2. Kiểm tra lỗi của Session (tải trang)
    // Chỉ hiển thị nếu không có lỗi POST
    if (!$has_error && isset($session_stock_error)):
        $has_error = true;
    ?>
         <div class="alert alert-danger auto-hide-alert" style="margin-top: 15px;">
            <?php echo $session_stock_error; ?>
        </div>
    <?php
    endif;

    // 3. Kiểm tra thành công
    if (isset($_SESSION['success'])):
    ?>
        <div class="alert alert-success auto-hide-alert" style="margin-top: 15px;">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php 
    endif; 
    // Kết thúc logic hiển thị lỗi
    ?>

    <?php if (isset($_SESSION['cart'])): ?>
        <form action="" method="post">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th width="40%">Tên sản phẩm</th>
                    <th width="12%">Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>

                <?php
                $total_cart = 0; 
                foreach ($_SESSION['cart'] as $product_id => $cart):
                    $slug = Helper::getSlug($cart['name']);
                    
                    // Sửa link sản phẩm (đã làm)
                    $product_link = "index.php?controller=product&action=detail&slug=$slug&id=$product_id";
                    ?>
                    <tr>
                        <td>
                            <?php if (!empty($cart['avatar'])): ?>
                                <img class="product-avatar img-responsive"
                                     src="../backend/assets/uploads/<?php echo $cart['avatar']; ?>"
                                     width="80">
                            <?php endif; ?>
                            <div class="content-product">
                                <a href="<?php echo $product_link; ?>" class="content-product-a">
                                    <?php echo $cart['name']; ?>
                                </a>
                                 <p style="font-size: 13px; color: #666; margin-top: 5px;">
                                     Số lượng còn lại trong kho: 
                                     <strong><?php echo isset($cart['stock_quantity']) ? $cart['stock_quantity'] : 'Không xác định'; ?></strong>
                                </p>
                            </div>
                        </td>
                        <td>
                            <?php
                            $value = $post_data_on_fail[$product_id] ?? $cart['quality'];
                            ?>
                            <input type="number" min="0" name="<?php echo $product_id; ?>" class="product-amount"
                                   value="<?php echo $value; ?>">
                        </td>
                        <td>
                            <?php echo number_format($cart['price'], 0, '.', '.'); ?> đ
                        </td>
                        <td>
                            <?php
                            $total_item = $cart['price'] * $value; 
                            $total_cart += $total_item;
                            echo number_format($total_item, 0, '.', '.');
                            ?> đ
                        </td>
                        <td>
                            <a class="content-product-a"
                               href="index.php?controller=cart&action=delete&id=<?php echo $product_id; ?>">
                                Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                <tr>
                    <td colspan="5" style="text-align: right">
                        Tổng giá trị đơn hàng:
                        <span class="product-price">
                        <?php echo number_format($total_cart, 0, '.', '.'); ?> đ
                    </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="product-payment">
                        <input type="submit" name="submit" value="Cập nhật lại số lượng" class="btn btn-primary">
                        
                        <?php 
                        if ($has_error): 
                        ?>
                            <a href="#" class="btn btn-success disabled" 
                               onclick="return false;" 
                               style="cursor: not-allowed; opacity: 0.6;" 
                               title="Vui lòng sửa lại số lượng sản phẩm quá tồn kho">
                                Đến trang thanh toán
                            </a>
                        <?php else: ?>
                            <a href="index.php?controller=payment&action=index" class="btn btn-success">Đến trang thanh toán</a>
                        <?php endif; ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    <?php else: ?>
        <h2 style="text-align: center">Giỏ hàng trống</h2>
        <div style="text-align: center">
            <img src="assets/images/cart-empty.png" width="150px"> <br> <br>
            <a href="index.php?controller=product&action=showAll" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<script>
    (function() {
        // 1. Chọn tất cả các thông báo
        var alerts = document.querySelectorAll('.auto-hide-alert');
        
        if (alerts.length > 0) {
            // 2. Thiết lập thời gian chờ (ĐÃ SỬA THÀNH 3 GIÂY)
            setTimeout(function() {
                // 3. Lặp qua từng thông báo để ẩn
                alerts.forEach(function(alert) {
                    
                    // Thêm hiệu ứng mờ dần cho đẹp (tùy chọn)
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    
                    // Ẩn hoàn toàn thẻ div sau khi hiệu ứng mờ kết thúc
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500); // 500ms = 0.5 giây (phải khớp với thời gian transition)
                });
            }, 3000); // 3000ms = 3 giây
        }
    })();
</script>