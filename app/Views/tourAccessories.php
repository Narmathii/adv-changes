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



    .btn_view_all {
        display: flex;
        position: relative;
        justify-content: center;
        padding: 0px 33px;
        margin-left: 1%;
    }

    .view-more {
        width: 25%;
        border: solid 2px #a4c735 !important;
        border-radius: 5px;
        color: #000;
        justify-content: center;
    }

    @media only screen and (max-width: 768px) {
        .view-more {
            width: 35% !important;

        }
    }

    /* Filter Styles */

    .min-max {
        padding: 5px;
    }

    .filter-price {
        background-color: #eee !important;
        padding: 12px !important;
        border-radius: 10px !important;
        width: 100%;
    }

    #products_page .filter-price .price-field {
        width: 100%;
        padding-left: 0 !important;
        left: 0 !important;
    }

    #products_page .filter-price .price-field input[type="range"] {
        width: 100% !important;
        margin-left: 0 !important;
        left: 0;
    }

    #products_page .filter-price .price-wrap {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    #products_page .filter-price .price-value-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #products_page .filter-price .price-wrap-1,
    #products_page .filter-price .price-wrap-2 {
        display: flex;
        align-items: center;
    }

    #products_page .filter-price .price-wrap input {
        width: 76px;
        text-align: center;
    }

    .orderby,
    .discount,
    .orderby_web,
    .orderby_mob,
    .discount_mob {

        width: 100%;
        padding: 1.5%;
        color: #000;
        border-radius: 10px;
    }

    .orderby>option,
    .discount>option,
    .orderby_web>option,
    .orderby_mob>option,
    .discount_mob>option {
        color: #000 !important
    }
</style>

<body id='products_page' class="dark-scheme">
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
                                <?php echo $tour_access[0]['lug_submenu'] ?>
                            </h1>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            
        </section> -->
        <!-- section close -->
        <section id="section-cars" class="products_wrapper px-3">
            <div class="container access_list_grid">
                <div class="row">
                    <h2 class="text-center mb-4">
                        <?php echo strtoupper($tour_access[0]['lug_submenu']) ?>
                    </h2>
                    <!-- mobile view filter -->
                    <span class="filter_sm d-lg-none">
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
                                    <div class="price-field mobile-view">
                                        <input type="range" min="0" class="input-min common_selector" max="50000"
                                            value="0" id="mob_min_val">
                                        <input type="range" min="0" class="input-max common_selector" max="50000"
                                            value="50000" id="mob_max_val">
                                    </div>
                                     <div class="price-wrap">
                                        <div class="price-value-group">
                                            <span class="min-max">Min</span>
                                            <div class="price-wrap-1">
                                                <input id="mob_one">
                                                <label for="one"></label>
                                            </div>
                                        </div>
                                        <div class="price-value-group">
                                            <span class="min-max">Max</span>
                                            <div class="price-wrap-2">
                                                <input id="mob_two">
                                                <label for="two"></label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                            </div>

                            <div class="item_filter_group">
                                <h4>Sort By</h4>
                                <select class="common_selector orderby_mob" aria-label="Default select example">
                                    <option value="0">Select Option</option>
                                    <option value="ASC">Order by A-Z</option>
                                    <option value="DESC">Order by Z-A</option>
                                    <option value="LOW">Low to High</option>
                                    <option value="HIGH">High to Low</option>
                                </select>
                            </div>


                            <div class="item_filter_group">
                                <h4>Discount</h4>
                                <select class="common_selector discount_mob" aria-label="Default select example">
                                    <option value="0">Select Discount</option>
                                    <option value="10">10% or more</option>
                                    <option value="20">20% or more</option>
                                    <option value="30">30% or more</option>
                                    <option value="40">40% or more</option>
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
                            <div class="item_filter_group">
                                <h4>Brands</h4>
                                <div class="de_form">
                                    <?php for ($i = 0; $i < count($search_brand); $i++) { ?>
                                        <div class="de_checkbox">
                                            <input class="common_selector brand" id="mob_search_brand_<?php echo $i ?>"
                                                name="brand[]" type="checkbox"
                                                value="<?php echo $search_brand[$i]['search_brand'] ?>">
                                            <label
                                                for="mob_search_brand_<?php echo $i ?>"><?php echo $search_brand[$i]['brand_name'] ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <input type="hidden" class="common_selector submenuid"
                                value="<?php echo $tour_access[0]['lug_submenu_id'] ?>" />
                        </div>
                    </div>




                    <!-- web view filter -->
                    <div class="col-lg-3 filter_lg">
                        <h5 id="web_filter" class="mb-0">Filter</h5>
                        <div class="item_filter_group">
                            <h4>Price (₹)</h4>
                            <fieldset class="filter-price">
                                <div class="price-field web-view">
                                    <input type="range" min="0" class="input-min common_selector" max="50000" value="0"
                                        id="web_min_val">
                                    <input type="range" min="0" class="input-max common_selector" max="50000"
                                        value="50000" id="web_max_val">
                                </div>
                                <div class="price-wrap">
                                    <div class="price-value-group">
                                        <span class="min-max">Min</span>
                                        <div class="price-wrap-1">
                                            <input id="web_one">
                                            <label for="one"></label>
                                        </div>
                                    </div>
                                    <div class="price-value-group">
                                        <span class="min-max">Max</span>
                                        <div class="price-wrap-2">
                                            <input id="web_two">
                                            <label for="two"></label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>


                        <div class="item_filter_group">
                            <h4>Sort By</h4>
                            <select class="common_selector orderby_web" aria-label="Default select example">
                                <option value="0">Select Option</option>
                                <option value="ASC">Order by A-Z</option>
                                <option value="DESC">Order by Z-A</option>
                                <option value="LOW">Low to High</option>
                                <option value="HIGH">High to Low</option>
                            </select>
                        </div>

                        <div class="item_filter_group">
                            <h4>Discount</h4>
                            <select class="common_selector discount" aria-label="Default select example">
                                <option value="0">Select Discount</option>
                                <option value="10">10% or more</option>
                                <option value="20">20% or more</option>
                                <option value="30">30% or more</option>
                                <option value="40">40% or more</option>
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
                        <div class="item_filter_group">
                            <h4>Brands</h4>
                            <div class="de_form">
                                <?php for ($i = 0; $i < count($search_brand); $i++) { ?>
                                    <div class="de_checkbox">
                                        <input class="common_selector brand" id="web_search_brand_<?php echo $i ?>"
                                            name="brand[]" type="checkbox"
                                            value="<?php echo $search_brand[$i]['search_brand'] ?>">
                                        <label
                                            for="web_search_brand_<?php echo $i ?>"><?php echo $search_brand[$i]['brand_name'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <input type="hidden" class="common_selector submenuid"
                            value="<?php echo $tour_access[0]['lug_submenu_id'] ?>" />
                    </div>


                    <div class="col-lg-9">
                        <div class="row seach_results">

                            <!-- Dynamic Data -->
                        </div>
                    </div>

                    <input type="hidden" id="total_page" value="<?= $total_page ?>">
                    <div class="col-lg-12">
                        <div class="pagination-container" id="pagination-container">

                        </div>
                    </div>

                    <input type="hidden" value="<?= $segment ?>" data-segment="<?= $segment ?>" id="dataSegment">
                    <input type="hidden" id="sub_id" value="<?= $sub_id ?>">
                    <div class="col-lg-12">


                        <?php
                        $pagination_Class = ($total_products <= 12) ? "d-none" : "";

                        ?>
                        <div class="pagination-container-default <?php echo $pagination_Class ?>"
                            id="pagination-container-default">
                            <ul class="pagination-list ">
                                <?php for ($i = 0; $i < count($pagination); $i++) { ?>
                                    <?php
                                    if ($pagination[$i]['active'] == 1) {
                                        $current_page = $pagination[$i]['page'];
                                    }
                                    ?>
                                    <li class="pagination-item">
                                        <a href="#"
                                            class="pagination-link-default <?php echo ($pagination[$i]['page'] == $current_page ? 'active' : '') ?>"
                                            data-page="<?php echo $pagination[$i]['page'] ?>" data-subid="<?= $sub_id ?>">
                                            <?php echo $pagination[$i]['label'] ?>
                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
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
                if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
                    history.replaceState(null, '', window.location.pathname);
                }

                const page = setFiltersFromURL();
                filter_data(page);

                $('.common_selector').click(function () {
                    filter_data(1);
                });

                $('.common_selector').change(function () {
                    filter_data(1);
                });


                function scrollToTop() {
                    const target = $(".seach_results");
                    if (target.length > 0) {
                        $('html, body').stop().animate({
                            scrollTop: target.offset().top - 250
                        }, 500, 'swing');
                    }
                }


                function get_filter(class_name) {
                    const values = new Set();
                    $('.' + class_name + ':checked').each(function () {
                        values.add($(this).val());
                    });
                    return Array.from(values);
                }

                // --- Update URL with filters and page ---
                function updateURLWithFilters(page = 1) {
                    const newParams = new URLSearchParams();

                    const available = get_filter('available');
                    const brand = get_filter('brand');
                    const discount = $('.discount').val();
                    const orderby_web = $('.orderby_web').val();
                    const orderby_mob = $('.orderby_mob').val();
                    const discount_mob = $('.discount_mob').val();


                    available.forEach(val => {
                        if (!newParams.getAll('available[]').includes(val)) {
                            newParams.append('available[]', val);
                        }
                    });
                    brand.forEach(val => {
                        if (!newParams.getAll('brand[]').includes(val)) {
                            newParams.append('brand[]', val);
                        }
                    });
                    if (discount) newParams.set('discount', discount);
                    if (orderby_web) newParams.set('orderby_web', orderby_web);

                    if (discount_mob) newParams.set('discount_mob', discount_mob);
                    if (orderby_mob) newParams.set('orderby_mob', orderby_mob);
                    newParams.set('page', page);


                    const currentParams = new URLSearchParams(window.location.search);
                    let shouldUpdate = false;


                    const keys = ['available[]', 'brand[]', 'discount', 'orderby_web', 'discount_mob', 'orderby_mob', 'page'];

                    for (let key of keys) {
                        const currentVals = [...new Set(currentParams.getAll(key))].sort();
                        const newVals = [...new Set(newParams.getAll(key))].sort();

                        if (currentVals.length !== newVals.length ||
                            currentVals.some((val, i) => val !== newVals[i])) {
                            shouldUpdate = true;
                            break;
                        }
                    }


                    if (shouldUpdate) {
                        const newURL = `${window.location.pathname}?${newParams.toString()}`;
                        history.pushState(null, '', newURL);
                        filter_data(page);
                    }
                }


                // --- Set filters and page number from URL ---
                function setFiltersFromURL() {
                    const params = new URLSearchParams(window.location.search);
                    const page = parseInt(params.get('page')) || 1;

                    // Available filter checkboxes
                    const available = params.getAll('available[]');
                    $('.common_selector[name="available[]"]').each(function () {
                        $(this).prop('checked', available.includes($(this).val()));
                    });

                    // Brand filter checkboxes
                    const brand = params.getAll('brand[]');
                    $('.common_selector[name="brand[]"]').each(function () {
                        $(this).prop('checked', brand.includes($(this).val()));
                    });

                    // Dropdown values
                    $('.discount').val(params.get('discount') || '');
                    $('.orderby_web').val(params.get('orderby_web') || '');

                    $('.discount_mob').val(params.get('discount_mob') || '');
                    $('.orderby_mob').val(params.get('orderby_mob') || '');


                    return page;
                }

                // --- Filter and Load Products ---
                function filter_data(page = 1) {
                    updateURLWithFilters(page);

                    const width = $(window).width();
                    let minimum_price, maximum_price;

                    if (width <= 768) {
                        minimum_price = $('#mob_min_val').val();
                        maximum_price = $('#mob_max_val').val();
                    } else {
                        minimum_price = $('#web_min_val').val();
                        maximum_price = $('#web_max_val').val();
                    }

                    const available = get_filter('available');
                    const brand = get_filter('brand');
                    const orderby_web = $('.orderby_web').val();
                    const orderby_mob = $('.orderby_mob').val();
                    const discount = $('.discount').val();
                    const discount_mob = $('.discount_mob').val();
                    const tablename = 'tbl_luggagee_products';
                    const submenu_id = $('#sub_id').val();
                    const action = 'fetch_data';

                    console.log(submenu_id);
                    $.ajax({
                        url: `${base_Url}prod-filter/${page}`,
                        type: "POST",
                        dataType: "json",
                        data: {
                            minimum_price,
                            maximum_price,
                            available,
                            brand,
                            orderby_web,
                            tablename,
                            submenu_id,
                            discount,
                            orderby_mob,
                            discount_mob,
                            action
                        },
                        success: function (data) {
                            const count = data.products.length;
                            const totalPages = data.pagination.length;
                            let searchResults = "";

                            if (count <= 0) {
                                searchResults = `
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 text-center newarrival_header">
                                        <h3 class="no-product">Currently, there are no products available!!!</h3>
                                    </div>
                                </div>
                            </div>`;
                                $('.seach_results').html(searchResults);
                                scrollToTop();
                                $('#pagination-container').addClass('d-none');
                            } else {
                                const formatter = new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'INR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });

                                data.products.forEach(product => {
                                    const redirectUrl = product.redirect_url.toLowerCase().replace(/[/ ]/g, '-');
                                    const prodId = btoa(product.prod_id);
                                    const formatOffer = formatter.format(product.offer_price);
                                    const formatMRP = formatter.format(product.product_price);
                                    const stockStatus = product.quantity <= 0 ? 'Out of stock' : 'Available';
                                    const offerTypeDetail = product.offer_type;

                                    // const offerClass = (product.offer_details == 1 || product.offer_details == 2 || product.offer_details == "" || product.offer_details == 0 || product.offer_details == "-") ? "d-none" : (offerTypeDetail == '1' ? "" : "d-none");
                                    const offerClass = (offerTypeDetail == 2 || (offerTypeDetail == 0 && product.offer_details == 0)) ? "d-none" : "";

                                    const piceClassname = (product.product_price === product.offer_price) ? 'd-none' : '';

                                    const offerDisp = product.offer_type == 1 ? 'Flat Discount' : product.offer_details + '%<span class="off_span">off</span>';

                                    let buyNow = (product.quantity <= 0) ? `
                                <div>
                                    <a class="btn-main buynow_btn"
                                        href="https://wa.me/7358992528?text=${encodeURIComponent("Welcome to Adventure Shoppe!\nProduct Name: " + product.product_name + "\nProduct Price: " + product.product_price)}">
                                        Contact us to order
                                    </a>
                                </div>` : `
                                <div>
                                    <a class="btn-main buynow_btn"
                                        href="${base_Url}tour-detail/${redirectUrl}/${prodId}">
                                        Buy Now
                                    </a>
                                </div>`;

                                    searchResults += `
                                <div class="col-12 col-lg-3 productCard my-4">
                                    <form>
                                        <div class="de-item">
                                            <span class="discount-tag ${offerClass}">${offerDisp}</span>
                                            <a><span aria-hidden="true" class="icon_heart_alt wishlist-icon"
                                                data-id="${product.prod_id}" tbl-name="${product.tbl_name}"></span></a>
                                            <div class="d-img">
                                                <a href="${base_Url}tour-detail/${redirectUrl}/${prodId}">
                                                    <img src="${base_Url}${product.product_img}" alt="${product.product_name}" />
                                                </a>
                                            </div>
                                            <div class="d-info">
                                                <div class="d-text">
                                                    <h4>${product.product_name}</h4>
                                                    <span class="d-price">${formatOffer}
                                                        <small class="${piceClassname}" style="text-decoration:line-through">${formatMRP}</small>
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
                                });

                                $('.seach_results').html(searchResults);
                                scrollToTop();
                                $('#pagination-container-default').html("");


                                if (count >= 12 || (totalPages === 1 && count > 12) || (totalPages > 1 && count <= 12)) {
                                    renderPagination(data, page);
                                } else {
                                    $('#pagination-container').html("");
                                }

                                $(".wishlist-icon").on('click', function () {
                                    let prod_id = $(this).data("id");
                                    let tbl_name = $(this).attr('tbl-name');

                                    $.ajax({
                                        type: "POST",
                                        url: `${base_Url}add-wishlist`,
                                        data: { prod_id, tbl_name },
                                        success: function (data) {
                                            let res = $.parseJSON(data);
                                            if (res.code === 200) {
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
                                                    bgColor: "#f00",
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

                // --- Render Pagination UI ---
                function renderPagination(data, currentPage) {

                    let paginationUI = '<ul class="pagination-list">';
                    data.pagination.forEach(function (pageLink) {
                        paginationUI += `
                    <li class="pagination-item">
                        <a href="#" class="pagination-link ${pageLink.page === currentPage ? 'active' : ''}" data-page="${pageLink.page}">
                            ${pageLink.label}
                        </a>
                    </li>`;
                    });
                    paginationUI += '</ul>';

                    $("#pagination-container").removeClass('d-none');
                    $('#pagination-container').html(paginationUI);
                    $('#pagination-container-default').html("");

                    $(".pagination-link").on('click', function (e) {
                        e.preventDefault();
                        const page = $(this).data("page");
                        filter_data(page);
                    });
                }

                // Handle browser back / forward navigation
                // window.onpopstate = function () {

                //     const page = setFiltersFromURL();
                //     console.log("back");
                //     console.log(page);
                //     filter_data(page);
                // };

            });


        </script>

</body>

</html>