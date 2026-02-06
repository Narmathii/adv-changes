<!DOCTYPE html>
<!-- TITLE -->
<title>Order List</title>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<?php require('components/head.php') ?>
<style>
    .addr-text {
        color: #000;
    }

    #payment-sts-btn {
        display: none;
    }
</style>

<div>

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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Order List</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Order List</a></li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    Filter
                                    Orders
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
                                                <th>Order No</th>
                                                <th>Customer name</th>
                                                <th>Order Date</th>
                                                <th>Order Details</th>
                                                <th>Payment Status</th>
                                                <th>Delivery Date</th>
                                                <th>Delivery Status</th>
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

<div class="modal fade bs-example-modal-xl modal-xl" id="order_form" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modal-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card card-bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="">
                                            <div class="fs-15 fw-semibold">User Details</div>
                                            <p class="name-text mt-3" id="user-name">
                                            </p>
                                            <p class="email-text mt-3" id="email-data">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card custom-card card-bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="">
                                            <div class="fs-15 fw-semibold">Address</div>

                                            <p class="addr-text mt-3" id="address">
                                            </p>
                                            <p class="addr-text" id="city">
                                            </p>
                                            <p class="addr-text" id="number">
                                            </p>

                                            <p class="addr-text" id="state_title">
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card custom-card card-bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="">
                                            <div class="fs-15 fw-semibold">Payment history</div>
                                            <p class="addr-text mt-3" id="order-date">
                                            </p>
                                            <p class="addr-text mt-3" id="trans-id">
                                            </p>
                                            <p class="addr-text" id="payment-id">
                                            </p>
                                            <p class="addr-text" id="total-amt">
                                            </p>
                                            <p class="addr-text" id="payment-sts">

                                            </p>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card custom-card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="card-title">
                                                Order Items
                                            </div>
                                            <div>

                                                <a id="payment-sts-btn" type="button"
                                                    class="btn btn-secondary-light btn-wave">Check
                                                    Payment
                                                    status -></a>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap" id="order-details">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">S.No</th>
                                                            <th scope="col">Items</th>
                                                            <th scope="col">Product name</th>
                                                            <th scope="col">MRP</th>
                                                            <th scope="col">Offer Type</th>
                                                            <th scope="col">Offer Details</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Drop Shipping</th>

                                                            <th scope="col">Total Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- code -->
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cancel-reason">

                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <a class="btn btn-success" id="btn-print"><i class="bi bi-printer"></i> Print</a>
                        <a class="btn btn-primary ms-3" id="btn-submit" data-bs-dismiss="modal"
                            aria-label="Close">Close</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>



<!-- TRACKING DETAILS EDIT MODAL -->
<div class="modal fade bs-example-modal-lg" id="tracking-order" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Tracking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tracking-form">
                    <div class="col-md-12">
                        <div class="my-2">
                            <label for="courier_partner" class="form-label">Courier Partner</label>
                            <input type="text" class="form-control courier_partner" id="courier_partner"
                                placeholder="Courier Name" name="courier_partner" value="">
                            <span class="error text-danger courier_partner mt-10"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="my-2">
                            <label for="tracking_id" class="form-label">Tracking ID</label>
                            <input type="text" class="form-control tracking_id" id="tracking_id"
                                placeholder="Tracking ID" name="tracking_id" value="">
                            <span class="error text-danger tracking_id mt-10"></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="my-2">
                            <label for="coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control coupon_code" id="coupon_code"
                                placeholder="Coupon Code" name="coupon_code" value="">
                            <span class="error text-danger coupon_code mt-10"></span>
                        </div>
                    </div> -->
                    <div class="my-2">
                        <label for="coupon_code" class="form-label">Delivery Date</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control del-date" name="delivery_date" id="date"
                                    placeholder="Choose delivery date">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="my-2">
                            <label for="bill_no" class="form-label">Bill No</label>
                            <input type="text" class="form-control bill_no" id="bill_no" placeholder="Bill No"
                                name="bill_no" value="">
                            <span class="error text-danger bill_no mt-10"></span>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="coupon_code" class="form-label">Bill Date</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control bill-date" name="bill_date" id="date"
                                    placeholder="Choose bill date">
                            </div>
                        </div>

                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <a class="btn btn-primary" id="submit-track">Submit</a>
                    </div>
            </div>
        </div>
        </form>
    </div>

</div>


<div class="modal fade bs-example-modal-xl" id="tracking-view" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Tracking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered border-primary" id="tracking-details">
                                <thead>
                                    <tr>
                                        <th scope="col">Courier Partner</th>
                                        <th scope="col">Tracking ID</th>
                                        <th scope="col">Delivery Date</th>
                                        <th scope="col">Delivery Message</th>
                                        <th scope="col">Bill No</th>
                                        <th scope="col">Bill Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>




<!-- Delivery status -->
<div class="modal fade bs-example-modal" id="delivery-status" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Delivery Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <div class="table-responsive">
                            <select class="form-select" name="delivery_status" id="delivery_status"
                                aria-label="Default select example">
                                <option selected>Select Status
                                </option>
                                <option value="1">New</option>
                                <option value="2">Pending</option>
                                <option value="3">Shipped</option>
                                <option value="4">Delivered</option>
                                <option value="5">Cancelled</option>
                                <option value="6">Refund Created</option>
                                <option value="7">Refund Processed</option>
                                <option value="8">Refund Failed</option>

                            </select>
                        </div>
                </div>

            </div>


        </div>

    </div>


    <div class="mb-3 mt-3 d-flex justify-content-end">
        <a class="btn btn-primary" id="submit-status">Submit</a>
    </div>
</div>



<!-- FOOTER-->
<?php require('components/footer.php') ?>

<!-- FOOTER -->


</div>

<script src="<?php echo base_url() ?>assets/admin/js/orderList.js"></script>


</body>

</html>