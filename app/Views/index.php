<!DOCTYPE html>
<html lang="zxx">

<?php
$bannerShopLinks = ['shopby-brand/yamaha', 'helmet-view', 'brands-viewall'];
$desktopAltTexts = [
    'Top Riding Gear and Bike Accessories',
    'Motorcycle Accessories and Riding Gear',
    'Shop Bike Gear and Touring Accessories',
];
$desktopSlides = [];
$mobileSlides = [];

if (!empty($banner) && is_array($banner)) {
    foreach ($banner as $i => $item) {
        $desktopSrc = trim((string) ($item['desktop_img'] ?? ''));
        $mobileSrc = trim((string) ($item['mobile_img'] ?? ''));
        $shopPath = $bannerShopLinks[$i] ?? 'brands-viewall';
        $rawLink = trim((string) ($item['link'] ?? ''));
        $resolvedLink = $rawLink !== '' ? $rawLink : $shopPath;

        if ($desktopSrc !== '') {
            $desktopSlides[] = [
                'src' => $desktopSrc,
                'link' => $resolvedLink,
                'alt' => $desktopAltTexts[$i] ?? ('Desktop Banner ' . ($i + 1)),
            ];
        }

        if ($mobileSrc !== '') {
            $mobileSlides[] = [
                'src' => $mobileSrc,
                'link' => $resolvedLink,
            ];
        }
    }
}

$desktopBannerCount = count($desktopSlides);
$mobileBannerCount = count($mobileSlides);
$buildBannerHref = static function ($link) {
    $link = trim((string) $link);
    if ($link === '') {
        return base_url();
    }
    if (preg_match('#^https?://#i', $link) === 1) {
        return $link;
    }
    return base_url(ltrim($link, '/'));
};
?>

<?php require "components/head.php"; ?>
<style>
    .desc-seo>p {
        padding: 20px;
        font-size: 17px;
        text-align: center;
    }

    .seo-desc-text>strong,
    .seo-desc-text>strong>a {
        color: rgb(45 117 195);
    }

    @media only screen and (min-width: 320px) and (max-width: 767px) {
        .desc-seo>p {
            padding: 5px;
            font-size: 15px;
            text-align: justify;
        }
    }

    .seo-desc-text>strong :hover,
    .seo-desc-text>strong>a :hover {
        color: #829b2f;
    }

    .card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        /* height: 250px; */
        margin: 1rem;
        position: relative;
        width: 100%;
        border-radius: 15px;
    }

    /* .card-2 {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
} */

    /* .card-2:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
} */

    .star {
        margin-top: 100px;
        width: 130px;
        height: 130px;
        background: #829b2f;
        margin-left: 100px;
    }

    .star:before {
        content: "";
        display: block;
        width: 130px;
        height: 130px;
        background: radial-gradient(circle, rgb(195 255 0) 0%, rgb(90 113 12) 100%);
        transform: rotateZ(45deg);
    }

    .star-12 {
        margin-top: 100px;
        width: 47px;
        height: 46px;
        background: radial-gradient(circle, rgb(195 255 0) 0%, rgb(90 113 12) 100%);
        /* transform: rotatez(45deg); */
        position: absolute;
        right: 20px;
        z-index: 9;
    }

    .star-12:before,
    .star-12:after {
        content: "";
        position: absolute;
        width: 47px;
        height: 46px;
        background: radial-gradient(circle, rgb(148 183 28) 0%, rgb(98 125 5) 100%);
    }

    .star-12:before {
        transform: rotatez(62deg);
    }

    .star-12:after {
        transform: rotatez(-60deg);
    }

    .star-12 span {
        position: absolute;
        top: 2px;
        z-index: 999;
        color: #fff;
        left: 7px;
        font-size: 18px;
    }

    .star-12 span.off_span {
        font-size: 11px;
        top: 22px;
    }

    .discount-tag {
        left: -8px;
    }

    body.dark-scheme {
        background-color: #f4f4f4 !important
    }

    #section-offers .de-item {
        margin: 0px;
    }

    .shop_now {
        background-color: #829b2f !important;
        color: #fff !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        padding: 10px 28px !important;
        border-radius: 6px !important;
        min-width: 130px;
        text-align: center;
        display: inline-block;
    }

    .banner_container {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .dark-scheme .card {
        background-color: rgb(255 255 255) !important;
    }

    .cart_head {
        color: #000 !important;
    }

    .cart_action .cart_wrapper,
    .cart_action .icon_cart_alt {
        color: #fff !important;
    }


    #banner_img {
        background-image: none;
        padding: 20px 0;
        background-size: cover !important;
        background-repeat: no-repeat !important;
        height: 75vh;
    }





    .hide-hotsale {
        display: none
    }

    .wish_view {
        margin-bottom: 15px !important;
        top: 20px !important
    }

    #section-offers .fa-quote-right:before {
        content: "50%";
        background-color: #a4c735;
        color: #fff;
        top: -2px;
        position: absolute;
        right: -2px;
        padding: 10px;
        border-radius: 4px 11px 4px 4px;
        font-size: 25px;
        width: 87px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Avenir Next", sans-serif;
        font-weight: 400;
        letter-spacing: 0px;
    }


    /* .offerratee {
        position: absolute;
        top: 1px;
        z-index: 99;
        left: 10px;
        background: #85a229;
        padding: 2px 6px;
        color: #fff !important;
        border-radius: 0 0 20px 0;
        font-size: 20px;
        font-weight: 600;
    } */

    .social-icons {
        padding: 30px;
        background-color: #000000cf;
        text-align: center;
        width: 100%;
        position: absolute;
        bottom: 0;
        z-index: 9;
    }

    .social-icons a {
        color: #fff;
        line-height: 30px;
        font-size: 30px;
        margin: 0 5px;
        text-decoration: none;
        background: #505050;
        width: 25%;
        transform: skew(-23deg);
    }


    .social-icons a i {
        color: #fff;
        font-size: 70px;
        display: contents;
    }

    .follow_us h2 {
        color: #fff !important;
    }

    .social-icons i:hover {
        background: transparent !important;
        color: #fff;
        font-size: 70px;
    }

    @media only screen and (max-width: 767px) {
        #de-carousel {
            display: none !important;
        }

        .social-icons a {
            font-size: 20px !important;
        }
    }

    @media only screen and (max-width: 767px) {
        /* #banner_img {
            display: block;
            background-image: url('./public/assets/images/banner/mobile.jpg') !important;

        }

        .offerratee {
            font-size: 15px !important;

        } */

        #banner_img {
            min-height: 0;
            height: auto !important;
            background-image: none !important;
            background: transparent !important;
            padding: 0 !important;
        }

        #banner_img .carousel-inner {
            overflow: hidden;
        }

        #banner_img .carousel-item {
            text-align: center;
            position: relative;
            background: #bdbdbd;
        }

        #banner_img .mobile-banner-frame {
            width: 100%;
            background: #bdbdbd;
            line-height: 0;
        }

        #banner_img .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        #banner_img .carousel-item .mask {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #banner_img .banner_container {
            width: 100%;
            position: relative;
            z-index: 3;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #banner_img .banner_content {
            position: static !important;
            top: auto !important;
            left: auto !important;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #banner_img .shop_now {
            display: inline-block;
            width: auto !important;
            min-width: 130px;
            padding: 10px 28px !important;
        }

        #banner_img .shop_now.btn-fullwidth {
            width: auto !important;
            display: inline-block !important;
        }

        #banner_img .carousel-indicators {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 12px;
            margin-bottom: 0;
            z-index: 4;
        }

    }

    @media only screen and (min-width: 768px) {
        #banner_img {
            display: none;
        }
    }


    #de-carousel {
        display: block;
    }



    /*  Krish  */
    #de-carousel .carousel-item img {
        width: 100%;
        height: 100vh;
        object-fit: cover;
        object-position: center;
    }

    #de-carousel .desktop-banner-frame {
        width: 100%;
        height: 100vh;
        background: #bdbdbd;
    }

    #de-carousel .carousel-item {
        background: #bdbdbd;
    }

    #de-carousel .carousel-item {
        position: relative;
    }

    #de-carousel .carousel-item img {
        position: relative;
        z-index: 1;
    }

    #de-carousel .carousel-item .mask {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #de-carousel .banner_container {
        width: 100%;
        position: relative;
        z-index: 3;
    }

    #de-carousel .shop_now {
        display: inline-block;
    }




</style>

<body onload="initialize()" class="dark-scheme home_page-">
    <div id="wrapper">
        <?php require "components/header.php"; ?>
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <?php if ($desktopBannerCount > 0) { ?>
                <section id="de-carousel" class="no-top no-bottom carousel slide carousel-fade" data-mdb-ride="carousel"
                    data-mdb-interval="<?php echo $desktopBannerCount > 1 ? '3000' : 'false'; ?>"
                    data-mdb-touch="<?php echo $desktopBannerCount > 1 ? 'true' : 'false'; ?>">
                    <div class="carousel-inner position-relative">
                        <?php foreach ($desktopSlides as $i => $slide) { ?>
                            <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                <div class="desktop-banner-frame">
                                    <a href="<?php echo $buildBannerHref($slide['link']); ?>">
                                        <img src="<?php echo base_url() . $slide['src']; ?>" class="img-fluid"
                                            alt="<?php echo $slide['alt']; ?>">
                                    </a>
                                </div>
                                <div class="mask">
                                    <div class="no-top no-bottom">
                                        <div class="h-100 v-center">
                                            <div class="container">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-12 text-center p-3 mb-sm-30">
                                                        <div class="container">
                                                            <div class="h-100 v-center">
                                                                <div class="container banner_container">
                                                                    <div class="banner_content">
                                                                        <a href="<?php echo $buildBannerHref($slide['link']); ?>"
                                                                            type='button' id='buynowBtn'
                                                                            class="btn-main btn-fullwidth shop_now">Shop Now</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="social-icons follow_us">
                        <div class="d-flex justify-content-evenly">
                            <a href="https://www.facebook.com/share/1AdUYKNcPB/ " title="facebook" class="facebook">
                                <div class="socialmedia_content">
                                    <p>Facebook</p>
                                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                </div>
                            </a>
                            <a href="https://www.instagram.com/ridersranchcoimbatore/?igsh=MWxnZmJldmZmdDdq#"
                                class="instagram" title="instagram">
                                <div class="socialmedia_content">
                                    <p>Instagram</p>
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </div>
                            </a>
                            <a href="https://www.youtube.com/@adventureshoppe3772?si=t6L5pC2zHRb4z1-i" title="youtube"
                                class="youtube">
                                <div class="socialmedia_content">
                                    <p>Youtube</p>
                                    <i class="fa fa-youtube-square" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php if ($desktopBannerCount > 1) { ?>
                        <a class="carousel-control-prev" href="#de-carousel" role="button" data-mdb-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#de-carousel" role="button" data-mdb-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    <?php } ?>
                    <div class="de-gradient-edge-bottom"></div>
                </section>
            <?php } ?>

            <?php if ($mobileBannerCount > 0) { ?>
                <section id="banner_img" class="no-top no-bottom carousel slide carousel-fade" data-mdb-ride="carousel"
                    data-mdb-interval="<?php echo $mobileBannerCount > 1 ? '3000' : 'false'; ?>"
                    data-mdb-touch="<?php echo $mobileBannerCount > 1 ? 'true' : 'false'; ?>">
                    <?php if ($mobileBannerCount > 1) { ?>
                        <div class="carousel-indicators">
                            <?php foreach ($mobileSlides as $i => $slide) { ?>
                                <button type="button" data-mdb-target="#banner_img" data-mdb-slide-to="<?php echo $i; ?>"
                                    class="<?php echo $i === 0 ? 'active' : ''; ?>"
                                    aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                    aria-label="Slide <?php echo $i + 1; ?>"></button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="carousel-inner position-relative">
                        <?php foreach ($mobileSlides as $i => $slide) { ?>
                            <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                <div class="mobile-banner-frame">
                                    <a href="<?php echo $buildBannerHref($slide['link']); ?>">
                                        <img src="<?php echo base_url() . $slide['src']; ?>" class="img-fluid"
                                            alt="Mobile Banner <?php echo $i + 1; ?>">
                                    </a>
                                </div>
                                <div class="mask">
                                    <div class="container banner_container">
                                        <div class="banner_content">
                                            <a href="<?php echo $buildBannerHref($slide['link']); ?>" type='button'
                                                class="btn-main btn-fullwidth shop_now">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($mobileBannerCount > 1) { ?>
                        <a class="carousel-control-prev" href="#banner_img" role="button" data-mdb-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#banner_img" role="button" data-mdb-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
    </div>



    <!-- offers  start  -->
    <!-- <?php $className = $offers <= 0 ? "d-none" : ""; ?>
    <section id="section-offers" class="p-5 <?= $className ?>">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header">
                    <h2>OFFERS</h2>
                    <a href="<?php echo base_url(); ?>offers/1"><span class="view_all">View all<i
                                class="right_arrow"></i></span></a> -->
    <!-- <span class="view_all">View all<i class="fa fa-angle-right"></i></span>  -->
    <!-- </div>
                <div class="col-12 col-carousel p-0">
                    <div class="owl-carousel carousel-main">
                        <?php for ($i = 0; $i < 8; $i++) { ?>
                            <div class="">
                                <div class="item">
                                    <div class="items_wrapper">
                                        <?php $tbl_name = $offers[$i]['tbl_name'];
                                        if ($tbl_name == "tbl_products") {
                                            $url = base_url() . "detail/" . strtolower(str_replace(['/', ' '], '-', $offers[$i]['redirect_url'])) . "/" . base64_encode($offers[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_accessories_list") {
                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(['/', ' '], '-', $offers[$i]['redirect_url'])) . "/" . base64_encode($offers[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_rproduct_list") {
                                            $url = base_url() . "riding-details/" . strtolower(str_replace(['/', ' '], '-', $offers[$i]['redirect_url'])) . "/" . base64_encode($offers[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_helmet_products") {
                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(['/', ' '], '-', $offers[$i]['redirect_url'])) . "/" . base64_encode($offers[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_luggagee_products") {
                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(['/', ' '], '-', $offers[$i]['redirect_url'])) . "/" . base64_encode($offers[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_camping_products") {
                                            $url = base_url() . "camp-details/" . strtolower(str_replace(['/', ' '], '-', $offers[$i]['redirect_url'])) . "/" . base64_encode($offers[$i]['prod_id']);
                                        }
                                        ?>
                                        <a href="<?php echo $url; ?>">
                                            <div class="de-item ">
                                                <?php $offerrr = $offers[$i]['offer_details'];
                                                if ($offerrr == 1 || $offerrr == 2 || $offerrr == "" || $offerrr == 0 || $offerrr == "-") {
                                                    $offerClass = "d-none";
                                                } else {
                                                    $offerClass = "";
                                                }
                                                ?>
                                                <span class="discount-tag  <?= $offerClass ?>">
                                                    <?= $offers[$i]['offer_details'] ?>%<span class="off_span">off</span>
                                                </span>
                                                <div class="d-img">
                                                    <img src="<?php echo base_url();
                                                    echo $offers[$i]['product_img']; ?>" class="img-fluid"
                                                        alt="<?php echo $offers[$i]['product_name']; ?>">
                                                    <div class="d-info " id="offer-viewpage">
                                                        <div class="d-text">
                                                            <h4><?php echo $offers[$i]['product_name']; ?></h4>
                                                            <span
                                                                class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $offers[$i]['offer_price']); ?><small
                                                                    class="<?= $className ?>">₹<?php echo number_format($offers[$i]['product_price']); ?></small></span>

                                                            <div>

                                                            </div>

                                                        </div>



                                                    </div>

                                                </div>

                                            </div>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </section> -->
    <!-- offers  End  -->


    <!-- New Arrivals Start  -->
    <section id="section-newArrival" class="p-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header">
                    <h2>NEW ARRIVALS</h2>
                    <a href="<?php echo base_url(); ?>newrrival-view/1"><span class="view_all">View all<i
                                class="right_arrow"></i></span></a>
                </div>
                <div class="col-12 col-carousel p-0">
                    <div class="owl-carousel carousel-main">
                        <?php for ($i = 0; $i < 8; $i++) { ?>
                            <div class="">
                                <div class="item">
                                    <p class="d-flex wish-status m-0">
                                        <span class="d-flex align-items-center">
                                            <?php $stock = $new_arrivals[$i]['quantity'];
                                            if ($stock <= 0) { ?>
                                                <span class="ribbon outof_stock">
                                                    <span>Out of stock</span>
                                                </span>
                                            <?php } else { ?>
                                                <span class="ribbon available">
                                                    <span>Available</span>
                                                </span>
                                            <?php } ?>
                                        </span>
                                    </p>

                                    <div class="items_wrapper">
                                        <?php $tbl_name = $new_arrivals[$i]['tbl_name'];
                                        if ($tbl_name == "tbl_products") {
                                            $url = base_url() . "detail/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_accessories_list") {
                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_rproduct_list") {
                                            $url = base_url() . "riding-details/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_helmet_products") {
                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_luggagee_products") {
                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_camping_products") {
                                            $url = base_url() . "camp-details/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                        }
                                        ?>
                                        <a href="<?php echo $url; ?>">
                                            <div class="container left" data-ribbon="Pormotion"
                                                style="--d:10px;--c:green;--f:13px">
                                            </div>
                                            <div class="de-item">
                                                <div class="d-img">
                                                    <img src="<?php echo base_url();
                                                    echo $new_arrivals[$i]['product_img']; ?>" class="img-fluid"
                                                        alt="<?php echo $new_arrivals[$i]['product_name']; ?>"
                                                        alt="<?php echo $new_arrivals[$i]['product_name']; ?>">
                                                </div>
                                                <div class="d-info" id="index-offer">
                                                    <div class="d-text">
                                                        <h4><?php echo $new_arrivals[$i]['product_name']; ?></h4>

                                                        <span
                                                            class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $new_arrivals[$i]['offer_price']); ?>
                                                            <?php if (!empty($new_arrivals[$i]['offer_details']) && $new_arrivals[$i]['offer_details'] !== "0") { ?>
                                                                <small
                                                                    class="<?= $className ?>">₹<?php echo number_format($new_arrivals[$i]['product_price']); ?></small>
                                                            <?php } ?>
                                                        </span>

                                                        <div class="mt-2">
                                                            <?php
                                                            $tbl_name = $new_arrivals[$i]['tbl_name'];

                                                            if ($tbl_name == "tbl_products") {
                                                                $url = base_url() . "detail/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_accessories_list") {
                                                                $url = base_url() . "accessories-detail/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_rproduct_list") {
                                                                $url = base_url() . "riding-details/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_helmet_products") {
                                                                $url = base_url() . "helmet-details/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_luggagee_products") {
                                                                $url = base_url() . "tour-detail/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_camping_products") {
                                                                $url = base_url() . "camp-details/" . strtolower(str_replace(['/', ' '], '-', $new_arrivals[$i]['redirect_url'])) . "/" . base64_encode($new_arrivals[$i]['prod_id']);
                                                            }
                                                            ?>
                                                            <a class="btn-main buynow_btn" href="<?php echo $url; ?>">Buy
                                                                Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- New Arrivals Enddd  -->


    <!-- Hot sales Start  -->
    <?php if (count($hotsale) <= 0) {
        $class = "hide-hotsale";
    } else {
        $class = "";
    } ?>
    <section id="section-newArrival" class="p-5 <?php echo $class; ?>">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header">
                    <h2>HOT SALE</h2>
                    <a href="<?php echo base_url(); ?>hotsale/1"><span class="view_all">View all<i
                                class="right_arrow"></i></span></a>
                </div>
                <div class="col-12 col-carousel p-0">
                    <div class="owl-carousel carousel-main">
                        <?php for ($i = 0; $i < 8; $i++) { ?>
                            <div class="">
                                <div class="item">
                                    <p class="d-flex wish-status m-0">
                                        <span class="d-flex align-items-center">
                                            <span class="ribbon outof_stock">
                                                <span class="gradient-text">Hot sale</span>
                                            </span>
                                        </span>
                                    </p>

                                    <div class="items_wrapper">
                                        <?php
                                        $tbl_name = $hotsale[$i]['tbl_name'];
                                        if ($tbl_name == "tbl_products") {
                                            $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_accessories_list") {
                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_rproduct_list") {
                                            $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_helmet_products") {
                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_luggagee_products") {
                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_camping_products") {
                                            $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        }
                                        ?>
                                        <a href="<?php echo $url; ?>">
                                            <div class="container left" data-ribbon="Pormotion"
                                                style="--d:10px;--c:green;--f:13px">
                                            </div>
                                            <div class="de-item">
                                                <?php if (!empty($hotsale[$i]['offer_details']) && $hotsale[$i]['offer_details'] !== "0") { ?>
                                                    <div class="star-12">
                                                        <span>
                                                            <?= $hotsale[$i]['offer_details'] ?>%
                                                            <span class="off_span">OFF</span>
                                                        </span>
                                                    </div>
                                                <?php } ?>
                                                <div class="d-img">
                                                    <img src="<?php echo base_url(); ?>/<?php echo $hotsale[$i]['product_img']; ?>"
                                                        class="img-fluid" alt="<?php echo $hotsale[$i]['product_name']; ?>">
                                                </div>
                                                <div class="d-info" id="index-offer">
                                                    <div class="d-text">
                                                        <h4><?php echo $hotsale[$i]['product_name']; ?></h4>

                                                        <div class="mt-2">
                                                            <?php
                                                            $tbl_name = $hotsale[$i]['tbl_name'];
                                                            if ($tbl_name == "tbl_products") {
                                                                $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_accessories_list") {
                                                                $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_rproduct_list") {
                                                                $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_helmet_products") {
                                                                $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_luggagee_products") {
                                                                $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_camping_products") {
                                                                $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            }
                                                            ?>
                                                            <span
                                                                class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $hotsale[$i]['offer_price']); ?>
                                                                <?php if (!empty($hotsale[$i]['offer_details']) && $hotsale[$i]['offer_details'] !== "0") { ?>
                                                                    <small
                                                                        class="<?= $className ?>">₹<?php echo number_format($hotsale[$i]['product_price']); ?></small>
                                                                <?php } ?>
                                                            </span>
                                                            <a class="btn-main buynow_btn" href="<?php echo $url; ?>">Buy
                                                                Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hot Sales Enddd  -->



    <!-- <section id="section-hotsale" class="px-5 <?php echo $class; ?>">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header" class="view_all">
                    <h3>HOT SALE</h3>
                    <a href="<?php echo base_url(); ?>hotsale"><span class="view_all">View all<i class="right_arrow"></i></span></a>
                </div>
                <div class="col-12 col-carousel">
                    <div class="owl-carousel carousel-main">
                        <?php for ($i = 0; $i < 4; $i++) { ?>
                            <div class="">
                                <div class="item">
                                <p class="d-flex wish-status m-0">
                                        <span class="d-flex align-items-center">
                                            <span class="ribbon outof_stock">
                                                <span class="gradient-text">Hot sale</span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="items_wrapper">
                                        <?php
                                        $tbl_name = $hotsale[$i]['tbl_name'];

                                        if ($tbl_name == "tbl_products") {
                                            $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_accessories_list") {
                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_rproduct_list") {
                                            $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_helmet_products") {
                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_luggagee_products") {
                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_camping_products") {
                                            $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                        }
                                        ?>
                                        <a href="<?php echo $url; ?>">
                                            <div class="de-item">
                                            <div class="star-12">
                                                    <span><?= $offers[$i]['offer_details'] ?>%
                                                        <span class="off_span">OFF</span>
                                                    </span>
                                                </div>
                                                <div class="d-img">
                                                    <img src="<?php echo base_url(); ?>/<?php echo $hotsale[$i]['product_img']; ?>"
                                                        class="img-fluid" alt="">
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h4><?php echo $hotsale[$i]['product_name']; ?></h4>
                                                        <div>
                                                            <?php
                                                            $tbl_name = $hotsale[$i]['tbl_name'];

                                                            if ($tbl_name == "tbl_products") {
                                                                $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_accessories_list") {
                                                                $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_rproduct_list") {
                                                                $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_helmet_products") {
                                                                $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_luggagee_products") {
                                                                $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            } elseif ($tbl_name == "tbl_camping_products") {
                                                                $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $hotsale[$i]['redirect_url'])) . "/" . base64_encode($hotsale[$i]['prod_id']);
                                                            }
                                                            ?>
                                                            <span
                                                                class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $hotsale[$i]['offer_price']); ?></span>
                                                            <a class="btn-main buynow_btn" href="<?php echo $url; ?>">Buy
                                                                Now</a>
                                                        </div>

                                                    </div>
                                                        </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section> -->


    <!-- Brands We deal  Start  -->
    <section id="section-brands" class="p-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header brands_we_deal">
                    <h2>BRANDS WE DEAL</h2>
                    <a href="<?php echo base_url(); ?>brands-viewall"><span class="view_all">View all<i
                                class="right_arrow"></i></span></a>
                </div>
                <div class="col-12 col-carousel">
                    <div class="owl-carousel carousel-brand">
                        <?php for ($i = 0; $i < 4; $i++) { ?>
                            <div class="item_wrapper">
                                <div class="item">
                                    <div class="">
                                        <a href="#">
                                            <div class="de-item" id="brands-deals">
                                                <div class="d-img" id="brands-deals-img">
                                                    <a
                                                        href="<?php echo base_url(); ?>brands/<?php echo strtolower(str_replace(' ', '-', $brand_master[$i]['brand_name'])); ?>/<?php echo base64_encode($brand_master[$i]['brand_master_id']); ?>">
                                                        <img src="<?php echo base_url();
                                                        echo $brand_master[$i]['brand_img']; ?>" class="img-fluid"
                                                            alt="<?= $brand_master[$i]['brand_name'] ?>"></a>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Brands We deal  End  -->

    <!-- Helmets  start  -->
    <section id="section-helmets" class="pb-0 ps-5 pe-5 pt-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header">
                    <h2>HELMETS</h2>
                    <a href="<?php echo base_url(); ?>helmet-view"><span class="view_all">View all<i
                                class="right_arrow"></i></span></a>
                </div>

                <div class="col-12 col-carousel">
                    <div class="owl-carousel carousel-main">
                        <?php for ($i = 0; $i < count($helemt_filter_view); $i++) { ?>
                            <div class="">
                                <div class="item">
                                    <div class="">
                                        <a
                                            href="<?php echo base_url(); ?>helmet-accessories/<?php echo strtolower(str_replace(' ', '-', $helemt_filter_view[$i]['h_submenu'])); ?>/<?php echo base64_encode($helemt_filter_view[$i]['h_submenu_id']); ?>/1">
                                            <div class="de-item">
                                                <div class="d-img">
                                                    <img src="<?php echo base_url();
                                                    echo $helemt_filter_view[$i]['hsubmenu_img']; ?>" class="img-fluid"
                                                        alt="<?= $helemt_filter_view[$i]['h_submenu'] ?>">
                                                </div>

                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h5 class="text-center">
                                                            <?php echo $helemt_filter_view[$i]['h_submenu']; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Helmets  End  -->


    <!-- SEO -Description -->
    <section id="section-newArrival" class="p-5 mb-3 mt-3 <?php echo $className; ?>">
        <div class="col-lg-12 text-center newarrival_header">
            <h2>TOP QUALITY RIDING GEAR & ACCESSORIES IN INDIA</h2>
        </div>
        <div class="container">
            <div class="card- card-2-">
                <div class="row align-items-center desc-seo seo-monitor">
                    <p class="seo-desc-text">
                        Welcome to <strong>Adventure Shoppe</strong> – your one-stop destination for the
                        <strong>top quality riding gear & accessories in india</strong>. As the
                        <strong><a href="<?= base_url() ?>helmet-accessories/full-face-helmet/Mg==/1">best helmet
                                shop</a></strong>
                        <br>and <strong><a href="<?= base_url() ?>riding-accessories/jackets/Mg==/1">top riding gear
                                shop</a></strong>,
                        we offer a complete range of riding essentials including branded helmets, jackets, gloves,
                        boots, and more.<br>
                        We bring you the <strong><a href="<?= base_url() ?>riding-accessories/body-armour/MjE=/1">best
                                riding gear</a></strong>
                        designed for safety, comfort, and performance. Explore top-quality
                        <strong><a href="<?= base_url() ?>helmet-accessories/helmet-accessories/Ng==/1">helmet
                                accessories</a></strong>,
                        <br>reliable <strong><a
                                href="<?= base_url() ?>touring-accesssories/bungee-cords-and-nets/MTA=/1">bike touring
                                accessories</a></strong>,
                        and tough <strong><a href="<?= base_url() ?>motor-accessories/crash-guard/MTI1/1">adventure bike
                                accessories</a></strong>
                        for all your rides. We also stock a wide variety of
                        <strong><a href="<?= base_url() ?>products/duke-200/NDI=/OTU=/1">all brand bike
                                accessories</a></strong>.<br>
                        From daily commutes to long-distance tours, find premium superbike gear, high-performance
                        <strong><a href="<?= base_url() ?>motor-accessories/airfilter/NTA=/1">bike performance
                                accessories</a></strong>,
                        and trusted <strong><a href="<?= base_url() ?>brands/red-rooster/MTc4"><br>top brand bike
                                accessories</a></strong>
                        under one roof. We're also proud
                        <strong><a href="<?= base_url() ?>camping/camping-accessories/MTg=">top camping gear
                                dealers</a></strong>,
                        making us your go-to place for every adventure need.<br>
                        Looking for the <strong><a href="<?= base_url() ?>motor-accessories/bash-plate/Mjk=/1">best bike
                                accessories</a></strong>
                        and a dependable <strong><a href="<?= base_url() ?>products/himlayan-450/MjI=/OTM=/1">best bike
                                pitstop</a></strong>?
                        Ride safe. Ride smart — with Adventure Shoppe.
                    </p>
                </div>
                <div class="row align-items-center desc-seo seo-lap">
                    <p class="seo-desc-text">
                        Welcome to <strong>Adventure Shoppe</strong> – your one-stop destination for the
                        <strong>top quality riding gear & accessories in india</strong>. As the
                        <strong><a href="<?= base_url() ?>helmet-accessories/full-face-helmet/Mg==/1">best helmet
                                shop</a></strong>
                        <br>and <strong><a href="<?= base_url() ?>riding-accessories/jackets/Mg==/1">top riding gear
                                shop</a></strong>,
                        we offer a complete range of riding essentials including branded helmets, jackets, gloves,
                        boots, and more.<br>
                        We bring you the <strong><a href="<?= base_url() ?>riding-accessories/body-armour/MjE=/1">best
                                riding gear</a></strong>
                        designed for safety, comfort, and performance. Explore top-quality
                        <strong><a href="<?= base_url() ?>helmet-accessories/helmet-accessories/Ng==/1">helmet
                                accessories</a></strong>,
                        <br>reliable <strong><a
                                href="<?= base_url() ?>touring-accesssories/bungee-cords-and-nets/MTA=/1">bike touring
                                accessories</a></strong>,
                        and tough <strong><a href="<?= base_url() ?>motor-accessories/crash-guard/MTI1/1">adventure bike
                                accessories</a></strong>
                        for all your rides. We also stock a wide variety of
                        <strong><a href="<?= base_url() ?>products/duke-200/NDI=/OTU=/1">all brand bike
                                accessories</a></strong>.<br>
                        From daily commutes to long-distance tours, find premium superbike gear, high-performance
                        <strong><a href="<?= base_url() ?>motor-accessories/airfilter/NTA=/1">bike performance
                                accessories</a></strong>,
                        and trusted <strong><a href="<?= base_url() ?>brands/red-rooster/MTc4"><br>top brand bike
                                accessories</a></strong>
                        under one roof. We're also proud
                        <strong><a href="<?= base_url() ?>camping/camping-accessories/MTg=">top camping gear
                                dealers</a></strong>,
                        making us your go-to place for every adventure need.<br>
                        Looking for the <strong><a href="<?= base_url() ?>motor-accessories/bash-plate/Mjk=/1">best bike
                                accessories</a></strong>
                        and a dependable <strong><a href="<?= base_url() ?>products/himlayan-450/MjI=/OTM=/1">best bike
                                pitstop</a></strong>?
                        Ride safe. Ride smart — with Adventure Shoppe.
                    </p>
                </div>

                <div class="row align-items-center desc-seo seo-mob">
                    <p class="seo-desc-text">
                        Welcome to <strong>Adventure Shoppe</strong> – your one-stop destination for the
                        <strong>Top Quality Riding Gear & Accessories in India</strong>. As the
                        <strong><a href="<?= base_url() ?>helmet-accessories/full-face-helmet/Mg==/1">best helmet
                                shop</a></strong>
                        and <strong><a href="<?= base_url() ?>riding-accessories/jackets/Mg==/1">top riding gear
                                shop</a></strong>,<br>
                        we offer a complete range of riding essentials including branded helmets, jackets, gloves,
                        boots, and more.
                        We bring you the <strong><a href="<?= base_url() ?>riding-accessories/body-armour/MjE=/1">Best
                                Riding Gear</a></strong>
                        designed for safety, comfort, and performance. Explore top-quality
                        <strong><a href="<?= base_url() ?>helmet-accessories/helmet-accessories/Ng==/1">helmet
                                accessories</a></strong>,
                        reliable <strong><a
                                href="<?= base_url() ?>touring-accesssories/bungee-cords-and-nets/MTA=/1">bike touring
                                accessories</a></strong>,
                        and tough <strong><a href="<?= base_url() ?>motor-accessories/crash-guard/MTI1/1">adventure bike
                                accessories</a></strong>
                        for all your rides. We also stock a wide variety of
                        <strong><a href="<?= base_url() ?>products/duke-200/NDI=/OTU=/1">All Brand Bike
                                Accessories</a></strong>.
                        From daily commutes to long-distance tours, find premium superbike gear, high-performance
                        <strong><a href="<?= base_url() ?>motor-accessories/airfilter/NTA=/1">bike performance
                                accessories</a></strong>,
                        and trusted <strong><a href="<?= base_url() ?>brands/red-rooster/MTc4">top brand bike
                                accessories</a></strong>
                        under one roof. We're also proud
                        <strong><a href="<?= base_url() ?>camping/camping-accessories/MTg=">top camping gear
                                dealers</a></strong>,
                        making us your go-to place for every adventure need.<br>
                        Looking for the <strong><a href="<?= base_url() ?>motor-accessories/bash-plate/Mjk=/1">best bike
                                accessories</a></strong>
                        and a dependable <strong><a href="<?= base_url() ?>products/himlayan-450/MjI=/OTM=/1">Best bike
                                pitstop</a></strong>?
                        Ride safe. Ride smart — with Adventure Shoppe.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- SEO -Description end-->

    <!-- SOCIAL MEDIA start -->
    <section id="social_media" class="pb-5 ps-5 pe-5 pt-0">
        <div class="container p-0">
            <div class="row">
                <div class="col-lg-12 text-center newarrival_header">
                    <h2>YOUTUBE</h2>
                </div>
                <div class="col-4 left_container">
                    <a href="<?php echo $youtube[0]['ytube_link']; ?>">
                        <img src="<?php echo base_url(); ?>/<?php echo $youtube[0]['ytube_img']; ?>"
                            class="img-fluid img-left" alt="">
                        <i><img src="<?php echo base_url(); ?>public/assets/images/icons/bi_youtube.png" alt=""></i>
                    </a>
                </div>
                <div class="col-4 center_container">
                    <a href="<?php echo $youtube[1]['ytube_link']; ?>">
                        <img src="<?php echo base_url(); ?>/<?php echo $youtube[1]['ytube_img']; ?>"
                            class="img-fluid img-center" alt="">
                        <i><img src="<?php echo base_url(); ?>public/assets/images/icons/bi_youtube.png" alt=""></i>
                    </a>
                </div>
                <div class="col-4 right_container">
                    <a href="<?php echo $youtube[2]['ytube_link']; ?>">
                        <img src="<?php echo base_url(); ?>/<?php echo $youtube[2]['ytube_img']; ?>"
                            class="img-fluid img-right" alt="">
                        <i><img src="<?php echo base_url(); ?>public/assets/images/icons/bi_youtube.png" alt=""></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- SOCIAL MEDIA end -->

    <!-- Recently viewed products -->
    <section id="section-newArrival" class="p-5 mb-5 <?php echo $className; ?>">
        <?php $recentCount = count($recent_products);
        $class = $recentCount <= 0 ? "display-none" : ""; ?>
        <div class="container">

            <div class="row align-items-center">
                <div class="col-lg-12 text-center newarrival_header  <?= $class ?>">
                    <h2>RECENTLY VIEWED PRODUCTS</h2>
                    <!-- <span class="view_all">View all<i class="fa fa-angle-right"></i></span> -->
                </div>
                <div class="col-12 col-carousel p-0">
                    <div class="owl-carousel carousel-recent" data-count="<?= count($recent_products) ?>">
                        <?php for ($i = 0; $i < count($recent_products); $i++) { ?>
                            <div class="">
                                <div class="item">
                                    <p class="d-flex wish-status">
                                        <span class="d-flex align-items-center similar-products">
                                            <?php $stock = $recent_products[$i]['quantity'];
                                            if ($stock <= 0) { ?>
                                                <span class="ribbon outof_stock">
                                                    <span>Out of stock</span>
                                                </span>
                                            <?php } else { ?>
                                                <span class="ribbon available">
                                                    <span>Available</span>
                                                </span>

                                            <?php } ?>
                                        </span>
                                    </p>
                                    <div class="items_wrapper">
                                        <?php
                                        $tbl_name = $recent_products[$i]['tbl_name'];

                                        if ($tbl_name == "tbl_products") {
                                            $url = base_url() . "detail/" . strtolower(str_replace(['/', ' '], '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_accessories_list") {
                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(['/', ' '], '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_rproduct_list") {
                                            $url = base_url() . "riding-details/" . strtolower(str_replace(['/', ' '], '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_helmet_products") {
                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(['/', ' '], '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_luggagee_products") {
                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(['/', ' '], '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        } elseif ($tbl_name == "tbl_camping_products") {
                                            $url = base_url() . "camp-details/" . strtolower(str_replace(['/', ' '], '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                        }
                                        ?>
                                        <a href="<?php echo $url; ?>">
                                            <div class="container left" data-ribbon="Pormotion"
                                                style="--d:10px;--c:green;--f:13px"></div>
                                            <div class="de-item">
                                                <div class="d-img">
                                                    <img src="<?php echo base_url();
                                                    echo $recent_products[$i]['product_img']; ?>" class="img-fluid"
                                                        alt="<?php echo $recent_products[$i]['product_name']; ?>">
                                                </div>
                                                <div class="d-info" id="index-offer">
                                                    <div class="d-text">
                                                        <h4><?php echo $recent_products[$i]['product_name']; ?></h4>
                                                        <span
                                                            class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $recent_products[$i]['offer_price']); ?>
                                                            <small
                                                                class="<?= $className ?>">₹<?php echo number_format($recent_products[$i]['product_price']); ?></small></span>
                                                        <?php $stock = $recent_products[$i]['quantity'];
                                                        if ($stock <= 0) { ?>
                                                            <div>
                                                                <a class="btn-main recently_view buynow_btn"
                                                                    href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $recent_products[$i]['product_name'] . "\nProduct Price: " . $recent_products[$i]['product_price']); ?>">
                                                                    Contact us to order
                                                                </a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div>
                                                                <?php
                                                                $tbl_name = $recent_products[$i]['tbl_name'];

                                                                if ($tbl_name == "tbl_products") {
                                                                    $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                                                } elseif ($tbl_name == "tbl_accessories_list") {
                                                                    $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                                                } elseif ($tbl_name == "tbl_rproduct_list") {
                                                                    $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                                                } elseif ($tbl_name == "tbl_helmet_products") {
                                                                    $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                                                } elseif ($tbl_name == "tbl_luggagee_products") {
                                                                    $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                                                } elseif ($tbl_name == "tbl_camping_products") {
                                                                    $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $recent_products[$i]['redirect_url'])) . "/" . base64_encode($recent_products[$i]['prod_id']);
                                                                }
                                                                ?>
                                                                <a class="btn-main recently_view buynow_btn "
                                                                    href="<?php echo $url; ?>">Buy Now</a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Recently viewed products end -->


    <!-- <section id="section_testimonial" class="pt-0">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="text-center">
                    <h3>Testimonial</h3>
                </div>
                <div class="gtco-testimonials" id="section-testimonials">
                    <div class="owl-carousel owl-carousel1 owl-theme">
                        <div>
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5>Very satisfied<br /></h5>
                                    <p class="card-text">“ This brake cleaner is a very useful product which I have
                                        purchased from Adventure Shoppe. I' m very satisfied with the product and the
                                                    results. Thank you for suggesting this product.” </p>
                                                    <span>-Eric Churchill</span>
                                            </div>

                                        </div>
                                </div>
                                <div>
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5>Desires color for Helmets<br />
                                            </h5>
                                            <p class="card-text">“Excellent choice for riding gear purchase, it's our
                                                3rd
                                                purchase, overall too good lot of verity, they will arrange for desires
                                                color
                                                for helmets.”
                                            </p>
                                            <span>-Aishwarya</span>
                                        </div>

                                    </div>
                                </div>
                                <div>
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5>Responsive and Helpful<br />
                                            </h5>
                                            <p class="card-text">“I have been using Rentaly for my Car Rental needs for
                                                over 5
                                                years now. I have never had any problems with their service. Their
                                                customer
                                                support is always responsive and helpful” </p>
                                            <span>-RanjithKumar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section> -->


    <!-- content close -->
    <a href="#" id="back-to-top"></a>
    <?php require "components/footer.php"; ?>
    <script>
        // (function() {
        //     "use strict";

        //     var carousels = function() {
        //         $(".owl-carousel1").owlCarousel({
        //             loop: true,
        //             center: true,
        //             margin: 10,
        //             responsiveClass: true,
        //             nav: false,
        //             responsive: {
        //                 0: {
        //                     items: 1,
        //                     nav: false
        //                 },
        //                 680: {
        //                     items: 2,
        //                     nav: false,
        //                     loop: false
        //                 },
        //                 1000: {
        //                     items: 3,
        //                     nav: true
        //                 }
        //             }
        //         });
        //     };

        //     (function($) {
        //         carousels();
        //     })(jQuery);
        // })();


        // $(document).ready(function() {
        //     $(".owl-carousel").owlCarousel({
        //         loop: true,
        //         margin: 10,
        //         nav: true,
        //         responsive: {
        //             0: {
        //                 items: 1
        //             },
        //             600: {
        //                 items: 3
        //             },
        //             1000: {
        //                 items: 4
        //             }
        //         }
        //     });
        // });
        // $(document).ready(function() {
        //     var itemsMainDiv = $('.MultiCarousel');
        //     var itemsDiv = $('.MultiCarousel-inner');
        //     var itemWidth = "";

        //     $('.leftLst, .rightLst').click(function() {
        //         var condition = $(this).hasClass("leftLst");
        //         if (condition)
        //             moveSlide(0, this);
        //         else
        //             moveSlide(1, this);
        //     });

        //     resizeCarousel();

        //     $(window).resize(function() {
        //         resizeCarousel();
        //     });

        //     function resizeCarousel() {
        //         var incno = 0;
        //         var itemClass = '.item';
        //         var id = 0;
        //         var btnParentSb = '';
        //         var itemsSplit = '';
        //         var sampwidth = itemsMainDiv.width();
        //         var bodyWidth = $('body').width();
        //         itemsDiv.each(function() {
        //             id = id + 1;
        //             var itemNumbers = $(this).find(itemClass).length;
        //             btnParentSb = $(this).parent().data("items");
        //             itemsSplit = btnParentSb.split(',');
        //             $(this).parent().attr("id", "MultiCarousel" + id);

        //             if (bodyWidth >= 1200) {
        //                 incno = itemsSplit[3];
        //                 itemWidth = sampwidth / incno;
        //             } else if (bodyWidth >= 992) {
        //                 incno = itemsSplit[2];
        //                 itemWidth = sampwidth / incno;
        //             } else if (bodyWidth >= 768) {
        //                 incno = itemsSplit[1];
        //                 itemWidth = sampwidth / incno;
        //             } else {
        //                 incno = itemsSplit[0];
        //                 itemWidth = sampwidth / incno;
        //             }
        //             $(this).css({
        //                 'transform': 'translateX(0px)',
        //                 'width': itemWidth * itemNumbers
        //             });
        //             $(this).find(itemClass).each(function() {
        //                 $(this).outerWidth(itemWidth);
        //             });

        //             $(".leftLst").addClass("over");
        //             $(".rightLst").removeClass("over");
        //         });
        //     }

        //     function moveSlide(direction, element) {
        //         var leftBtn = $('.leftLst');
        //         var rightBtn = $('.rightLst');
        //         var translateXval = '';
        //         var divStyle = $(element).parent().find(itemsDiv).css('transform');
        //         var values = divStyle.match(/-?[\d\.]+/g);
        //         var xds = values ? Math.abs(values[4]) : 0;
        //         var slideWidth = itemWidth * $(element).parent().data("slide");

        //         if (direction === 0) {
        //             translateXval = parseInt(xds) - parseInt(slideWidth);
        //             $(element).parent().find(rightBtn).removeClass("over");

        //             if (translateXval <= itemWidth / 2) {
        //                 translateXval = 0;
        //                 $(element).parent().find(leftBtn).addClass("over");
        //             }
        //         } else if (direction === 1) {
        //             var itemsCondition = $(element).parent().find(itemsDiv).width() - $(element).parent().width();
        //             translateXval = parseInt(xds) + parseInt(slideWidth);
        //             $(element).parent().find(leftBtn).removeClass("over");

        //             if (translateXval >= itemsCondition - itemWidth / 2) {
        //                 translateXval = itemsCondition;
        //                 $(element).parent().find(rightBtn).addClass("over");
        //             }
        //         }
        //         $(element).parent().find(itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
        //     }
        // });

        // Owl Carousel

        $('.carousel-main').owlCarousel({

            items: 4,

            loop: true,

            // autoplay: true,

            autoplayTimeout: 7000000,

            margin: 2,

            nav: true,

            dots: false,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    nav: true

                },

                600: {

                    items: 2,

                    nav: false

                },

                1200: {

                    items: 4,

                    nav: true,

                    loop: true

                },

                1800: {

                    items: 6,

                    nav: true,

                    loop: true

                }

            }

        })

       
        $('.carousel-brand').owlCarousel({

            items: 4,

            loop: true,

            // autoplay: true,

            autoplayTimeout: 7000000,

            margin: 2,

            nav: true,

            dots: false,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    nav: true

                },

                600: {

                    items: 2,

                    nav: false

                },

                1200: {

                    items: 5,

                    nav: true,

                    loop: true

                },

                1800: {

                    items: 8,

                    nav: true,

                    loop: true

                }

            }

        })

    </script>



    <script>
        $(document).ready(function () {
            let width = window.innerWidth;


            if (width >= 1650) {
                $(".seo-monitor").removeClass("d-none");
                $(".seo-lap").addClass("d-none");
                $(".seo-mob").addClass("d-none");

            }
            else if (width >= 767 && width <= 1649) {
                $(".seo-monitor").addClass("d-none");
                $(".seo-lap").removeClass("d-none");
                $(".seo-mob").addClass("d-none");
            }
            else if ((width >= 325 && width <= 767)) {
                $(".seo-monitor").addClass("d-none");
                $(".seo-lap").addClass("d-none");
                $(".seo-mob").removeClass("d-none");
                // $("#section-offers").removeClass("p-5");
                // $("#section-newArrival").removeClass("p-5")
                // $("#section-hotsale").removeClass("p-5")
            }
        })

    </script>
</body>

<script src="<?php echo base_url(); ?>public/assets/custom/wishlist.js"></script>
<script>
    let widthrttrt = window.innerWidth;
    console.log(widthrttrt);
</script>

<script>
    $('.carousel-main').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
            0: {         // mobile
                items: 2
            },
            768: {       // tablet
                items: 3
            },
            1024: {      // desktop
                items: 4
            }
        }
    });

</script>
<script>

    function toggleMobileBanner() {
        var $banner = $('#banner_img');
        if ($(window).width() <= 767) {
            $banner.show();
            if (typeof mdb !== 'undefined' && mdb.Carousel) {
                var instance = mdb.Carousel.getInstance($banner[0]);
                if (!instance) {
                    new mdb.Carousel($banner[0], { interval: 3000 });
                }
            }
        } else {
            $banner.hide();
        }
    }

    $(document).ready(function () {
        toggleMobileBanner();
    });

    $(window).on('resize', function () {
        toggleMobileBanner();
    });
</script>



</html>
