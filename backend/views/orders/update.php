<?php
require_once 'helpers/Helper.php';
?>
<h2>Chỉnh sửa đơn hàng #<?php echo $order['id'] ?></h2>
<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="fullname">Họ tên khách hàng</label>
                <input type="text" name="fullname" id="fullname"
                       value="<?php echo isset($order['fullname']) ? $order['fullname'] : '' ?>"
                       class="form-control"/>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" id="address"
                       value="<?php echo isset($order['address']) ? $order['address'] : '' ?>"
                       class="form-control"/>
            </div>
            <div class="form-group">
                <label for="mobile">Số điện thoại</label>
                <input type="text" name="mobile" id="mobile"
                       value="<?php echo isset($order['mobile']) ? $order['mobile'] : '' ?>"
                       class="form-control"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       value="<?php echo isset($order['email']) ? $order['email'] : '' ?>"
                        class="form-control"/>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú</label>
                <textarea name="note" id="note"
                          class="form-control"><?php echo isset($order['note']) ? $order['note'] : '' ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="order_status">Trạng thái đơn hàng</label>
                
                <select name="order_status" id="order_status" class="form-control">
                    
                    <option value="0" <?php echo ($order['order_status'] == 0) ? 'selected' : ''; ?>>
                        Chờ xác nhận
                    </option>
                    <option value="1" <?php echo ($order['order_status'] == 1) ? 'selected' : ''; ?>>
                        Chờ giao hàng
                    </option>
                    <option value="2" <?php echo ($order['order_status'] == 2) ? 'selected' : ''; ?>>
                        Đang giao
                    </option>
                    <option value="3" <?php echo ($order['order_status'] == 3) ? 'selected' : ''; ?>>
                        Đã giao
                    </option>
                    <option value="4" <?php echo ($order['order_status'] == 4) ? 'selected' : ''; ?>>
                        Huỷ hàng
                    </option>
                </select>
            </div>
            </div>
    </div>
    <br>
    <div class="form-group">
        <input type="submit" name="submit" value="Save" class="btn btn-primary"/>
        <a href="index.php?controller=order" class="btn btn-default">Back</a>
    </div>
</form>