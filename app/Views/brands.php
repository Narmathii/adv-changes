<!DOCTYPE html>
<?php
require("components/head.php");
?>

<style>
    .orderby {
        width: 100%;
        padding: 3%;
        color: #000;
    }

    .orderby>option {
        color: #000 !important
    }
</style>

<body id="products_page" class="dark-scheme">
    <?php
    require("components/header.php");
    ?>
    <!-- content begin -->

    <div class="no-bottom no-top zebra">

        <!-- section begin -->
        <!-- <section id="subheader" class="jarallax text-light">
          
            <div class="center-y relative text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>
                                <?php echo $product[0]['modal'] ?>
                            </h1>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- section close -->
        <section id="section-cars" class="products_wrapper">
            <div class="container">
                <div class="row">
                    <h1 class="mb-4">
                        <?php echo $product[0]['modal'] ?>
                    </h1>

                    <!-- mobile view filter -->
                    <!-- <span class="filter_sm d-lg-none">
                        <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                            aria-controls="offcanvasRight"><i class="fa fa-filter"
                                aria-hidden="true"></i>Filter</button>
                    </span>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                        aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasRightLabel" class="mb-0">Filter</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="item_filter_group">
                                <h4>Price (₹)</h4>
                                <fieldset class="filter-price">
                                    <div class="price-field">
                                        <input type="range" min="0" class="input-min common_selector" max="50000"
                                            value="0" id="mob_min_val">
                                        <input type="range" min="0" class="input-max common_selector" max="50000"
                                            value="50000" id="mob_max_val">
                                    </div>
                                    <div class="price-wrap">
                                        <div class="price-wrap-1">

                                            <input id="mob_one">
                                            <label for="one"></label>
                                        </div>
                                        <div class="price-wrap_line">-</div>

                                        <div class="price-wrap-2">

                                            <input id="mob_two">
                                            <label for="two"></label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="item_filter_group">
                                <h4>Sort By</h4>
                                <select class="common_selector orderby" aria-label="Default select example">
                                    <option value="0">Select Option</option>
                                    <option value="ASC">Order by A-Z</option>
                                    <option value="DESC">Order by Z-A</option>
                                </select>
                            </div>

                            <div class="item_filter_group">
                                <h4>Availabilty</h4>
                                <div class="de_form">
                                    <div class="de_checkbox">
                                        <input class="common_selector available" id="mobile_available"
                                            name="mobile_available" type="checkbox" value="1">
                                        <label for="mobile_available">Available</label>
                                    </div>

                                    <div class="de_checkbox">
                                        <input class="common_selector available" id="mobile_outofstock"
                                            name="mobile_outofstock" type="checkbox" value="0">
                                        <label for="mobile_outofstock">Out Of Stock</label>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- web view filter -->
                    <!-- <div class="col-lg-3 filter_lg">
                        <div class="item_filter_group">
                            <h4>Price (₹)</h4>
                            <fieldset class="filter-price">
                                <div class="price-field">
                                    <input type="range" min="0" class="input-min common_selector" max="50000" value="0"
                                        id="web_min_val">
                                    <input type="range" min="0" class="input-max common_selector" max="50000"
                                        value="50000" id="web_max_val">
                                </div>
                                <div class="price-wrap">
                                    <div class="price-wrap-1">
                                        <input id="web_one">
                                        <label for="one"></label>
                                    </div>
                                    <div class="price-wrap_line">-</div>
                                    <div class="price-wrap-2">
                                        <input id="web_two">
                                        <label for="two"></label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>


                        <div class="item_filter_group">
                            <h4>Sort By</h4>
                            <select class="common_selector orderby" aria-label="Default select example">
                                <option value="0">Select Option</option>
                                <option value="ASC">Order by A-Z</option>
                                <option value="DESC">Order by Z-A</option>
                            </select>
                        </div>

                        <div class="item_filter_group">
                            <h4>Availabilty</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input class="common_selector available" id="web_available" name="web_available"
                                        type="checkbox" value="1">
                                    <label for="web_available">Available</label>
                                </div>

                                <div class="de_checkbox">
                                    <input class="common_selector available" id="web_outofstock" name="web_outofstock"
                                        type="checkbox" value="0">
                                    <label for="web_outofstock">Out Of Stock</label>
                                </div>


                            </div>
                        </div>
                       
                    </div> -->

                    <div class="col-lg-12 px-5">
                        <div class="row  seach_results">

                            <?php if (count($product) <= 0) { ?>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 text-center newarrival_header">
                                            <h3 class="no-product">Currently, there are no products available!!!.</h3>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php for ($i = 0; $i < count($product); $i++) { ?>
                                    <div class="col-12 col-lg-3 productCard my-3">

                                        <div class="de-item">

                                            <!-- wishlist  start -->
                                            <a><span aria-hidden="true" class="icon_heart_alt wishlist-icon"
                                                    data-id="<?php echo $product[$i]['prod_id'] ?>"
                                                    tbl-name="<?php echo $product[$i]['tbl_name'] ?>"></span></a>
                                            <!-- wishlist end -->
                                            <div class="d-img">
                                                <?php
                                                $tbl_name = $product[$i]['tbl_name'];

                                                if ($tbl_name == "tbl_products") {
                                                    $url = base_url() . "detail/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                } else if ($tbl_name == "tbl_accessories_list") {
                                                    $url = base_url() . "accessories-detail/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                } else if ($tbl_name == "tbl_rproduct_list") {
                                                    $url = base_url() . "riding-details/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                } else if ($tbl_name == "tbl_helmet_products") {
                                                    $url = base_url() . "helmet-details/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                } else if ($tbl_name == "tbl_luggagee_products") {
                                                    $url = base_url() . "tour-detail/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                } else if ($tbl_name == "tbl_camping_products") {
                                                    $url = base_url() . "camp-details/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                }
                                                ?>

                                                <a href="<?php echo $url; ?>">
                                                    <img src="<?php echo base_url() ?>/<?php echo $product[$i]['product_img'] ?>"
                                                        alt="<?php echo $product[$i]['product_name'] ?>" />
                                                </a>
                                            </div>

                                            <?php
                                            $offerType = $product[$i]['offer'];
                                            $offerVal = $product[$i]['offer_details'];

                                            $offClass = ($offerType == 2 || ($offerType == 0 && $offerVal == 0)) ? 'd-none' : '';

                                            $offerDisp = ($offerType == 1)
                                                ? 'Flat Discount'
                                                : $offerVal . '%<span class="off_span">off</span>';

                                            if ($offerType == 2) {
                                                ?>
                                                <span class="offerrate-"></span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="discount-tag <?= $offClass ?>"><?= $offerDisp ?></span>
                                                <?php
                                            }
                                            ?>





                                            <div class="d-info">
                                                <div class="d-text">
                                                    <h4>
                                                        <?php echo $product[$i]['product_name'] ?>
                                                    </h4>
                                                    <?php
                                                    $MRP = $product[$i]['product_price'];
                                                    $RS = $product[$i]['prod_price'];

                                                    if ($MRP == $RS) {
                                                        $Classname = "d-none";
                                                    } else {
                                                        $Classname = "";
                                                    }
                                                    ?>
                                                    <span class="d-price">
                                                        ₹<?php echo number_format($product[$i]['prod_price']) ?>
                                                        <small class="<?= $Classname ?>"
                                                            style="text-decoration:line-through">₹<?php echo number_format($product[$i]['product_price']) ?></small>
                                                    </span>
                                                    <p class="d-flex wish-status my-2">
                                                        <span class="d-flex align-items-center">
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
                                                                href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $product[$i]['product_name'] . "\nProduct Price: " . $product[$i]['product_price']); ?>">Contact
                                                                us to order</a>
                                                        </div>

                                                    <?php } else { ?>

                                                        <div>
                                                            <?php
                                                            $tbl_name = $product[$i]['tbl_name'];

                                                            if ($tbl_name == "tbl_products") {
                                                                $url = base_url() . "detail/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                            } else if ($tbl_name == "tbl_accessories_list") {
                                                                $url = base_url() . "accessories-detail/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                            } else if ($tbl_name == "tbl_rproduct_list") {
                                                                $url = base_url() . "riding-details/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                            } else if ($tbl_name == "tbl_helmet_products") {
                                                                $url = base_url() . "helmet-details/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                            } else if ($tbl_name == "tbl_luggagee_products") {
                                                                $url = base_url() . "tour-detail/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                            } else if ($tbl_name == "tbl_camping_products") {
                                                                $url = base_url() . "camp-details/" . strtolower(str_replace(['/', ' '], '-', $product[$i]['redirect_url'])) . "/" . base64_encode($product[$i]['prod_id']);
                                                            }
                                                            ?>
                                                            <a class="btn-main buynow_btn" href="<?php echo $url; ?>">Buy Now</a>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- content close -->
        <?php
        require("components/footer.php");
        ?>

        <script>
            $(document).ready(function () {
                function filter_data() {
                    var width = $(window).width();
                    if (width <= 768) {
                        var minimum_price = $('#mob_min_val').val();
                        var maximum_price = $('#mob_max_val').val();
                    }
                    else {
                        var minimum_price = $('#web_min_val').val();
                        var maximum_price = $('#web_max_val').val();

                    }
                    var available = get_filter('available');
                    var brand = get_filter('brand');
                    var orderby = $('.orderby').val();

                    $.ajax({
                        url: base_Url + "brand-filter",
                        type: "POST",
                        dataType: "json",
                        data: {
                            minimum_price: minimum_price,
                            maximum_price: maximum_price,
                            available: available,
                            brand: brand,
                            orderby: orderby,


                        },
                        success: function (data) {
                            let count = data.length;
                            let searchResults = "";

                            if (count <= 0) {
                                searchResults += ` <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 text-center newarrival_header">
                                            <h3 class="no-product">Currently, there are no products available!!!.</h3>
                                        </div>
                                    </div>
                                </div>`;
                                $('.seach_results').html(searchResults);
                            }
                            else {
                                for (let i = 0; i < count; i++) {
                                    const product = data[i];
                                    const redirectUrl = product.redirect_url.toLowerCase().replace(/ /g, '-');
                                    const prodId = btoa(product.prod_id);  // Base64 encode product ID
                                    const formattedPrice = parseFloat(product.offer_price).toFixed(2);
                                    const stockStatus = product.stock_status == 0 ? 'Out of stock' : 'Available';

                                    searchResults += `
                    <div class="col-12 col-lg-4 productCard mb-4">
                    <form>
                        <a href="${base_Url}detail/${redirectUrl}/${prodId}">
                            <div class="de-item">

                             <a><span aria-hidden="true" class="icon_heart_alt wishlist-icon"
                                                            data-id="${product.prod_id}"
                                                            tbl-name="${product.tbl_name}"></span></a>
                                                    
                                <div class="d-img">
                                    <img src="${base_Url}${product.product_img}" alt="${product.product_name}"/>
                                </div>
                                <div class="d-info">
                                    <div class="d-text">
                                        <span class="d-price">
                                            ₹ ${formattedPrice}
                                        </span>
                                        <h4>${product.product_name}</h4>
                                        <p class="d-flex wish-status">
                                            <span class="d-flex align-items-center">
                                                <span class="product_status ${stockStatus == 'Out of stock' ? 'outof_stock' : ''}">
                                                    <label>${stockStatus}</label>
                                                </span>
                                            </span>
                                        </p>
                                        <div>
                                            <a class="btn-main buynow_btn" href="${base_Url}detail/${redirectUrl}/${prodId}">Buy Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                         </form>
                    </div>`;
                                }
                                $('.seach_results').html(searchResults);
                            }


                        }
                    });
                }

                function get_filter(class_name) {
                    var filter = [];
                    $('.' + class_name + ':checked').each(function () {
                        filter.push($(this).val());
                    });
                    return filter;
                }

                $('.common_selector').click(function () {
                    filter_data();
                });
            });

        </script>
</body>

</html>