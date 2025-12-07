<section id="wrapper-product-detail">
    <div class="container">
        <div class="row">
                <div  id="wrapper-detail">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-title">
                                <h1><?php echo $product['title']; ?> - <?php echo $product['weight']; ?></h1>
                                <div class="product_vendor"><?php echo $product['supplier']; ?> </div>
                                <div class="product_sku">
                                    <span id="pro_sku"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div id="surround">
                                <div class="white-product">


                                    <a class="slide-prev slide-nav" href="javascript:">
                                        <i class="fa fa-arrow-circle-o-left fa-2"></i>
                                    </a>
                                    <a class="slide-next slide-nav" href="javascript:">
                                        <i class="fa fa-arrow-circle-o-right fa-2"></i>
                                    </a>

                                    <img class="product-image-feature" src="../backend/assets/uploads/<?php echo $product['avatar']; ?>" alt="<?php echo $product['title']; ?> - <?php echo $product['weight']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="short_description">
                                <h4>
                                    Mô tả ngắn:
                                </h4>
                                <p>
                                    <?php echo $product['summary']; ?>	</p>
                            </div>
                            <div class="product-price" id="price-preview">
                                <span><?php echo number_format($product['price']); ?>đ</span>
                            </div>
                            <div class="product-quantity">
                            <strong>Số lượng còn lại:</strong> 
                            <?php echo $product['quantity'] > 0 ? $product['quantity'] : '<span style="color:red">Hết hàng</span>'; ?>
                            </div>


                            <?php if ($product['quantity'] > 0): ?>
                                <form id="add-item-form" action="index.php?controller=cart&action=add&id=<?php echo $product['id']; ?>" method="post" class="variants clearfix">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <div class="pd40 clearfix">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-12 col-sm-6 col-xs-12">
                                                <div class="quantity-box clearfix">
                                                    <div class="quantity-bgr">
                                                        <input type="number" id="Quantity" name="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>" class="quantity-selector">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
                                                <div class="box-add-cart">
                                                    <button type="submit" id="add-to-cart" class="btn-detail addtocart btn-color-add btn-min-width btn-mgt" name="add">
                                                        Thêm vào giỏ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="pd40 clearfix">
                                    <div class="box-add-cart">
                                        <button type="button" class="btn-detail btn-min-width btn-mgt" disabled style="background-color: #999; cursor: not-allowed;">
                                            Hết hàng
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="pt20">
                                <div class="addthis_toolbox addthis_default_style ">

                                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>


                                    <a class="addthis_button_google_plusone" g:plusone:size="medium" g:plusone:count="false"></a>

                                </div>
                                <script type="text/javascript" src="../../s7.addthis.com/js/250/addthis_widget.js"></script>
                                </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;">
                            <div role="tabpanel" class="product-comment">
                                <ul class="nav nav-tabs" id="page-product" role="tablist">
                                    <li role="presentation" ><a  href="#mota" aria-controls="mota" role="tab" data-toggle="tab">Mô tả sản phẩm</a></li>

                                    <li role="presentation">
                                        <a href="#binhluan" aria-controls="binhluan" role="tab" data-toggle="tab"  role="tab">Bình luận</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane" id="mota">
                                        <div class="container-fluid product-description-wrapper">

                                            <div>
                                                <?php echo $product['content'];?>
                                            </div>

                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane active" id="binhluan">
                                        <div class="container-fluid product-comment-wrapper">


                                            <div class="fb-comments" data-href="https://growmax.myharavan.com/products/bap-cai-tim" data-width="100%" data-numposts="5"></div>

                                            <div id="fb-root"></div>				<script>(function(d, s, id) {
                                                    var js, fjs = d.getElementsByTagName(s)[0];
                                                    if (d.getElementById(id)) return;
                                                    js = d.createElement(s); js.id = id;
                                                    js.src = "../../connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4&appId=1376564555975870";
                                                    fjs.parentNode.insertBefore(js, fjs);
                                                }(document, 'script', 'facebook-jssdk'));</script>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>