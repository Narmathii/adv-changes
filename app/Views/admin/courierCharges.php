<!DOCTYPE html>
<!-- TITLE -->
<title>courierCharges</title>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<?php require('components/head.php') ?>
<style>
    #comments {
        height: 100px;
    }
</style>

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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Courier Charges</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Courier Details</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Courier Charges</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <a id="addUserData"
                                    class="btn btn-end btn-outline-primary btn-wave d-sm-flex align-items-center justify-content-between">Add
                                    Data</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>State</th>
                                                <th>District</th>
                                                <th>Courier Name</th>
                                                <th>Charges</th>
                                                <th>Status</th>
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

    <div class="modal fade bs-example-modal-lg" id="distric_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add courier Charges</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modal-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="state_id" class="form-label">State
                                    </label><br>
                                    <select class="form-select" name="state_id" id="state_id">
                                        <option value="">Select State</option>
                                        <?php for ($i = 0; $i < count($state); $i++) {
                                            ?>
                                            <option value="<?php echo $state[$i]['state_id'] ?>">
                                                <?php echo $state[$i]['state_title'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dist_id" class="form-label">District
                                    </label><br>
                                    <select class="form-select" name="dist_id" id="dist_id">

                                        <!-- code -->
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="mb-3">
                                    <label for="courier_id" class="form-label">Courier Name
                                    </label><br>
                                    <select class="form-select" name="courier_id" id="courier_id">
                                        <option value="">Select Courier Name</option>
                                        <?php for ($i = 0; $i < count($couriers); $i++) {
                                            ?>
                                            <option value="<?php echo $couriers[$i]['courier_id'] ?>">
                                                <?php echo $couriers[$i]['courier_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">

                                <label for="charges" class="form-label">Courier Charges</label>
                                <input type="text" class="form-control charges" id="charges"
                                    placeholder="Courier charges" name="charges" value="">

                            </div>
                            <div class="col-md-6">
                                <label for="active_sts" class="form-label">Active status
                                </label><br>
                                <select class="form-select" name="active_sts" id="active_sts">
                                    <option value="">Select status</option>

                                    <option value="1">
                                        Active
                                    </option>
                                    <option value="0">
                                        Deactive
                                    </option>

                                </select>
                                <span class="error text-danger active_sts mt-10"></span>
                            </div>

                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12">
                                <label for="comments" class="form-label">comments</label>
                                <textarea class="form-control" id="comments" name="comments" rows="1"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 mt-3 d-flex justify-content-end">
                            <a class="btn btn-primary" id="btn-submit">Submit</a>
                        </div>
                </div>


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

    <script src="<?php echo base_url() ?>assets/admin/js/courierCharges.js"></script>


</body>

</html>