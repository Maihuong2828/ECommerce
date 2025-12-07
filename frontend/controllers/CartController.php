<?php
//controllers/CartController.php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/Slide.php';
require_once 'models/Contact.php';

class CartController extends Controller
{
    //chức năng thêm vào giỏ hàng
    public function add()
    {
        // BƯỚC 1: KIỂM TRA ĐĂNG NHẬP
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng';
            header('Location: index.php?controller=login&action=login');
            exit();
        }

        // BƯỚC 2: LOGIC THÊM VÀO GIỎ
        
        // ==========================================================
        // BẮT ĐẦU SỬA: LẤY SỐ LƯỢNG VÀ ID SẢN PHẨM
        // ==========================================================
        
        // Lấy ID sản phẩm (từ GET, hoạt động cho cả link và form)
        $product_id = $_GET['id'];
        
        // Lấy số lượng: từ POST (trang chi tiết) hoặc mặc định là 1 (trang danh sách)
        $quantity_to_add = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        // Đảm bảo số lượng luôn ít nhất là 1
        if ($quantity_to_add < 1) {
            $quantity_to_add = 1;
        }

        //gọi model để lấy thông tin sản phẩm
        $product_model = new Product();
        $product = $product_model->getById($product_id);

        // ==========================================================
        // SỬA: KIỂM TRA SỐ LƯỢNG TỒN KHO (Logic mới)
        // ==========================================================
        
        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại!';
            header('Location: index.php?controller=home&action=index'); // Về trang chủ
            exit();
        }

        // Lấy số lượng hiện tại trong giỏ (nếu có)
        $current_quantity_in_cart = isset($_SESSION['cart'][$product_id]['quality']) ? $_SESSION['cart'][$product_id]['quality'] : 0;
        
        // Tính tổng số lượng mong muốn
        $total_desired_quantity = $current_quantity_in_cart + $quantity_to_add;

        // So sánh tổng mong muốn với số lượng tồn kho
        // $product['quantity'] là số lượng tồn kho từ CSDL
        if ($total_desired_quantity > $product['quantity']) {
            $_SESSION['error'] = "Số lượng trong giỏ ('$total_desired_quantity') vượt quá số lượng tồn kho ('{$product['quantity']}')!";
            header('Location: ' . $_SERVER['HTTP_REFERER']); // Quay lại trang trước
            exit();
        }
        // ==========================================================
        // KẾT THÚC SỬA PHẦN KIỂM TRA
        // ==========================================================

        //logic giỏ hàng
        //nếu sp chưa tồn tại trong giỏ hàng
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['title'],
                'price' => $product['price'],
                'avatar' => $product['avatar'],
                // ==========================================================
                // SỬA: Dùng $quantity_to_add thay vì 1
                'quality' => $quantity_to_add, 
                // ==========================================================
                'stock_quantity' => $product['quantity'] 
            ];
        } else {
            //nếu sp đã tồn tại trong giỏ hàng
            // ==========================================================
            // SỬA: Cộng thêm $quantity_to_add thay vì ++
            $_SESSION['cart'][$product_id]['quality'] += $quantity_to_add;
            // ==========================================================
        }
        
        $_SESSION['success'] = 'Thêm sản phẩm vào giỏ hàng thành công';
        //chuyển hướng về trang giỏ hàng
        header('Location: index.php?controller=cart&action=index');
        exit();
    }

    //trang giỏ hàng của bạn
    public function index()
    {
        //xử lý update giỏ hàng
        //khi user click nút Cập nhật giỏ hàng
        if (isset($_POST['submit'])) {
            //lặp giỏ hàng, gán lại số lượng cho từng sp
            //nếu số lượng là số âm thì báo lỗi
            foreach ($_SESSION['cart'] as $product_id => $cart) {
                $product_model = new Product();
                $product = $product_model->getById($product_id);
                $stock_quantity = $product['quantity']; // Lấy số lượng tồn kho mới nhất
                
                if ($_POST[$product_id] < 0) {
                    $_SESSION['error'] = 'Số lượng phải > 0';
                    header('Location: index.php?controller=cart&action=index');
                    exit();
                }
                
                // ✅ SỬA LOGIC: Kiểm tra số lượng cập nhật với tồn kho
                if ($_POST[$product_id] > $stock_quantity) {
                     $_SESSION['error'] = "Sản phẩm '{$cart['name']}' chỉ còn {$stock_quantity} chiếc trong kho.";
                     // Lưu lại dữ liệu post để hiển thị lại trên form
                     $_SESSION['post_data_on_fail'] = $_POST;
                     header('Location: index.php?controller=cart&action=index');
                     exit();
                }

                //gán lại số lượng
                $_SESSION['cart'][$product_id]['quality'] =
                    $_POST[$product_id];
                // Cập nhật lại số lượng tồn kho trong session (nếu cần)
                $_SESSION['cart'][$product_id]['stock_quantity'] = $stock_quantity;
            }
            $_SESSION['success'] = 'Cập nhật giỏ hàng thành công';
            // Xóa dữ liệu post cũ nếu thành công
            unset($_SESSION['post_data_on_fail']);
        }
        
        // ✅ SỬA LOGIC: Kiểm tra tồn kho khi tải trang
        // (Phòng trường hợp người khác mua mất hàng trong khi mình đang xem giỏ)
        $session_stock_error = null;
        $post_data_on_fail = $_SESSION['post_data_on_fail'] ?? []; // Lấy dữ liệu post cũ (nếu có)
        unset($_SESSION['post_data_on_fail']); // Xóa đi sau khi lấy
        
        if (!isset($_POST['submit'])) { // Chỉ kiểm tra khi tải trang, không kiểm tra khi vừa submit
             $product_model = new Product();
             foreach($_SESSION['cart'] as $product_id => &$cart) {
                 $product = $product_model->getById($product_id);
                 $current_stock = $product ? $product['quantity'] : 0; // Kiểm tra nếu sản phẩm bị xóa
                 $cart['stock_quantity'] = $current_stock; // Cập nhật tồn kho mới nhất
                 
                 if ($cart['quality'] > $current_stock) {
                     $session_stock_error = "Số lượng tồn kho của sản phẩm '{$cart['name']}' đã thay đổi. Vui lòng cập nhật lại giỏ hàng.";
                     // Không break để cập nhật hết tồn kho cho các sản phẩm khác
                 }
             }
             unset($cart); // Hủy tham chiếu
        }


        //lấy slide
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();
        //lấy contact
        $contact_model = new Contact();
        $contacts = $contact_model->getAll();
        //lấy nội dung view, gán vào layout
        $this->content =
            $this->render('views/carts/index.php', [
                'slides' => $slides,
                'contacts' => $contacts,
                'session_stock_error' => $session_stock_error, // Truyền lỗi tồn kho ra view
                'post_data_on_fail' => $post_data_on_fail // Truyền dữ liệu post (nếu có) ra view
            ]);
        //gọi layout
        require_once 'views/layouts/main.php';
    }

    //xóa sản phẩm khỏi giỏ hàng
    public function delete()
    {
        $product_id = $_GET['id'];
        //xóa phần tử mảng dựa theo key
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['success'] = 'Xóa sản phẩm khỏi giỏ hàng thành công';
        //chuyển hướng về trang giỏ hàng
        header('Location: index.php?controller=cart&action=index');
        exit();
    }
}