<!DOCTYPE html>
<?php
require("components/head.php");
?>

<style>
    /* Pagination Container */
    .pagination-list {
        display: flex;
        list-style: none;
        justify-content: end;
        padding: 0;
        margin: 20px 0;
    }

    /* Pagination Items */
    .pagination-item {
        margin: 0 5px;
    }

    /* Pagination Links */
    .pagination-link,
    .pagination-link-default {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #a4c735;
        text-decoration: none;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    /* Hover State */
    .pagination-link:hover,
    .pagination-link-default:hover {
        background-color: #a4c735;
        color: #fff;
    }

    /* Active Page */
    .pagination-link.active,
    .pagination-link-default.active {
        background-color: #a4c735;
        color: #fff;
        border-color: #a4c735;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {

        /* Reduce padding and font size for smaller screens */
        .pagination-link,
        .pagination-link-default {
            padding: 5px 8px;
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {

        /* Show fewer pagination links on small screens */
        .pagination-list {
            overflow-x: auto;
            /* Allow horizontal scrolling */
            white-space: nowrap;
        }

        .pagination-item {
            display: inline-block;
        }
    }
</style>

<body id="products_page" class="dark-scheme">
    <?php
    require("components/header.php");
    ?>
    <!-- content begin -->

    <div class="no-bottom no-top zebra">

        <!-- section begin -->
        <section id="subheader" class="jarallax text-light">
            <img src="<?php echo base_url() ?>public/assets/images/background/tvs.jpg" class="jarallax-img" alt="">
            <div class="center-y relative text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>
                                Search Results!!
                            </h1>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- section close -->
        <section id="section-cars" class="products_wrapper">
            <div class="container">
                <!-- <div class="row">
                    <div class="col-lg-3">
                        <div class="item_filter_group">
                            <h4>Vehicle Type</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input id="vehicle_type_1" name="vehicle_type_1" type="checkbox"
                                        value="vehicle_type_1">
                                    <label for="vehicle_type_1">Car</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="vehicle_type_2" name="vehicle_type_2" type="checkbox"
                                        value="vehicle_type_2">
                                    <label for="vehicle_type_2">Van</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="vehicle_type_3" name="vehicle_type_3" type="checkbox"
                                        value="vehicle_type_3">
                                    <label for="vehicle_type_3">Minibus</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="vehicle_type_4" name="vehicle_type_4" type="checkbox"
                                        value="vehicle_type_4">
                                    <label for="vehicle_type_4">Prestige</label>
                                </div>

                            </div>
                        </div>

                        <div class="item_filter_group">
                            <h4>Car Body Type</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input id="car_body_type_1" name="car_body_type_1" type="checkbox"
                                        value="car_body_type_1">
                                    <label for="car_body_type_1">Convertible</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_2" name="car_body_type_2" type="checkbox"
                                        value="car_body_type_2">
                                    <label for="car_body_type_2">Coupe</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_3" name="car_body_type_3" type="checkbox"
                                        value="car_body_type_3">
                                    <label for="car_body_type_3">Exotic Cars</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_4" name="car_body_type_4" type="checkbox"
                                        value="car_body_type_4">
                                    <label for="car_body_type_4">Hatchback</label>
                                </div>
1
                                <div class="de_checkbox">
                                    <input id="car_body_type_5" name="car_body_type_5" type="checkbox"
                                        value="car_body_type_5">
                                    <label for="car_body_type_5">Minivan</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_6" name="car_body_type_6" type="checkbox"
                                        value="car_body_type_6">
                                    <label for="car_body_type_6">Truck</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_7" name="car_body_type_7" type="checkbox"
                                        value="car_body_type_7">
                                    <label for="car_body_type_7">Sedan</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_8" name="car_body_type_8" type="checkbox"
                                        value="car_body_type_8">
                                    <label for="car_body_type_8">Sports Car</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_9" name="car_body_type_9" type="checkbox"
                                        value="car_body_type_9">
                                    <label for="car_body_type_9">Station Wagon</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_body_type_10" name="car_body_type_10" type="checkbox"
                                        value="car_body_type_10">
                                    <label for="car_body_type_10">SUV</label>
                                </div>

                            </div>
                        </div>

                        <div class="item_filter_group">
                            <h4>Car Seats</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input id="car_seat_1" name="car_seat_1" type="checkbox" value="car_seat_1">
                                    <label for="car_seat_1">2 seats</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_seat_2" name="car_seat_2" type="checkbox" value="car_seat_2">
                                    <label for="car_seat_2">4 seats</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_seat_3" name="car_seat_3" type="checkbox" value="car_seat_3">
                                    <label for="car_seat_3">6 seats</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_seat_4" name="car_seat_4" type="checkbox" value="car_seat_4">
                                    <label for="car_seat_4">6+ seats</label>
                                </div>

                            </div>
                        </div>

                        <div class="item_filter_group">
                            <h4>Car Engine Capacity (cc)</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input id="car_engine_1" name="car_engine_1" type="checkbox" value="car_engine_1">
                                    <label for="car_engine_1">1000 - 2000</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_engine_2" name="car_engine_2" type="checkbox" value="car_engine_2">
                                    <label for="car_engine_2">2000 - 4000</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_engine_3" name="car_engine_3" type="checkbox" value="car_engine_3">
                                    <label for="car_engine_3">4000 - 6000</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="car_engine_4" name="car_engine_4" type="checkbox" value="car_engine_4">
                                    <label for="car_engine_4">6000+</label>
                                </div>

                            </div>
                        </div>

                        <div class="item_filter_group">
                            <h4>Price ($)</h4>
                            <div class="price-input">
                                <div class="field">
                                    <span>Min</span>
                                    <input type="number" class="input-min" value="0">
                                </div>
                                <div class="field">
                                    <span>Max</span>
                                    <input type="number" class="input-max" value="2000">
                                </div>
                            </div>
                            <div class="slider">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input type="range" class="range-min" min="0" max="2000" value="0" step="1">
                                <input type="range" class="range-max" min="0" max="2000" value="2000" step="1">
                            </div>
                        </div>
                    </div>

                    
                </div> -->



                <div class="col-lg-12">
                    <div class="row seach_results">
                        <?php for ($i = 0; $i < count($search_data); $i++) { ?>
                            <div class="col-12 col-lg-3  productCard mb-4">

                                <?php
                                $tbl_name = $search_data[$i]['tbl_name'];
                                if ($tbl_name == "tbl_products") {
                                    $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                } else if ($tbl_name == "tbl_accessories_list") {
                                    $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                } else if ($tbl_name == "tbl_rproduct_list") {
                                    $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                } else if ($tbl_name == "tbl_helmet_products") {
                                    $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                } else if ($tbl_name == "tbl_luggagee_products") {
                                    $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                } else if ($tbl_name == "tbl_camping_products") {
                                    $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                }
                                ?>
                                <a href="<?php echo $url ?>">
                                    <div class="de-item">
                                        <?php
                                        $offer = $search_data[$i]['offer_details'];
                                        if ($offer == 1 || $offer == 2 || $offer == "" || $offer == 0 || $offer == "-") {
                                            $offerClass = "d-none";
                                        } else {
                                            $offerClass = "";

                                        } ?>

                                        <span class="offer  <?= $offerClass ?>">
                                            <?= $search_data[$i]['offer_details'] ?>%
                                        </span>
                                        <div class="d-img">
                                            <img
                                                src="<?php echo base_url() ?>/<?php echo $search_data[$i]['product_img'] ?>" />
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4>
                                                    <?php echo $search_data[$i]['product_name'] ?>
                                                </h4>
                                                <?php
                                                $MRP = $search_data[$i]['product_price'];
                                                $RS = $search_data[$i]['offer_price'];

                                                if ($MRP == $RS) {
                                                    $Classname = "d-none";
                                                } else {
                                                    $Classname = "";
                                                }
                                                ?>
                                                <span class="d-price">
                                                    ₹<?php echo number_format($search_data[$i]['offer_price'], 2) ?>
                                                    <small class="<?= $Classname ?>"
                                                        style="text-decoration:line-through">₹<?php echo number_format($search_data[$i]['product_price'], 2) ?></small>
                                                </span>
                                                <p class="d-flex wish-status my-2">
                                                    <span class="d-flex align-items-center">
                                                        <?php
                                                        $stock = $search_data[$i]['quantity'];
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
                                                $stock = $search_data[$i]['quantity'];
                                                if ($stock <= 0) { ?>

                                                    <div>
                                                        <a class="btn-main buynow_btn"
                                                            href="https://wa.me/7358992528?text=<?php echo urlencode("Product Information!\nProduct Name: " . $product[$i]['product_name'] . "\nProduct Price: " . $product[$i]['product_price']); ?>">Contact
                                                            us to order</a>
                                                    </div>

                                                <?php } else { ?>

                                                    <div>

                                                        <?php
                                                        $tbl_name = $search_data[$i]['tbl_name'];

                                                        if ($tbl_name == "tbl_products") {
                                                            $url = base_url() . "detail/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                                        } else if ($tbl_name == "tbl_accessories_list") {
                                                            $url = base_url() . "accessories-detail/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                                        } else if ($tbl_name == "tbl_rproduct_list") {
                                                            $url = base_url() . "riding-details/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                                        } else if ($tbl_name == "tbl_helmet_products") {
                                                            $url = base_url() . "helmet-details/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                                        } else if ($tbl_name == "tbl_luggagee_products") {
                                                            $url = base_url() . "tour-detail/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                                        } else if ($tbl_name == "tbl_camping_products") {
                                                            $url = base_url() . "camp-details/" . strtolower(str_replace(' ', '-', $search_data[$i]['redirect_url'])) . "/" . base64_encode($search_data[$i]['prod_id']);
                                                        }
                                                        ?>
                                                        <a class="btn-main buynow_btn" href="<?php echo $url ?>">Buy Now</a>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>

                        <input type="hidden" id="total_page" value="<?= $total_page ?>">
                        <div class="col-lg-12">
                            <div class="pagination-container" id="pagination-container">

                            </div>
                        </div>



                        <div class="col-lg-12">
                            <input type="hidden" id="sub_id" data-search="<?= $search_value ?>">
                            <?php
                            $pagination_Class = ($total_products <= 12) ? "d-none" : "";

                            ?>
                            <div class="pagination-container-default <?php echo $pagination_Class ?>"
                                id="pagination-container-default">
                                <ul class="pagination-list">
                                    <?php for ($i = 0; $i < count($pagination); $i++) { ?>
                                        <?php
                                        if ($pagination[$i]['active'] == 1) {
                                            $current_page = $pagination[$i]['page'];
                                        }
                                        ?>
                                        <li class="pagination-item">
                                            <a href="#"
                                                class="pagination-link-default <?php echo ($pagination[$i]['page'] == $current_page ? 'active' : '') ?>"
                                                data-page="<?php echo $pagination[$i]['page'] ?>"
                                                data-search="<?= $search_value ?>">
                                                <?php echo $pagination[$i]['label'] ?>
                                            </a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
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
            function productDetailsPage(page, search_data) {

                $.ajax({
                    method: 'POST',
                    url: base_Url + 'loadmore-searchdata',
                    data: { page: page, search_data: search_data },
                    dataType: 'json',
                    contentType: 'application/x-www-form-urlencoded',
                    success: function (data) {
                        let count = data.products.length;
                        let searchResults = "";

                        if (count <= 0) {
                            searchResults += `
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center newarrival_header">
                                    <h3 class="no-product">Currently, there are no products available!!!</h3>
                                </div>
                            </div>
                        </div>`;
                            $('.seach_results').html(searchResults);
                            $('#pagination-container-default').addClass('d-none');
                        } else {

                            // INR formatter
                            const formatter = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'INR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });

                            for (let i = 0; i < count; i++) {
                                const product = data.products[i];
                                const redirectUrl = product.redirect_url.toLowerCase().replace(/[/ ]/g, '-');
                                const prodId = btoa(product.prod_id);
                                const formattedPrice = formatter.format(product.offer_price);
                                const stockStatus = product.quantity == 0 ? 'Out of stock' : 'Available';
                                const MRPPrice = product.product_price;
                                const formatMRP = formatter.format(MRPPrice);
                                const offerPrice = product.offer_price;
                                const formatOffer = formatter.format(offerPrice);
                                let stock = product.quantity;

                                let offerDetails = product.offer_details;
                                let offerClass = (offerDetails == 1 || offerDetails == 2 || offerDetails == "" || offerDetails == 0 || offerDetails == "-") ? "d-none" : "";

                                let priceClassname = (MRPPrice == offerPrice) ? 'd-none' : '';

                                let tblName = product.tbl_name;
                                let url = '';
                                if (tblName) {
                                    if (tblName === "tbl_products") {
                                        url = base_Url + "detail/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                    } else if (tblName === "tbl_accessories_list") {
                                        url = base_Url + "accessories-detail/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                    } else if (tblName === "tbl_rproduct_list") {
                                        url = base_Url + "riding-details/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                    } else if (tblName === "tbl_helmet_products") {
                                        url = base_Url + "helmet-details/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                    } else if (tblName === "tbl_luggagee_products") {
                                        url = base_Url + "tour-detail/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                    } else if (tblName === "tbl_camping_products") {
                                        url = base_Url + "camp-details/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                    }
                                }
                                //redirect url end
                                let buyNow = "";
                                if (stock <= 0) {
                                    buyNow += `
                                                <div>
                                                    <a class="btn-main buynow_btn"
                                                        href="https://wa.me/7358992528?text=${encodeURIComponent("Welcome to Adventure Shoppe!\nProduct Name: " + product.product_name + "\nProduct Price: " + product.offer_price)}">
                                                        Contact us to order
                                                    </a>
                                                </div>
                                            `;
                                }
                                else {
                                    buyNow += `
                                                <div>
                                                    <a class="btn-main buynow_btn"
                                                        href="${url}">
                                                        Buy Now
                                                    </a>
                                                </div>
                                            `;
                                }


                                searchResults += `
                                    <div class="col-12 col-lg-3 productCard mb-4">
                                        <form>
                                            <div class="de-item">                                            
                                                <span class="offer ${offerClass}">${offerDetails}%</span>
                                                <a><span aria-hidden="true" class="icon_heart_alt wishlist-icon" data-id="${product.prod_id}" tbl-name="${product.tbl_name}"></span></a>
                                                <div class="d-img">
                                                    <a href="${url}">
                                                        <img src="${base_Url}${product.product_img}" />
                                                    </a>
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h4>${product.product_name}</h4>
                                                        <span class="d-price">
                                                            ${formatOffer}
                                                            <small class="${priceClassname}" style="text-decoration:line-through">${formatMRP}</small>
                                                        </span>
                                                        <p class="d-flex wish-status my-2">
                                                            <span class="d-flex align-items-center">
                                                                <span class="product_status ${stockStatus == 'Out of stock' ? 'outof_stock' : ''}">
                                                                    <label>${stockStatus}</label>
                                                                </span>
                                                            </span>
                                                        </p>
                                                        ${buyNow}
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>`;
                            }
                            searchResults += '<div class="pagination-container-default " id="pagination-container-default" style="background-size: 100%; background-repeat: no-repeat;"></div>'
                            $('.seach_results').html(searchResults);


                            // Render pagination if more than 12 products exist
                            if (data.products.length >= 12) {
                                renderPaginationView(data, page);
                            }
                            else if (data.products.length <= 12 && page != 1) {
                                renderPaginationView(data, page);
                            }
                            else {
                                $('#pagination-link-default').html("");
                            }


                            // Add to wishlist event handler
                            $(".wishlist-icon").on('click', function () {
                                let prod_id = $(this).data("id");
                                let tbl_name = $(this).attr('tbl-name');
                                $.ajax({
                                    type: "POST",
                                    url: base_Url + "add-wishlist",
                                    data: { prod_id: prod_id, tbl_name: tbl_name },
                                    success: function (response) {
                                        let res = $.parseJSON(response);
                                        if (res.code == 200) {
                                            $.toast({
                                                icon: "success",
                                                heading: "Success",
                                                text: res.msg,
                                                position: "top-right",
                                                bgColor: "#28292d",
                                                loader: true,
                                                hideAfter: 2000,
                                                stack: false,
                                                showHideTransition: "fade",
                                            });
                                            setTimeout(function () {
                                                location.reload();
                                            }, 1000);
                                        } else {
                                            $.toast({
                                                icon: "error",
                                                heading: "Warning",
                                                text: res.msg,
                                                position: "top-right",
                                                bgColor: "#res",
                                                loader: true,
                                                hideAfter: 2000,
                                                stack: false,
                                                showHideTransition: "fade",
                                            });
                                        }
                                    },
                                });
                            });
                        }
                    }
                });
            }

            // Click event for pagination links
            $(".pagination-link-default").on('click', function (e) {
                e.preventDefault();
                $(".pagination-container").addClass('d-none');
                let page = $(this).data("page");
                let search_data = $(this).data("search");
                productDetailsPage(page, search_data);
            });

            // Function to render pagination
            function renderPaginationView(data, currentPage) {
                let searchvalue = data.search_data;

                let paginationUI = '<ul class="pagination-list">';
                data.pagination.forEach(function (pageLink) {
                    paginationUI += `
                        <li class="pagination-item">
                            <a href="#" class="pagination-link-default ${pageLink.page == currentPage ? 'active' : ''}" data-page="${pageLink.page}">
                                ${pageLink.label} 
                            </a>
                        </li>`;
                });
                paginationUI += '</ul>';

                $('#pagination-container-default').removeClass("d-none");
                $('#pagination-container-default').html(paginationUI);

                $(".pagination-link-default").on('click', function (e) {
                    console.log(e);
                    $(".pagination-container").addClass('d-none');
                    e.preventDefault();
                    let page = $(this).data("page");
                    let search_data = searchvalue;

                    productDetailsPage(page, search_data);
                });
            }
        </script>
</body>

</html>