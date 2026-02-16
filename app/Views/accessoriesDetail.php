
<!DOCTYPE html>
<html lang="zxx">

<?php require("components/head.php"); ?>
<style>
    /* ================================================================= */
    .carousel-control-next-icon,
    .carousel-control-prev-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        background-color: rgba(0, 0, 0, 0.3) !important;
        background-size: 100% 100%;
        color: #fff !important
    }

   

    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .carousel-item.item.active>img {
        width: 100%;
        height: 400px;
        object-fit: contain;
    }

    .carousel-inner {
        box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.2), 0 6px 12px 0 rgba(0, 0, 0, 0.19);
    }

    .wish-status>.availableqty {
        color: #85a229 !important
    }

    .wish-status>.outofstockqty {
        color: red !important;
    }

    .view-chart {
        text-decoration: underline;
        color: var(--primary-color) !important;
        font-size: 15px;

    }

    .view-chart:hover {
        color: var(--primary-color) !important;
    }

    .share-btn {
        margin-left: -44%;
        margin-top: 2%;
        right:30px;
    }

    .owl-carousel .owl-stage-outer {
        padding: 23px 0 17px 0;
    }

    #section-product-details .de-price,
    .nav-tabs .nav-link.active {
        background-color: transparent;
    }

    .prod-description>strong {}

.prod-specification + ul {
    padding-left: 0;
    margin-left: 0;
    list-style-position: inside;
}

.prod-specification + ul li {
    margin-left: 0;
}

    /* ===== SHARE LINK INPUT  ===== */
.popup .field #copy-text {
    padding: 6px 8px;          
    white-space: nowrap;      
    overflow: hidden;         
    text-overflow: ellipsis;   
    font-size: 14px;
}

/* remove icon padding */
.popup .field input,
.popup .field #copy-text {
    padding-left: 0px !important;  
}

.field input { padding-left: 45px; }
.popup .field input { padding-left: 45px; }

/* Real Price */
.real_price.strike {
    font-weight: bold !important;    
    color: #777 ;         
}
@media only screen and (max-width: 500px) {
    .btn-detail div {
        padding: 1px;
}}


@media only screen and (min-width: 425px) and (max-width: 767px) {
    .block-with-text p {
        overflow: hidden !important;
    }
}
    
</style>

<body onload="initialize()" class="dark-scheme">
    <div id="wrapper">
        <?php require("components/header.php"); ?>
        <!-- content begin -->
        <div class="no-bottom no-top zebra">
            <div id="top"></div>
            <section id="section-product-details" class="px-5 pb-0">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-1 col-md-2 col-sm-3 col-4 p-0 web-view">
                            <div id="slider-thumbimage-desk">
                                <img class='slideshow-thumbnails active'
                                    src='<?= base_url() ?><?= $acc_details['product_img'] ?>'
                                    alt="<?php echo $acc_details['product_name'] ?>">

                                <?php
                                $baseurl = base_url();
                                for ($i = 0; $i <= 10; $i++) {
                                    $img = trim($acc_details["img_" . $i]);
                                    if (!empty($img) && $img != $baseurl) {
                                        ?>
                                        <img class="slideshow-thumbnails" src="<?= base_url() . $img ?>" />
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 web-view">
                            <div id='lens'></div>
                            <div id='slideshow-items-container'>
                                <img class='slideshow-items active'
                                    src='<?= base_url() ?><?= $acc_details['product_img'] ?>'>

                                <?php
                                for ($i = 0; $i <= 10; $i++) {
                                    if ($acc_details["img_" . $i] != "") { ?>
                                        <img class='slideshow-items' src='<?= base_url() ?><?= $acc_details["img_" . $i] ?>'>
                                    <?php }
                                } ?>
                                <form>

                                    <?php
                                    $offerType = $acc_details['offer_type'];
                                    $offerDetail = $acc_details['offer_details'];


                                    if ($offerType == 1 || $offerType == 2 || $offerDetail == 0) {
                                        ?>

                                    <?php } else { ?>
                                        <span class="offerrate offer"><?php echo $acc_details['offer_details'] ?>%</span>
                                    <?php }
                                    ?>

                                    <input type="hidden" name="prod_id" id="prod_id"
                                        value="<?php echo $acc_details['prod_id'] ?>" />
                                    <input type="hidden" name="tbl_name" id="tbl_name"
                                        value="<?php echo $tbl_name ?>" />
                                    <input type="hidden" name="user" id="user" value="<?php echo $user_idd ?>" />
                                    <a><span aria-hidden="true" class="icon_heart_alt wishlist-btn"></span></a>
                                    <a><span aria-hidden="true" class="fas fa-share-alt share-btn"
                                            id="share-btn"></span></a>
                                </form>
                            </div>
                            <div id='result'></div>
                        </div>
                        <div class="col-lg-6 mob-view">
                            <form>
                                <div id='slideshow-items-container'>
                                    <img class='slideshow-items-mob active'
                                        src='<?= base_url() ?><?= $acc_details['product_img'] ?>'>
                                    <?php
                                    for ($i = 0; $i <= 10; $i++) {
                                        if ($acc_details["img_" . $i] != "") { ?>
                                            <img class='slideshow-items-mob'
                                                src='<?= base_url() ?><?= $acc_details["img_" . $i] ?>'>
                                        <?php }
                                    } ?>
                                </div>

                                <div id='result'></div>
                                <div id="slider-thumbimage-mob">
                                    <img class='slideshow-thumbnails-mob active'
                                        src='<?= base_url() ?><?= $acc_details['product_img'] ?>'>
                                    <?php
                                    for ($i = 0; $i <= 10; $i++) {
                                        if ($acc_details["img_" . $i] != "") { ?>
                                            <img class='slideshow-thumbnails-mob'
                                                src='<?= base_url() ?><?= $acc_details["img_" . $i] ?>'>
                                        <?php }
                                    } ?>
                                </div>

                                <?php
                                $offerType = $acc_details['offer_type'];
                                $offerDetail = $acc_details['offer_details'];


                                if ($offerType == 1 || $offerType == 2 || $offerDetail == 0) {
                                    ?>

                                <?php } else { ?>
                                    <span class="offerrate offer"><?php echo $acc_details['offer_details'] ?>%</span>
                                <?php }
                                ?>



                                <input type="hidden" name="prod_id" id="prod_id"
                                    value="<?php echo $acc_details['prod_id'] ?>" />
                                <input type="hidden" name="tbl_name" id="tbl_name" value="<?php echo $tbl_name ?>" />
                                <a><span aria-hidden="true" class="icon_heart_alt wishlist-btn"></span></a>
                                <a><span aria-hidden="true" class="fas fa-share-alt share-btn"></span></a>
                            </form>
                        </div>
                        <div class="col-lg-7 pb-0 product_details">
                            <div class="de-price">
                                <span class="vehicle_name"><?php echo $acc_details['product_name'] ?></span>
                            </div>
                            <div class="d-block block-with-text pt-2">
                                <span class="m-0"><?php echo $acc_details['prod_desc'] ?></span>
                            </div>
                            <div class="de-box text-light">
                                <form name="contactForm" id='product-form' method="post">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                    <div class="col-lg-12 block-with-text p-0">
                                        <p class="offer_price">
                                            <?php
                                            $offerType = $acc_details['offer_type'];
                                            if (($offerType == 0) || ($offerType == 1)) {
                                                ?>
                                                <span
                                                    class="m-0 price_span">INR.<?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $acc_details['offer_price']) ?></span><span
                                                    class="real_price strike">
                                                    INR.<?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $acc_details['product_price']); ?></span>
                                                <?php
                                            } else { ?>
                                                <span
                                                    class="m-0 price_span">INR.<?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $acc_details['offer_price']) ?></span></span>
                                            <?php }
                                            ?>

                                        </p>


                                        <div class="d-flex align-items-center mb-3">
                                            <p class="mb-0">Quantity </p>
                                            <div class="number ml-3">
                                                <span class="minus">-</span>
                                                <input id="quantity" name="quantity" type="text" value="1" stock-qty=""
                                                    placeholder="1" readonly />
                                                <span class="plus">+</span>
                                            </div>
                                        </div>

                                        <!-- Stock & DropShipping start -->
                                        <div class="d-flex wish-status">
                                            <?php
                                            if ($acc_details['quantity'] <= 0) {
                                                $className = "outofstockqty";
                                                $quantity = "Out of Stock";
                                            } else {
                                                $className = "availableqty";
                                                $quantity = "Available";
                                            } ?>

                                            <p class="d-flex align-items-center <?php echo $className ?>">
                                                <span>Stock status </span>
                                                :&nbsp;<strong><?php echo $quantity ?></strong>
                                            </p>
                                        </div>

                                        <?php if ($acc_details['drop_shipping'] != 0) { ?>
                                            <div class="d-flex wish-status p-1 mb-2">
                                                <p class="d-flex align-items-center drop-shipping">
                                                    Drop Shipping :Product is only available
                                                    online
                                                </p>
                                            </div>
                                        <?php } ?>
                                        <!-- Stock & DropShipping end -->



                                        <input type="hidden" class="main-stock" value="<?= $acc_details['quantity'] ?>"
                                            data-sizeval="<?= $countSize ?>">
                                        <div class="addto_cart mb-4 ">
                                            <div class="col-lg-12 btn-detail p-0">
                                                <!-- Checkout type based on qty -->
                                                <?php
                                                if ($acc_details['quantity'] <= 0) { ?>
                                                    <div class="col-lg-8 contactus">
                                                        <a class="btn-main btn-fullwidth" type='button'
                                                            href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $acc_details['product_name'] . "\nProduct Price: " . $acc_details['product_price']); ?>">
                                                            Contact us to order</a>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-lg-4 pl-0">
                                                        <a type='button' id='addtocart'
                                                            class="btn-main btn-fullwidth addto_cartbtn">Add cart</a>
                                                    </div>
                                                    <div class="col-lg-4 ml-1 ">
                                                        <a id='buynowBtn' class="btn-main btn-fullwidth book_now">Buy
                                                            Now</a>
                                                    </div>
                                                <?php } ?>
                                                <!-- Checkout type based on qty end-->
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div class='row'>
                                        <div class='highlight-window' id='product-img'>
                                            <div class='highlight-overlay' id='highlight-overlay'></div>
                                        </div>


                                        <input type="hidden" name="config_image1" id="config_image"
                                            value="<?= $acc_details['product_img'] ?>" />
                                        <!-- <input type="hidden" name="color" id="color_val"
                                            value="<?php echo $acc_details['color'][0] ?>" /> -->
                                        <input type="hidden" name="size" id=""
                                            value="<?php echo $acc_details['size'][0] ?>" />

                                        <div class='window d-flex'>
                                            <?php
                                            $size = $acc_details['size'];
                                            $stock = $acc_details['stock'];
                                            if ($size[0] != "") {
                                                $count = count($size);

                                                if ($count > 0) { ?>
                                                    <div class='size-picker col-lg-6 col-md-6 p-0 mt-3'>
                                                        <p>Size:</p>

                                                        <select class='range-picker size-details' name="size"
                                                            id="size-<?php echo $i ?>">
                                                            <?php for ($i = 0; $i < $count; $i++) { ?>
                                                                <option value="<?php echo $size[$i] ?>"
                                                                    data-sizestock="<?php echo $stock[$i] ?>">
                                                                    <?php echo $size[$i] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <!-- <div class='size-picker-chart col-lg-6 col-md-6 p-0 mt-3'>
                                                                <p class="size-chart" id="size-chart">Size Chart:</p>
                                                                <a href="#" class="view-chart d-flex justify-content-start"><i class="fa fa-tag p-1"></i>
                                                                    View Size
                                                                </a>
                                                            </div> -->
                                                </div>
                                            <?php }
                                            } else { ?>
                                            <div class='size-picker col-lg-12 col-12 p-0 mt-3 d-none'></div>
                                        <?php } ?>
                                    </div>
                                    <!-- Corrected share button section -->

                                    <div class="popup">
                                        <header id="share-header">
                                            <p id="share-title">Share Link</p>
                                            <div class="close"><i class="fa fa-times"></i></div>
                                        </header>
                                        <div class="content">
                                            <p>Share this link via</p>
                                            <ul class="icons">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $current_url ?>"
                                                    class="fa fa-facebook social-media"></a>
                                                <a href="mailto:?subject=Check out this link&body=Here is the link: <?= $current_url ?>"
                                                    class="fa fa-envelope"></a>
                                                <a href="whatsapp://send?text=<?= $current_url ?>"
                                                    data-action="share/whatsapp/share" class="fa fa-whatsapp"></a>
                                                <a href="https://t.me/share/url?url=<?= $current_url ?>"
                                                    class="fa fa-telegram"></a>
                                            </ul>
                                            <p class="copy-link">Or copy link</p>
                                            <div class="field">
                                                <input type="text" id="copy-text" value="<?= $current_url ?>" style="margin-left: 4px;">
                                                <button class="btn-copy" onclick="Copyfunction()">Copy</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>


                            <div class="d-flex wish-status">
                                <?php
                                if ($acc_details['quantity'] <= 0) {
                                    $className = "outofstockqty";
                                    $quantity = "Out of Stock";
                                } else {
                                    $className = "availableqty";
                                    $quantity = "Available";
                                } ?>

                            </div>

                            <input type="hidden" name="table_name" id="table_name" value="<?php echo $tbl_name ?>" />
                            <input type="hidden" name="prod_id" id="prod_id"
                                value="<?php echo $acc_details['prod_id'] ?>" />
                            <input type="hidden" name="prod_price" id="prod_price"
                                value="<?php echo $acc_details['offer_price'] ?>" />
                            <input type="hidden" name="size_stock" id="size_stock" value="">

                            <!-- Stock based on Size -->
                            <?php
                            $ConfigSize = $acc_details['size'];
                            if (!empty($ConfigSize) && is_array($ConfigSize)) {
                                $countSize = count($ConfigSize);

                                // Additional check if the first element is empty
                                if ($countSize > 0 && ($ConfigSize[0] === "" || $ConfigSize[0] === null)) {
                                    $countSize = 0;
                                }

                            } else {
                                $countSize = 0;
                            }
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <!-- section begin -->
        <section aria-label="section" id="  details_section" class="py-0 px-5 ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="spacer30"></div>
                        <div class="tab-default">
                            <?php

                            if ($acc_details['prod_desc'] != "") { ?>
                                <nav>
                                    <div class="nav nav-tabs justify-content-start" id="nav-tab" role="tablist">
                                        <button class="nav-link active justify-content-start" id="nav-home-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab"
                                            aria-controls="nav-home" aria-selected="true">Description</button>
                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active nav-desc" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <p class="m-0 prod-description"><?php echo $acc_details['prod_desc'] ?></p>
                                    </div>

                                </div>
                            <?php } ?>

                        </div>
                        <?php if (!empty($acc_details['specifications'])): ?>
                            <div class="tab-default mt-3">
                                <nav>
                                    <div class="nav nav-tabs justify-content-start" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-spec-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Specification</button>
                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <p class="m-0 prod-specification"><?php echo $acc_details['specifications'] ?></p>
                                    </div>

                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- similar  products START -->
        <?php $totalCount = count($similar);
        if ($totalCount >= 3) { ?>
            <section id="section-newArrival" class="py-0 px-5 <?php echo $className ?>">
                <?php
                $recentCount = count($similar);
                $class = $recentCount <= 0 ? "display-none" : ""; ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 text-center newarrival_header  <?= $class ?>">
                            <h3>SIMILAR PRODUCTS</h3>
                            <!-- <span class="view_all">View all<i class="fa fa-angle-right d-none"></i></span> -->
                        </div>
                        <div class="col-12 col-carousel">
                            <div class="owl-carousel carousel-main">
                                <?php for ($i = 0; $i < count($similar); $i++) { ?>
                                    <div class="item">

                                        <div class="">

                                            <?php
                                            $tbl_name = $similar[$i]['tbl_name'];

                                            if ($tbl_name == "tbl_products") {
                                                $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                            } else if ($tbl_name == "tbl_accessories_list") {
                                                $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                            } else if ($tbl_name == "tbl_rproduct_list") {
                                                $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                            } else if ($tbl_name == "tbl_helmet_products") {
                                                $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                            } else if ($tbl_name == "tbl_luggagee_products") {
                                                $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                            } else if ($tbl_name == "tbl_camping_products") {
                                                $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                            }
                                            ?>
                                            <a href="<?php echo $url; ?>">
                                                <div class="de-item">
                                                    <?php
                                                    $offer = $similar[$i]['offer_details'];
                                                    if ($offer == 1 || $offer == 2 || $offer == "" || $offer == 0 || $offer == "-") {
                                                        $offerClass = "d-none";
                                                    } else {
                                                        $offerClass = "";

                                                    } ?>


                                                    <span class="discount-tag  <?= $offerClass ?>">
                                                        <?= $similar[$i]['offer_details'] ?>%<span class="off_span">off</span>
                                                    </span>

                                                    <div class="d-img">

                                                        <img src="<?php echo base_url() ?><?php echo $similar[$i]['product_img'] ?>"
                                                            class="img-fluid" alt="<?php echo $similar[$i]['product_name'] ?>">
                                                    </div>
                                                    <div class="d-info">
                                                        <div class="d-text">
                                                            <h4><?php echo $similar[$i]['product_name'] ?></h4>

                                                            <?php
                                                            $MRP = $similar[$i]['product_price'];
                                                            $RS = $similar[$i]['offer_price'];

                                                            if ($MRP == $RS) {
                                                                $Classname = "d-none";
                                                            } else {
                                                                $Classname = "";
                                                            }
                                                            ?>
                                                            <span
                                                                class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $similar[$i]['offer_price']) ?>
                                                                &nbsp;<small class="<?= $Classname ?>"
                                                                    style="text-decoration:line-through">₹<?php echo number_format($similar[$i]['product_price']) ?></small></span>



                                                            <p class="d-flex wish-status my-2">
                                                                <span class="d-flex align-items-center similar-products">
                                                                    <?php
                                                                    $stock = $similar[$i]['quantity'];
                                                                    if ($stock <= 0) { ?>
                                                                        <span class="product_status outof_stock">
                                                                            <label>Out of stock</label>
                                                                        </span>
                                                                    <?php } else {
                                                                        ?>
                                                                        <span class="product_status">
                                                                            <label>Available</label>
                                                                        </span>
                                                                    <?php } ?>
                                                                </span>
                                                            </p>

                                                            <?php
                                                            $stock = $similar[$i]['quantity'];
                                                            if ($stock <= 0) { ?>
                                                                <div>
                                                                    <a class="btn-main buynow_btn"
                                                                        href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $similar[$i]['product_name'] . "\nProduct Price: " . $similar[$i]['product_price']); ?>">Contact
                                                                        us to order</a>
                                                                </div>

                                                            <?php } else { ?>

                                                                <div>
                                                                    <?php
                                                                    $tbl_name = $similar[$i]['tbl_name'];

                                                                    if ($tbl_name == "tbl_products") {
                                                                        $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                                                    } else if ($tbl_name == "tbl_accessories_list") {
                                                                        $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                                                    } else if ($tbl_name == "tbl_rproduct_list") {
                                                                        $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                                                    } else if ($tbl_name == "tbl_helmet_products") {
                                                                        $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                                                    } else if ($tbl_name == "tbl_luggagee_products") {
                                                                        $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                                                    } else if ($tbl_name == "tbl_camping_products") {
                                                                        $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $similar[$i]['redirect_url'])) . "/" . base64_encode($similar[$i]['prod_id']);
                                                                    }
                                                                    ?>


                                                                    <a class="btn-main buynow_btn" href="<?php echo $url; ?>">Buy
                                                                        Now</a>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
        <!-- similar  products END -->

        <!--New Arrivals start -->

        <section id="section-newArrival" class="py-0 px-5 <?php echo $className ?>">
            <?php
            $similarCount = count($similarProducts);
            $class = $similarCount <= 0 ? "display-none" : ""; ?>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 text-center newarrival_header  <?= $class ?>">
                        <h3>RELATED PRODUCTS</h3>
                        <!-- <span class="view_all">View all<i class="fa fa-angle-right d-none"></i></span> -->
                    </div>
                    <div class="col-12 col-carousel">
                        <div class="owl-carousel carousel-main">
                            <?php
                            $renderedProductIDs = array();
                            ?>
                            <?php for ($i = 0; $i < count($similarProducts); $i++) {

                                if (!in_array($similarProducts[$i]['prod_id'], $renderedProductIDs)) {

                                    $renderedProductIDs[] = $similarProducts[$i]['prod_id'];
                                    ?>
                                    <div class="item">
                                        <div class="">

                                            <a
                                                href="<?php echo base_url() ?>accessories-detail/<?php echo strtolower(str_replace(' ', '-', $similarProducts[$i]['redirect_url'])) ?>/<?php echo base64_encode($similarProducts[$i]['prod_id']) ?>">
                                                <div class="de-item">
                                                    <?php
                                                    $offer = $similarProducts[$i]['offer_details'];
                                                    if ($offer == 1 || $offer == 2 || $offer == "" || $offer == 0 || $offer == "-") {
                                                        $offerClass = "d-none";
                                                    } else {
                                                        $offerClass = "";

                                                    } ?>

                                                    <span class="discount-tag  <?= $offerClass ?>">
                                                        <?= $similarProducts[$i]['offer_details'] ?>%<span
                                                            class="off_span">off</span>
                                                    </span>
                                                    <div class="d-img">

                                                        <img src="<?php echo base_url() ?><?php echo $similarProducts[$i]['product_img'] ?>"
                                                            class="img-fluid"
                                                            alt="<?php echo $similarProducts[$i]['product_name'] ?>">
                                                    </div>
                                                    <div class="d-info">
                                                        <div class="d-text">
                                                            <h4><?php echo $similarProducts[$i]['product_name'] ?></h4>

                                                            <?php
                                                            $MRP = $similarProducts[$i]['product_price'];
                                                            $RS = $similarProducts[$i]['offer_price'];

                                                            if ($MRP == $RS) {
                                                                $Classname = "d-none";
                                                            } else {
                                                                $Classname = "";
                                                            }
                                                            ?>
                                                            <span
                                                                class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $similarProducts[$i]['offer_price']) ?>
                                                                &nbsp;<small class="<?= $Classname ?>"
                                                                    style="text-decoration:line-through">₹<?php echo number_format($similarProducts[$i]['product_price']) ?></small></span>
                                                            <p class="d-flex wish-status my-2">
                                                                <span class="d-flex align-items-center similar-products">
                                                                    <?php
                                                                    $stock = $similarProducts[$i]['quantity'];
                                                                    if ($stock <= 0) { ?>
                                                                        <span class="product_status outof_stock">
                                                                            <label>Out of stock</label>
                                                                        </span>
                                                                    <?php } else {
                                                                        ?>
                                                                        <span class="product_status">
                                                                            <label>Available</label>
                                                                        </span>
                                                                    <?php } ?>
                                                                </span>
                                                            </p>

                                                            <?php
                                                            $stock = $similarProducts[$i]['quantity'];
                                                            if ($stock <= 0) { ?>
                                                                <div>
                                                                    <a class="btn-main buynow_btn"
                                                                        href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $similarProducts[$i]['product_name'] . "\nProduct Price: " . $similarProducts[$i]['product_price']); ?>">Contact
                                                                        us to order</a>
                                                                </div>

                                                            <?php } else { ?>

                                                                <div>
                                                                    <a class="btn-main buynow_btn"
                                                                        href="<?php echo base_url() ?>accessories-detail/<?php echo strtolower(str_replace(' ', '-', $similarProducts[$i]['redirect_url'])) ?>/<?php echo base64_encode($similarProducts[$i]['prod_id']) ?>">Buy
                                                                        Now</a>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!--Recently Viewed products  -->

        <section id="section-newArrival" class="py-0 px-5 <?php echo $className ?>">
            <?php
            $recentCount = count($recent_products);
            $class = $recentCount <= 0 ? "display-none" : ""; ?>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 text-center newarrival_header  <?= $class ?>">
                        <h3>RECENTLY VIEWED PRODUCTS</h3>
                        <!-- <span class="view_all">View all<i class="fa fa-angle-right d-none"></i></span> -->
                    </div>
                    <div class="col-12 col-carousel">
                        <div class="owl-carousel carousel-recent" data-count="<?= count($recent_products) ?>">
                            <?php for ($i = 0; $i < count($recent_products); $i++) { ?>
                                <div class="item">
                                    <div class="">

                                        <?php
                                        $tbl_name = $recent_products[$i]['tbl_name'];

                                        if ($tbl_name == "tbl_products") {
                                            $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } else if ($tbl_name == "tbl_accessories_list") {
                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } else if ($tbl_name == "tbl_rproduct_list") {
                                            $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } else if ($tbl_name == "tbl_helmet_products") {
                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } else if ($tbl_name == "tbl_luggagee_products") {
                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } else if ($tbl_name == "tbl_camping_products") {
                                            $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        }
                                        ?>
                                        <a href="<?php echo $url; ?>">
                                            <div class="de-item">
                                                <?php
                                                $offer = $recent_products[$i]['offer_details'];
                                                if ($offer == 1 || $offer == 2 || $offer == "" || $offer == 0 || $offer == "-") {
                                                    $offerClass = "d-none";
                                                } else {
                                                    $offerClass = "";

                                                } ?>


                                                <span class="discount-tag  <?= $offerClass ?>">
                                                    <?= $recent_products[$i]['offer_details'] ?>%<span
                                                        class="off_span">off</span>
                                                </span>
                                                <div class="d-img">

                                                    <img src="<?php echo base_url() ?><?php echo $recent_products[$i]['product_img'] ?>"
                                                        class="img-fluid"
                                                        alt="<?php echo $recent_products[$i]['product_name'] ?>">
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h4><?php echo $recent_products[$i]['product_name'] ?></h4>
                                                        <?php
                                                        $MRP = $recent_products[$i]['product_price'];
                                                        $RS = $recent_products[$i]['offer_price'];

                                                        if ($MRP == $RS) {
                                                            $Classname = "d-none";
                                                        } else {
                                                            $Classname = "";
                                                        }
                                                        ?>
                                                        <span
                                                            class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $recent_products[$i]['offer_price']) ?>
                                                            &nbsp;<small class="<?= $Classname ?>"
                                                                style="text-decoration:line-through">₹<?php echo number_format($recent_products[$i]['product_price']) ?></small></span>
                                                        <p class="d-flex wish-status my-2">
                                                            <span class="d-flex align-items-center similar-products">
                                                                <?php
                                                                $stock = $recent_products[$i]['quantity'];
                                                                if ($stock <= 0) { ?>
                                                                    <span class="product_status outof_stock">
                                                                        <label>Out of stock</label>
                                                                    </span>
                                                                <?php } else {
                                                                    ?>
                                                                    <span class="product_status">
                                                                        <label>Available</label>
                                                                    </span>
                                                                <?php } ?>
                                                            </span>
                                                        </p>

                                                        <?php
                                                        $stock = $recent_products[$i]['quantity'];
                                                        if ($stock <= 0) { ?>
                                                            <div>
                                                                <a class="btn-main buynow_btn"
                                                                    href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $recent_products[$i]['product_name'] . "\nProduct Price: " . $recent_products[$i]['product_price']); ?>">Contact
                                                                    us to order</a>
                                                            </div>

                                                        <?php } else { ?>

                                                            <div>
                                                                <?php
                                                                $tbl_name = $hotsale[$i]['tbl_name'];

                                                                if ($tbl_name == "tbl_products") {
                                                                    $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                                } else if ($tbl_name == "tbl_accessories_list") {
                                                                    $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                                } else if ($tbl_name == "tbl_rproduct_list") {
                                                                    $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                                } else if ($tbl_name == "tbl_helmet_products") {
                                                                    $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                                } else if ($tbl_name == "tbl_luggagee_products") {
                                                                    $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                                } else if ($tbl_name == "tbl_camping_products") {
                                                                    $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                                }
                                                                ?>


                                                                <a class="btn-main buynow_btn" href="<?php echo $url; ?>">Buy
                                                                    Now</a>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
    <!-- content close -->
    <a href="#" id="back-to-top"></a>
    <?php require("components/footer.php"); ?>

    <script>
        let main_stock = $(".main-stock").val();

        let sizecount = $(".main-stock").data('sizeval');
        let initialSize = "";
        let sizeStock = "";

        function updateQuantity(stock) {
            $("#quantity").val(1);
            $("#quantity").attr('stock-qty', stock);
            $("#size_stock").val(stock);
        }

        // Initial stock update based on size count
        if (sizecount <= 0) {
            $("#quantity").attr('stock-qty', main_stock);
            $("#size_stock").val(0);
        } else {
            sizeStock = $(".size-details option:selected").data("sizestock");
            updateQuantity(sizeStock);
        }

        // Event listener for size dropdown change
        $(".size-details").on("change", function () {
            let selectedSizeStock = $("option:selected", this).data("sizestock");

            if (selectedSizeStock !== undefined) {
                updateQuantity(selectedSizeStock);
            } else {
                $("#quantity").attr('stock-qty', main_stock);
                $("#size_stock").val(0);
            }
        });


    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var colors = document.querySelectorAll('.color');
            colors.forEach(function (color) {
                color.addEventListener('click', function () {
                    // Deselect all colors
                    colors.forEach(function (c) {
                        c.classList.remove('selected');
                        var radio = c.querySelector("input[type='radio']");
                        if (radio) {
                            radio.removeAttribute("checked");
                        }
                    });

                    // Select the clicked color
                    color.classList.add('selected');
                    var radio = color.querySelector("input[type='radio']");
                    if (radio) {
                        radio.setAttribute("checked", "checked");
                        var dataIndex = radio.getAttribute("data-id");
                        var prodID = radio.getAttribute("prod-id");
                        var colorID = $(radio).val();
                        $("#color_val").val(colorID);

                        // console.log(dataIndex);
                        var table_name = "tbl_rproduct_list";

                        console.log(dataIndex);

                        $.ajax({
                            type: "POST",
                            data: { prod_id: prodID, table_name: table_name, colorID: colorID },
                            url: base_Url + "get-varients",
                            dataType: "json",
                            success: function (data) {
                                $("#config_image").val(data.configImg1[0]);
                                // $("#displayed_image").attr("src", data.configImg1[0]);
                                console.log(data.configImg1[0]);
                                var sliderImage = "";

                                var SizeModule = "";
                                sliderImage += `
                                 <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100"
                                                src="${base_Url}${data.configImg1[0]}"
                                                alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100"
                                                src="${base_Url}${data.configImg2[0]}"
                                                alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100"
                                                src="${base_Url}${data.configImg3[0]}"
                                                alt="Third slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100"
                                                src="${base_Url}${data.configImg4[0]}"
                                                alt="Third slide">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>`;

                                $("#carouselExampleControls").html(sliderImage);


                                for (let j = 0; j < data.size.length; j++) {
                                    let size = data.size[j];


                                    SizeModule += ` 
                                                <div class='size-option'>
                                                    <input type="radio" name="size" id="size-${dataIndex}-${j}"
                                                        value="${size}" ${j === 0 ? 'checked' : ''}>
                                                    <label for="size-${dataIndex}-${j}">${size}</label>
                                                </div>`;

                                }

                                $("#range-picker").html(SizeModule);





                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log("Error Details:");
                                console.log("Status: " + textStatus);
                                console.log("Error Thrown: " + errorThrown);
                                console.log("Response Text: " + jqXHR.responseText);

                            },
                        });


                    }


                });
            });

        });

        document.getElementById('range-picker').addEventListener('click', function (e) {
            var sizeList = document.getElementById('range-picker').children;
            for (var i = 0; i <= sizeList.length - 1; i++) {
                console.log(sizeList[i].classList);
                if (sizeList[i].classList.contains('active')) {
                    sizeList[i].classList.remove('active');
                }
            }
            e.target.classList.add('active');
        })
    </script>




    <script>
        $(document).ready(function () {
            $('.slideshow-thumbnails').hover(function () { changeSlide($(this)); });
            $('.slideshow-thumbnails-mob').on('click', function () { changemobSlide($(this)) })

            $(document).mousemove(function (e) {

                var x = e.clientX; var y = e.clientY;

                var x = e.clientX; var y = e.clientY;

                var imgx1 = $('.slideshow-items.active').offset().left;
                var imgx2 = $('.slideshow-items.active').outerWidth() + imgx1;
                var imgy1 = $('.slideshow-items.active').offset().top;
                var imgy2 = $('.slideshow-items.active').outerHeight() + imgy1;

                if (x > imgx1 && x < imgx2 && y > imgy1 && y < imgy2) {
                    $('#lens').show(); $('#result').show();
                    imageZoom($('.slideshow-items.active'), $('#result'), $('#lens'));
                } else {
                    $('#lens').hide(); $('#result').hide();
                }

            });

        });

        function imageZoom(img, result, lens) {

            result.width(img.innerWidth()); result.height(img.innerHeight());
            lens.width(img.innerWidth() / 2); lens.height(img.innerHeight() / 2);

            result.offset({ top: img.offset().top, left: img.offset().left + img.outerWidth() + 10 });

            var cx = img.innerWidth() / lens.innerWidth(); var cy = img.innerHeight() / lens.innerHeight();

            result.css('backgroundImage', 'url(' + img.attr('src') + ')');
            result.css('backgroundSize', img.width() * cx + 'px ' + img.height() * cy + 'px');

            lens.mousemove(function (e) { moveLens(e); });
            img.mousemove(function (e) { moveLens(e); });
            lens.on('touchmove', function () { moveLens(); })
            img.on('touchmove', function () { moveLens(); })

            function moveLens(e) {
                var x = e.clientX - lens.outerWidth() / 2;
                var y = e.clientY - lens.outerHeight() / 2;
                if (x > img.outerWidth() + img.offset().left - lens.outerWidth()) { x = img.outerWidth() + img.offset().left - lens.outerWidth(); }
                if (x < img.offset().left) { x = img.offset().left; }
                if (y > img.outerHeight() + img.offset().top - lens.outerHeight()) { y = img.outerHeight() + img.offset().top - lens.outerHeight(); }
                if (y < img.offset().top) { y = img.offset().top; }
                lens.offset({ top: y, left: x });
                result.css('backgroundPosition', '-' + (x - img.offset().left) * cx + 'px -' + (y - img.offset().top) * cy + 'px');
            }
        }


        function changeSlide(elm) {

            $('.slideshow-items').removeClass('active');
            $('.slideshow-items').eq(elm.index()).addClass('active');
            $('.slideshow-thumbnails').removeClass('active');
            $('.slideshow-thumbnails').eq(elm.index()).addClass('active');
        }


        function changemobSlide(e) {
            $('.slideshow-items-mob').removeClass('active');
            $('.slideshow-items-mob').eq(e.index()).addClass('active');
            $('.slideshow-thumbnails-mob').removeClass('active');
            $('.slideshow-thumbnails-mob').eq(e.index()).addClass('active');
        }

    </script>

    <script>
        $(document).ready(function () {

            function toggleView() {
                let Width = window.innerWidth;
                if (Width <= 576) {
                    $(".web-view").addClass('d-none');
                    $(".mob-view").removeClass('d-none');
                } else {
                    $(".web-view").removeClass('d-none');
                    $(".mob-view").addClass('d-none');
                }
            }
            toggleView();


            $(window).resize(function () {
                toggleView();
            });
        });

    </script>


    <script>

        $(".share-btn").click(function (e) {
            e.preventDefault();
            $(".popup").toggleClass("show");
        })



        $(".popup .close").click(function () {
            $(".popup").removeClass("show");
        });



        // copy url in clipboard:
        function Copyfunction() {

            const copyText = document.getElementById("copy-text");


            navigator.clipboard.writeText(copyText.value).then(function () {

                alert("Link copied to clipboard: " + copyText.value);

                // Redirect to the current URL (refresh)
                window.location.href = window.location.href;
            }).catch(function (error) {
                console.error('Copy failed', error);
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            let prodID = $("#prod_id").val();
            let tblName = $("#tbl_name").val();
            let user = $("#user").val();
            $.ajax({
                type: "POST",
                url: base_Url + 'insert-frequent-details',
                data: { prod_id: prodID, tbl_name: tblName, user: user },
                dataType: 'json',

                success: function () {
                }
            })
        })
    </script>

</body>

</html>
