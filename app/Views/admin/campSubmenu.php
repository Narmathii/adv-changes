<!DOCTYPE html>
<!-- TITLE -->
<title>Sub Menu</title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Sub Menu</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                                <li class="breadcrumb-item"><a href="#"></a>
                                    Camping</li>
                                <li class="breadcrumb-item active" aria-current="page">Sub Menu</li>
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
                                    Data</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Menu</th>
                                                <th>Sub Menu</th>
                                                <th>Images</th>
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
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Sub Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="submenu-form">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="camp_menu_id" class="form-label">Menu
                                </label><br>
                                <select class="form-select" name="camp_menu_id" id="camp_menu_id">
                                    <option value="">Select Menu</option>
                                    <?php foreach ($menu as $data) {
                                        ?>
                                        <option value="<?php echo $data['camp_menu_id'] ?>">
                                            <?php echo $data['camp_menu'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <span class="error text-danger camp_menu_id mt-5"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="my-2">
                                <label for="c_submenu" class="form-label">Sub Menu</label>
                                <input type="text" class="form-control c_submenu" id="c_submenu" placeholder="Sub Menu"
                                    name="c_submenu" value="">
                                <span class="error text-danger c_submenu mt-10"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Modal Image
                            </label><br>
                            <span class="text-success">Required size 500*350 </span>
                            <input class="form-control" type="file" id="csubmenu_img" name="csubmenu_img">

                            <img src="" id="modal_image_url" alt="image" width="130px"
                                style="padding-top: 15px; display:none;">

                            <span class="error text-danger csubmenu_img mt-5"></span>
                        </div>

                        <div class="mb-3 d-flex justify-content-end">
                            <a class="btn btn-primary" id="btn-submit">Submit</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- FOOTER-->
    <?php require ('components/footer.php') ?>

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

    <script src="<?php echo base_url() ?>assets/admin/js/campingSubmenu.js"></script>


</body>

</html>