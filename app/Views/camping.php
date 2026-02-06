<!DOCTYPE html>
<html lang="zxx">

<?php require("components/head.php"); ?>
<style>
    /* Pagination Container */
    .pagination-list {
        display: flex;
        list-style: none;
        justify-content: end;
        padding: 0;
        margin: 20px 0;
    }

    /* Pagination Items */
    .pagination-item {
        margin: 0 5px;
    }

    /* Pagination Links */
    .pagination-link,
    .pagination-link-default {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #a4c735;
        text-decoration: none;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    /* Hover State */
    .pagination-link:hover,
    .pagination-link-default:hover {
        background-color: #a4c735;
        color: #fff;
    }

    /* Active Page */
    .pagination-link.active,
    .pagination-link-default.active {
        background-color: #a4c735;
        color: #fff;
        border-color: #a4c735;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {

        /* Reduce padding and font size for smaller screens */
        .pagination-link,
        .pagination-link-default {
            padding: 5px 8px;
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {

        /* Show fewer pagination links on small screens */
        .pagination-list {
            overflow-x: auto;
            /* Allow horizontal scrolling */
            white-space: nowrap;
        }

        .pagination-item {
            display: inline-block;
        }
    }


    .orderby {
        width: 100%;
        padding: 3%;
        color: #000;
    }

    .orderby>option,
    .discount>option,
    .orderby_web>option,
    .orderby_mob>option,
    .discount_mob>option {
        color: #000 !important
    }




    .de-item .d-img img {
        object-fit: contain !important;
        aspect-ratio: 4 / 2.7;
    }
</style>

<body class="dark-scheme">
    <div id="wrapper">

        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close -->

        <!-- header begin -->
        <?php require("components/header.php"); ?>
        <!-- header close -->


        <!-- content begin -->
        <div class="no-bottom no-top zebra shopbybrand" id="content">
            <div id="top"></div>

            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <video autoplay muted loop id="myVideo" class="jarallax-img">
                    <source src="<?php echo base_url() ?>public/assets/images/background/BIke_sliding.mp4"
                        type="video/mp4">
                </video>
                <!-- <img src="<?php echo base_url() ?>public/assets/images/background/2.jpg" class="jarallax-img" alt=""> -->
                <div class="center-y relative text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1>
                                    <?php echo $camping_list[0]['camp_menu'] ?>
                                </h1>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- section close -->
            <section id="section-shopByBrands">
                <div class="container">
                    <div class="row" >
                        <div class="col-lg-12"> 
                            <div class="row" style="display:-webkit-box!important"> 
                                <?php for ($i = 0; $i < count($camping_list); $i++) { ?>

                                    <div class="col-12 col-lg-3">
                                        <a
                                            href="<?= base_url() ?>camping-products/<?php echo strtolower(str_replace(' ', '-', $camping_list[$i]['c_submenu'])) ?>/<?php echo base64_encode($camping_list[$i]['c_submenu_id']) ?>">
                                            <div class="de-item mb30">
                                                <div class="d-img">
                                                    <img src="<?= base_url() . $camping_list[$i]['csubmenu_img'] ?>"
                                                        class="img-fluid" alt="<?php echo $camping_list[$i]['c_submenu'] ?>">
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text text-center">
                                                        <h3>
                                                            <?php echo $camping_list[$i]['c_submenu'] ?>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>

                                <?php } ?>
                             </div> 
                         </div> 

                    </div>
                </div>
            </section>


        </div>
        <!-- content close -->

        <a href="#" id="back-to-top"></a>

        <!-- footer begin -->
        <?php require("components/footer.php"); ?>
        <!-- footer close -->

    </div>
    <!-- Javascript Files
    ================================================== -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>public/assets/js/desigcustomnesia.js"></script>

</body>

</html>