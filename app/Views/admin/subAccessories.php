<!DOCTYPE html>
<!-- TITLE -->
<title>Sub Accessories</title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Sub Accessories</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sub Accessories</li>
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
                                                <th>Accessories Title</th>
                                                <th>SubAccessories Name </th>
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
                    <h5 class="modal-title" id="myLargeModalLabel">Add Sub Accessories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modal-form">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="access_id" class="form-label">Accessories Title
                                </label><br>
                                <select class="form-select" name="access_id" id="access_id">
                                    <option value="">Select Accessories Title</option>
                                    <?php foreach ($access_data as $access) {
                                        ?>
                                        <option value="<?php echo $access['access_id']; ?>">
                                            <?php echo  $access['access_title']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <span class="error text-danger access_name mt-5"></span>
                            </div>
                            <div class="my-2">
                                <label for="sub_access_name" class="form-label">Sub Accessories</label>
                                <input type="text" class="form-control sub_access_name" id="sub_access_name"
                                    placeholder="Sub Accessories Name" name="sub_access_name" value="">
                                <span class="error text-danger sub_access_name mt-10"></span>
                            </div>


                        </div>

                        <div class="mb-3 d-flex justify-content-end">
                            <a class="btn btn-success" id="btn-submit">Submit</a>
                        </div>
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

    <script src="<?php echo base_url() ?>assets/admin/js/subAccessories.js"></script>


</body>

</html>