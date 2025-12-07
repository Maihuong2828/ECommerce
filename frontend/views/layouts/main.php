<?php
/*
 * ✅ TỐI ƯU HIỆU NĂNG:
 * - Bỏ require_once 'models/Category.php' và lệnh gọi Category::getAll()
 * vì biến $categories không được sử dụng ở bất kỳ đâu trong layout.
 */
require_once 'models/Contact.php';

// SỬA LỖI: Bỏ '\models\' ra khỏi tên class
$contact_model = new Contact();
$contacts = $contact_model->getAll();

?>
<!doctype html>
<html lang="en">
<base href="<?php echo $_SERVER['SCRIPT_NAME']; ?>" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><head>
    <link rel="shortcut icon" href="assets/images/favicon-moi.png" type="image/png" />
    <meta charset="utf-8" />
    <title>
        Digiworld Hà Nội
    </title>
    <meta name="keywords" content="Theme mặc định, Theme bán hàng, Theme haravan" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0' name='viewport' />
    <link rel="canonical" href="index.html" />
    <script type='text/javascript'>
        //<![CDATA[
        if ((typeof Haravan) === 'undefined') {
            Haravan = {};
        }
        Haravan.culture = 'vi-VN';
        Haravan.shop = 'growmax.myharavan.com';
        Haravan.theme = {
            "name": "Growmax- V1.1",
            "id": 1000382909,
            "role": "main"
        };
        Haravan.domain = 'growmax.myharavan.com';
        //]]>
    </script>
    <script type='text/javascript'>
        ! function() {
            var hrv_analytics = window.hrv_analytics = window.hrv_analytics || [];
            if (!hrv_analytics.initialize)
                if (hrv_analytics.invoked) window.console && console.error && console.error("Segment snippet included twice.");
                else {
                    hrv_analytics.invoked = !0;
                    hrv_analytics.methods = ["start", "trackSubmit", "trackClick", "trackLink", "trackForm", "pageview", "identify", "reset", "group", "track", "ready", "alias", "debug", "page", "once", "off", "on"];
                    hrv_analytics.factory = function(t) {
                        return function() {
                            var e = Array.prototype.slice.call(arguments);
                            e.unshift(t);
                            hrv_analytics.push(e);
                            return hrv_analytics
                        }
                    };
                    for (var t = 0; t < hrv_analytics.methods.length; t++) {
                        var e = hrv_analytics.methods[t];
                        hrv_analytics[e] = hrv_analytics.factory(e)
                    }
                    hrv_analytics.load = function(t, e) {
                        var n = document.createElement("script");
                        n.type = "text/javascript";
                        n.async = !0;
                        n.src = "../stats.hstatic.net/analyticsv3.min.js";
                        var a = document.getElementsByTagName("script")[0];
                        a.parentNode.insertBefore(n, a);
                        hrv_analytics._loadOptions = e
                    };
                    hrv_analytics.SNIPPET_VERSION = "4.1.0";
                    hrv_analytics.start('pro:web:1000098760');
                    hrv_analytics.page();
                    hrv_analytics.load();
                }
        }();
    </script>

    <script type='text/javascript'>
        window.HaravanAnalytics = window.HaravanAnalytics || {};
        window.HaravanAnalytics.meta = window.HaravanAnalytics.meta || {};
        window.HaravanAnalytics.meta.currency = 'VND';
        var meta = {
            "page": {
                "pageType": "home"
            }
        };
        for (var attr in meta) {
            window.HaravanAnalytics.meta[attr] = meta[attr];
        }
    </script>

    <script src="assets/js/jquery.min.1.11.0.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src='assets/js/option_selection.js' type='text/javascript'></script>
    <script src='assets/js/api.jquery.js' type='text/javascript'></script>

    <script>
        var formatMoney = '{{amount}}₫';
    </script>

    <script src='assets/js/scripts4c33.js?v=32' type='text/javascript'></script>

    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/jquery-migrate-1.2.0.min.js"></script>
    <script src='assets/js/jquery.touchSwipe.min.js' type='text/javascript'></script>
    <script data-target=".product-resize" data-parent=".products-resize" data-img-box=".image-resize" src="assets/js/fixheightproductv2.js"></script>
    <script src="assets/js/haravan.plugin.1.0.js"></script>



    <script src='assets/js/jquery.flexslider.js' type='text/javascript'></script>
    <script src='assets/js/owl.carousel.js' type='text/javascript'></script>
    <link href='assets/css/owl.carousel.css' rel='stylesheet' type='text/css' media='all' />


    <script src='assetsV/js/jquery.fancybox.js' type='text/javascript'></script>
    <link href='assets/css/jquery.fancybox.css' rel='stylesheet' type='text/css' media='all' />
    <script src='assets/js/jquery.fancybox-media4c33.js?v=32' type='text/javascript'></script>




    <script src='assets/js/15-jquery.total-storage.min4c33.js?v=32' type='text/javascript'></script>
    <script src='assets/js/loadimage4c33.js?v=32' type='text/javascript'></script>
    <script src='assets/js/jquery-ui.min4c33.js?v=32' type='text/javascript'></script>
    <script src='assets/js/jquery.ui.touch-punch.min4c33.js?v=32' type='text/javascript'></script>

    <script type="text/javascript" src="assets/js/addthis_widget.js#pubid=ra-54aa0592190a1461" async="async"></script>
    <link href='assets/css/page-contact-form.css' rel='stylesheet' type='text/css' media='all' />








    <meta property="og:type" content="website" />
    <meta property="og:title" content="ThanhCanh" />
    <meta property="og:image" content="http://theme.hstatic.net/1000098760/1000382909/14/share_fb_home.png?v=32" />
    <meta property="og:image:secure_url" content="https://theme.hstatic.net/1000098760/1000382909/14/share_fb_home.png?v=32" />



    <meta property="og:url" content="https://growmax.myharavan.com/" />
    <meta property="og:site_name" content="GrowMax" />


    <link rel="stylesheet" href="assets/css/bootstrap.3.3.1.css">
    <link href='assets/css/bootstrap-theme4c33.css?v=32' rel='stylesheet' type='text/css' media='all' />
    <link href='assets/css/font-awesome.min.css' rel='stylesheet' type='text/css' media='all' />

    <link href='assets/css/flexslider.css' rel='stylesheet' type='text/css' media='all' />
    <link href='assets/css/style4c33.css?v=32' rel='stylesheet' type='text/css' media='all' />
    <link href='assets/css/style-grow4c33.css?v=32' rel='stylesheet' type='text/css' media='all' />
    <link href='assets/css/responsive4c33.css?v=32' rel='stylesheet' type='text/css' media='all' />

    <link href='assets/css/css1.css?v=32' rel='stylesheet' type='text/css' media='all' />









</head>

<body>

    <header class="header">
        <div class="head-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 top-mobile">
                        <ul class="social">

                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>



                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>



                            <li><a href="#"><i class="fa fa-google"></i></a></li>



                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>



                            <li><a href="#"><i class="fa fa-flickr"></i></a></li>



                            <li><a href="#"><i class="fa fa-skype"></i></a></li>


                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="logo text-center">

                            <h1>
                                <a href="index.php?controller=home&action=index">
                                    <img src="assets/images/logo-moi.png" alt="Digiworld Hà Nội" class="img-responsive" />
                                </a>
                            </h1>


                            <h1 style="display:none">
                                <a href="index.php?controller=home&action=index">Thế Giới Công Nghệ</a>
                            </h1>



                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="header-control clearfix">
                            <div class="top-menu">


                                <div class="account-header">
                                    <div style="display: flex;">

                                        <div style="display: inline-block;
    vertical-align: top;
    width: 42px ;
    height: 42px;
    background: #000;
    text-align: right;
    font-size: 17px;
    transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    -webkit-transition: all 0.2s ease-in;
    padding: 7px 80px 0px 0px;
    margin: 18px 44px 0px 0px ;
    cursor: pointer;">
                                            <h4 style="text-align: right; color: #FFFFFF;"> <?php if (isset($_SESSION['user'])) : ?>
                                                    <?php echo $_SESSION['user']['username']; ?>
                                                <?php endif; ?>
                                            </h4>
                                        </div>
                                        <div class="account-block">

                                            <i class="user-top fa fa-user"></i>
                                        </div>
                                    </div>



                                    <div class="account-list">
                                        <ul class="account-links" style="text-align: left; font-weight: bold; font-size: 20px;">

                                            <?php if (isset($_SESSION['user'])) : ?>

                                                <li>
                                                    <a href="index.php?controller=user&action=history">
                                                        <span class="fa fa-history"></span>
                                                        Lịch sử đặt hàng
                                                    </a>
                                                </li>

                                                <?php echo '<li><a href="index.php?controller=login&action=logout">
                                                    <span class="fa fa-sign-out"></span>
                                                    Đăng xuất
                                                </a></li>'; ?>
                                            <?php else : ?>
                                                <?php echo '<li><a href="index.php?controller=login&action=signup" title="Đăng ký">
                                                    <span class="fa fa-user"></span>
                                                    Đăng ký
                                                </a></li>

                                            <li><a href="index.php?controller=login&action=login" title="Đăng nhập">
                                                    <span class="fa fa-sign-in"></span>
                                                    Đăng nhập
                                                </a></li>'; ?>
                                            <?php endif; ?>

                                        </ul>
                                    </div>
                                </div>

                                <div id="cart_block">
                                    <div class="cart-heading">
                                        <i class="cart-icon">
                                            <img src="assets/images/icon-cart-hover4c33.png?v=32" class="cart-icon-hover" alt="">
                                            <img src="assets/images/icon-cart4c33.png?v=32" class="cart-icon-standard" alt=""></i>
                                    </div>

                                    <div id="clone-item" style="display: none;">
                                        <div class="item_2 clearfix hidden item-ajax item-cart clearfix">
                                            <div class="nav-bar-item">
                                                <figure class="image-cart">
                                                    <a href="#">
                                                        <img src="#">
                                                    </a>
                                                </figure>
                                                <div class="text_cart">
                                                    <h4>
                                                        <a href="#"></a>
                                                    </h4>
                                                    <span class="variant"></span>
                                                    <div class="price-line">
                                                        <span class="quantity"></span> x
                                                        <span class="new-price"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cart_content" id="view-cart">
                                        <?php
                                        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) :
                                        ?>
                                            <div style="padding: 40px 20px; font-size:15px;">
                                                <p style="margin:0" class="text-center">Giỏ hàng của bạn đang trống</p>
                                                <p class="text-center"><a href="index.php?controller=product&action=showAll">Tiếp tục mua hàng</a></p>
                                            </div>

                                        <?php
                                          else :
                                            // (B) Nếu giỏ hàng có hàng
                                        ?>
                                            <div class="cart-block-item">
                                                <?php $total_price = 0; ?>
                                                <?php foreach ($_SESSION['cart'] as $product_id => $cart) : ?>
                                                    <?php
                                                    $subtotal = $cart['price'] * $cart['quality'];
                                                    $total_price += $subtotal;
                                                    // Giả định link ảnh (dựa trên 'avatar' từ session)
                                                    $cart_avatar = "../backend/assets/uploads/" . $cart['avatar'];
                                                    // Giả định link sản phẩm
                                                    $product_link = "index.php?controller=product&action=detail&id=$product_id";
                                                    ?>

                                                    <div class="item_2 clearfix item-ajax item-cart clearfix">
                                                        <div class="nav-bar-item">
                                                            <figure class="image-cart">
                                                                <a href="<?php echo $product_link; ?>">
                                                                    <img src="<?php echo $cart_avatar; ?>">
                                                                </a>
                                                            </figure>
                                                            <div class="text_cart">
                                                                <h4>
                                                                    <a href="<?php echo $product_link; ?>">
                                                                        <?php echo $cart['name']; ?>
                                                                    </a>
                                                                </h4>
                                                                <div class="price-line">
                                                                    <span class="quantity" style="font-weight: bold;"><?php echo $cart['quality']; ?></span> x
                                                                    <span class="new-price"><?php echo number_format($cart['price']); ?> đ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>
                                            </div> <div class="total-cart" style="padding: 10px 20px; border-top: 1px solid #ddd;">
                                                <p style="font-weight: bold; font-size: 16px; margin: 0 0 10px 0;">
                                                    Tổng tiền:
                                                    <span style="float:right; color: red;"><?php echo number_format($total_price); ?> đ</span>
                                                </p>
                                                <p style="margin:0 0 10px 0;" class="text-center">
                                                    <a href="index.php?controller=cart&action=index" style="background: #000; color: #fff; padding: 10px; display: block; text-decoration: none;">
                                                        Xem chi tiết giỏ hàng
                                                    </a>
                                                </p>
                                                <p class="text-center" style="margin-bottom: 5px;"><a href="index.php?controller=product&action=showAll">Tiếp tục mua hàng</a></p>
                                            </div>

                                        <?php endif; ?>
                                    </div> </div>

                                <style>
                                    .cart-block-item {
                                        max-height: 300px;
                                        overflow-y: auto; /* Sửa thành cuộn dọc */
                                    }
                                </style>


                            </div>
                            <div class="sponline">
                                <?php
                                // $contacts đã được định nghĩa ở đầu file
                                foreach ($contacts as $contact) :
                                ?>
                                    Hotline hỗ trợ: <span class="phonehl">
                                        <?php echo $contact['hotline']; ?>
                                    </span><?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="head-2">
            <div class="container">
                <div class="mainmenu">
                    <div class="searchform">
                        <form action="index.php?controller=product&action=showAll" method="post" class="search">
                            <input type="hidden" name="type" value="product">
                            <input type="text" placeholder="Tìm kiếm" name="str-product-name">
                            <button type="submit"><img src="assets/images/icon_search4c33.png?v=32" alt=""></button>
                        </form>
                    </div>
                    <div class="menu-subnav" style="font-weight: bold;">
                        <ul class="cssmenu">


                            <li>
                                <a href="index.php?controller=home&action=index" class="current" title="Trang chủ">Trang chủ </a>
                            </li>


                            <li>
                                <a href="index.php?controller=product&action=showAll" title="Sản phẩm">Sản Phẩm</a>
                            </li>

                            <li>
                                <a href="index.php?controller=new&action=index" class="" title="Tin tức">Tin tức </a>
                            </li>


                            <li>
                                <a href="index.php?controller=introduce&action=index" class="" title="Giới thiệu">Giới thiệu </a>
                            </li>


                            <li>
                                <a href="index.php?controller=contact&action=index" class="" title="Liên hệ">Liên hệ </a>
                            </li>


                        </ul>
                    </div>
                    <div id="menu-gadget">
                        <div class="row">

                            <div id="menu-icon">menu</div>

                            <ul class="menu">


                                <li>
                                    <a href="index.php?controller=home&action=index" class="current" title="Trang chủ">Trang chủ </a>
                                </li>


                                <li>
                                    <a href="index.php?controller=product&action=showAll" title="Sản phẩm">Sản Phẩm</a>
                                </li>

                                <li>
                                    <a href="index.php?controller=new&action=index" class="" title="Tin tức">Tin tức </a>
                                </li>


                                <li>
                                    <a href="index.php?controller=introduce&action=index" class="" title="Giới thiệu">Giới thiệu </a>
                                </li>


                                <li>
                                    <a href="index.php?controller=contact&action=index" class="" title="Liên hệ">Liên hệ </a>
                                </li>

                            </ul>

                            <script>
                                jQuery("#menu-icon").on("click", function() {
                                    jQuery("#menu-gadget .menu").slideToggle();
                                    jQuery(this).toggleClass("active");
                                });

                                jQuery('#menu-gadget .menu').find('li>ul').before('<i class="fa fa-angle-down"></i>');
                                jQuery('#menu-gadget .menu li i').on("click", function() {
                                    if (jQuery(this).hasClass('fa-angle-up')) {
                                        jQuery(this).removeClass('fa-angle-up').parent('li').find('> ul').slideToggle();
                                    } else {
                                        jQuery(this).addClass('fa-angle-up').parent('li').find('> ul').slideToggle();
                                    }
                                });
                            </script>




                        </div>

                    </div>
                </div>
            </div>
        </div>

        <header>

            <div class="clear"></div>

            <?php
            // Lấy controller từ URL, nếu không có thì mặc định là 'home'
            $controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
            // Chỉ hiển thị banner nếu controller là 'home'
            if ($controller == 'home') :
            ?>
                <aside class="slider">

                    <div class="slider-default">
                        <div class="flexslider-container">
                            <div class="flexslider">
                                <ul class="slides">

                                    <?php
                                    // Kiểm tra $slides tồn tại (vì $slides chỉ đc controller Home truyền vào)
                                    if (isset($slides) && !empty($slides)) {
                                        foreach ($slides as $slide) : ?>

                                            <li>
                                                <a href="#">
                                                    <img src="../backend/assets/uploads/<?php echo $slide['avatar'] ?>" />
                                                </a>
                                            </li>
                                    <?php
                                        endforeach;
                                    }
                                    ?>



                                </ul>
                                <div class="flex-controls"></div>
                            </div>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>


            <div class="clear"></div>
            <main class="container">
                <?php
                if (isset($_SESSION['error'])) {
                    //hiển thị mảng theo key trong 1 chuỗi mà ko cần nối chuỗi
                    //sử dụng ký tự {} bao lấy mảng đó
                    echo "<div class='alert alert-danger'>
        {$_SESSION['error']}
        </div>";
                    unset($_SESSION['error']);
                }

                /* * ✅ ĐÃ SỬA LỖI LẶP 2 DÒNG "Fullname...":
                 * Đã comment (ẩn) đoạn code bên dưới để tránh
                 * lặp lại lỗi (vì lỗi này đã được in ở file view)
                 */
                /*
                if (!empty($this->error)) {
                    echo "<div class='alert alert-danger'>
        $this->error
        </div>";
                }
                */

                if (isset($_SESSION['success'])) {
                    //hiển thị mảng theo key trong 1 chuỗi mà ko cần nối chuỗi
                    //sử dụng ký tự {} bao lấy mảng đó
                    echo "<div class='alert alert-success'>
        {$_SESSION['success']}
        </div>";
                    unset($_SESSION['success']);
                }
                ?>
            </main>
            <?php
            //hiển thị nội dung động tương ứng của từng view
            echo $this->content;
            ?>
            <footer class="footer">
                <div class="register-news">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 wow slideInLeft">
                                <div class="content-register-news">
                                    <h3>ĐĂNG KÝ NHẬN BẢN TIN</h3>
                                    <p>Để cập nhật những thông tin mới nhất về Digiworld Hà Nội</p>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="form-register-news">
                                    <form accept-charset='UTF-8' action='#' class='contact-form' method='post'>
                                        <input name='form_type' type='hidden' value='customer'>
                                        <input name='utf8' type='hidden' value='✓'>

                                        <input type="email" name="contact[email]" class="form-control" placeholder="Vui lòng nhập email của bạn">
                                        <input type="submit" value="ĐĂNG KÝ">

                                    </form>
                                </div>

                            </div>

                            <div class="col-md-4 wow slideInRight">
                                <div class="footer-hotline">
                                    <p>HOTLINE HỖ TRỢ: </p>
                                    <?php
                                    // $contacts đã được định nghĩa ở đầu file
                                    foreach ($contacts as $contact) :
                                    ?>
                                        <h3><?php echo $contact['hotline']; ?></h3>
                                    <?php endforeach; ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


                <div class="coppyright">
                    <p>Copyright © 2022 Digiworld Hà Nội. <a target='_blank' href='https://sv.dhcnhn.vn/'>Powered by NL</a>.</p>
                </div>

                <style>
                    .footer .register-news {
                        background-color: #000000; /* Nền đen cho phần đăng ký tin */
                    }
                    .footer .coppyright {
                        background-color: #000000; /* Nền đen cho phần copyright */
                    }
                    .footer .content-register-news h3 {
                        color: #FFFFFF; /* Chữ "ĐĂNG KÝ NHẬN BẢN TIN" màu trắng */
                    }
                    .footer .content-register-news p,
                    .footer .footer-hotline p,
                    .footer .footer-hotline h3,
                    .footer .coppyright p {
                        color: #FFFFFF; /* Chữ còn lại trong footer màu trắng */
                    }
                    .footer .coppyright p a {
                        color: #CCCCCC; /* Link trong footer màu xám nhạt */
                    }
                </style>
            </footer>

            <a href="#" class="scrollToTop">
                <i class="fa fa-chevron-up"></i>
            </a>



            <link href='assets/css/animate.min.css' rel='stylesheet' type='text/css' media='all' />
            <script src='assets/js/wow.js' type='text/javascript'></script>
            <script>
                new WOW().init();
            </script>
</body>



</html>