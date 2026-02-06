<!DOCTYPE html>
<?php
require("components/head.php");
?>
<meta name="csrf-token" content="<?= csrf_hash() ?>">

<style>
  .new-address>form-label {
    color: #000 !important;
  }

  .d-none {
    display: none !important;
  }

  .acc_panel>.form-control {
    text-transform: lowercase !important;
    color: #000 !important;
  }

  .change-address,
  .submit-email,
  .add-address {
    color: #829b2f;
    text-transform: capitalize;

    background-color: #829b2f;
    color: #fff !important;

  }

  .add_container {
    padding: 20px;
  }

  .address-field>p {
    overflow-wrap: break-word !important;
  }

  .change-address:hover {
    box-shadow: 0 2px 5px 0 #829b2f, 0 2px 10px 0 #829b2f !important;

  }


  .totalamt {
    font-size: 15px;
  }

  .color_wrap>ul,
  .color-name {
    text-transform: capitalize;
  }

  #empty-cart {
    font-size: 100px;
    display: block;
    padding: 20px;
    color: #829b2f !important;

  }

  select {
    color: #000;
  }

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
    color: #000 !important;
    font-size: 16px;
  }

  label {
    margin: 9px 12px 0 0;
    /* text-transform:uppercase; */
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
  }

  .custom-select {
    width: 100%;
    height: 40px;
    overflow: hidden;
    background: url("https://skyzone.com.au/assets/admin/images/select_arrow.png") no-repeat right #333;
    border: 1px solid var(--primary-color) !important;
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

  .delete_btn {
    background: #a82a2a !important;
    color: #fff !important;
    width: 100px;
    font-size: 14px !important;
  }

  .cancel_btn_add {
    background: #a82a2a !important;
    color: #fff !important;
    width: 100px;
    font-size: 14px !important;
  }

  #addAddress {
    padding-left: 20px !important;
  }

  .de-item .d-img img {

    object-fit: contain !important;
    height: 50vh !important;
  }

  .modal-confirm .modal-footer a {
    color: #000;
  }

  .button_close {
    font-size: 16px !important;
  }

  .add-address {
    width: 145px !important;
  }

  .icon_plus {
    margin-right: 5px;
    font-size: 25px;
  }

  .existing_address {
    font-size: 18px;
  }

  ::placeholder {
    text-align: start !important;
    color: #d3d3d3 !important;
  }

  .acc li {
    list-style-type: none;
    padding: 0;
    border: 1px solid #5b5b5b;
    border-radius: 5px;
    /* margin: 20px 0; */
  }

  .acc_ctrl {
    cursor: pointer;
    display: block;
    outline: none;
    padding: 2em;
    position: relative;
    text-align: center;
    width: 100%;
    padding: 15px;
    background: #3d3d3d;
  }

  .acc_ctrl:before {
    background: #fff;
    content: '';
    height: 2px;
    margin-right: 37px;
    position: absolute;
    right: 0;
    top: 50%;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
    -webkit-transition: all 0.2s ease-in-out;
    -moz-transition: all 0.2s ease-in-out;
    -ms-transition: all 0.2s ease-in-out;
    -o-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
    width: 14px;
  }

  .acc_ctrl:after {
    background: #fff;
    content: '';
    height: 2px;
    margin-right: 37px;
    position: absolute;
    right: 0;
    top: 50%;
    width: 14px;
  }

  .acc_ctrl.active:before {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  .acc_ctrl.active h2,
  .acc_ctrl:focus h2 {
    position: relative;
  }

  .acc_panel {
    /* display: none; */
    /* overflow: hidden; */
    /* margin-bottom: 20px; */
  }

  .buynow_page .form-control {
    text-align: left !important;
    border-color: #000 !important;
  }

  .form-check-input {
    margin-top: 1px;
    z-index: 99;
    margin-left: 2%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: none;
  }

  .form-check-input[type=radio]:checked:after {
    border-radius: 50%;
    width: .625rem;
    height: .625rem;
    border-color: #829b2f;
    background-color: #829b2f;
    margin: 0;
  }

  .form-check-input:checked:focus {
    border-color: #829b2f;
  }

  .form-check-input:checked {
    border-color: #a4c735;
  }

  .acc_ctrl h4 {
    margin-left: 4%;
    font-size: 20px;
    margin-bottom: 0;
  }

  .custom-select {
    border: 1px solid #000 !important;
  }

  .acc {
    padding: 20px;
  }

  h4 {
    color: #000 !important;
    font-weight: 500 !important;
  }

  .save_btn {
    background-color: green;
  }

  .form-check-input {
    border: 1px solid #d3d3d3 !important;
  }

  #default_addr {
    margin-top: 0px;
  }

  .form-check-input[type=checkbox]:checked:after {
    margin-left: 0px;
  }

  .step-2 label {
    margin: 5px 12px 0 0;
  }

  .d-text {
    margin: 10px 40px;
  }

  .d-text span {
    color: #d3d3d3;
    font-size: 15px;
  }

  .address_detail,
  .email_detail {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border: unset !important;
    border-radius: 5px;
    padding: 20px;
    margin-top: 30px;

  }

  .address_category {
    border: 1px solid #829b2f;
    margin-left: 8px;
    padding: 5px;
    border-radius: 15px;
    color: #829b2f !important;
    text-transform: uppercase;
    font-size: 10px !important;
    font-weight: 600;
  }

  .address_status {
    margin: 30px 0 10px;
  }

  .change_btn {
    position: relative;
  }

  .change-address {
    text-transform: capitalize;
    position: absolute;
    /* anchor inside the parent */
    background-color: #829b2f;
    color: #fff !important;
    right: 10px;
    /* spacing from right edge */
    bottom: 10px;
    /* spacing from bottom edge */
    width: 120px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 25px;
  }



  @media only screen and (max-width: 391px) {
    .change-address {
      width: 39px !important;
      height: 36px;
      border-radius: 5px;
      font-size: 0;
      /* hides "Change" text */
      padding: 0;
      margin-left: 80%;
    }

    .change-address i {
      font-size: 16px;
      margin: 0;
    }

    .food_img_price_des .food_dec_flex p,
    .cart_total .price_total p {

      font-size: 14px;
    }

    h4 {
      font-size: 20px;
    }

    .action_btn .prev-step,
    .action_btn .next-step {

      font-size: 14px;
      align-items: center;
    }



  }

  @media only screen and (min-width: 392px) and (max-width: 425px) {
        .change-address {
        width: 39px !important;
        height: 36px;
        border-radius: 5px;
        font-size: 0;
        padding: 0;
        top: ;
        margin-top: -11%;
        margin-right: 6%;
        }

    .change-address i {
      font-size: 16px;
      margin: 0;
    }


  }
</style>

<body id="cartlist_page-" class="dark-scheme buynow_page">
  <?php
  $defaultDistructValue = 0;
  require("components/header.php");
  ?>
  <!-- content begin -->
  <section class="pb-0">
    <div id="container" class="container mt-5-">
      <!-- <div class="progress_bar">
        <div class="progress px-1" style="height: 3px;">
          <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
            aria-valuemax="100"></div>
        </div>
        <div class="step-container d-flex justify-content-between">

          <div class="step-circle" onclick="displayStep(1)">1</div>
          <div class="step-circle" onclick="displayStep(2)">2</div>
        </div>
      </div> -->

      <form id="multi-step-form">
        <div class="step step-1" id="buynow">
          <div class="section-empty">
            <div class="container content">
              <div class="row justify-content-center p-0">
                <?php if (empty($address)) { ?>
                  <h4 class="text-center">Add Delivery Address</h4>

                  <div class="row m-3 justify-content-center new-address">
                    <div class="col-12 col-lg-6">
                      <span class="form-label d-block">State</span>
                      <div class="custom-select form-label">
                        <select id="state_id_val" name="state_id">
                          <option value="">Select State</option>
                          <?php foreach ($state as $states) { ?>
                            <option value="<?php echo $states['state_id']; ?>">
                              <?php echo $states['state_title']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <span class="form-label d-block">District</span>
                      <div class="custom-select form-label">
                        <select id="dist_id_val" name="dist_id">
                          <!-- Placeholder for districts -->
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-2">
                      <span class="form-label d-block">Land Mark</span>
                      <input name="landmark" id="landmark" type="text" class="form-control" value="">
                    </div>
                    <div class="col-12 col-lg-6 mb-2">
                      <span class="form-label d-block">Town / City</span>
                      <input name="city" id="city" type="text" class="form-control" value="">
                    </div>
                    <div class="col-12 col-lg-6 mb-2">
                      <span class="form-label d-block">Address</span>
                      <textarea name="address" id="address" class="form-control" rows="1"></textarea>
                    </div>
                    <div class="col-12 col-lg-6 mb-2">
                      <span class="form-label d-block">Zip/Postal code</span>
                      <input name="pincode" id="pincode" type="text" class="form-control" value="">
                    </div>
                    <div class="form-check ms-5 my-2">
                      <input class="form-check-input" type="checkbox" id="default_addr" name="default_addr"
                        style="width: 1.25rem; height: 1.25rem;">
                      <label class="form-check-label" for="default_addr">Set as default address</label>
                    </div>
                    <div class="save_cancel_btn p-1">
                      <a type="submit" class="btn me-2 px-3 rounded-3 save_btn" id="save_address">
                        <i class="fa fa-save me-2"></i>Save
                      </a>
                    </div>
                  </div>

                <?php } ?>



                <?php
                if ($email === "") {
                  $addEmailClass = "";
                  $changeEmailClass = "d-none";
                } else {
                  $changeEmailClass = "";
                  $addEmailClass = "d-none";
                }

                ?>
                <div class="col-12 col-lg-7 mx-auto">
                  <h4 class="text-center mb-4">Email</h4>
                  <div class="mail-container">
                    <!-- Add Email Section -->
                    <div class="email_detail d-flex flex-column flex-lg-row mb-3 add_email <?= $addEmailClass ?>">
                      <div class="col-12 col-lg-9">
                        <div class="acc_panel">
                          <input class="form-control mb-2" type="text" name="email" id="email-check"
                            placeholder="email">
                        </div>
                      </div>
                      <div class="col-12 col-lg-3 text-end mt-2 mt-lg-0">
                        <a class="btn btn-sm w-100 submit-email" id="submit-email">Submit</a>
                      </div>
                    </div>

                    <!-- Change Email Section -->
                    <div class="email_detail d-flex flex-column flex-lg-row mb-3 change_email <?= $changeEmailClass ?>">
                      <div class="col-12 col-lg-9">
                        <div class="acc_panel">
                          <input class="form-control mb-2" type="text" name="email" id="change-email-ip"
                            value="<?= $email ?>">
                        </div>
                      </div>
                      <div class="col-12 col-lg-3 text-end mt-2 mt-lg-0">
                        <a class="btn btn-sm w-100 submit-email" id="change-email">Change Email</a>
                      </div>
                    </div>
                  </div>
                </div>





                <div class="col-12 col-lg-7">
                  <?php if (!empty($address)) { ?>
                    <h4 class="text-center mb-5">Delivery Address</h4>
                    <?php foreach ($address as $addr) {
                      $defaultAddress = $addr['default_addr'];
                      $checkedSts = $defaultAddress ? 'checked' : '';
                      $displayData = $checkedSts ? 'display:block;' : '';
                      if ($defaultAddress) {
                        $defaultstateValue = $addr['state_id'];
                      }
                      ?>
                      <div class="address_detail d-flex flex-column flex-lg-row mb-3">
                        <div class="col-12 col-lg-9">
                          <div class="acc_panel" style="<?= $displayData ?>">
                            <input class="form-check-input address-radio" type="radio"
                              data-state_id="<?= $addr['state_id'] ?>" name="default_addr" id="<?= $addr['add_id'] ?>"
                              <?= $checkedSts ?>>
                            <div class="d-text address-field">
                              <p><?= $addr['username'] ?></p>
                              <span class="existing_address" id="view_address"><?= $addr['address'] ?></span>,
                              <span class="existing_address" id="view_landmark"><?= $addr['landmark'] ?></span><br>
                              <span class="existing_address" id="view_city"><?= $addr['city'] ?></span>,
                              <span class="existing_address" id="view_state"><?= $addr['dist_name'] ?></span><br>
                              <span class="existing_address" id="view_state"><?= $addr['state_title'] ?> -
                                <?= $addr['pincode'] ?></span><br>
                              <p>Mobile Number : <span><?= $addr['number'] ?></span></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-lg-3 text-end mt-2 mt-lg-0">
                          <a class="btn btn-sm w-100 change-address" data-id="<?= $addr['add_id'] ?>"
                            data-index="<?= $i ?>">Change&nbsp;<i class="fas fa-edit"></i></a>
                        </div>
                      </div>
                    <?php } ?>

                  <?php } ?>
                </div>
                <?php
                if (count($address) <= 0) {
                  $dispAddClass = "d-none";
                } else {
                  $dispAddClass = "";
                }
                ?>
                <div class="col-12 col-lg-7 mx-auto add_container <?= $dispAddClass ?>">

                  <a class="btn btn-sm w-100 add-address"><i class="fas fa-plus me-1"></i> Add new address</a>

                </div>
                <div class="col-12 col-lg-7 mt-5 <?= $dispAddClass ?>">
                  <h4 class="text-center mb-5">Select Courier Option</h4>
                   <div class="couriercharge">
                    <?php foreach ($courier_type as $type) { ?>
                      <div class="acc_panel d-none">
                        <input class="form-check-input courier-type" type="radio" name="courier_option"
                          id="<?= $type['courier_id'] ?>" value="<?= $type['courier_id'] ?>">
                        <div class="d-text">
                          <label class="form-check-label" for="st_courier"><?= $type['courier_name'] ?></label>
                        </div>
                      </div>
                    <?php } ?>
                    <input type="hidden" id="prod_price" value="<?= $buynow[0]['sub_total'] ?>">
                    <div class="acc_panel">
                      <input class="form-check-input courier-type" type="radio" name="courier_option" id="free-shipping"
                        value="0">
                      <div class="d-text">
                        <label class="form-check-label" for="free">Free Shipping</label>
                      </div>
                    </div>
                  </div>
                </div>

                <input type="hidden" id="buynow-state-id" value="<?= $defaultstateValue ?>">

                <div class="action_btn">
                  <a href="<?= base_url() ?>" type="button" class="btn-primary prev-step">Continue shopping</a>
                  <a type="button" class="btn-primary next-step">Next</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="step step-2 row justify-content-center">
          <p class="billing_text">Your Orders</p>
          <div class="step_2_wrapper col-lg-9 mb-5">
            <div class="yourCart_div">
              <div class="cart_img_content">
                <!-- start -->
                <?php for ($i = 0; $i < count($buynow); $i++) {
                  ?>
                  <div class="food_img_price_des">
                    <div class="cart_food_img">
                      <img src="<?php echo base_url() ?><?php echo $buynow[$i]['config_image1'] ?>"
                        alt="<?php echo $buynow[$i]['product_name'] ?>">
                    </div>
                    <div class="food_dec_flex">
                      <p><?php echo $buynow[$i]['product_name'] ?></p>
                      <!-- <p><?php echo $buynow[$i]['size'] ?></p>
                      <p><?php echo $buynow[$i]['color_name'] ?></p> -->
                      <?php if ($buynow[$i]['size'] != '0') { ?>

                        <p><span class="badge badge-light">Size :</span><?php echo $buynow[$i]['size'] ?> </p>
                      <?php } ?>


                      <p class="disp_<?php echo $buynow[$i]['cart_id'] ?>" id="prod_price">
                        ₹<?php echo number_format($buynow[$i]['sub_total']) ?>
                      </p>

                    </div>
                  </div>
                <?php } ?>
                <!-- end -->
              </div>
            </div>

            <div class="cart_total">
              <!-- <div class="price_total">
                <p>Total</p>
                <p id="step3-totalamt" class="total_amt_cal"></p>
              </div> -->
              <!-- <div class="price_total">
                <p>Shipping</p>
                <p>free</p>
              </div> -->
              <!-- <div class="price_total">
                <p>Discount</p>
                <p>0</p>
              </div> -->
              <div class="price_total">
                <p>Courier Charges</p>
                <p id="courier-charge">₹</p>
              </div>
            </div>
            <input type="hidden" id="final_total" name="final_total">
            <button type="button" class="total_btn_cart">
              <span>Total Payable</span>
              <span id="step3-totalamt" class="total_amt_cal overAllTotalValue"></span>
            </button>

            <div class="confirm_order">
              <button type="button" class="continue_shoppingBtn pay_btn prev-step me-4">
                < Back</button>
                  <a type="submit" class="total_btn_cart text_center_button place_order btn-success" id="buy-now">Buy
                    Now</a>
            </div>
            <div class="place_order_wrapper">
            </div>
          </div>
        </div>

      </form>


      <div class="add_address_wrapper">
        <div class="modal fade" id="edit_address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header border-bottom-0">
                <h5 class="modal-title p-0" id="address_title">
                </h5>
                <a id="address-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </a>
              </div>
              <form id="address_formdata">
                <div class="container">
                  <div class="row mx-0 justify-content-center">
                    <div class="col-md-7 col-lg-5 px-lg-2 col-xl-12 px-xl-0 px-xxl-3">

                      <label class="d-block mb-4">
                        <span class="form-label d-block">State</span>
                        <div class="custom-select form-label">

                          <select id="state_id_val" name="state_id">
                            <option value="">Select State</option>
                            <?php for ($i = 0; $i < count($state); $i++) { ?>

                              <option value="<?php echo $state[$i]['state_id'] ?>">
                                <?php echo $state[$i]['state_title'] ?>
                              </option>
                            <?php } ?>
                          </select>
                        </div>
                      </label>
                      <label class="d-block mb-4">
                        <span class="form-label d-block">District</span>
                        <div class="custom-select form-label">
                          <select id="dist_id_val" name="dist_id">
                            <!-- code -->
                          </select>
                        </div>
                      </label>
                      <label class="d-block mb-4">
                        <span class="form-label d-block">Land
                          Mark</span>
                        <input name="landmark" id="landmark_val" type="text" class="form-control" placeholder=""
                          autocomplete="off" />
                      </label>
                      <label class="d-block mb-4">
                        <span class="form-label d-block">Town /
                          City</span>
                        <input name="city" id="city_val" type="text" class="form-control" placeholder=""
                          autocomplete="off" />
                      </label>
                      <label class="d-block mb-4">
                        <span class="form-label d-block">Address</span>
                        <textarea name="address" id="address_val" class="form-control" rows="2" placeholder="Address"
                          autocomplete="off"></textarea>
                      </label>
                      <label class="d-block mb-4">
                        <span class="form-label d-block">Zip/Postal
                          code</span>
                        <input name="pincode" id="pincode_val" type="text" class="form-control" placeholder=""
                          autocomplete="off" />
                      </label>
                      <div class="form-check ms-2 mb-4">
                        <input class="form-check-input" type="checkbox" id="default_addr_val" name="default_addr"
                          style="width: 1.25rem; height: 1.25rem;">
                        <label class="form-check-label" for="default_addr">Set as default address</label>
                      </div>

                      <div class="mb-3 save_cancel_btn">
                        <a class="btn me-2  px-3 rounded-3 save_btn" id="save_change_address">Save</a>
                        <a type="submit" class="btn cancel_btn_add" data-dismiss="modal" aria-label="Close"
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



      <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
          <div class="modal-content delete_modal">
            <div class="modal-header flex-column p-0">
              <div class="icon-box">
                <i class="fa fa-close m-0" style="font-size:36px"></i>
              </div>
              <h4 class="modal-title w-100">Are you sure?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <p class="m-0">Do you really want to Remove this product?</p>
            </div>
            <div class="modal-footer justify-content-center p-0">
              <button type="button" class="btn btn-secondary btnclose" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger btndelete">Remove</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- -->

  </section>

  <!-- Modal HTML -->


  <?php
  require("components/footer.php");
  ?>
  <script src="<?php echo base_url() ?>public/assets/custom/buynow.js"></script>

  <script>
    $(function () {
      $('.acc_ctrl').on('click', function (e) {
        e.preventDefault();
        if ($(this).hasClass('active')) {
          $(this).removeClass('active');
          $(this).next()
            .stop()
            .slideUp(300);
        } else {
          $(this).addClass('active');
          $(this).next()
            .stop()
            .slideDown(300);
        }
      });
    });

  </script>
  <script>
    $(document).ready(function () {
      $(".address-radio").change(function () {
        let add_id = $(this).attr("id");
        let state = $(this).data('state_id');
        let token = localStorage.getItem("token");

        $.ajax({
          type: "POST",
          url: base_Url + "update-default-addr",
          data: { add_id: add_id },
          headers: { Authorization: "Bearer " + token },
          success: function (data) {
            let R = $.parseJSON(data);
            if (R.code == 200) {

              $(".address-radio").not(this).prop("checked", false);
              $("#" + add_id).prop("checked", true);

              $("#buynow-state-id").val(R.state_id);
            }
            else {
              $.toast({
                icon: "error",
                heading: "Warning",
                text: R.msg,
                position: "bottom-left",
                bgColor: "#red",
                loader: true,
                hideAfter: 2000,
                stack: false,
                showHideTransition: "fade",
              });
            }
          },
          error: function (error) {
            let status = error.status;
            if (status === 401) {
              localStorage.removeItem("token");
              window.location.href = base_Url;
            }
            console.log(error);
          },
        })

      });
    });

  </script>
</body>

</html>