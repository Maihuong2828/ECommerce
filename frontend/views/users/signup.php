<style>
    .validation-group {
        position: relative;
    }
    .large_form input.text {
        position: relative;
        z-index: 1;
        background-color: transparent;
    }
    /* Viền đỏ cho input lỗi */
    .large_form input.text.has-error {
        border-color: #dc3545 !important;
    }
    /* Thông báo lỗi (nằm bên dưới) */
    .error-message {
        color: #dc3545;
        font-size: 13px;
        display: none;
        margin-top: 5px;
        text-align: left;
    }
</style>


<section class="page-banner">
    <div class="auto-container text-center clearfix">
        <h1>Tạo tài khoản</h1>
    </div>
</section>
<div class="container">
    <div class="row">
        <div id="layout-account" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="userbox">
                <div class="header-account clearfix">
                    <i class="fa fa-key"></i><h2>Tạo tài khoản</h2>
                </div>

                <?php if (isset($this->error)): ?>
                    <div class="alert alert-danger" style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; text-align: left;">
                        <?php echo $this->error; ?>
                    </div>
                <?php endif; ?>

                <form accept-charset='UTF-8' action="" id='create_customer' method='post'>
                    <input name='form_type' type='hidden' value='create_customer'>
                    <input name='utf8' type='hidden' value='✓'>
                    <div id="last_name" class="clearfix large_form">
                        <label for="last_name" class="label icon-field">Họ</label>
                        <input required type="text" value="" name="last_name" placeholder=" Vui lòng điền họ" class="text" size="30" />
                    </div>
                    <div id="first_name" class="clearfix large_form">
                        <label for="first_name" class="label icon-field">Tên</label>
                        <input required type="text" value="" name="first_name" placeholder="Vui lòng điền tên" class="text" size="30" />
                    </div>

                    <div class="clearfix large_form">
                        <label for="username" class="icon-field">Tài khoản *</label>
                        <div class="validation-group">
                            <input required type="text" value="" name="username" id="username" placeholder="Vui lòng nhập tên tài khoản" class="text" autocomplete="off" />
                            </div>
                        <small class="error-message"></small>
                    </div>

                    <div class="clearfix large_form">
                        <label for="password" class="icon-field">Mật khẩu *</label>
                        <div class="validation-group">
                            <input required type="password" name="password" id="password" placeholder="Vui lòng nhập mật khẩu" class="text" size="16" autocomplete="off" />
                        </div>
                        <small class="error-message"></small>
                    </div>

                    <div class="clearfix large_form">
                        <label for="phone" class="icon-field">Số điện thoại *</label>
                        <div class="validation-group">
                            <input required type="text" name="phone" id="phone" placeholder="Vui lòng nhập số điện thoại" class="text" />
                        </div>
                        <small class="error-message"></small>
                    </div>

                    <div class="clearfix large_form">
                        <label for="address" class="icon-field">Địa chỉ</label>
                        <input required type="text" name="address" placeholder="Vui lòng điền địa chỉ" class="text" />
                    </div>

                    <div id="email" class="clearfix large_form">
                        <label for="email" class="label icon-field">Đia chỉ email *</label>
                        <div class="validation-group">
                            <input required type="email" value="" placeholder="Vui lòng điền địa chỉ email" name="email" id="email_input" class="text" size="30" />
                        </div>
                        <small class="error-message"></small>
                    </div>

                    <div class="action_bottom">
                        <input class="btn" type="submit" name="submit" value="Đăng ký" id="btn-signup" />
                    </div>
                    <div class="req_pass">
                        <a class="come-back" href="index.php">Quay về</a>
                    </div>
                </form> 

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        // Lấy các đối tượng input
        var $username = $('#username');
        var $password = $('#password');
        var $phone = $('#phone');
        var $email = $('#email_input'); // Lấy input email
        
        var debounceTimer;

        // --- HÀM VALIDATION ---

        // Username
        $username.on('keyup input', function() {
            var username = $username.val();
            var $parentDiv = $(this).closest('.large_form');
            var $errorMsg = $parentDiv.find('.error-message');
            
            clearTimeout(debounceTimer);

            if (username.length > 0 && username.length < 3) { 
                showError($username, $errorMsg, 'Username phải có ít nhất 3 ký tự');
                return;
            }

            if (username.length >= 3) {
                debounceTimer = setTimeout(function() {
                    $.ajax({
                        url: 'index.php?controller=login&action=checkUsername',
                        type: 'GET',
                        data: { username: username },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.exists) {
                                showError($username, $errorMsg, 'Username này đã tồn tại');
                            } else {
                                showSuccess($username, $errorMsg);
                            }
                        }
                    });
                }, 500);
            } else {
                 showSuccess($username, $errorMsg); // Xóa lỗi nếu trường rỗng
            }
        });

        // Password
        $password.on('keyup input', function() {
            var password = $password.val();
            var $parentDiv = $(this).closest('.large_form');
            var $errorMsg = $parentDiv.find('.error-message');
            var passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,15}$/;

            if (password.length > 0 && !passRegex.test(password)) { 
                showError($password, $errorMsg, 'Mật khẩu 8-15 ký tự (phải có hoa, thường, số, ký tự đặc biệt)');
            } else {
                showSuccess($password, $errorMsg);
            }
        });

        // Phone
        $phone.on('keyup input', function() {
            var phone = $phone.val();
            var $parentDiv = $(this).closest('.large_form');
            var $errorMsg = $parentDiv.find('.error-message');
            var phoneRegex = /^0[0-9]{9}$/;

            if (phone.length > 0 && !phoneRegex.test(phone)) { 
                showError($phone, $errorMsg, 'SĐT phải có 10 số và bắt đầu bằng 0');
            } else {
                showSuccess($phone, $errorMsg);
            }
        });

        // SỬA: Email validation (Rule 2)
        $email.on('keyup input', function() {
            var email = $email.val();
            var $parentDiv = $(this).closest('.large_form');
            var $errorMsg = $parentDiv.find('.error-message');
            
            // Chỉ kiểm tra khi người dùng đã gõ gì đó
            if (email.length > 0) {
                // Nếu không chứa ký tự '@'
                if (!email.includes('@')) { 
                    showError($email, $errorMsg, "Vui lòng bao gồm '@' trong địa chỉ email");
                } 
                // Nếu có '@' nhưng không hợp lệ (ví dụ: abc@) - dùng regex đơn giản
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                     showError($email, $errorMsg, "Định dạng email không hợp lệ");
                }
                // Nếu hợp lệ
                else {
                    showSuccess($email, $errorMsg);
                }
            } else {
                // Nếu trường rỗng, xóa lỗi
                showSuccess($email, $errorMsg);
            }
        });

        // --- HÀM HIỂN THỊ LỖI / THÀNH CÔNG ---

        // SỬA: Đã bỏ $icon (Rule 1)
        function showError($input, $errorMsg, message) {
            $input.addClass('has-error');
            $errorMsg.text(message).show();
        }

        // SỬA: Đã bỏ $icon (Rule 1)
        function showSuccess($input, $errorMsg) {
            $input.removeClass('has-error');
            $errorMsg.text('').hide();
        }
        
        // SỬA: Đã bỏ hàm checkAllValidation()

    });
</script>