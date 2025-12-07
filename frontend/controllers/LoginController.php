<?php
    //xử lý đăng nhập đăng ký cho user
    require_once 'controllers/Controller.php';
    require_once 'models/User.php';
    require_once 'models/Slide.php';
    require_once 'models/Contact.php';
    
    class LoginController extends Controller {

        //xử lý đăng ký user
        public function signup() {
            
            $user_model = new User();

            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $first_name = $_POST['first_name'];
                $last_name= $_POST['last_name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $email = $_POST['email'];

                // Gán lại giá trị vào model
                $user_model->username = $username;
                $user_model->first_name = $first_name;
                $user_model->last_name = $last_name;
                $user_model->phone = $phone;
                $user_model->address = $address;
                $user_model->email = $email;

                // --- VALIDATION PHÍA SERVER ---
                if (empty($username) || empty($password)) {
                    $this->error = 'Username hoặc password không được để trống!';
                } 
                else if (!preg_match('/^0[0-9]{9}$/', $phone)) {
                    $this->error = 'Số điện thoại phải có 10 chữ số và bắt đầu bằng số 0';
                }
                else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,15}$/', $password)) {
                    $this->error = 'Mật khẩu phải từ 8-15 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt';
                }
                // SỬA: Thêm validation cho email (Rule 2)
                else if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->error = 'Email không đúng định dạng';
                }
                else {
                    $user = $user_model->getUserByUsername($username); 
                    if (!empty($user)) {
                        $this->error = 'Tên tài khoản này đã tồn tại, vui lòng chọn tên khác';
                    }
                }
                // --- KẾT THÚC VALIDATION ---

                if (empty($this->error)) {
                    $user_model->password = md5($password);
                    $is_register = $user_model->insert(); 
                    
                    if($is_register){
                        $_SESSION['success'] = 'Đăng ký thành công!';
                        header('Location: index.php?controller=login&action=login');
                        exit();
                    } else {
                        $this->error = 'Đăng ký thất bại, vui lòng thử lại!';
                    }
                }
            }
            
            $slide_model = new Slide();
            $slides = $slide_model->getSlide();
            $contact_model = new Contact();
            $contacts = $contact_model->getAll();
            
            $this->is_login_page = true;
            
            $this->content = $this->render('views/users/signup.php', [
                'slides' => $slides,
                'contacts' => $contacts,
            ]);
            require_once 'views/layouts/main.php';
        }

        public function checkUsername() {
            $this->layout = null; 
            $username = isset($_GET['username']) ? $_GET['username'] : '';
            if (empty($username)) {
                echo json_encode(['exists' => false]);
                exit();
            }
            $user_model = new User();
            $user = $user_model->getUserByUsername($username);
            if ($user) {
                echo json_encode(['exists' => true]);
            } else {
                echo json_encode(['exists' => false]);
            }
            exit(); 
        }

        //xử lý login
        public function login() {
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                if (empty($username) || empty($password)) {
                    $this->error = 'Không được để trống trường username hoặc password';
                }
                
                if (empty($this->error)) {
                    $user_model = new User();
                    $password = md5($password);
                    $user = $user_model->getUser($username, $password); 

                    if (empty($user)) {
                        $this->error = 'Sai username hoặc password';
                    } else {
                        $_SESSION['success'] = 'Đăng nhập thành công';
                        $_SESSION['user'] = $user;
                        if ($user['is_admin'] == 1) {
                            header('Location: ../backend/index.php');
                            exit();
                        } else {
                            header('Location: index.php');
                            exit();
                        }
                    }
                }
            }
            $slide_model = new Slide();
            $slides = $slide_model->getSlide();
            $contact_model = new Contact();
            $contacts = $contact_model->getAll();
            $this->is_login_page = true;
            $this->content = $this->render('views/users/login.php', [
                'slides' => $slides,
                'contacts' => $contacts
            ]);
            require_once 'views/layouts/main.php';
        }

        //đăng xuất người dùng
        public function logout() {
             if (empty($_SESSION['user'])){
                $_SESSION['error'] = 'Bạn chưa đăng nhập!';
                header('Location: index.php?controller=login&action=login');
                exit();
            }else{
                unset($_SESSION['user']);
                $_SESSION['success'] = 'Logout thành công!';
                header('Location: index.php?controller=login&action=login');
                exit();
            }
        }
    } 
?>