<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php'; // ✅ ĐÃ SỬA LỖI TYPO
require_once 'models/Order.php'; // Bổ sung model Order

class UserController extends Controller {
    
    public function history() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để xem lịch sử đơn hàng';
            header('Location: index.php?controller=login&action=login');
            exit();
        }
        
        // 2. Lấy đơn hàng
        $user_id = $_SESSION['user']['id'];
        $order_model = new Order();
        $orders = $order_model->getOrdersByUserId($user_id);

        $this->content = $this->render('views/users/history.php', [
            'orders' => $orders
        ]);
        require_once 'views/layouts/main.php';
    }

    /**
     * ✅ Phương thức mới để hủy đơn
     */
    public function cancel() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để thực hiện chức năng này';
            header('Location: index.php?controller=login&action=login');
            exit();
        }
        
        // 2. Kiểm tra ID đơn hàng
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID đơn hàng không hợp lệ';
            header('Location: index.php?controller=user&action=history');
            exit();
        }

        $order_id = $_GET['id'];
        $user_id = $_SESSION['user']['id'];
        
        // 3. Gọi Model để xử lý hủy
        $order_model = new Order();
        // Lấy thông tin đơn hàng để kiểm tra
        $order = $order_model->getOrderByIdAndUserId($order_id, $user_id);

        // 4. Kiểm tra xem đơn hàng có tồn tại và thuộc user này không
        if (!$order) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại hoặc không phải của bạn';
            header('Location: index.php?controller=user&action=history');
            exit();
        }
        
        // 5. Kiểm tra trạng thái có hợp lệ để hủy không (0 hoặc 1)
        if ($order['order_status'] != 0 && $order['order_status'] != 1) {
            $_SESSION['error'] = 'Không thể huỷ đơn hàng ở trạng thái này';
            header('Location: index.php?controller=user&action=history');
            exit();
        }

        // 6. Tiến hành cập nhật
        $is_cancelled = $order_model->cancelOrder($order_id, $user_id);
        
        if ($is_cancelled) {
            $_SESSION['success'] = "Đã huỷ thành công đơn hàng #$order_id";
            // (Nâng cao: Tại đây bạn có thể thêm logic hoàn lại số lượng sản phẩm vào kho)
        } else {
            $_SESSION['error'] = "Huỷ đơn hàng #$order_id thất bại, vui lòng thử lại";
        }

        header('Location: index.php?controller=user&action=history');
        exit();
    }
}