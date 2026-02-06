<!DOCTYPE html>
<!-- TITLE -->
<title>Cust List</title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Registered Customer List</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Customer Details</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Customer List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <!-- <div class="card-header">
                                <a id="addUserData"
                                    class="btn btn-end btn-outline-primary btn-wave d-sm-flex align-items-center justify-content-between">Add
                                    Data</a>
                            </div> -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Address</th>
                                                <!-- <th>Active status</th> -->
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

    <div class="modal fade" id="addr-modal">
        <div class="modal-dialog modal-dialog-top text-top modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Saved Address</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="container address-module">
                    <form id="addr-form">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card border border-primary custom-card">
                                    
                                        <label class="list-group-item"id="default_addr"
                  name="default_addr">
                                            <!-- code -->
                                        </label>
                                        
                                            <div class="card-body">
                                                <div class="row gy-3">
                                                    <div class="col-xl-4">
                                                        <label for="text-area" class="form-label">Address</label>
                                                        <textarea class="form-control" id="address" name="address"
                                                            rows="1"></textarea>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="landmark" class="form-label">Landmark</label>
                                                        <input type="text" class="form-control border-dotted"
                                                            id="landmark" name="landmark" placeholder="Dotted">
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="city" class="form-label">City</label>
                                                        <input type="text" class="form-control border-dashed"
                                                            name="city" id="city">
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="district" class="form-label">District</label>
                                                        <input type="text" class="form-control border-dashed"
                                                            id="district" name="district">
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="state" class="form-label">State</label>
                                                        <input type="text" class="form-control border-dashed"
                                                            id="state">
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label for="pincode" class="form-label">Pincode</label>
                                                        <input type="text" class="form-control border-dashed"
                                                            id="pincode">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
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

    <script src="<?php echo base_url() ?>assets/admin/js/custList.js"></script>


</body>

</html>