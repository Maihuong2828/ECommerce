<?php
require_once 'helpers/Helper.php';
?>
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>Admin</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Đăng nhập</p>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($this->error)): ?>
            <div class="alert alert-danger">
                <?php echo $this->error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" 
                       value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" 
                       placeholder="Username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" 
                       value="" 
                       placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">
                        Đăng nhập
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>