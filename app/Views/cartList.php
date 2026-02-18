<!DOCTYPE html>
<?php
require("components/head.php");
?>
<meta name="csrf-token" content="<?= csrf_hash() ?>">

<style>
  .d-none {
    display: none !important;
  }

  .submit-email {
    background: #829b2f;
    color: #fff !important;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px 0;
  }

  .form-control {
    background: #fff !important;
    border: 1px solid #d3d3d3 !important;
    border-radius: 8px;
    height: 45px !important;
  }

  .couriercharge {
    padding-left: 25px;
  }

  .dark-scheme .card {
    background-color: #fff
  }

  .yourCart_div,
  .cart_total,
  .total_btn_cart {
    background-color: #fff;
  }

  .change-address {
    text-transform: capitalize;
    position: absolute !important;
    background-color: #829b2f;
    color: #fff !important;
    right: 0;
    bottom: 0;
    width: 120px !important;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 25px;
  }

  .add-address {
    color: #829b2f;
    text-transform: capitalize;
    position: absolute !important;
    background-color: #829b2f;
    color: #fff !important;
    left: 17px;

  }

  /* .mail-container>.add_email,
  .mail-container>.change_email {
    display: none;
  } */



  .add_container {
    padding: 20px;
    justify-content: space-around;
  }

  .address-field>p {
    overflow-wrap: break-word !important;
  }

  .change-address:hover {
    box-shadow: 0 2px 5px 0 #829b2f, 0 2px 10px 0 #829b2f !important;

  }

  .food_dec_flex {
    background-size: 100%;
    background-repeat: no-repeat;
    overflow: hidden;

  }

  .totalamt {
    font-size: 15px;
  }

  .color_wrap>ul,
  .color-name {
    text-transform: capitalize;
  }

  .color_wrap>ul>li.active {
    border: 1px solid #000;
  }

  #empty-cart {
    font-size: 100px;
    display: block;
    padding: 20px;
    color: #a4c735 !important;

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
    background: #ffffff;
    width: 100%;
    padding: 5px;
    line-height: 1;
    border: 1px solid #fff;
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
    /* display: none;
    overflow: hidden; */
    /* margin-bottom: 20px; */
  }

  #cartlist_page .form-control {
    text-align: start !important;
  }

  .form-check-input {
    margin-top: 1px;
    z-index: 99;
    margin-left: -2%;
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

  .address_detail {
    box-shadow: 0px 4px 6px rgba(207, 207, 207, 0.25), 0px 2px 4px rgba(0, 0, 0, 0.25);
    border: unset !important;
    border-radius: 10px;
    background-color: #fff;
    padding: 20px !important;
    margin-bottom: 30px !important;
    position: relative;
  }

  .address_category {
    border: 1px solid #a4c735;
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

  #display_price_amt {
    color: #000 !important
  }

  li.active {
    background-color: none !important;
  }

  .btn-decrement,
  .btn-increment {
    padding-left: 10px !important;
  }

  .cartlist-container {
    padding-top: 75px !important;
  }

  @media only screen and (max-width: 425px) {
    .change-address {
      top: 2px !important;
      right: -28px !important;
      bottom: 0;
      width: 39px !important;
      height: 36px;
      border-radius: 5px !important;
    }


    .food_img_price_des .food_dec_flex p,
    .cart_total .price_total p {

      font-size: 14px;
    }

    h4 {
      font-size: 20px;
    }

  }

/*   Krish   */
.product_name, 
.food_dec_flex p {
    white-space: normal !important; 
    overflow: visible !important;   
    text-overflow: clip !important; 
    display: block !important;      
    height: auto !important;        
}
#multi-step-form li, #multi-step-form span, #multi-step-form p, #multi-step-form input, #multi-step-form label {
    color: #000 !important;
}

</style>

<body id="cartlist_page" class="dark-scheme">

  <?php

  require("components/header.php");
  $defaultStateValue = 0;
  ?>
  <!-- content begin -->
  <section class="pb-0 px-5 cartlist-container">
    <div id="container" class="container">
      <div class="progress_bar">
        <div class="progress px-1" style="height: 3px;">
          <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
            aria-valuemax="100">
          </div>
        </div>
        <div class="step-container d-flex justify-content-between">
          <div class="step-circle" onclick="displayStep(1)">1</div>
          <div class="step-circle" onclick="displayStep(2)">2</div>
          <div class="step-circle" onclick="displayStep(3)">3</div>
        </div>
      </div>

      <form id="multi-step-form">
        <div class="step step-1">
          <section class="h-100 gradient-custom p-0">
            <div class="container">
              <h5 class="mb-0 cart_head">My Orders</h5>
              <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
                  <div class="card mb-4">
                    <div class="card-body">
                      <?php if ($cart_count != 0) { ?>
                        <?php for ($i = 0; $i < count($cart_product); $i++) { ?>
                          <div class="row">
                            <div class="col-lg-2 col-md-12 mb-4 mb-lg-0">
                              <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                <img src="<?php echo base_url() . $cart_product[$i]->config_image1; ?>" class="w-100"
                                  alt="<?php echo $cart_product[$i]->product_name; ?>" />
                                <a href="#!">
                                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                </a>
                              </div>
                            </div>

                            <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
                              <p class="product_name"><strong><?php echo $cart_product[$i]->product_name; ?></strong></p>
                              <?php $sizeVal = $cart_product[$i]->size;
                              if ($sizeVal != "0") { ?>
                                <div class="mycart_product_wrap">
                                  <div class="product_item">
                                    <div class="d-flex">
                                      <p class="m-0">Size:</p>
                                      <ul>
                                        <li></li>&nbsp;<?php echo $cart_product[$i]->size; ?>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                              <?php
                              $size_stock = $cart_product[$i]->size_stock;
                              if ($size_stock != 0) {
                                $final_stock = $size_stock;
                              } else {
                                $final_stock = $cart_product[$i]->total_stock;
                              }
                              ?>
                              <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>" />

                              <div class="d-flex mb-4" style="max-width: 300px">
                                <button type="button" class="btn px-3 me-2 ripple-surface btn-decrement"
                                  cart_id_data="<?php echo $cart_product[$i]->cart_id; ?>">
                                  <i class="icon_minus_alt2"></i>
                                </button>
                                <div class="form-outline">
                                  <input min="1" step="1" name="quantity" value="<?php echo $cart_product[$i]->quantity; ?>"
                                    type="number" class="form-control quantity_<?php echo $cart_product[$i]->cart_id; ?>"
                                    readonly />
                                  <label class="form-label">Quantity</label>
                                </div>
                                <button type="button" class="btn ripple-surface px-3 ms-2 btn-increment"
                                  cart_id_data="<?php echo $cart_product[$i]->cart_id; ?>"
                                  data-stock="<?php echo $final_stock; ?>">
                                  <i class="icon_plus_alt2"></i>
                                </button>
                              </div>

                              <input type="hidden" class="cart-price offer_<?php echo $cart_product[$i]->cart_id; ?>"
                                value="<?php echo $cart_product[$i]->offer_price; ?>" />

                              <p class="text-start text-md-center">
                                <strong>
                                  <span id="display_price_amt"
                                    class="m-0 display-price disp_<?php echo $cart_product[$i]->cart_id; ?>">₹
                                    <?php echo number_format($cart_product[$i]->sub_total); ?>
                                  </span>
                                </strong>
                              </p>

                              <a class="trigger-btn m-0 btnDlt" data-toggle="modal"
                                dlt_id="<?php echo $cart_product[$i]->cart_id; ?>">
                                <i class="icon_trash"></i></a>
                            </div>
                          </div>
                          <hr class="my-4" />
                        <?php } ?>
                      <?php } else { ?>
                        <div class="row">
                          <div class="col-lg-12 col-md-6 mb-4 mb-lg-0">
                            <span class="text-center justify-content-center" id="empty-cart">
                              <i class="fa fa-shopping-cart"></i>
                            </span>
                            <h4 class="product_name text-center"><strong>Your Cart is Empty!!!</strong></h4>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                  <div class="card mb-12">
                    <div class="card-body">
                      <div class="row">
                        <div class="coupon_wrapper">
                          <p>Coupon</p>
                          <div class="coupon-row">
                            <span id="cpnCode">Coming Soon !</span>
                            <span id="cpnBtn">Apply Code</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Price details -->
                <div class="col-md-4">
                  <div class="card mb-4">
                    <div class="card-header py-3">
                      <h5 class="mb-0">Price details</h5>
                    </div>
                    <div class="card-body">
                      <ul class="list-group list-group-flush">
                        <li
                          class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                          <?php $Itemview = $total_items > 1 ? "Items" : "Item"; ?>
                          Price (<?php echo $total_items . " " . $Itemview; ?>)
                          <span class="m-0 total_amt_cal"></span>
                        </li>
                        <li
                          class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                          <div><strong>Total amount</strong></div>
                          <span><strong id="total-amt" class="total_amt_cal"></strong></span>
                        </li>
                      </ul>
                      <a type="button" id="place-order" class="btn-lg btn-block pay_btn checkpout_btn next-step">
                        <i class="icon_cart me-2"></i>Place Order
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- STEP 2: Address -->
        <div class="step step-2">
          <div class="section-empty">
            <div class="container content">
              <div class="row justify-content-center p-0">
                <?php require "components/addressForm.php"; ?>
                <div class="container">
                  <div class="row">
                    <?php if (!empty($address)) { ?>
                      <div class="col-12 col-lg-8 mx-auto">
                        <div class="add_container d-flex">
                          <a class="btn btn-sm w-100 add-address"><i class="fas fa-plus me-1"></i> Add new address</a>
                          <h4 class="text-center mb-4">Delivery Address</h4>
                        </div>
                        <?php foreach ($address as $i => $addr) {
                          $defaultAddress = $addr["default_addr"];
                          $checkedSts = $defaultAddress ? "checked" : "";
                          ?>
                          <div class="address_detail d-flex flex-column flex-lg-row mb-3">
                            <div class="col-12 col-lg-9">
                              <div class="acc_panel">
                                <input class="form-check-input address-radio mb-2" type="radio"
                                  data-dist_id="<?php echo $addr["dist_id"]; ?>" name="default_addr"
                                  id="<?php echo $addr["add_id"]; ?>" <?php echo $checkedSts; ?> />
                                <div class="d-text address-field">
                                  <p class="fw-bold"><?php echo $addr["username"]; ?></p>
                                  <p><?php echo $addr["address"] . ", " . $addr["landmark"]; ?></p>
                                  <p>
                                    <?php echo $addr["city"] . ", " . $addr["dist_name"] . ", " . $addr["state_title"] . " - " . $addr["pincode"]; ?>
                                  </p>
                                  <p>Mobile Number: <span><?php echo $addr["number"]; ?></span></p>
                                </div>
                              </div>
                            </div>

                            <?php ?>
                            <div class="col-12 col-lg-3 text-end mt-2 mt-lg-0 change_btn">
                              <a class="btn btn-sm w-100 change-address" data-id="<?php echo $addr["add_id"]; ?>"
                                data-index="<?= $i ?>">Change&nbsp;<i class="fas fa-edit"></i>
                              </a>
                            </div>
                          </div>
                        <?php } ?>
                      </div>

                      <div class="col-12 col-lg-4 pt-4">
                        <h4 class="text-center mt-1 mb-5">Email</h4>
                        <div class="mail-container">
                          <div class="email_detail add_email ">
                            <input class="form-control mb-2" type="text" name="email" id="email-check"
                              placeholder="email">
                            <a class="btn btn-sm w-100 submit-email" id="submit-email">Submit</a>
                          </div>
                          <div class="email_detail change_email ">
                            <input class="form-control mb-2" type="text" name="email" id="change-email-ip" value="">
                            <a class="btn btn-sm w-100 submit-email" id="change-email-btn">Change Email</a>
                          </div>
                          <h4 class="text-start mt-5 mb-4 ps-3">Select Courier Option</h4>
                          <div class="couriercharge">
                            <?php foreach ($courier_type as $type) { ?>
                              <div class="acc_panel mb-2 d-none">
                                <input class="form-check-input courier-type" type="radio" name="courier_option"
                                  id="<?php echo $type["courier_id"]; ?>" value="<?php echo $type["courier_id"]; ?>" />
                                <label class="form-check-label ms-3"
                                  for="<?php echo $type["courier_id"]; ?>"><?php echo $type["courier_name"]; ?></label>
                              </div>
                            <?php } ?>
                            <div class="acc_panel mb-2">
                              <input class="form-check-input courier-type" type="radio" name="courier_option"
                                id="courier-option" value="0" />
                              <label class="form-check-label ms-3" for="courier-option">Free Shipping</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" id="cart-state-id" value="<?php echo $defaultState[0]["state_id"]; ?>" />
                      <div class="action_btn text-center mt-4">
                        <button type="button" class="btn btn-primary me-2 prev-step">Previous</button>
                        <button type="button" class="btn btn-success next-step" id="prod-detail">Next</button>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- STEP 3 -->
        <div class="step step-3 row justify-content-center d-none" id="step3-final">
          <p class="billing_text">Your Orders</p>
          <div class="step_3_wrapper col-lg-11 mb-5">
            <div class="yourCart_div">
              <div class="cart_img_content">
                <?php for ($i = 0; $i < count($cart_product); $i++) { ?>
                  <div class="food_img_price_des">
                    <div class="cart_food_img">
                      <img src="<?php echo base_url() . $cart_product[$i]->config_image1; ?>"
                        alt="<?php echo $cart_product[$i]->product_name; ?>">
                    </div>
                    <div class="food_dec_flex">
                      <p><?php echo $cart_product[$i]->product_name; ?></p>
                      <p class="disp_<?php echo $cart_product[$i]->cart_id; ?>">
                        ₹<?php echo number_format($cart_product[$i]->sub_total); ?>
                      </p>
                    </div>
                  </div>
                  <?php if ($cart_product[$i]->size != "0") { ?>
                    <p>Size: <?php echo $cart_product[$i]->size; ?></p>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>

            <div class="cart_total">
              <div class="price_total">
                <p>Total</p>
                <p id="step3-totalamt" class="total_amt_cal"></p>
              </div>
              <div class="price_total">
                <p>Courier Charges</p>
                <p id="courier-charge"></p>
              </div>
            </div>

            <input type="hidden" id="final_total" name="final_total">

            <button type="button" class="total_btn_cart">
              <span>Total Payable</span>
              <span id="step3-totalamt" class="total_amt_cal overAllTotalValue"></span>
            </button>

            <div class="confirm_order mt-3">
              <button type="button" class="continue_shoppingBtn pay_btn prev-step me-4">
                <i class="arrow_left me-2"></i>Go Orders
              </button>
              <a type="submit" class="total_btn_cart text_center_button place_order btn-success" id="buy-now">Buy
                Now</a>
            </div>
            <div class="place_order_wrapper"></div>
          </div>
        </div>
      </form>

    </div>


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

                            <option value="<?php echo $state[$i][
                              "state_id"
                            ]; ?>">
                              <?php echo $state[$i]["state_title"]; ?>
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
                        autocomplete="off" style="width: 1.25rem; height: 1.25rem;">
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

  </section>

  <!-- Modal HTML -->


  <?php
  require("components/footer.php");
  ?>
  <script src="<?php echo base_url() ?>public/assets/custom/cartList.js"></script>

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
              $("#cart-state-id").val(R.state_id);
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
  <script>

    function displayStep(stepNumber) {
      if (stepNumber >= 1 && stepNumber <= 3) {
        $(".step-" + currentStep).hide();
        $(".step-" + stepNumber).show();
        currentStep = stepNumber;
        updateProgressBar();
      }
    }</script>


</body>

</html>