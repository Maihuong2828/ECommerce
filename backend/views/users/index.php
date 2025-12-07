<h2>Tìm kiếm tài khoản</h2>
<form action="" method="GET">
    <input type="hidden" name="controller" value="user">
    <input type="hidden" name="action" value="index">
    
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="keyword">Từ khóa (Tên, Email, SĐT, Username...)</label>
                <input type="text" id="keyword" name="keyword" 
                       value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" 
                       class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="is_admin">Phân quyền</label>
                <select id="is_admin" name="is_admin" class="form-control">
                    <option value="">--- Tất cả ---</option>
                    <option value="1" <?php echo (isset($_GET['is_admin']) && $_GET['is_admin'] == '1') ? 'selected' : ''; ?>>Admin</option>
                    <option value="0" <?php echo (isset($_GET['is_admin']) && $_GET['is_admin'] == '0') ? 'selected' : ''; ?>>User</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
             <label>&nbsp;</label>
            <div class="form-group">
                <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary">
                <a href="index.php?controller=user&action=index" class="btn btn-default">Xóa filter</a>
            </div>
        </div>
    </div>
</form>

<hr>

<h2>Quản lý Tài khoản (User)</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID (user_id)</th>
            <th>Username</th>
            <th>Họ và Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Phân quyền</th>
            <th>Thời gian tạo</th>
            <th>Thời gian cập nhật</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['last_name'] . ' ' . $user['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                    <td>
                        <?php 
                            // Hiển thị vai trò
                            echo ($user['is_admin'] == 1) 
                                ? '<span class="label label-danger">Admin</span>' 
                                : '<span class="label label-success">User</span>'; 
                        ?>
                    </td>
                    <td>
                        <?php echo !empty($user['created_at']) ? date('d-m-Y H:i:s', strtotime($user['created_at'])) : ''; ?>
                    </td>
                    <td>
                        <?php 
                        // Chỉ hiển thị nếu đã có cập nhật
                        if (!empty($user['updated_at'])) {
                            echo date('d-m-Y H:i:s', strtotime($user['updated_at']));
                        }
                        ?>
                    </td>
                    <td>
                        <a href="index.php?controller=user&action=update&id=<?php echo $user['id']; ?>" title="Sửa" class="btn btn-xs btn-primary">
                            <i class="fa fa-pencil-square-o"></i> Sửa
                        </a>
                        <a href="index.php?controller=user&action=delete&id=<?php echo $user['id']; ?>" title="Xóa" class="btn btn-xs btn-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản <?php echo htmlspecialchars($user['username']); ?>? Hành động này không thể hoàn tác.')">
                            <i class="fa fa-trash"></i> Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">Không có tài khoản nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php echo isset($pages) ? $pages : ''; ?>