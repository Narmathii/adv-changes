<!DOCTYPE html>
<!-- TITLE -->
<title>Dashboard</title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <!-- <li class="breadcrumb-item active" aria-current="page">HRM</li> -->
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="row">

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>new-order">
                                    <div class="card custom-card hrm-main-card secondary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-secondary">
                                                        <i class="ri-newspaper-line fs-18"></i>


                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">New Orders</span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $new_order[0]['new_order'];
                                                        $value = count($new_order) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-primary-transparent">View Details</span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>pending-order">
                                    <div class="card custom-card hrm-main-card warning">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-warning">
                                                        <i class="ri-time-line fs-18"></i>

                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">Pending
                                                        Orders</span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $pending_order[0]['pending_order'];
                                                        $value = count($pending_order) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-warning-transparent">View Details</span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>shipping-status">
                                    <div class="card custom-card hrm-main-card primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-primary">
                                                        <i class="ri-shopping-cart-line fs-18"></i>

                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">Shipping
                                                        Status</span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $shipping_status[0]['shipping_status'];
                                                        $value = count($shipping_status) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-primary-transparent">View Details</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>delivery-status">
                                    <div class="card custom-card hrm-main-card success">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-success">
                                                        <i class="ri-truck-line fs-18"></i>

                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">Delivery
                                                        Status</span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $delivery_status[0]['delivery_status'];
                                                        $value = count($delivery_status) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-success-transparent">View Details</span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>cancel-orders">
                                    <div class="card custom-card hrm-main-card danger">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-danger">
                                                        <i class="bi bi-x-square-fill"></i>

                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">Cancel Order
                                                        Details
                                                    </span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $cancelled_status[0]['delivery_status'];
                                                        $value = count($cancelled_status) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-danger-transparent">View Details</span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>refund-details">
                                    <div class="card custom-card hrm-main-card warning">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-warning">
                                                        <i class="bi bi-arrow-clockwise"></i>

                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">Refund
                                                        Details
                                                    </span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $refund_status[0]['delivery_status'];
                                                        $value = count($cancelled_status) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-warning-transparent">View Details</span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
                <!--End::row-1 -->

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Payment Pending Orders</h1>

                </div>

                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="row">

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <a href="<?php echo base_url() ?>order-pending">
                                    <div class="card custom-card hrm-main-card danger">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top">
                                                <div class="me-3">
                                                    <span class="avatar bg-danger">
                                                        <i class="ri-newspaper-line fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="fw-semibold text-muted d-block mb-2">Pending
                                                        Orders</span>
                                                    <h5 class="fw-semibold mb-2">
                                                        <?php
                                                        $totalCount = $order_pending_status[0]['order_pending'];
                                                        $value = count($order_pending_status) == "" ? 0 : $totalCount ?>
                                                        <?php echo $value ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <span class="badge bg-danger-transparent">View Details</span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- END MAIN-CONTENT -->

        <!-- SEARCH-MODAL -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <a href="javascript:void(0);" class="input-group-text" id="Search-Grid"><i
                                    class="fe fe-search header-link-icon fs-18"></i></a>
                            <input type="search" class="form-control border-0 px-2" placeholder="Search"
                                aria-label="Username">
                            <a href="javascript:void(0);" class="input-group-text" id="voice-search"><i
                                    class="fe fe-mic header-link-icon"></i></a>
                            <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <p class="font-weight-semibold text-muted mb-2">Are You Looking For...</p>
                            <span class="search-tags"><i class="fe fe-user me-2"></i>People<a href="javascript:void(0);"
                                    class="tag-addon"><i class="fe fe-x"></i></a></span>
                            <span class="search-tags"><i class="fe fe-file-text me-2"></i>Pages<a
                                    href="javascript:void(0);" class="tag-addon"><i class="fe fe-x"></i></a></span>
                            <span class="search-tags"><i class="fe fe-align-left me-2"></i>Articles<a
                                    href="javascript:void(0);" class="tag-addon"><i class="fe fe-x"></i></a></span>
                            <span class="search-tags"><i class="fe fe-server me-2"></i>Tags<a href="javascript:void(0);"
                                    class="tag-addon"><i class="fe fe-x"></i></a></span>
                        </div>
                        <div class="my-4">
                            <p class="font-weight-semibold text-muted mb-2">Recent Search :</p>
                            <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                                <a href="notifications.html"><span>Notifications</span></a>
                                <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                            </div>
                            <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                                <a href="alerts.html"><span>Alerts</span></a>
                                <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                            </div>
                            <div class="p-2 border br-5 d-flex align-items-center text-muted mb-0 alert">
                                <a href="mail.html"><span>Mail</span></a>
                                <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group ms-auto">
                            <button class="btn btn-sm btn-primary-light">Search</button>
                            <button class="btn btn-sm btn-primary">Clear Recents</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SEARCH-MODAL -->

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

    <!-- FOOTER-->
    <?php require('components/footer.php') ?>

</body>

</html>