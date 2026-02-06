<!DOCTYPE html>
<html lang="zxx">

<?php require ("components/head.php"); ?>
<style>
    .hide-config {
        display: none;
    }

    .carousel-item.item.active>img {
        width: 100%;
        height: 400px;
        object-fit: contain;
    }

    .carousel-inner {
        box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.2), 0 6px 12px 0 rgba(0, 0, 0, 0.19);
    }

    .wish-status>.availableqty {
        color: #28a745 !important
    }

    .wish-status>.outofstockqty {
        color: red !important;
    }
</style>

<body onload="initialize()" class="dark-scheme details_page">
    <div id="wrapper">

        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close -->
        <?php require ("components/header.php"); ?>
        <!-- content begin -->
        <div class="no-bottom no-top zebra">
            <div id="top"></div>
            <section id="section-product-details" class="pb-0">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6">
                            <form>

                                <div id="slider-carousel" class="owl-carousel">
                                    <div class="item ">
                                        <img src="<?php echo base_url() ?>/<?php echo $product['img_1'] ?>" alt="">
                                    </div>
                                    <div class="item">
                                        <img src="<?php echo base_url() ?>/<?php echo $product['img_2'] ?>" alt="">
                                    </div>
                                    <div class="item">
                                        <img src="<?php echo base_url() ?>/<?php echo $product['img_3'] ?>" alt="">
                                    </div>
                                    <div class="item">
                                        <img src="<?php echo base_url() ?>/<?php echo $product['img_4'] ?>" alt="">
                                    </div>
                                </div>



                                <?php
                                $offerType = $product['offer_type'];
                                $offer_details = $product['offer_details'];

                                if ($offerType == 1 && $offer_details == 0 || $offerType == 2 && $offer_details == 0) {
                                    ?>
                                    <span class="offerrate-"></span>
                                <?php } else { ?>
                                    <span class="offerrate"><?php echo $product['offer_details'] ?>% Off</span>
                                <?php }
                                ?>

                                <input type="hidden" name="prod_id" id="prod_id"
                                    value="<?php echo $product['prod_id'] ?>" />
                                <input type="hidden" name="tbl_name" id="tbl_name" value="<?php echo $tbl_name ?>" />

                                <!-- color & sizes  -->
                                <span aria-hidden="true" class="icon_heart_alt wishlist-btn"></span>
                            </form>
                        </div>
                        <div class="col-lg-6 pb-0 product_details">
                            <div class="de-price text-center">
                                <span class="vehicle_name"><?php echo $product['product_name'] ?></span>
                            </div>
                            <div class="de-box text-light ">
                                <form name="contactForm" id='product-form' method="post">
                                    <!-- <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /> -->

                                    <div class="col-lg-12 singleProduct_detail p-0">
                                        <span id="output"><?php echo $product['prod_desc'] ?></span>
                                    </div>
                                        <div class='row'>
                                            <div class='highlight-window' id='product-img'>
                                                <div class='highlight-overlay' id='highlight-overlay'></div>
                                            </div>
                                        
                                            <input type="hidden" name="config_image1" id="config_image1"
                                                value="<?php echo $product['img_1'] ?>" />
                                            <div class='window <?php echo $className ?>'>
                                                <?php
                                                $colorMaster = $product['colormaster'];
                                                $selectedID = $product['color'];

                                                if ($selectedID != "") {
                                                    if (count($selectedID) > 0) { ?>
                                                        <div class='main-content mt-3'>
                                                            <p>Color:</p>
                                                            <?php
                                                            for ($i = 0; $i < count($selectedID); $i++) {
                                                                for ($j = 0; $j < count($colorMaster); $j++) {
                                                                    if ($selectedID[$i] == $colorMaster[$j]['color_id']) {
                                                                        $backoundColor = $colorMaster[$j]['hex_code'];
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="color"
                                                                    style="background-color:<?php echo $backoundColor ?>">

                                                                    <input type="radio" name="color" class="color-option"
                                                                        prod-id="<?php echo $product['prod_id'] ?>"
                                                                        data-id="<?php echo $i ?>"
                                                                        value="<?php  echo  $selectedID[$i] ?>"
 
                                                                        <?php echo $i == 0 ? 'checked' : '' ?>>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    <?php }
                                                } else { ?>
                                                   <div class='main-content mt-3'>
                                                   <input type="hidden" name="color" class="color-option" value="0" >                
                                                   </div>
                                                <?php } ?>

                                                <?php
                                                $size = $product['size'];
                                                if ($size != "") {
                                                    $count = count($size);
                                                    if ($count > 0) { ?>
                                                        <div class='size-picker col-lg-5 col-12 p-0 mt-3'>
                                                            <p>Size:</p>
                                                            <div class='range-picker' id='range-picker'>
                                                                <?php foreach ($size as $i => $sizeDetails) { ?>
                                                                    <div class='size-option'>
                                                                        <input type="radio" name="size" id="size-<?php echo $i ?>"
                                                                            value="<?php echo $sizeDetails ?>" <?php echo $i == 0 ? 'checked' : '' ?>>
                                                                        <label
                                                                            for="size-<?php echo $i ?>"><?php echo $sizeDetails ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                }  else { ?>
                                                    <div class='size-picker col-lg-5 col-12 p-0 mt-3'>
                                                        <input type="hidden" name="size" id="size-<?php echo $i ?>" value="0">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="d-flex wish-status">
                                            <?php
                                            if ($product['quantity'] <= 0) {
                                                $className = "outofstockqty";
                                                $quantity = "Out of Stock";
                                            } else {
                                                $className = "availableqty";
                                                $quantity = $product['quantity'] . "  left in stock";
                                            } ?>

                                            <p class="d-flex align-items-center <?php echo $className ?>">
                                                <span>Stock status </span> :&nbsp;<?php echo $quantity ?>
                                            </p>
                                        </div>

                                        <div class="addto_cart price">
                                            <div class="col-lg-12 my-2">
                                                <p class="offer_price">
                                                    <?php
                                                    $offerType = $product['offer_type'];
                                                    if ($offerType == 0 || $offerType == 1) { ?>
                                                        <span
                                                            class="m-0 price_span">₹<?=  preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$product['offer_price'] );?></span><span
                                                            class="real_price strike">
                                                            ₹<?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$product['product_price'] ); ?></span>
                                                        <?php
                                                    } else { ?>
                                                        <span
                                                            class="m-0 price_span">₹<?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$product['offer_price'] );?></span></span>
                                                    <?php }
                                                    ?>

                                                </p>

                                            </div>
                                        </div>

                                        <!-- <div class="row px-3">
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                                
                                            <div class="d-flex mb-4 " style="max-width: 300px">
                                                <button class="btn px-3 me-2 ripple-surface"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                    <i class=" icon_minus_alt2"></i> 
                                                </button>
                                                <div class="form-outline">
                                                    <input id="form1" min="0" name="quantity" value="1" type="number" class="form-control" />
                                                    <label class="form-label" for="form1">Quantity</label>
                                                </div>
                                                <button class="btn ripple-surface px-3 ms-2"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                    <i class="icon_plus_alt2"></i>
                                                </button>
                                            </div>
                                        </div>
                                            <div class="col-lg-4 ">
                                                <a href="<?php echo base_url() ?>cart-list"  type='button' id='addtocart' class="btn-main btn-fullwidth addto_cartbtn">AddTo Cart</a>
                                            </div>
                                            <div class="col-lg-4 ">
                                            <a href="<?php echo base_url() ?>buy-now"  type='button' id='send_message' class="btn-main btn-fullwidth book_now">Buy Now</a>
                                            </div>
                                    </div> -->`
                                        <input type="hidden" name="table_name" id="table_name"
                                            value="<?php echo $tbl_name ?>" />
                                        <input type="hidden" name="prod_id" id="prod_id"
                                            value="<?php echo $product['prod_id'] ?>" />
                                        <input type="hidden" name="prod_price" id="prod_price"
                                            value="<?php echo $product['offer_price'] ?>" />
                                        <div class="addto_cart ">
                                            <div class="col-lg-12 btn-detail">
                                                <div class="col-lg-4 ">
                                                    <div class="number">
                                                        <span class="minus">-</span>
                                                        <input id="quantity" name="quantity" type="text" value="1"
                                                            placeholder="1" />
                                                        <span class="plus">+</span>
                                                    </div>
                                                </div>
                                                 <!-- Checkout type based on qty -->
                                            <?php
                                        if ($product['quantity'] <= 0) { ?>
                                            <div class="col-lg-8 contactus">
                                            <a class="btn-main btn-fullwidth " type='button'
                                            href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $product['product_name'] . "\nProduct Price: " . $product['product_price']); ?>">
                                                   Contact us to order</a>
                                            </div>
                                         <?php  }  else { ?>
                                            <div class="col-lg-4 ">
                                            <a type='button' id='addtocart'
                                                class="btn-main btn-fullwidth addto_cartbtn">Add cart</a>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <a id='buynowBtn' class="btn-main btn-fullwidth book_now">Buy Now</a>
                                        </div>
                                         <?php } ?>
                                        <!-- Checkout type based on qty end-->
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section begin -->
            <section aria-label="section" class="py-0 details_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 pt-0">
                            <div class="spacer30"></div>
                            <div class="tab-default">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Description</button>
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-profile" type="button" role="tab"
                                            aria-controls="nav-profile" aria-selected="false">Specifications</button>
                                        <!-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Features</button> -->
                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <p class="m-0"><?php echo $product['prod_desc'] ?></p>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <section id="product_specifications">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="spacer-10"></div>
                                                        <div class="de-spec">
                                                            <div class="d-row">
                                                                <span
                                                                    class="d-value"><?php echo $product['specifications'] ?></span>
                                                            </div>

                                                        </div>

                                                        <div class="spacer-single"></div>

                                                    </div>

                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->
            <section id="section-newArrival" class="py-0">
                <?php
                $similarCount = count($similarProducts);
                $class = $similarCount <= 0 ? "display-none" : ""; ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 text-center newarrival_header  <?= $class ?>">
                            <h3>SIMILAR PRODUCTS</h3>
                            <!-- <span class="view_all">View all<i class="fa fa-angle-right d-none"></i></span> -->
                        </div>
                        <div class="col-12 col-carousel">
                            <div class="owl-carousel carousel-main">

                                <?php for ($i = 0; $i < count($similarProducts); $i++) { ?>
                                    <div class="item">
                                        <div class="">
                                            <a
                                                href="<?php echo base_url() ?>detail/<?php echo strtolower(str_replace(' ', '-', $similarProducts[$i]['redirect_url'])) ?>/<?php echo base64_encode($similarProducts[$i]['prod_id']) ?>">
                                                <div class="de-item">
                                                    <div class="d-img">

                                                        <img src="<?php echo base_url() ?><?php echo $similarProducts[$i]['product_img'] ?>"
                                                            class="img-fluid" alt="">
                                                    </div>

                                                   
                                                    <div class="d-info">
                                                        <div class="d-text">
                                                        <h4><?php echo $similarProducts[$i]['product_name'] ?></h4>
                                                            <span
                                                                class="d-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$similarProducts[$i]['offer_price']) ?></span>
                                                            
                                                                <p class="d-flex wish-status">
                                                                <span class="d-flex align-items-center similar-products" >
                                                                    <?php
                                                                    $stock = $product[$i]['quantity'];
                                                                    if ($stock <= 0) { ?>
                                                                        <span class="product_status outof_stock">
                                                                            <label>Out of stock</label>
                                                                        </span>
                                                                    <?php } else {
                                                                        ?>
                                                                        <span class="product_status">
                                                                            <label>Available</label>
                                                                        </span>
                                                                    <?php } ?>
                                                                </span>
                                                            </p>

                                                            <?php
                                                            $stock = $product[$i]['quantity'];
                                                            if ($stock <= 0) { ?>
                                                                <div>
                                                                    <a class="btn-main buynow_btn"
                                                                        href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $similarProducts[$i]['product_name'] . "\nProduct Price: " . $similarProducts[$i]['product_price']); ?>">Contact
                                                                        us to order</a>
                                                                </div>

                                                            <?php } else { ?>

                                                                <div>
                                                                    <a class="btn-main buynow_btn"
                                                                        href="<?php echo base_url() ?>detail/<?php echo strtolower(str_replace(' ', '-', $similarProducts[$i]['redirect_url'])) ?>/<?php echo base64_encode($similarProducts[$i]['prod_id']) ?>">Buy
                                                                        Now</a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->
        </div>
    </div>
    <!-- content close -->
    <a href="#" id="back-to-top"></a>
    <?php require ("components/footer.php"); ?>



    <script>

        document.addEventListener("DOMContentLoaded", function () {
            var colors = document.querySelectorAll('.color');
            colors.forEach(function (color) {
                color.addEventListener('click', function () {
                    // Deselect all colors
                    colors.forEach(function (c) {
                        c.classList.remove('selected');
                        var radio = c.querySelector("input[type='radio']");
                        if (radio) {
                            radio.removeAttribute("checked");
                        }
                    });

                    // Select the clicked color
                    color.classList.add('selected');
                    var radio = color.querySelector("input[type='radio']");
                    if (radio) {
                        radio.setAttribute("checked", "checked");
                        var dataIndex = radio.getAttribute("data-id");
                        var prodID = radio.getAttribute("prod-id");

                        var table_name = "tbl_products";

                        $.ajax({
                            type: "POST",
                            data: { prod_id: prodID, table_name: table_name },
                            url: base_Url + "get-config-images",
                            dataType: "json",
                            success: function (data) {
                                $("#config_image1").val(data.configImg1[dataIndex]);
                                var sliderImage = "";
                                sliderImage += `<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active item">
                                            <img class="d-block " src="${base_Url}${data.configImg1[dataIndex]}" >
                                            </div>
                                            <div class="carousel-item item">
                                            <img class="d-block" src="${base_Url}${data.configImg2[dataIndex]}">
                                            </div>
                                            <div class="carousel-item item">
                                            <img class="d-block " src="${base_Url}${data.configImg3[dataIndex]}" >
                                            </div>
                                            <div class="carousel-item item">
                                            <img class="d-block " src="${base_Url}${data.configImg4[dataIndex]}">
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        </div>`;

                                $("#slider-carousel").html(sliderImage);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log("Error Details:");
                                console.log("Status: " + textStatus);
                                console.log("Error Thrown: " + errorThrown);
                                console.log("Response Text: " + jqXHR.responseText);
                            },
                        });




                    }


                });
            });
        });

        document.getElementById('range-picker').addEventListener('click', function (e) {
            var sizeList = document.getElementById('range-picker').children;
            for (var i = 0; i <= sizeList.length - 1; i++) {
                console.log(sizeList[i].classList);
                if (sizeList[i].classList.contains('active')) {
                    sizeList[i].classList.remove('active');
                }
            }
            e.target.classList.add('active');
        })

    </script>

</body>


</html>