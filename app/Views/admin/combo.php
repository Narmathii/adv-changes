<!DOCTYPE html>
<!-- TITLE -->
<title>Combo</title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Add Products</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                                <li class="breadcrumb-item"><a href="#">Combo</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Products</li>
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

                                                <th width="14%">Product Name</th>
                                                <th>Price</th>
                                                <th>Product Image</th>
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
                    <h5 class="modal-title" id="myLargeModalLabel">AddProducts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="product-main">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <label for="product_name" class="form-label">Accessories Name
                                    </label><br>
                                    <input type="text" class="form-control product_name" id="product_name"
                                        placeholder="Accessories Name" name="product_name" value="">
                                    <span class="error text-danger product_name mt-10"></span>
                                </div>

                                <div class="col-lg-6 mt-3">
                                    <label for="product_price" class="form-label">Accessories Price
                                    </label><br>
                                    <input type="text" class="form-control product_price" id="product_price"
                                        placeholder="Product Price" name="product_price" value="">
                                    <span class="error text-danger product_price mt-10"></span>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <label for="offer_price" class="form-label">Offer Price
                                    </label><br>
                                    <input type="text" class="form-control offer_price" id="offer_price"
                                        placeholder="Offer Price" name="offer_price" value="">
                                    <span class="error text-danger offer_price mt-10"></span>
                                </div>

                                <div class="col-lg-6 mt-3">
                                    <label for="offer_details" class="form-label">Offer Details
                                    </label><br>
                                    <input type="text" class="form-control offer_details" id="offer_details"
                                        placeholder="Offer Details" name="offer_details" value="">
                                    <span class="error text-danger offer_details mt-10"></span>
                                </div>


                                <div class="col-lg-6 mt-3">
                                    <label for="redirect_url" class="form-label">Redirect Url
                                    </label><br>
                                    <input type="text" class="form-control redirect_url" id="redirect_url"
                                        placeholder="Redirect Url" name="redirect_url" value="">
                                    <span class="error text-danger redirect_url mt-10"></span>
                                </div>



                                <div class="col-lg-6 mt-3">
                                    <label for="arrival_status" class="form-label">New arrivals Status
                                    </label><br>
                                    <select class="form-select" name="arrival_status" id="arrival_status">
                                        <option value="">Select status</option>
                                        <option value="1">
                                            New Arrivals
                                        </option>
                                        <option value="0">
                                            Current
                                        </option>
                                    </select>
                                    <span class="error text-danger arrival_status mt-10"></span>
                                </div>

                                <div class="col-lg-6 mt-3">
                                    <label for="soldout_status" class="form-label">Stock status
                                    </label><br>
                                    <select class="form-select" name="soldout_status" id="soldout_status">
                                        <option value="">Select status</option>

                                        <option value="1">
                                            Available
                                        </option>
                                        <option value="0">
                                            Out of Stock
                                        </option>

                                    </select>
                                    <span class="error text-danger soldout_status mt-10"></span>
                                </div>


                                <div class="col-lg-12 mt-3">
                                    <label for="product_img" class="form-label">Product Image
                                    </label><br>
                                    <input class="form-control" type="file" id="product_img" name="product_img">

                                    <img src="" id="product_image_url" alt="image" width="130px"
                                        style="padding-top: 15px; display:none;">

                                    <span class="error text-danger product_img mt-5"></span>
                                </div>


                                <!-- Product Details Start -->
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
                                    <textarea class="form-control" id="prod_desc" name="prod_desc" rows="3"></textarea>
                                    <span class="error text-danger prod_desc mt-5"></span>
                                </div>

                                <div class="modal-header mt-3">
                                    <h5 class="modal-title"> <i class="ri-briefcase-line"></i> Specifications</h5>

                                </div>

                                <div class="col-xl-4 mt-3">
                                    <label for="material" class="form-label">Material</label>
                                    <input type="text" class="form-control" id="material" name="material"
                                        placeholder="Material">
                                    <span class="error text-danger material mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="colour" class="form-label">Color</label>
                                    <select class="form-control floating" name="colour" id="colour">
                                        <option value="">Select Color</option>
                                        <?php foreach ($colour as $data) { ?>

                                            <option value="<?php echo $data['color_id'] ?>">
                                                <?php echo $data['color_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="prod_weight" class="form-label">Product weight (kg)</label>
                                    <input type="text" class="form-control" id="prod_weight" name="prod_weight"
                                        placeholder="Product weight (kg)">
                                    <span class="error text-danger prod_weight mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="measurement" class="form-label">Product measurement L*B*H (cm)</label>
                                    <input type="text" class="form-control" id="measurement" name="measurement"
                                        placeholder="Product measurement L*B*H (cm)">
                                    <span class="error text-danger measurement mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="fitment" class="form-label">Fitment</label>
                                    <input type="text" class="form-control" id="fitment" name="fitment"
                                        placeholder="Fitment">
                                    <span class="error text-danger fitment mt-5"></span>
                                </div>
                                <div class="col-xl-4 mt-3">
                                    <label for="warrenty" class="form-label">Warranty</label>
                                    <input type="text" class="form-control" id="warrenty" name="warrenty"
                                        placeholder="Warranty">
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



    <!-- View Details Modal -->

    <div class="modal fade bs-example-modal-lg" id="model-view" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg  modal-dialog-">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">View Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 ">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered border-success">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td><span style="display: inline-block;" id="description"> </span></td>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="table-responsive mt-3">
                        <table class="table text-nowrap table-bordered border-success">
                            <thead>
                                <tr>

                                    <th scope="col">Offer Details</th>
                                    <th scope="col">Offer Price</th>
                                    <th>New Arrivals Status</th>
                                    <th scope="col">Soldout Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span id="offer"> <span></td>
                                    <td><span id="offer-price"> <span></td>
                                    <td><span id="arrival-status"> <span></td>
                                    <td><span id="soldout-status"> <span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-5">
                        <table class="table text-nowrap table-bordered border-success " id="tbl-img">
                            <thead>
                                <tr>
                                    <th scope="col">Img1</th>
                                    <th scope="col">Img2</th>
                                    <th scope="col">Img3</th>
                                    <th scope="col">Img4</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!--img Code  -->
                            </tbody>
                        </table>
                    </div>

                    <h5 class="modal-title mt-5" id="myLargeModalLabel">Specifications</h5>
                    <div class="table-responsive mt-3">
                        <table class="table text-nowrap table-bordered border-success" id="specific">
                            <thead>
                                <tr>
                                    <th scope="col">Specifications</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>

                    <h5 class="modal-title mt-5" id="myLargeModalLabel">Features</h5>
                    <div class="table-responsive mt-3">
                        <table class="table text-nowrap table-bordered border-success">
                            <thead>
                                <tr>

                                    <th scope="col">Features</th>

                                </tr>
                            </thead>
                            <tbody>
                                <td>
                                    <p style="text-align:justify;vertical-align: top;" id="product-feature"></p>
                                </td>
                            </tbody>
                        </table>
                    </div>
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






    <script src="<?php echo base_url() ?>assets/admin/js/combo.js"></script>
</body>

</html>