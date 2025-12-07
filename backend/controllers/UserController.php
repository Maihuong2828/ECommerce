<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';
require_once 'models/Pagination.php'; // Thêm model Pagination

class UserController extends Controller
{
    // Hàm khởi tạo để kiểm tra quyền Admin
    public function __construct()
    {
        // Kiểm tra admin đăng nhập
        // Nếu chưa đăng nhập HOẶC đã đăng nhập nhưng không phải admin (is_admin != 1)
        
        // ĐÃ SỬA: Kiểm tra $_SESSION['admin'] thay vì $_SESSION['user']
        if (!isset($_SESSION['admin']) || $_SESSION['admin']['is_admin'] != 1) {
            $_SESSION['error'] = 'Bạn cần đăng nhập với quyền Admin để vào trang này';
            // Chuyển hướng về trang login của backend
            header('Location: index.php?controller=login&action=login');
            exit();
        }
    }

    /**
     * Action: index (Xem danh sách tài khoản)
     * URL: index.php?controller=user&action=index
     * ĐÃ CẬP NHẬT: Thêm tìm kiếm và phân trang
     */
    public function index()
    {
        $user_model = new User();
        
        // Lấy ID admin hiện tại để không hiển thị chính mình trong danh sách
        // ĐÃ SỬA: Lấy từ $_SESSION['admin']
        $current_admin_id = $_SESSION['admin']['id'];

        // Lấy tổng số bản ghi
        $count_total = $user_model->countTotal($current_admin_id);

        // Xử lý chuỗi query string để gắn vào link phân trang
        $query_additional = '';
        if (isset($_GET['keyword'])) {
            $query_additional .= '&keyword=' . $_GET['keyword'];
        }
        if (isset($_GET['is_admin']) && $_GET['is_admin'] !== '') {
            $query_additional .= '&is_admin=' . $_GET['is_admin'];
        }

        // Cấu hình mảng params cho Pagination
        $arr_params = [
            'total' => $count_total,
            'limit' => 5, // Giới hạn 5 user/trang
            'query_string' => 'page',
            'controller' => 'user',
            'action' => 'index',
            'full_mode' => false,
            'query_additional' => $query_additional,
            'page' => isset($_GET['page']) ? $_GET['page'] : 1
        ];

        // Lấy danh sách user theo phân trang
        $users = $user_model->getAllPagination($arr_params, $current_admin_id);
        
        // Khởi tạo đối tượng Pagination
        $pagination = new Pagination($arr_params);

        // Lấy HTML phân trang
        $pages = $pagination->getPagination();

        // Truyền dữ liệu ra view
        $this->content = $this->render('views/users/index.php', [
            'users' => $users,
            'pages' => $pages // Truyền HTML phân trang ra view
        ]);
        
        // Gọi layout chính
        require_once 'views/layouts/main.php';
    }

    /**
     * Action: update (Sửa tài khoản)
     * URL: index.php?controller=user&action=update&id=<user_id>
     */
    public function update()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user&action=index');
            exit();
        }
        $id = $_GET['id'];
        $user_model = new User();
        $user = $user_model->getById($id); // Lấy thông tin user để đổ ra form

        // Xử lý submit form
        if (isset($_POST['submit'])) {
            // Gán giá trị từ form cho model
            $user_model->first_name = $_POST['first_name'];
            $user_model->last_name = $_POST['last_name'];
            $user_model->phone = $_POST['phone'];
            $user_model->address = $_POST['address'];
            $user_model->email = $_POST['email'];
            $user_model->is_admin = $_POST['is_admin'];
            $user_model->updated_at = date('Y-m-d H:i:s'); // Lấy thời gian cập nhật
            
            $is_update = $user_model->update($id);
            if ($is_update) {
                $_SESSION['success'] = 'Cập nhật tài khoản thành công';
            } else {
                $_SESSION['error'] = 'Cập nhật tài khoản thất bại';
            }
            header('Location: index.php?controller=user&action=index');
            exit();
        }

        // Truyền dữ liệu ra view
        $this->content = $this->render('views/users/update.php', [
            'user' => $user
        ]);
        
        // Gọi layout chính
        require_once 'views/layouts/main.php';
    }

    /**
     * Action: delete (Xoá tài khoản)
     * URL: index.php?controller=user&action=delete&id=<user_id>
     */
    public function delete()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user&action=index');
            exit();
        }
        $id = $_GET['id'];
        
        // Không cho phép admin tự xóa chính mình
        // ĐÃ SỬA: Lấy từ $_SESSION['admin']
        if ($id == $_SESSION['admin']['id']) {
            $_SESSION['error'] = 'Bạn không thể tự xóa tài khoản của mình!';
            header('Location: index.php?controller=user&action=index');
            exit();
        }

        $user_model = new User();
        $is_delete = $user_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa tài khoản thành công';
        } else {
            $_SESSION['error'] = 'Xóa tài khoản thất bại';
        }
        header('Location: index.php?controller=user&action=index');
        exit();
    }
}
?>