<?php
//controllers/PaymentController.php
require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/OrderDetail.php';
require_once 'models/Product.php';
require_once 'models/Slide.php';
require_once 'models/Contact.php';
require_once 'models/Product.php';
// ... (require PHPMailer) ...
require_once 'configs/PHPMailer/src/PHPMailer.php';
require_once 'configs/PHPMailer/src/SMTP.php';
require_once 'configs/PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PaymentController extends Controller
{
    public function index()
    {
        //xử lý submit form khi user click THanh toán
        if (isset($_POST['submit'])) {
            
            // ... (Phần kiểm tra tồn kho) ...
            if (isset($_SESSION['cart'])) {
                $product_model = new Product();
                foreach ($_SESSION['cart'] as $product_id => $cart) {
                    $product = $product_model->getById($product_id);
                    $stock = $product['quantity']; 
                    if ($cart['quality'] > $stock) {
                        
                        $this->error = "Sản phẩm '{$product['title']}' chỉ còn {$stock} sản phẩm (bạn đang đặt {$cart['quality']}). Vui lòng <a href='index.php?controller=cart&action=index' class='btn btn-danger btn-sm'>cập nhật lại giỏ hàng</a>.";
                        
                        break;
                    }
                }
            }

            $fullname = $_POST['fullname'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $note = $_POST['note'];
            $method = $_POST['method']; // Biến này vẫn dùng để điều hướng

            if (empty($this->error)) {
                if (empty($fullname) || empty($address) || empty($mobile)) {
                    $this->error = 'Fullname, address, mobile không đc để trống';
                }
            }
            
            if (empty($this->error)) {
                $order_model = new Order();
                
                $user_id = NULL; 
                if (isset($_SESSION['user'])) {
                    $user_id = $_SESSION['user']['id'];
                }
                
                $price_total = 0;
                foreach ($_SESSION['cart'] as $cart) {
                    $price_item = $cart['price'] * $cart['quality'];
                    $price_total += $price_item;
                }
                
                
                // Loại bỏ $method (tham số thứ 8) ra khỏi lệnh gọi hàm insert()
                $order_id = $order_model->insert(
                    $user_id,
                    $fullname,
                    $address,
                    $mobile,
                    $email,
                    $note,
                    $price_total
                );

                if ($order_id > 0) {
                    // ... (Phần lưu order_detail giữ nguyên) ...
                    $order_detail_model = new OrderDetail();
                    $order_detail_model->order_id = $order_id;
                    $product_model = new Product();
                    foreach ($_SESSION['cart'] as $product_id => $cart) {
                        $order_detail_model->product_id = $product_id;
                        $order_detail_model->quality = $cart['quality']; 
                        $order_detail_model->insert();
                        $product_model->updateQuantityAfterOrder($product_id, $cart['quality']); 
                    }
                
                    // ... (Phần gửi mail, redirect giữ nguyên) ...
                    $_SESSION['order_info'] = [
                        'order_id' => $order_id,
                        'fullname' => $fullname,
                        'address' => $address,
                        'mobile' => $mobile,
                        'email' => $email,
                        'note' => $note,
                        'price_total' => $price_total,
                    ];
                    $_SESSION['order_cart'] = $_SESSION['cart'];
                    
                    // Logic chuyển hướng của bạn vẫn dùng $method như bình thường
                    if ($method == 0) { 
                        header("Location: index.php?controller=payment&action=online");
                        exit();
                    } else { 
                        $this->sendMail($email);
                        unset($_SESSION['cart']);
                        header("Location: index.php?controller=payment&action=confirmation");
                        exit();
                    }
                }
            }
        }
        
        // ... (Phần lấy slide, contact giữ nguyên) ...
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();
        $contact_model = new Contact();
        $contacts = $contact_model->getAll();

        $this->content =
            $this->render('views/payments/index.php', [
                'slides' => $slides,
                'contacts' => $contacts
            ]);
        require_once 'views/layouts/main.php';
    }

    // ... (Các hàm confirmation, sendMail giữ nguyên) ...
    public function confirmation()
    {
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();
        $contact_model = new Contact();
        $contacts = $contact_model->getAll();

        $this->content = $this->render('views/payments/order_confirmation.php', [
            'slides' => $slides,
            'contacts' => $contacts
        ]);
        require_once 'views/layouts/main.php';
    }
    
    public function sendMail($email)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'timnguoiquen01@gmail.com';
            $mail->Password   = 'imfyvbtrgktxiedz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->setFrom('timnguoiquen01@gmail.com', 'Gửi từ Digital World');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Cảm ơn bạn đã đặt hàng!';
            $mail->Body    = "Chào $email, Cảm ơn bạn đã tin tưởng sử dụng sản phẩm của Digital World. Mong bạn sẽ hài lòng khi sử dụng dịch vụ từ chúng tôi.";
            $mail->send();
        } catch (Exception $e) {
        }
    }

    public function thank()
    {
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();
        $contact_model = new Contact();
        $contacts = $contact_model->getAll();

        // Đã sửa lỗi cú pháp $this.content -> $this->content
        $this->content = $this->render('views/payments/thank.php', [
                'slides' => $slides,
                'contacts' => $contacts
            ]);
        require_once 'views/layouts/main.php';
    }

    public function online()
    {
        // Đã sửa lỗi cú pháp $this.content -> $this->content
        $this->content = $this->render('configs/nganluong/index.php');
        echo $this->content;
        
        /**
         * ✅ ĐÃ SỬA LỖI LẶP 2 DÒNG:
         * Thêm exit() để ngăn không cho layout 'main.php' chạy
         * và echo $this->content thêm một lần nữa.
         */
        exit();
    }
}