<!DOCTYPE html>
<html lang="zxx">
<?php require("components/head.php"); ?>
<style>
    * {
        font-family: 'poppins';
    }

    .orders_list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .orders_list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 0;
        border-bottom: 1px solid #ddd;
    }

    .orders_list label {
        flex-basis: 40%;
        font-weight: bold;
        font-family: 'poppins'
    }

    .orders_list span,
    .orders_list .status-container {
        flex-basis: 60%;
        text-align: left !important;
    }

    .view-address {
        display: inline-block;
        margin-left: 10px;
    }

    #disp-name {
        color: #000 !important;
    }


    @media (max-width: 767px) {
        .orders_list li {
            border-bottom: 0 !important;
        }

        label {
            color: grey !important;
            font-size: 16px !important;
        }

        .w-50 {
            width: 25% !important;

        }

        .orders_list li {
            flex-direction: column;
            align-items: flex-start;
        }

        .orders_list span,
        .orders_list .status-container {
            text-align: left;
            margin-top: 5px;
        }

        .orders_list label {
            flex-basis: auto;
        }

        #section-orders .orders_list ul {
            display: block !important;
        }

        #section-orders li {
            display: block !important;
        }

        .orders_list span,
        .orders_list .status-container {
            flex-basis: auto !important;
        }

        .track_viewpage>img {
            width: 15px !important;
            display: flex;
            justify-content: flex-end !important;

        }
    }



    .one-product>p,
    .multiple-product>p {
        color: #2b2b2bcc;
        font-size: 14px;
    }

    /* .one-product>p:hover,
    .multiple-product>p :hover {
        color: #2874f0;
        font-size: 15px !important;


    } */

    .placed_order {
        background: #53c50c;
        width: 11px;
        height: 11px;
        margin: 4px 4px 0 5px;
        border-radius: 50%;
        border: 1px solid #fff;
        display: flex;
    }

    .cancel_order {
        background: rgb(255, 0, 0);
        width: 11px;
        height: 11px;
        margin: 4px 4px 0 5px;
        border-radius: 50%;
        border: 1px solid #fff;
        display: flex;

    }

    .text-right {
        text-align: right;
    }

    .order-color>ul>li:active> {
        text-transform: capitalize !important;
    }

    #empty-cart {
        font-size: 100px;
        display: block;
        padding: 20px;
        color: #a4c735 !important;
    }

    .purchase a {
        font-size: 15px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        /* border-radius: 5px; */
        height: 40px;
        width: 200px;
    }

    .purchase {
        display: flex;
        justify-content: center;
        margin-top: 5%;
    }

    .de_tab_inputs {
        text-align: left !important;
    }

    label {
        color: #000;
    }

    .dark-scheme .de-item {
        margin: 10px;
    }

    .de-item .d-img img {
        aspect-ratio: 3 / 2.7;
    }

    .MultiCarousel .item {
        width: 200px;
    }

    .d-text h4 {
        width: 155px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .paymen_details .price_fields {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 8px 0;
    }

    .price_fields p {
        margin: 0;
    }

    #section-orders h5 {
        font-size: 22px;
        font-weight: bolder;
    }

    .cart_price {
        font-size: 1rem;
        color: #333;
    }

    .cart_price .label {
        font-weight: bold;
        margin-right: 10px;
    }

    .cart_price .price {
        color: #007bff;
        margin-top: 5px;
    }

    .border-bottom {
        border-bottom: 2px solid #dee2e6;
    }

    .text-start {
        text-align: left;
    }

    .text-md-end {
        text-align: right;
    }

    /* Responsive behavior */
    @media (max-width: 767px) {
        .text-md-end {
            text-align: left;
        }
    }

    .price-details>tr {
        color: #000
    }

    .price-details>tr>td {
        border-bottom: 0 !important;
        font-size: medium;
    }

    .order-total {
        font: bold !important;
        font-size: larger;
    }

    .btn-return-policy {
        display: inline-flex;
        align-items: center;
        font-size: 16px;
        color: #fff;
        background-color: #829b2f;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
        padding: 6px 8px;
    }

    .btn-return-policy:hover {
        color: #fff;
        background-color: #829b2f !important;
    }

    .btn-return-policy i {
        margin-right: 10px;
    }

    .table td {
        border-top: 0 !important;
    }

    span.product_status {
        margin-right: 10px;
    }

    .order_statuss {
        background: #53c50c;
        width: 11px;
        height: 11px;
        margin: 0px 4px 0 5px;
        border-radius: 50%;
        border: 1px solid #fff;
        display: flex;
    }

    span.order_statuss {
        margin-top: 7px;
        margin-right: 10px;
    }

    ul.p-0 li {
        width: 100%;
        /* Adjust to a fixed width, if necessary */
        display: flex;
        /* Makes the elements align properly */
        justify-content: space-between;
        /* Distribute the space evenly */
    }
</style>

<body onload="initialize()" class="dark-scheme">
    <div id="wrapper">
        <?php require("components/header.php"); ?>
        <!-- content begin -->
        <div class="no-bottom no-top zebra">
            <div id="top"></div>
            <section id="section-orders" class="bg-gray-100 text-align-center pt-0">
                <div class="container pt-5">
                    <?php $count = count($summary);
                    $class = $count <= 0 ? "d-none" : "";
                    ?>
                    <h5 class="text-center pb-4 <?php echo $class ?>">My Orders</h5>
                    <div class="row">
                        <div class="col-lg-3 mb30">
                            <div class="card padding30 rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="<?php echo base_url() ?>public/assets/images/profile/avatar.jpg"
                                            alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h4 id="disp-name">
                                            <?php echo $username[0]['username'] ?>

                                        </h4>
                                    </div>

                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <li><a href="<?php echo base_url() ?>myprofile"><i class="fa fa-user"></i>My
                                            Profile</a>
                                    </li>
                                    <li><a href="<?php echo base_url() ?>address"><i class="fa fa-address-book-o"></i>My
                                            Address</a>
                                    </li>
                                    <li><a href="#" class="active"><i class="fa fa-cogs"></i>My
                                            Orders</a>
                                    </li>
                                    <li><a href="<?php echo base_url() ?>logout-view"><i class="fa fa-sign-out"></i>Sign
                                            Out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if (count($summary) <= 0) { ?>
                            <div class="col-md-9 orders_wrapper">
                                <span class="text-center justify-content-center" id="empty-cart"><i
                                        class="fa fa-shopping-cart"></i> </span>
                                <h3 class="product_name text-center"><strong>
                                        No Orders Placed yet!!!
                                    </strong>
                                </h3>
                                <div class="purchase">
                                    <a href="<?php echo base_url() ?>" type="button"
                                        class="continue_shoppingBtn pay_btn prev-step me-4">
                                        <i class="arrow_left me-2"></i>Back to purchase
                                    </a>
                                </div>
                            </div>
                        <?php } else { ?>

                            <div class="col-md-9 orders_wrapper">
                                <?php foreach ($summary as $orderID => $orderDetails) { ?>
                                    <div class="col-12 border-bottom- pt-3">
                                        <div class="orders_list">
                                            <ul class="p-0">
                                                <li>
                                                    <label class="order_date">Order Placed</label>
                                                    <span><?php echo date('d F, Y', strtotime($orderDetails[0]['order_date'])); ?></span>
                                                </li>
                                                <!-- <li>
                                                    <label class="order_id">Order Id</label>
                                                    <span><?php echo $orderDetails[0]['order_no']; ?></span>
                                                </li> -->
                                                <li>
                                                    <label class="payment">Address</label>
                                                    <span class="view-address text-center justify-content-center"
                                                        data-toggle="modal" data-target="#modal-<?php echo $orderID; ?>">
                                                        <i class="fas fa-map-marker-alt"></i> view
                                                    </span>
                                                </li>
                                                <li>
                                                    <label class="order_id">Order Status</label>
                                                    <div class="status-container d-flex">
                                                        <?php $className = ($orderDetails[0]['delivery_status'] == "Cancelled" || $orderDetails[0]['delivery_status'] == "Order Pending") ? "cancel_order" : "placed_order" ?>
                                                        <?php $delStatus = $orderDetails[0]['delivery_status'];
                                                        if ($delStatus == 'New') {
                                                            $delMessage = 'Your order has been placed';
                                                        } else if ($delStatus == 'Pending') {
                                                            $delMessage = 'Your order is being processed';
                                                        } else if ($delStatus == 'Shipped') {
                                                            $delMessage = 'Your order has been shipped';
                                                        } else if ($delStatus == 'Delivered') {
                                                            $delMessage = 'Your order has been delivered';
                                                        } else if ($delStatus == 'Cancelled') {
                                                            $delMessage = 'Your order has been Cancelled';
                                                        } else if ($delStatus == 'Refund Created') {
                                                            $delMessage = 'The refund has been created';
                                                        } else if ($delStatus == 'Refund Processed') {
                                                            $delMessage = 'Refund credited within 5-7 days.';
                                                        } else if ($delStatus == 'Order Pending') {
                                                            $delMessage = 'Payment not Confirmed';
                                                        } else if ($delStatus == 'Refund Failed') {
                                                            $delMessage = 'Refund Failed';

                                                        }
                                                        ?>
                                                        <span style="word-break: break-all;"
                                                            class=" <?php echo $className ?>"></span><?php echo $delMessage ?>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a class="track_viewpage"
                                                        href="<?= base_url() ?>tracking-order/<?= base64_encode($orderID) ?>">
                                                        <img width="16" src="<?= base_url() ?>public/right-arrow.png" />
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="col-12 border-bottom"></div>
                                        <?php if (count($orderDetails) == 1) { ?>
                                            <div class="row py-3">
                                                <div class="col-lg-3 col-md-12 border-bottom">
                                                    <div class="bg-image hover-overlay hover-zoom ripple rounded photo mb-3"
                                                        data-mdb-ripple-color="light">
                                                        <img src="<?php echo base_url() . $orderDetails[0]['config_image1']; ?>"
                                                            class="w-50" alt="Product Image" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-6 order_details border-bottom one-product">
                                                    <p class="mb-0 mt-3"><?php echo $orderDetails[0]['product_name']; ?></p>
                                                    <span class="product_desc mb-0">Price:
                                                        <span><?php echo number_format($orderDetails[0]['prod_price']); ?></span>
                                                    </span><br>
                                                    <!-- <span class="product_desc mb-0">Quantity:
                                                        <span><?php echo $orderDetails[0]['quantity']; ?></span>
                                                    </span> -->

                                                    <!-- <?php
                                                    $sizeVal = $orderDetails[0]['size'];
                                                    $hexVal = $orderDetails[0]['hex_code'];
                                                    ?>
                                                    <div class="mycart_product_wrap">
                                                        <div class="product_item">
                                                            <?php if ($orderDetails[0]['size'] != '0') { ?>
                                                                <div class="d-flex <?php echo $displaysize ?>">
                                                                    <p class="m-0">Size:<?php echo $orderDetails[0]['size'] ?></p>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($orderDetails[0]['hex_code'] != '0') { ?>

                                                                <div class="color_wrap d-flex <?php echo $displaycolor ?>">
                                                                    <p class="m-0">Colour:</p>
                                                                    <ul>

                                                                        <li class="active"
                                                                            data-color="<?php echo $orderDetails[0]['hex_code'] ?>"
                                                                            style="background-color :<?php echo $orderDetails[0]['hex_code'] ?> ">
                                                                        </li>
                                                                        <?php echo $orderDetails[0]['color_name'] ?>

                                                                    </ul>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    <?php ?> -->

                                                    <input type="hidden" class="delivery-status"
                                                        data-status="<?php echo $orderDetails[0]['delivery_status']; ?>">
                                                    <a href="https://wa.me/7358992528?text=Welcome%20to%20Adventure%20Shoppe!%0A%0AAddress%20the%20issue%20with%20the%20product%20image%20and%20please%20send%20your%20bill%20across.%20We%20will%20get%20back%20to%20you%20within%2024%20working%20hours
                                                Product Name: <?php echo $orderDetails[0]['product_name']; ?>
                                                Product Price: <?php echo $orderDetails[0]['product_price']; ?>"
                                                        class="btn-return-policy"
                                                        data-id="<?php echo $orderDetails[0]['delivered_time']; ?>"
                                                        data-status="<?php echo $orderDetails[0]['delivery_status']; ?>"
                                                        id="order_<?php echo $orderID; ?>">
                                                        <i class="fas fa-undo-alt"></i> Return Policy
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 order_price border-bottom">
                                                    <p class="text-start text-md-end cart_price">
                                                    <table class="table table-bordered-none">
                                                        <tbody class="price-details">
                                                            <tr>
                                                                <td><strong>Total Price</strong></td>
                                                                <td><span class="m-0">:
                                                                        ₹<?php echo number_format($orderDetails[0]['product_price']); ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Delivery Charge</td>
                                                                <td><span class="m-0">:
                                                                        ₹<?php echo number_format($orderDetails[0]['courier_charge']); ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Order Total</td>
                                                                <td>
                                                                    <p id="total-amt"><span class="m-0 order-total">:
                                                                            <strong>₹<?php echo number_format($orderDetails[0]['sub_total']); ?></strong></span>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    </p>
                                                </div>

                                            </div>
                                        <?php } else if (count($orderDetails) > 1) { ?>
                                            <?php for ($i = 0; $i < count($orderDetails); $i++) { ?>

                                                    <div class="row py-3">
                                                        <div class="col-lg-3 col-md-12 border-bottom">
                                                            <div class="bg-image hover-overlay hover-zoom ripple rounded photo mb-3"
                                                                data-mdb-ripple-color="light">
                                                                <img src="<?php echo base_url() . $orderDetails[$i]['config_image1']; ?>"
                                                                    class="w-50" alt="Product Image" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6 order_details border-bottom multiple-product">
                                                            <p class="mb-0"><?php echo $orderDetails[$i]['product_name']; ?></p>
                                                            <span class="product_desc mb-0">Price:
                                                                <span><?php echo number_format($orderDetails[$i]['prod_price']); ?></span>
                                                            </span><br>
                                                            <!-- <sapn class="product_desc mb-0">Quantity:
                                                                <span><?php echo $orderDetails[$i]['quantity']; ?></span>
                                                            </sapn>
                                                            <?php
                                                            $sizeVal = $orderDetails[$i]['size'];
                                                            $hexVal = $orderDetails[$i]['hex_code'];
                                                            if ($sizeVal != '0' && $hexVal != '0') { ?>
                                                                <div class="mycart_product_wrap">
                                                                    <div class="product_item">
                                                                        <div class="d-flex">
                                                                            <p class="m-0">Size:<?php echo $orderDetails[$i]['size'] ?></p>
                                                                        </div>
                                                                        <div class="color_wrap d-flex order-color">
                                                                            <p class="m-0">Colour:</p>
                                                                            <ul>

                                                                                <li class="active"
                                                                                    data-color="<?php echo $orderDetails[$i]['hex_code'] ?>"
                                                                                    style="background-color:<?php echo $orderDetails[$i]['hex_code'] ?>">
                                                                                </li>
                                                                            <?php echo $orderDetails[$i]['color_name'] ?>

                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        <?php } ?> -->
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 order_price border-bottom">
                                                            <p class="text-start text-md-end cart_price">
                                                            <table class="table table-bordered-none">
                                                                <tbody class="price-details">
                                                                    <tr>
                                                                        <td><strong>Total Price</strong></td>
                                                                        <td><span class="m-0">:
                                                                                ₹<?php echo number_format($orderDetails[$i]['product_price']); ?></span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </p>
                                                        </div>

                                                    </div>
                                            <?php } ?>
                                                <div class="container border-bottom">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-12"></div>
                                                        <div class="col-lg-5 col-md-12">
                                                            <a href="https://wa.me/7358992528?text=Welcome%20to%20Adventure%20Shoppe!%0A%0AAddress%20the%20issue%20with%20the%20product%20image%20and%20please%20send%20your%20bill%20across.%20We%20will%20get%20back%20to%20you%20within%2024%20working%20hours
                                                        Product Name: <?php echo $orderDetails[0]['product_name']; ?><br>
                                                        Product Price: <?php echo $orderDetails[0]['product_price']; ?>"
                                                                class="btn-return-policy"
                                                                data-id="<?php echo $orderDetails[0]['delivered_time']; ?>"
                                                                data-status="<?php echo $orderDetails[0]['delivery_status']; ?>"
                                                                id="order_<?php echo $orderID; ?>">
                                                                <i class="fas fa-undo-alt"></i> Return Policy
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-4 col-md-12">
                                                            <table class="table table-bordered-none">
                                                                <tbody class="price-details">
                                                                    <tr>
                                                                        <td>Delivery Charge</td>
                                                                        <td class="text-right"><span class="m-0">:
                                                                                ₹<?php echo number_format($orderDetails[0]['courier_charge']); ?></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Order Total</td>
                                                                        <td class="text-right">
                                                                            <p id="total-amt"><span
                                                                                    class="m-0 order-total">:₹<?php echo number_format($orderDetails[0]['sub_total']) ?></span>

                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php } ?>

                                        <div class="modal fade" id="modal-<?php echo $orderID; ?>" tabindex="-1" role="dialog"
                                            aria-labelledby="modal-<?php echo $orderID; ?>-label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal-<?php echo $orderID; ?>-label">Order
                                                            Address
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><?php echo $orderDetails[0]['address']; ?>,
                                                            <?php echo $orderDetails[0]['landmark']; ?>
                                                        </p>
                                                        <p><?php echo $orderDetails[0]['city']; ?>,
                                                            <?php echo $orderDetails[0]['dist_name']; ?>
                                                        </p>
                                                        <p><?php echo $orderDetails[0]['state_title']; ?> -
                                                            <?php echo $orderDetails[0]['pincode']; ?>
                                                        </p>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
            </section>
        </div>
    </div>
    <!-- content close -->
    <a href="#" id="back-to-top"></a>
    <?php require("components/footer.php"); ?>
    <script>
        $(document).ready(function () {
            $(".delivery-status").each(function (index, element) {
                let status = $(element).attr('data-status');

                if (status !== "Delivered") {
                    $(this).closest(".col-lg-5").find(".btn-return-policy").addClass("d-none");
                } else {
                    $(this).closest(".col-lg-5").find(".btn-return-policy").removeClass("d-none");
                }
            });

            $(".btn-return-policy").each(function (index, element) {
                let orderTime = $(element).attr("data-id");
                let deliveryStatus = $(element).attr("data-status");

                if (deliveryStatus === "Delivered") {
                    let orderDate = new Date(orderTime);
                    let currentDate = new Date();
                    let diff = currentDate - orderDate;
                    let days = diff / (1000 * 60 * 60 * 24);
                    let hrs = diff / (1000 * 60 * 60);

                    if (days >= 7) {
                        $(element).addClass('d-none');
                    } else {
                        $(element).removeClass('d-none');
                    }
                } else {
                    $(element).addClass('d-none');
                }
            });

        });
    </script>
    <script src="<?php echo base_url() ?>public/assets/custom/myorders.js"></script>
    <script>
        $(document).ready(function () {
            var width = $(window).width();

            if (width <= 768) {
                $('.bg-image').addClass('ripple-surface ripple-surface-light');
            }
        })
    </script>
</body>

</html>