<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class LoginController extends Controller
{

    public function login()
    {
        // Nếu user đã đăng nhập VÀ LÀ ADMIN, chuyển thẳng vào trong,
        // không cho ở lại trang login nữa.
        if (isset($_SESSION['admin']) && $_SESSION['admin']['is_admin'] == 1) {
            header('Location: index.php?controller=category&action=index');
            exit();
        }

        if (isset($_POST['submit'])) {
            //gán biến
            $username = $_POST['username'];
            $password = $_POST['password'];
            //validate
            if (empty($username) || empty($password)) {
                $this->error = 'Phải nhập username và password';
            }
            
            //xử lý login
            if (empty($this->error)) {
                $user_model = new User();
                $password = md5($password);
                $user = $user_model->getUserLogin($username, $password);

                // KIỂM TRA PHÂN QUYỀN (ĐÃ SỬA)
                if (empty($user)) {
                    // 1. Kiểm tra sai thông tin
                    $this->error = 'Sai username hoặc password';
                } elseif ($user['is_admin'] != 1) {
                    // 2. Kiểm tra có phải admin không
                    $this->error = 'Tài khoản này không có quyền truy cập vào trang Admin!';
                } else {
                    // 3. Đăng nhập thành công
                    //login thành công, tạo session
                    $_SESSION['admin'] = $user;
                    //chuyển hướng về trang admin
                    header('Location: index.php?controller=category&action=index');
                    exit();
                }
            }
        }
        
        //gọi layout để hiển thị view
        // Sửa lỗi cú pháp $this.content và $this.render
        $this->content = $this->render('views/users/login.php');
        require_once 'views/layouts/main_login.php';
    }

    /**
     * Hàm logout
     * Xóa session và chuyển hướng về trang login
     */
    public function logout()
    {
        unset($_SESSION['admin']);
        $_SESSION['success'] = 'Đăng xuất thành công';
        header('Location: index.php?controller=login&action=login');
        exit();
    }
}
?>