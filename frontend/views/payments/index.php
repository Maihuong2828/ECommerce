<?php
require_once 'helpers/Helper.php';

// ✅ BƯỚC 1: Giữ lại thông tin đã nhập nếu biểu mẫu không hợp lệ
$fullname = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '';
$address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
$mobile = isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$note = isset($_POST['note']) ? htmlspecialchars($_POST['note']) : '';

// (Không cần biến $method nữa vì đã cố định)
?>
<div class="container">

    <?php
    // Hiển thị thông báo lỗi (từ PaymentController)
    if (isset($this->error)):
    ?>
        <div class="alert alert-danger" style="margin-top: 15px;">
            <?php echo $this->error; // Hiển thị lỗi (cho phép cả HTML) ?>
        </div>
    <?php endif; ?>

    <h2>Thanh toán</h2>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h3 class="center-align">Thông tin khách hàng</h3>
                <div class="form-group">
                    <label>Họ tên khách hàng</label>
                    <input type="text" name="fullname" value="<?php echo $fullname; ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" value="<?php echo $address; ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>SĐT</label>
                    <input type="number" min="0" name="mobile" value="<?php echo $mobile; ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" min="0" name="email" value="<?php echo $email; ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Ghi chú thêm</label>
                    <textarea name="note" class="form-control"><?php echo $note; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Phương thức thanh toán</label> <br />
                    <strong>COD (Thanh toán khi nhận hàng)</strong>
                    <input type="hidden" name="method" value="1" />
                </div>
                
            </div>
            <div class="col-md-6 col-sm-6">
                <h3 class="center-align">Thông tin đơn hàng của bạn</h3>
                <?php
                //biến lưu tổng giá trị đơn hàng
                $total = 0;
                if (isset($_SESSION['cart'])) :
                ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="40%" style="padding-left: 10px;">Tên sản phẩm</th>
                                <th width="12%">Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                            <?php foreach ($_SESSION['cart'] as $product_id => $cart) :
                                $product_link = 'san-pham/' . Helper::getSlug($cart['name']) . "/$product_id";
                            ?>
                                <tr>
                                    <td style="padding-left: 10px;">
                                        <?php if (!empty($cart['avatar'])) : ?>
                                            <img class="product-avatar img-responsive" src="../backend/assets/uploads/<?php echo $cart['avatar']; ?>" width="60" />
                                        <?php endif; ?>
                                        <div class="content-product">
                                            <a href="<?php echo $product_link; ?>" class="content-product-a">
                                                <?php echo $cart['name']; ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="product-amount">
                                            <?php echo $cart['quality']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="product-price-payment">
                                            <?php echo number_format($cart['price'], 0, '.', '.') ?> đ
                                        </span>
                                    </td>
                                    <td>
                                        <span class="product-price-payment">
                                            <?php
                                            $price_total = $cart['price'] * $cart['quality'];
                                            $total += $price_total;
                                            ?>
                                            <?php echo number_format($price_total, 0, '.', '.') ?> đ
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="5" class="product-total" style="padding-left: 10px;">
                                    Tổng giá trị đơn hàng:
                                    <span class="product-price">
                                        <?php echo number_format($total, 0, '.', '.') ?> đ
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>
        <input type="submit" name="submit" value="Thanh toán" class="btn btn-primary">
        <a href="gio-hang-cua-ban" class="btn btn-secondary">Về trang giỏ hàng</a>
    </form>
</div>