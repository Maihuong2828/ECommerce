<?php

require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/Category.php';

class OrderController extends Controller
{
    public function index()
    {
        $order_model = new Order();
        
        // Lấy từ khóa tìm kiếm
        $search_query = isset($_GET['query']) ? $_GET['query'] : null;
        
        // Lấy trạng thái lọc (kiểm tra !== '' để cho phép lọc cả status 0)
        $filter_status = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : null;
        
        // Truyền cả hai vào hàm getAll()
        $orders = $order_model->getAll($search_query, $filter_status);

        $this->content = $this->render('views/orders/index.php', [
            'orders' => $orders
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail()
    {
        $id = $_GET['id'];
        $order_model = new Order();
        $order = $order_model->getById($id);

        $this->content = $this->render('views/orders/detail.php', [
            'order' => $order
        ]);
        require_once 'views/layouts/main.php';
    }

    public function update()
    {
        $id = $_GET['id'];
        $order_model = new Order();
        $order = $order_model->getById($id);
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=order');
            exit();
        }


        //xử lý submit form
        if (isset($_POST['submit'])) {
            
            $fullname = $_POST['fullname'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $note = $_POST['note'];
            $order_status = $_POST['order_status']; 

            //xử lý validate
            if (empty($fullname)) {
                $this->error = 'Không được để trống fullname';
            } else if (empty($address)) {
                $this->error = 'Không được để trống address';
            } else if (empty($mobile)) {
                $this->error = 'Không được để trống mobile';
            } else if (empty($email)) {
                $this->error = 'Không được để trống email';
            }

            //nếu không có lỗi thì tiến hành save dữ liệu
            if (empty($this->error)) {
                //save dữ liệu vào bảng news
                $order_model->fullname = $fullname;
                $order_model->address = $address;
                $order_model->mobile = $mobile;
                $order_model->email = $email;
                $order_model->note = $note;
                $order_model->order_status = $order_status; 
                $order_model->updated_at = date('Y-m-d H:i:s');

                $is_update = $order_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=order');
                exit();
            }
        }


        $this->content = $this->render('views/orders/update.php', [
            'order' => $order
        ]);
        require_once 'views/layouts/main.php';
    }
}