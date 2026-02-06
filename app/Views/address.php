<!DOCTYPE html>
<html lang="zxx">
<?php
require ("components/head.php");
?>
<meta name="csrf-token" content="<?= csrf_hash() ?>">

<style>
    
.btnDlt {
  background: #bf1111;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 5px;
  width: 35px;
  height: 35px;
  margin-left: 10px !important;
  position: absolute;
  right: 15px;
  top: 53%;
}
select,
option,
label {
  /* font-family: arial; */
  color: #000;
  font-size: 16px;
}
label {
  margin: 9px 12px 0 0;
  /* text-transform:uppercase; */
}
.dark-scheme .de-item-list{
    background-color:#fff !important;
}
.custom-select select {
  background: transparent;
  width: 100%;
  padding: 5px;
  line-height: 1;
  border: 0;
  border-radius: 0;
  height: 40px;
  -webkit-appearance: none;
}
.custom-select option {
  background: #fff;
  color: #000;
}
.custom-select {
  width: 100%;
  height: 40px;
  overflow: hidden;
  background: url("https://skyzone.com.au/assets/admin/images/select_arrow.png")
    no-repeat right #333;
  /* border: 1px solid var(--primary-color) !important; */
  border-radius: 4px;
}
.custom-select {
  background-color: transparent !important;
  padding: 0 !important;
  height: auto !important;
}

.de_tab_inputs {
  text-align: left !important;
}

.update_profileBtn {
  padding-left: 40px !important;
}
/* .delete_btn {
  background: #a82a2a !important;
  color: #fff !important;
  width: 100px;
  font-size: 14px !important;
} */
/* .cancel_btn_add {
  background: #a82a2a !important;
  color: #fff !important;
  width: 100px;
  font-size: 14px !important;
} */
#addAddress {
  padding-left: 20px !important;
}

.de-item .d-img img {
   
  object-fit: contain !important;
  height: 50vh !important;
}
.modal-confirm .modal-footer a {
  color: #fff;
}

.button_close{
  font-size: 16px !important;
}

.address_detail{

border: 1px solid #d3d3d3;

border-radius: 5px;

padding: 10px 20px 10px;

}

</style>

<body onload="initialize()" class="dark-scheme address_page">
    <div id="wrapper">

        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close -->
        <!-- header begin -->
        <?php
        require ("components/header.php");
        ?>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>

            <section id="section-address" class="bg-gray-100">
                <div class="container">
                    <div class="row">
                        <h5>My Address</h5>
                        <div class="col-lg-3 mb30">
                            <div class="card padding30  rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="<?php echo base_url() ?>public/assets/images/profile/avatar.jpg"
                                            alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h4>
                                            <?php echo $username[0]['username']?>
                                           
                                        </h4>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <li><a href="<?php echo base_url() ?>myprofile"><i class="fa fa-user"></i>My
                                            Profile</a></li>
                                            <li><a href="#" class="active"><i class="fa fa-address-book-o"></i>My Address</a>
                                    </li>
                                            <li><a href="<?php echo base_url() ?>myorders"><i class="fa fa-cogs"></i>My
                                            Orders</a></li>
                                    <!-- <li><a href="#"><i class="fa fa-cogs"></i>My Orders</a></li> -->
                                    
                                    <li><a href="<?php echo base_url() ?>"><i class="fa fa-sign-out"></i>Sign Out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="mx-4">
                                <div class="row ">
                                    <div class="col-lg-12 address_wrapper">
                                        <form id="form-create-item" class="form-border" method="post">
                                            <div class="de_tab tab_simple">
                                                <ul class="de_nav">
                                                    <li class="active"><span>Address</span></li>
                                                </ul>
                                            </div>
                                        </form>
                                        <div class="add_address_wrapper">
                                            <div class="container">
                                                <!-- <i class="fa fa-plus" aria-hidden="true"></i> -->

                                                <input type="button" id="add-address" class="btn-main update_profileBtn"
                                                    data-toggle="modal" value="Add New Address">
                                            </div>
                                            <div class="modal fade" id="add_form" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-bottom-0">
                                                            <h5 class="modal-title p-0">Add Address
                                                            </h5>
                                                            <a id="addAddress" type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </a>
                                                        </div>
                                                        <form id="address_formdata">      
                                                            <div class="container">
                                                                <div class="row mx-0 justify-content-center">
                                                               <div
                                                                        class="col-md-7 col-lg-5 px-lg-2 col-xl-12 px-xl-0 px-xxl-3">

                                                                        <label class="d-block mb-4">
                                                                            <span
                                                                                class="form-label d-block">State</span>
                                                                            <div class="custom-select form-label">

                                                                                <select id="state_id" name="state_id">
                                                                                <option value="">Select State</option>
                                                                                    <?php for ($i = 0; $i < count($state); $i++) { ?>
                                                                                       
                                                                                        <option
                                                                                            value="<?php echo $state[$i]['state_id'] ?>">
                                                                                            <?php echo $state[$i]['state_title'] ?>
                                                                                        </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </label>
                                                                        <label class="d-block mb-4">
                                                                            <span
                                                                                class="form-label d-block">District</span>
                                                                            <div class="custom-select form-label">
                                                                                <select id="dist_id" name="dist_id">
                                                                                    <!-- code -->
                                                                                </select>
                                                                            </div>
                                                                        </label>
                                                                        <label class="d-block mb-4">
                                                                            <span class="form-label d-block">Land
                                                                                Mark</span>
                                                                            <input name="landmark" id="landmark"
                                                                                type="text" class="form-control"
                                                                                placeholder="" />
                                                                        </label>
                                                                        <label class="d-block mb-4">
                                                                            <span class="form-label d-block">Town /
                                                                                City</span>
                                                                            <input name="city" id="city" type="text"
                                                                                class="form-control" placeholder="" />
                                                                        </label>
                                                                        <label class="d-block mb-4">
                                                                            <span
                                                                                class="form-label d-block">Address</span>
                                                                            <textarea name="address" id="address"
                                                                                class="form-control" rows="2"
                                                                                placeholder="Address"></textarea>
                                                                        </label>
                                                                        <label class="d-block mb-4">
                                                                            <span class="form-label d-block">Zip/Postal
                                                                                code</span>
                                                                            <input name="pincode" id="pincode"
                                                                                type="text" class="form-control"
                                                                                placeholder="" />
                                                                        </label>
                                                                        <div class="form-check ms-2 mb-4">
                                                                            <input class="form-check-input" type="checkbox" id="default_addr" name="default_addr" style="width: 1.25rem; height: 1.25rem;">
                                                                            <label class="form-check-label" for="default_addr">Set as default address</label>
                                                                        </div>
                                                                        
                                                                        <div class="mb-3 save_cancel_btn">
                                                                            <a class="btn me-2  px-3 rounded-3 save_btn"
                                                                                id="btn_save">Save</a>
                                                                            <a type="submit" class="btn cancel_btn_add" 
                                                                                data-dismiss="modal"
                                                                                aria-label="Close" id="btn-cancel" >Cancel</a>
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

                                    
                                    <?php for($i=0;$i < count($address);$i++) 
                                    {?>
                                    <div class="col-12 mb-3 w-100 address_detail">
                                        <div class="de-item-list w-100 p-0">
                                            <div class="d-info  p-0">
                                                <div class="d-text  address-field" >
                                                <h4>Address</h4>
                                                    <span class="existing_address" id="view_address"><?php echo $address[$i]['address'] ?></span>,
                                                   
                                                   <span class="existing_address" id="view_landmark"><?php echo $address[$i]['landmark'] ?></span>
                                                   <br>
                                                   <span class="existing_address" id="view_city"><?php echo $address[$i]['city'] ?></span>

                                                   <br>
                                                   <?php echo $address[$i]['dist_name'] ?></span>
                                                   <br>
                                                   <span class="existing_address" id="view_dist"><?php echo $address[$i]['state_title'] ?> - 
                                                   <?php echo $address[$i]['pincode'] ?> </span>
                                                   <br>
                                                   <span class="existing_address" id="view_state"></span>
                                                   <!-- <br><br> -->
                                                   <!-- code -->
                                                </div>
                                                <div class="save_cancel_btn">
                                                    <a type="submit" 
                                                        class="btn me-2  px-3 rounded-3 edit_btn" add_id="<?php echo $address[$i]['add_id'] ?>" 
                                                         index="<?php echo $i ?>" >
                                                        <i class="fa fa-edit me-1"></i>Edit</a>
                                                    <a type="submit" class="btn delete_btn"
                                                        add_id="<?php echo $address[$i]['add_id'] ?>"  index="<?php echo $i ?>"><i
                                                            class="fa fa-trash-o me-1"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- delete modal -->
                                    <div id="delete_modal" class="modal fade">
                                        <div class="modal-dialog modal-confirm">
                                        <div class="modal-content delete_modal">
                                            <div class="modal-header flex-column p-0">
                                            <div class="icon-box" >
                                                <i class="fa fa-close m-0" style="font-size:36px" ></i>
                                                <!-- <i class="fa-solid fa-xmark"></i> -->
                                                <!-- <i class="material-icons">&#xE5CD;</i> -->
                                            </div>
                                            <h4 class="modal-title w-100">Are you sure?</h4>
                                            <button type="button" id="close-btndlt" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                            <p class="m-0">Do you really want to Delete Address</p>
                                            </div>
                                            <div class="modal-footer justify-content-center p-0">
                                            <a type="button" class="btn btn-secondary btnclose button_close" data-dismiss="modal">Cancel</a>
                                            <a type="button" class="btn btn-danger btndelete" add_id="<?php echo $address[$i]['add_id'] ?>">Remove</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <a href="#" id="back-to-top"></a>
        <?php
        require ("components/footer.php");
        ?>
        <script src="<?php echo base_url() ?>public/assets/custom/address.js"></script>
    </div>
</body>

</html>