<!DOCTYPE html>
<!-- TITLE -->
<title>Payment List</title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Payment List</h1>
                    <div class="ms-md-1 ms-0">
                        <!-- <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payment List</li>
                            </ol>
                        </nav> -->
                    </div>
                </div>
                <!-- Page Header Close -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    Filter
                                   Details
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-text text-muted"><i class="ri-calendar-line"></i>
                                            </div>
                                            <input type="text" class="form-control flatpickr-input" id="date"
                                                name="filter_date" placeholder="Choose date" required>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn btn-primary btn-raised-shadow btn-wave" id="filter-btn">Filter
                                            Orders</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Customer Name</th>
                                                <th>Order ID</th>
                                                <th>Payment Details</th>
                                                <th>Amount</th>
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
                    <h5 class="modal-title" id="myLargeModalLabel">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modal-form">

                        <div class="col-md-12">

                            <div class="my-2">
                                <label for="payment_id" class="form-label">Payment ID</label>
                                <input type="text" class="form-control payment_id" id="payment_id"
                                    placeholder="Payment ID" name="payment_id" value="">
                                <span class="error text-danger payment_id mt-10"></span>
                            </div>


                        </div>
                        <div class="col-md-12">

                            <div class="my-2">
                                <label for="method" class="form-label">Payment Method</label>
                                <input type="text" class="form-control method" id="method"
                                    placeholder="Payment Method" name="method" value="">
                                <span class="error text-danger method mt-10"></span>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="my-2">
                                <label for="time" class="form-label">Payment Time</label>
                                <input type="text" class="form-control time" id="time"
                                    placeholder="Payment Time" name="time" value="">
                                <span class="error text-danger time mt-10"></span>
                            </div>


                        </div>

                        <div class="mb-3 d-flex justify-content-end">
                            <a class="btn btn-primary" id="btn-submit" data-bs-dismiss="modal"
                                aria-label="Close">Close</a>
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

    <script src="<?php echo base_url() ?>assets/admin/js/paymentList.js"></script>


</body>

</html>