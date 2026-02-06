<!DOCTYPE html>
<!-- TITLE -->
<title>Stock Notification</title>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<?php require ('components/head.php') ?>

<body>

    <!-- LOADER -->
    <div id="loader">
        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/media/loader.svg" alt="">
    </div>
    <!-- END LOADER -->

    <!-- PAGE -->
    <div class="page">
        <?php require ('components/topnav.php') ?>

        <?php require ('components/sidenavbar.php') ?>

        <!-- MAIN-CONTENT -->

        <div class="main-content app-content">


            <div class="container-fluid">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Notifications</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->




                <div class="container-lg">
                    <div class="row justify-content-center">
                        <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <ul class="list-unstyled mb-0 notification-container">
                                <?php for ($i = 0; $i < count($stock_status); $i++) {
                                    ?>
                                    <li>
                                        <div class="card custom-card un-read">
                                            <div class="card-body p-3">

                                                <a href="<?php
                                                $tableName = $stock_status[$i]['tbl_name'];

                                                if ($tableName == "tbl_products") {
                                                    $url = "add-products";
                                                } else if ($tableName == "tbl_accessories_list") {
                                                    $url = "accessories-list";
                                                } else if ($tableName == "tbl_rproduct_list") {
                                                    $url = "riding-product-list";
                                                } else if ($tableName == "tbl_luggagee_products") {
                                                    $url = "luggage_product-list";
                                                } else if ($tableName == "tbl_helmet_products") {
                                                    $url = "helmet-product-list";
                                                } else if ($tableName == "tbl_camping_products") {
                                                    $url = "camp-product-list";
                                                }
                                                echo $url
                                                    ?> ">
                                                    <div class="d-flex align-items-top mt-0 flex-wrap">

                                                        <div class="flex-fill">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mt-sm-0 mt-2">
                                                                    <p class="mb-0 fs-14 fw-semibold">
                                                                        <?= $stock_status[$i]['product_name'] ?>
                                                                    </p>
                                                                    <p class="mb-0 text-muted">
                                                                        Product ID : <span
                                                                            class="badge bg-primary-transparent fw-semibold mx-1">
                                                                            <?= $stock_status[$i]['prod_id'] ?></span>
                                                                    </p>
                                                                    <p class="mb-0 text-muted mt-3">
                                                                        Product Master : <span
                                                                            class="badge bg-primary-transparent fw-semibold mx-1">
                                                                            <?php
                                                                            $tableName = $stock_status[$i]['tbl_name'];

                                                                            if ($tableName == "tbl_products") {
                                                                                $name = "Shop By Bike";
                                                                            } else if ($tableName == "tbl_accessories_list") {
                                                                                $name = "Motor Accessories";
                                                                            } else if ($tableName == "tbl_rproduct_list") {
                                                                                $name = "Riding Gears";
                                                                            } else if ($tableName == "tbl_luggagee_products") {
                                                                                $name = "Luggage and Touring";
                                                                            } else if ($tableName == "tbl_helmet_products") {
                                                                                $name = "Helmet and Accessories";
                                                                            } else if ($tableName == "tbl_camping_products") {
                                                                                $name = "Camping";
                                                                            }

                                                                            echo $name
                                                                                ?></span>
                                                                    </p>

                                                                </div>
                                                                <div class="ms-auto">
                                                                    Quantity :
                                                                    <span class="float-end badge bg-light text-muted">
                                                                        <?= $stock_status[$i]['quantity'] ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>

                        </div>

                    </div>


                </div>


            </div>


        </div>

        <!-- FOOTER-->
        <?php require ('components/footer.php') ?>

</body>

</html>