<h2>Chỉnh sửa tài khoản: <?php echo htmlspecialchars($user['username']); ?></h2>

<form action="" method="post">
    <div class="form-group">
        <label for="username">Tài khoản (Username)</label>
        <input type="text" id="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
        <small class="form-text text-muted">Không thể thay đổi tên tài khoản</small>
    </div>

    <div class="form-group">
        <label for="last_name">Họ</label>
        <input type="text" name="last_name" id="last_name" class="form-control" 
               value="<?php echo isset($user['last_name']) ? htmlspecialchars($user['last_name']) : ''; ?>">
    </div>

    <div class="form-group">
        <label for="first_name">Tên</label>
        <input type="text" name="first_name" id="first_name" class="form-control" 
               value="<?php echo isset($user['first_name']) ? htmlspecialchars($user['first_name']) : ''; ?>">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" 
               value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>">
    </div>

    <div class="form-group">
        <label for="phone">Số điện thoại</label>
        <input type="text" name="phone" id="phone" class="form-control" 
               value="<?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?>">
    </div>

    <div class="form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" name="address" id="address" class="form-control" 
               value="<?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?>">
    </div>

    <div class="form-group">
        <label for="is_admin">Phân quyền</label>
        <select name="is_admin" id="is_admin" class="form-control">
            <option value="0" <?php echo ($user['is_admin'] == 0) ? 'selected' : ''; ?>>
                User (Người dùng)
            </option>
            <option value="1" <?php echo ($user['is_admin'] == 1) ? 'selected' : ''; ?>>
                Admin (Quản trị viên)
            </option>
        </select>
    </div>

    <br>
    <div class="form-group">
        <input type="submit" name="submit" value="Lưu thay đổi" class="btn btn-primary">
        <a href="index.php?controller=user&action=index" class="btn btn-default">Quay lại</a>
    </div>
</form>