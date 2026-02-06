<!DOCTYPE html>
<!-- TITLE -->
<title>Main Products </title>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<?php require('components/head.php') ?>

<body>

    <!-- LOADER -->
    <div id="loader">
        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/media/loader.svg" alt="">
    </div>
    <!-- END LOADER -->

    <!-- PAGE -->
    <div class="page">
        <?php require('components/topnav.php') ?>

        <?php require('components/sidenavbar.php') ?>

        <!-- MAIN-CONTENT -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Main Products </h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                                <li class="breadcrumb-item"><a href="#">Projects</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Main Products </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <a id="addData"
                                    class="btn btn-end btn-outline-primary btn-wave d-sm-flex align-items-center justify-content-between">Add
                                    Products</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Brand Name</th>
                                                <th>Modal Name </th>
                                                <th>Accessories Name</th>
                                                <th>Accessories Price</th>
                                                <th>Product Image</th>
                                                <th>Featured Products</th>
                                                <th>Product Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- data -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="model-data" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg  modal-dialog-">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Main Products </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="product-main">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="brand_id" class="form-label">Brand Name
                                    </label><br>
                                    <select class="form-select" name="brand_id" id="brand_id">
                                        <option value="">Select Brand Name</option>
                                        <?php foreach ($brand_name as $brand) { ?>
                                            <option value="<?php echo $brand['brand_id'] ?>">
                                                <?php echo $brand['brand_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="error text-danger brand_id mt-5"></span>
                                </div>
                                <div class="col-lg-4">
                                    <label for="modal_id" class="form-label">Modal Name
                                    </label><br>
                                    <select class="form-select" name="modal_id" id="modal_id">
                                        <option value="">Select Modal Name</option>
                                        <?php foreach ($modal_name as $modal) { ?>
                                            <option value="<?php echo $modal['modal_id'] ?>">
                                                <?php echo $modal['modal_name'] ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                    <span class="error text-danger modal_id mt-5"></span>
                                </div>
                                <div class="col-lg-4">
                                    <label for="sub_access_id" class="form-label">Sub Accessories
                                    </label><br>
                                    <select class="form-select" name="sub_access_id" id="sub_access_id">
                                        <option value="">Select Sub Accessories</option>
                                        <?php foreach ($sub_access as $subaccess) { ?>
                                            <option value="<?php echo $subaccess['sub_access_id'] ?>">
                                                <?php echo $subaccess['sub_access_name'] ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                    <span class="error text-danger sub_access_id mt-5"></span>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <label for="product_name" class="form-label">Product Name
                                    </label><br>
                                    <input type="text" class="form-control product_name" id="product_name"
                                        placeholder="Product Name" name="product_name" value="">
                                    <span class="error text-danger product_name mt-10"></span>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <label for="product_price" class="form-label">Product Price
                                    </label><br>
                                    <input type="text" class="form-control product_price" id="product_price"
                                        placeholder="Product Price" name="product_price" value="">
                                    <span class="error text-danger product_price mt-10"></span>
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label for="offer_details" class="form-label">Offer Details
                                    </label><br>
                                    <input type="text" class="form-control offer_details" id="offer_details"
                                        placeholder="Offer Details" name="offer_details" value="">
                                    <span class="error text-danger offer_details mt-10"></span>
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label for="arrival_id" class="form-label">New arrivals Status
                                    </label><br>
                                    <select class="form-select" name="arrival_id" id="arrival_id">
                                        <option value="">Select status</option>
                                        <?php foreach ($new_arrival as $arrivals) { ?>
                                            <option value="<?php echo $arrivals['arrival_status'] ?>">
                                                <?php echo $arrivals['arival_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="error text-danger arrival_id mt-10"></span>
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label for="soldout_id" class="form-label">Soldout Status
                                    </label><br>
                                    <select class="form-select" name="soldout_id" id="soldout_id">
                                        <option value="">Select status</option>
                                        <?php foreach ($soldout_status as $soldout) { ?>
                                            <option value="<?php echo $soldout['sold_staus'] ?>">
                                                <?php echo $soldout['sold_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="error text-danger soldout_id mt-10"></span>
                                </div>


                                <div class="col-lg-12 mt-3">
                                    <label for="product_img" class="form-label">Product Image
                                    </label><br>
                                    <input class="form-control" type="file" id="product_img" name="product_img">

                                    <img src="" id="product_image_url" alt="image" width="130px"
                                        style="padding-top: 15px; display:none;">

                                    <span class="error text-danger product_img mt-5"></span>
                                </div>

                                <div class="modal-header mt-3">
                                    <h5 class="modal-title"><i class="bi bi-bag"></i> Product Details</h5>

                                </div>

                                <div class="col-lg-3 mt-3">
                                    <label for="img_1" class="form-label">Image 1
                                    </label><br>
                                    <input class="form-control" type="file" id="img_1" name="img_1">

                                    <img src="" id="img1_url" alt="image" width="130px"
                                        style="padding-top: 15px; display:none;">

                                    <span class="error text-danger img_1 mt-5"></span>
                                </div>

                                <div class="col-lg-3 mt-3">
                                    <label for="img_2" class="form-label">Image 2
                                    </label><br>
                                    <input class="form-control" type="file" id="img_2" name="img_2">

                                    <img src="" id="img2_url" alt="image" width="130px"
                                        style="padding-top: 15px; display:none;">

                                    <span class="error text-danger img_2 mt-5"></span>
                                </div>


                                <div class="col-lg-3 mt-3">
                                    <label for="img_3" class="form-label">Image 3
                                    </label><br>
                                    <input class="form-control" type="file" id="img_3" name="img_3">

                                    <img src="" id="img3_url" alt="image" width="130px"
                                        style="padding-top: 15px; display:none;">

                                    <span class="error text-danger img_3 mt-5"></span>
                                </div>
                                <div class="col-lg-3 mt-3">
                                    <label for="img_4" class="form-label">Image 4
                                    </label><br>
                                    <input class="form-control" type="file" id="img_4" name="img_4">

                                    <img src="" id="img4_url" alt="image" width="130px"
                                        style="padding-top: 15px; display:none;">

                                    <span class="error text-danger img_4 mt-5"></span>
                                </div>

                                <div class="col-lg-12 mt-3">
                                    <label for="prod_desc" class="form-label">Product
                                        Description</label>
                                    <textarea class="form-control" id="prod_desc"  name="prod_desc" rows="3"></textarea>
                                    <span class="error text-danger prod_desc mt-5"></span>
                                </div>

                                <div class="modal-header mt-3">
                                    <h5 class="modal-title"> <i class="ri-briefcase-line"></i> Specifications</h5>

                                </div>

                                <div class="col-xl-4 mt-3 ">
                                    <label for="material" class="form-label">Material</label>
                                    <input type="text" class="form-control" id="material"  name="material" placeholder="Material">
                                    <span class="error text-danger material mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="colour" class="form-label">Colour</label>
                                    <input type="text" class="form-control" id="colour" name="colour"  placeholder="Colour">
                                    <span class="error text-danger colour mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="prod_weight" class="form-label">Product weight (kg)</label>
                                    <input type="text" class="form-control" id="prod_weight" name="prod_weight"
                                        placeholder="Product weight (kg)">
                                    <span class="error text-danger prod_weight mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="measurement" class="form-label">Product measurement L*B*H (cm)</label>
                                    <input type="text" class="form-control" id="measurement" name ="measurement"
                                        placeholder="Product measurement L*B*H (cm)">
                                    <span class="error text-danger measurement mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="fitment" class="form-label">Fitment</label>
                                    <input type="text" class="form-control" id="fitment" name="fitment" placeholder="Fitment">
                                    <span class="error text-danger fitment mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="warrenty" class="form-label">Warranty</label>
                                    <input type="text" class="form-control" id="warrenty" name="warrenty" placeholder="Warranty">
                                    <span class="error text-danger warrenty mt-5"></span>
                                </div>

                                <div class="modal-header mt-3">
                                    <h5 class="modal-title"><i class="bi bi-bar-chart-line"></i> Features</h5>

                                </div>

                                <div class="col-lg-12 mt-3">
                                    <label for="features" class="form-label">Product
                                        Features</label>
                                    <textarea class="form-control" id="features" name="features" rows="3"></textarea>
                                    <span class="error text-danger features mt-5"></span>
                                </div>


                            </div>
                        </div> <br><br>
                        <div class="mb-3 d-flex justify-content-end">
                            <a class="btn btn-success" id="btn-submit">Submit</a>
                        </div>

                        </hr>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <!-- FOOTER-->
    <?php require('components/footer.php') ?>

    <!-- FOOTER -->

    <footer class="footer mt-auto py-3 bg-white text-center">
        <div class="container">
            <span class="text-muted"> Copyright © <span id="year"></span> <a href="javascript:void(0);"
                    class="text-dark fw-semibold">Adventure shoppe</a>.
                Designed </span> by <a href="javascript:void(0);">
                <span class="fw-semibold text-primary text-decoration-underline">Appteq</span>
            </a> All
            rights
            reserved
            </span>
        </div>
    </footer>
    <!-- END FOOTER -->

    </div>

    <script src="<?php echo base_url() ?>assets/admin/js/mainProduct.js"></script>


</body>

</html>