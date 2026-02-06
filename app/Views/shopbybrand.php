<!DOCTYPE html>
<html lang="zxx">

<?php require("components/head.php"); ?>

<body class="dark-scheme">

    <div id="wrapper">

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
                                    <?php echo $modal_list[0]['brand_name'] ?>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <?php for ($i = 0; $i < count($modal_list); $i++) { ?>

                                    <div class="col-xl-3 col-lg-6">
                                        <a
                                            href="
                                            <?php echo base_url('products/' . strtolower(str_replace([' ', '/'], '-', $modal_list[$i]['modal_name'])) . '/' . base64_encode($modal_list[$i]['modal_id'])) . '/' . base64_encode($modal_list[$i]['brand_id']); ?>/1">
                                            <div class="de-item mb30">
                                                <div class="d-img">
                                                    <img src="<?= base_url() . $modal_list[$i]['modal_img'] ?>"
                                                        class="img-fluid" alt="<?php echo $modal_list[$i]['modal_name'] ?>">
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h3 class="text-center">
                                                            <?php echo $modal_list[$i]['modal_name'] ?>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
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
    <script src="<?php echo base_url() ?>public/assets/js/designesia.js"></script>

</body>

</html>