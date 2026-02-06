<!DOCTYPE html>
<html lang="zxx">

<?php require("components/head.php"); ?>
<style>
    .de_tab_inputs {
        text-align: left !important;
    }

    .address_detail .d-info {
        padding: 20px;
        border: 1px solid #d3d3d3;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0px 4px 6px rgba(207, 207, 207, 0.25), 0px 2px 4px rgba(0, 0, 0, 0.25);

    }

    label span.form-label {
        color: #000 !important;
        text-transform: capitalize;
    }

    .btn.btnclose,
    .btn.btndelete {
        font-size: 15px !important;
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .dark-scheme .card {
        background-color: #fff;
        box-shadow: 0px 4px 6px rgba(207, 207, 207, 0.25), 0px 2px 4px rgba(0, 0, 0, 0.25);

    }

    .edit_btn {
        box-shadow: 0px 4px 6px rgba(207, 207, 207, 0.25), 0px 2px 4px rgba(0, 0, 0, 0.25);

    }
</style>

<body onload="initialize()" class="dark-scheme">
    <div id="wrapper">
        <?php require("components/header.php"); ?>
        <!-- content begin -->
        <div class="no-bottom no-top zebra">
            <div id="top"></div>
            <section id="section-profile" class="bg-gray-100">
                <div class="container">
                    <h5>My Profile</h5>
                    <div class="row">
                        <div class="col-lg-3 mb30">
                            <div class="card padding30 rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="<?php echo base_url() ?>public/assets/images/profile/avatar.jpg"
                                            alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h3 id="profile_name">
                                            <span class="profile_username text-gray" id="profile_email">
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <!-- <li><a href="account-dashboard.html"><i class="fa fa-home"></i>Dashboard</a></li> -->
                                    <li><a href="#" class="active"><i class="fa fa-user"></i>My
                                            Profile</a></li>
                                    <li><a href="<?php echo base_url() ?>address"><i class="fa fa-address-book-o"></i>My
                                            Address</a></li>
                                    <li><a href="<?php echo base_url() ?>myorders"><i class="fa fa-cogs"></i>My
                                            Orders</a></li>

                                    <!-- <li><a href="account-favorite.html"><i class="fa fa-car"></i>My Favorite Cars</a></li> -->
                                    <li><a href="<?php echo base_url() ?>logout-view"><i class="fa fa-sign-out"></i>Sign
                                            Out</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="mx-4">
                                <div class="row ">
                                    <div class="col-12 mb-3 w-100 address_detail">
                                        <div class="de-item-list w-100 p-0">
                                            <div class="d-info">
                                                <div class="d-text">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb20 de_tab_inputs">
                                                            <span>Username:</span>
                                                            <span><?php echo $profile[0]['username'] ?></span>

                                                        </div>
                                                        <div class="col-lg-6 mb20 de_tab_inputs">
                                                            <span>Email:</span>
                                                            <span><?php echo $profile[0]['email'] ?></span>

                                                        </div>
                                                        <div class="col-lg-6 de_tab_inputs">
                                                            <span>Mobile:</span>
                                                            <span><?php echo $profile[0]['number'] ?></span>

                                                        </div>
                                                        <div class="col-lg-6 de_tab_inputs">
                                                            <span>Whatsapp:</span>
                                                            <span><?php echo $profile[0]['wanumber'] ?></span>

                                                        </div>
                                                        <div class="col-md-6 mb20 de_tab_inputs">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="save_cancel_btn">
                                                    <a type="submit" class="btn me-2  px-3 rounded-3 edit_btn"
                                                        data-toggle="modal" data-target="#add_form" data-id="">
                                                        <i class="fa fa-edit me-1"></i>Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit User model -->
                                    <div class="modal fade" id="add_form" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom-0">
                                                    <h5 class="modal-title p-0">Edit Users</h5>
                                                    <a id="addUser" type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </a>
                                                </div>
                                                <form id="profile_form">
                                                    <div class="container">
                                                        <div class="row mx-0 justify-content-center">
                                                            <div
                                                                class="col-md-7 col-lg-5 px-lg-2 col-xl-12 px-xl-0 px-xxl-3">
                                                                <label class="d-block">
                                                                    <span class="form-label d-block">Username</span>
                                                                </label>
                                                                <label class="d-block mb-4">
                                                                    <input type="text" name="username" id="username"
                                                                        class="form-control" placeholder=""
                                                                        autocomplete="off" />
                                                                </label>
                                                                <label class="d-block mb-4">
                                                                    <span class="form-label d-block">Email</span>
                                                                    <input type="email" name="email" id="email"
                                                                        class="form-control" placeholder=""
                                                                        autocomplete="off" />
                                                                </label>
                                                                <label class="d-block mb-4">
                                                                    <span class="form-label d-block">Mobile
                                                                        Number</span>
                                                                    <input type="number" name="number" id="number"
                                                                        class="form-control" placeholder="" readonly
                                                                        autocomplete="off" />
                                                                </label>
                                                                <label class="d-block mb-4">
                                                                    <span class="form-label d-block">Whatsapp
                                                                        Number</span>
                                                                    <input type="number" name="wanumber" id="wanumber"
                                                                        class="form-control" placeholder=""
                                                                        autocomplete="off" />
                                                                </label>
                                                                <div class="mb-3 save_cancel_btn">
                                                                    <a class="btn me-2  px-3 rounded-3 save_btn"
                                                                        id="update-btn">Save</a>
                                                                    <a type="submit" class="btn cancel_btn_add"
                                                                        data-dismiss="modal" aria-label="Close"
                                                                        id="btn-cancel">Cancel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->
        <a href="#" id="back-to-top"></a>
        <?php require("components/footer.php"); ?>


        <script src="<?php echo base_url() ?>public/assets/custom/myprofile.js"></script>


</body>

</html>