<?php
// ... (code PHP ở đầu file giữ nguyên) ...
?>
<header class="main-header">
    <a href="index2.html" class="logo">
        <span class="logo-mini"><b>A</b>LT</span>
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <i class="fa fa-bars"></i>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/images/anhdaidien.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">
                            <?php echo $_SESSION['admin']['username']; ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="assets/images/anhdaidien.jpg" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $_SESSION['admin']['username']?> - Web Developer
                                <small>Thành viên từ năm 2012</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="index.php?controller=login&action=logout"
                                   class="btn btn-default btn-flat">
                                    Sign out
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/images/anhdaidien.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['admin']['username']?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">LAOYOUT ADMIN</li>

            <li>
                <a href="index.php?controller=category&action=index">
                    <i class="fa fa-th"></i> <span>Quản lý danh mục</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li>
                <a href="index.php?controller=product&action=index">
                    <i class="fa fa-lemon"></i> <span>Quản lý sản phẩm</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li>
                <a href="index.php?controller=order&action=index">
                    <i class="fa fa-shopping-basket"></i> <span>Quản lý đơn hàng</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            
            <li>
                <a href="index.php?controller=user&action=index">
                    <i class="fa fa-users"></i> <span>Quản lý tài khoản</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            </ul>
    </section>
    </aside>

<div class="breadcrumb-wrap content-wrap content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
</div>