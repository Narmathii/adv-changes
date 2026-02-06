<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <!-- TITLE -->
    <title>Order Details</title>

    <style>
        .order-item {
            margin-top: 5%;
            margin-bottom: 2%;
        }

        .address {
            width: 50%;
        }

        #order-detail {
            margin-bottom: 10%;
            text-align: center;
        }

        .tbl-address,
        .tbl-address th,
        .tbl-address td {
            border: 1px solid #000 !important;
            padding: 2px;
            padding: 10px;
            text-transform: uppercase;
            ;
        }

        ,
        .tbl-address td.second-col {
            text-align: start;
            margin-left: 20%;
            /* vertical-align: top; */


        }

        /* Simple styling that DomPDF can handle */
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .row {
            display: block;
            width: 100%;
        }

        .col {
            display: inline-block;
            width: 48%;
            padding: 1%;
            vertical-align: top;
        }

        h2 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }


        .table-responsive,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .pdf-img {
            width: 100px !important;
            height: 100px !important
        }
    </style>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4812959302242779"
     crossorigin="anonymous"></script>
<meta name="google-adsense-account" content="ca-pub-4812959302242779">

<body>
    <div>

        <!-- PAGE -->
        <div class="page">
            <!-- MAIN-CONTENT -->
            <div class="container">
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h2 class="page-title fw-semibold fs-18 mb-0 text-center" id="order-detail">Order Details</h2>
                </div>
                <table class="tbl-address mt-4">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 60%; border: 1px solid #000;">Order Date</th>
                            <td scope="col" style="width: 60%; border: 1px solid #000;">
                                <?php echo $data[0]['order_date'] ?>
                            </td>

                        </tr>
                        <tr>
                            <th scope="col" style="width: 60%; border: 1px solid #000;">Name</th>
                            <td scope="col" style="width: 60%; border: 1px solid #000;">
                                <?php echo $data[0]['username'] ?>
                            </td>

                        </tr>
                        <tr>
                            <th scope="col" style="width: 60%; border: 1px solid #000;">Email</th>
                            <td scope="col" style="width: 60%; border: 1px solid #000;">
                                <?php echo $data[0]['email'] ?>
                            </td>

                        </tr>
                        <tr>
                            <th scope="col" style="width: 60%; border: 1px solid #000;">Address</th>
                            <th scope="col" style="text-align: start;width: 40%">Payment history</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row"><?php echo $data[0]['address'] ?> ,<?php echo $data[0]['landmark'] ?></td>
                            <td class="second-col">Order ID - <?php echo $data[0]['order_no'] ?></td>

                        </tr>
                        <tr>
                            <td scope="row"><?php echo $data[0]['city'] ?>,<?php echo $data[0]['dist_name'] ?></td>
                            <td class="second-col">Payment ID -<?php echo $data[0]['razerpay_payment_id'] ?></td>

                        </tr>
                        <tr>
                            <td scope="row"><?php echo $data[0]['number'] ?></td>
                            <td class="second-col">Total Amount - <?php echo $data[0]['sub_total'] ?> Rs</td>

                        </tr>
                        <tr>
                            <td scope="row"><?php echo $data[0]['state_title'] ?> - <?php echo $data[0]['pincode'] ?>
                            </td>
                            <td class="second-col">Payment Status - <?php echo $data[0]['payment_status'] ?></td>

                        </tr>

                    </tbody>
                </table>

                <h4 class="order-item">Order Items</h4>

                <table class="mt-4">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Items</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">MRP</th>
                            <th scope="col">Offer Type</th>
                            <th scope="col">Offer Details</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($data); $i++) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
                                <td>
                                    <img class="pdf-img" src="<?php echo base_url($data[$i]['config_image1']); ?>" />
                                </td>



                                <?php if ($data[$i]['size'] != 0 || $data[$i]['size'] != "") { ?>
                                    <td>
                                        <?= $data[$i]['product_name'] ?><br>
                                        Size : <?= $data[$i]['size'] ?> <br>
                                        <!-- Color : <?= $data[$i]['color_name'] ?> -->
                                    </td>
                                <?php } else { ?>
                                    <td><?= $data[$i]['product_name'] ?></td>
                                <?php } ?>
                                <td><?= $data[$i]['actual_price'] ?></td>
                                <td><?php

                                $dispOffer = $data[$i]['offer_type'];

                                $dispOffer = $dispOffer == 0 ? "Percentage" : ($dispOffer == 1 ? "Flat Discount" : "None");

                                echo $dispOffer ?></td>
                                <td><?= $data[$i]['offer_details'] ?></td>
                                <td><?= $data[$i]['quantity'] ?></td>
                                <td style="text-align:right"><?= $data[$i]['product_price'] ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="7" style="text-align:right">Delivery Charge (<?= $data[0]['courier_type'] ?>):
                            </td>
                            <td colspan="1" style="text-align:right"><?= $data[0]['courier_charge'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:right">Total Price : </td>
                            <td colspan="1" style="text-align:right"><?= $data[0]['sub_total'] ?></td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>

</html>