<!DOCTYPE html>
<html lang="zxx">

<?php require ("components/head.php"); ?>
<style>
    .de_tab_inputs {
        text-align: left !important;
    }

    #ordere_summary_wrapper li label,
    #ordere_summary_wrapper li span,
    #ordere_summary_wrapper p,
    #ordere_summary_wrapper span,
    #ordere_summary_wrapper label {
        color: #000 !important;
    }

    ul {
        display: flex;
        justify-content: space-between;
    }

    li {
        flex-direction: column;
        display: flex;
    }

    .order_confirmation {
        background: #d3d3d3;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
    }

    .row {
        padding: 15px 15px 0 15px;
    }

    .margin {
        margin: 0 140px;
        border: 1px solid #d3d3d3;
    }

    .order_details,
    .order_qty,
    .order_price {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .order_qty label {
        margin-bottom: 1rem;
    }

    .price_fields {
        display: flex;
        justify-content: space-between;
    }

    .border-bottom {
        border-bottom: 1px solid #d3d3d3;
    }

    label {
        font-weight: 600;
        text-transform: capitalize;
        font-size: 18px;
    }

    .confirm_order {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .image-width {
        width: 25% !important;
    }

    .table td,
    .table td>span {
        padding: .75rem;
        vertical-align: top;
        border-top: 0;
        border-bottom: 0 !important;
    }
</style>

<body onload="initialize()">
    <div id="wrapper">
        <?php require ("components/header.php"); ?>
        <a href="#" id="back-to-top"></a>
        <section id="ordere_summary_wrapper">

            <?php foreach ($summary as $orderID => $orderDetails): ?>
                <div class="margin">
                    <div class="row pt-0">
                        <div class="order_confirmation">
                            <p>Your Order has been confirmed and will be shipping soon.</p>
                        </div>
                        <div class="col-12 border-bottom pt-3">
                            <div>
                                <ul class="p-0">
                                    <li>
                                        <label class="order_date">Order Date</label>
                                        <span><?php echo date('d F, Y', strtotime($orderDetails[0]['order_date'])); ?></span>
                                    </li>
                                    <li>
                                        <label class="order_id">Order Id</label>
                                        <span><?php echo $orderDetails[0]['order_no']; ?></span>
                                    </li>
                                    <li>
                                        <label class="payment">Payment Status</label>
                                        <span><?php echo $orderDetails[0]['order_status']; ?></span>
                                    </li>
                                    <li>
                                        <label class="address">Address</label>
                                        <span><?php echo $orderDetails[0]['address']; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($orderDetails as $item) { ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-12 border-bottom">
                                <div class="bg-image hover-overlay hover-zoom ripple rounded photo mb-3"
                                    data-mdb-ripple-color="light">
                                    <img src="<?php echo base_url() ?><?php echo $item['product_img']; ?>" class="image-width"
                                        alt="<?php echo $item['product_name']; ?>" />
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 order_details border-bottom">
                                <p><strong><?php echo $item['product_name']; ?></strong></p>
                            </div>
                            <div class="col-lg-2 col-md-6 order_qty border-bottom">
                                <label class="payment">QTY</label>
                                <span><?php echo $item['quantity']; ?></span>
                            </div>
                            <div class="col-lg-2 col-md-6 order_price border-bottom">
                                <p class="text-start text-md-end cart_price">
                                    <strong><span class="m-0">₹<?php echo $item['sub_total']; ?></span></strong>
                                </p>
                            </div>

                            <div class="]-lg-4 " style="background-size: 100%; background-repeat: no-repeat;">
                                <a type="button" id="buynowBtn" class="btn-main btn-fullwidth book_now">Buy Now</a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php foreach ($orderDetails as $item) { ?>
                        <div class="row">
                            <div class="col-12 border-bottom">
                                <div class="price_fields">
                                    <label class="sub_totoal">Sub Total</label>
                                    <p>₹<?php echo $item[0]['sub_total']; ?></p>
                                </div>
                                <div class="price_fields">
                                    <label class="shipping_cost">Delivery Charge</label>
                                    <p><?php echo $orderDetails[0]['courier_charge'] > 0 ? '₹' . $orderDetails[0]['courier_charge'] : 'Free'; ?>
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 border-bottom pb-3">
                                <div class="price_fields">
                                    <label class="total">Total</label>
                                    <strong>₹<?php echo $orderDetails[0]['order_total']; ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-lg-12 border-bottom">
                            <p>We'll send you shipping confirmation when your order(s) are on the way! We appreciate your
                                business and hope you enjoy your purchase.</p>
                        </div>
                        <div class="col-lg-12 d-flex flex-column py-3">
                            <strong>Thank you!</strong>
                            <strong>Adventure Shopee</strong>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="confirm_order">
                <a href="<?php echo base_url() ?>" type="button" class="continue_shoppingBtn pay_btn prev-step me-4">
                    <i class="arrow_left me-2"></i>Home
                </a>
            </div>
        </section>
        <?php require ("components/footer.php"); ?>
        <script src="<?php echo base_url() ?>public/assets/custom/myprofile.js"></script>
</body>

</html>