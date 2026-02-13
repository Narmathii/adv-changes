<footer class="text-light">
    <div class="container mw-100 m-0" style=" padding-bottom: 50px;">
        <div class="row g-custom-x justify-content-center">

            <div class="col-lg-2 footersm">
                <a href="<?php echo base_url() ?>">
                    <img src="<?php echo base_url() ?>public/assets/images/logo-whiteBorder.png" class="jarallax-img"
                        alt="" width="150">
                </a>
            </div>

            <div class="col-lg-2">
                <div class="widget p-sm-0">
                    <h5 class="text-center">About</h5>
                    <p class="text-about-responsive">We provide the best camping, riding and motorcycle accessories in
                        Coimbatore. Retail store & Wholesale.</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="widget p-sm-0">
                    <h5 class="text-center">Contact Info</h5>

                    <address class="s1">
                        <span style="cursor: default;">
                            <i class="id-color fa fa-map-marker fa-lg"></i><span class="footer_address">Old no 44A, new
                                no 69A, G.K.D.Nagar third Street, Pappanaickenpalayam, Coimbatore - 641037, Tamil Nadu ,
                                India
                            </span>
                        </span>

                        <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                            <span class="m-0" style="cursor: default;">
                                <i class="id-color fa fa-phone fa-lg"></i>+91-7358992528
                            </span>

                            <span class="mx-1 separator-pipe">|</span>

                            <span class="m-0">
                                <i class="id-color fa fa-envelope-o fa-lg"></i>
                                <a href="mailto:abhishek@adventureshoppe.com">abhishek@adventureshoppe.com</a>
                            </span>
                        </div>
                    </address>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="widget p-sm-0">
                    <h5 class="text-center">Information</h5>
                    <ul class="list-unstyled text-center" style="line-height: 2.2em;">
                        <li><a href="<?php echo base_url() ?>terms-conditions">Terms &amp; Conditions</a></li>
                        <li><a href="<?php echo base_url() ?>privacy-policy">Privacy Policy</a></li>
                        <li><a href="<?php echo base_url() ?>contact-us">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="widget m-0 p-sm-0">
                    <h5 class="text-center">Social Network</h5>
                    <div class="socialmedia_links">
                        <a href="https://www.instagram.com/ridersranchcoimbatore/" target="_blank"><i
                                class="fa fa-instagram"></i></a>
                        <a href="https://www.facebook.com/share/1AdUYKNcPB/" target="_blank"><i
                                class="fa fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/@adventureshoppe3772" target="_blank">
                            <img src="<?php echo base_url() ?>public/assets/images/icons/youtube.svg" alt="Youtube">
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="subfooter">
        <div class="container mw-100 m-0 px-5">
            <div class="row align-items-center">

                <div class="col-md-6 text-copy-left mb-2 mb-md-0">
                    <span>Copyright © <span id="current-year"></span> AdventureShoppe All rights reserved</span>
                </div>

                <div class="col-md-6 text-copy-right">
                    <span>Designed and Developed by <a href="https://www.appteq.in/" target="_blank"
                            class="dev-link">Appteq Technology Solutions</a></span>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* =========================================
       CUSTOM RESPONSIVE STYLES
       ========================================= */

        .text-about-responsive {
            text-align: center;
        }

        .separator-pipe {
            display: none !important;
        }

        .text-copy-left {
            text-align: center;
        }

        .text-copy-right {
            text-align: center;
        }


        @media (min-width: 992px) {

            .text-about-responsive {
                text-align: left !important;
            }

            .separator-pipe {
                display: inline !important;
            }

            .text-copy-left {
                text-align: left !important;
            }

            .text-copy-right {
                text-align: right !important;
            }
        }


        /* =========================================
       GENERAL STYLES
       ========================================= */
        .subfooter {
            font-size: 13px !important;
            padding: 15px 0;
        }

        .dev-link {
            text-decoration: none !important;
            color: inherit !important;
            font-weight: bold;
        }

        .dev-link:hover {
            color: #829b2f !important;
        }

        .widget address div span {

            margin-bottom: 0 !important;
        }

        .socialmedia_links {
            display: flex !important;
            justify-content: center !important;
            gap: 15px !important;
            margin-top: 15px !important;
            text-align: center !important;
        }

        .socialmedia_links a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 45px !important;
            height: 45px !important;
            background: #ffffff !important;
            border-radius: 50% !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            position: relative !important;
            overflow: hidden !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .socialmedia_links a::before,
        .socialmedia_links a::after,
        .socialmedia_links a span {
            display: none !important;
            background: transparent !important;
            content: none !important;
        }

        .socialmedia_links a i {
            color: #000000 !important;
            font-size: 20px !important;
            background: transparent !important;
            position: relative !important;
            z-index: 2 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .socialmedia_links a img {
            width: 20px !important;
            height: auto !important;
            display: block !important;
            position: relative !important;
            z-index: 2 !important;
        }

        .socialmedia_links a:hover {
            background-color: #829b2f !important;
            background-image: none !important;
            transform: translateY(-2px) !important;
        }

        .socialmedia_links a:hover i {
            color: #ffffff !important;
        }

        .socialmedia_links a:hover img {
            filter: brightness(0) invert(1) !important;
        }

        .widget ul li a {
            color: #a5a5a5;
            text-decoration: none;
        }

        .widget ul li a:hover {
            color: #829b2f;
        }

        @media (max-width: 768px) {

            .subfooter span,
            .subfooter a {
                font-weight: 500;
            }
        }

        @media (max-width: 576px) {
            .footer-links {
                text-align: center;
            }

            .footer-links a {
                display: inline-block;
                margin: 4px 10px;
                font-size: 13px;
            }

            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .footer-links .footer-row {
                display: flex;
                justify-content: center;
                gap: 16px;
            }
        }

        span.footer_address {
            display: inline-block !important;
            margin-left: 30px !important;
            margin-top: -24px !important;
        }

        @media (min-width: 992px) {
            span.footer_address {
                display: inline-block !important;
                margin-left: 30px !important;
                margin-top: -28px !important;
            }
        }
    </style>
    <script>
        document.getElementById("current-year").innerHTML = new Date().getFullYear();
    </script>
</footer>
<!-- footer close -->

<!-- Javascript Files================================================== -->


<script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/designesia.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/custom.js"></script>


<!--TOAST CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

<!-- Bootsrap 5 js  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url() ?>public/assets/custom/detail.js"></script>
<script src="<?php echo base_url() ?>public/assets/custom/globalwishlist.js"></script>

<!-- <script src="<?php echo base_url() ?>public/assets/custom/buynow.js"></script> -->

<!-- SWEETALERTS JS -->
<script src="<?php echo base_url() ?>assets/admin/build/assets/libs/sweetalert2/sweetalert2.min.js"></script>


<link rel="modulepreload" href="<?php echo base_url() ?>assets/admin/build/assets/sweet-alerts-ccdc3280.js" />
<script type="module" src="<?php echo base_url() ?>assets/admin/build/assets/sweet-alerts-ccdc3280.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>


<script>
    $(window).on('load', function () {
        $('#status').fadeIn();
        $('#preloaderr').delay(350).fadeOut('slow');
        $('body').delay(350).css({ 'overflow': 'visible' });
    })
</script>


<!-- price slider -->
<script>
    function setupSliders(minSliderId, maxSliderId, minValueId, maxValueId, priceFieldId) {

        var lowerSlider = document.querySelector(minSliderId);
        var upperSlider = document.querySelector(maxSliderId);
        var priceField = document.querySelector(priceFieldId);
        // Set initial values
        document.querySelector(minValueId).value = lowerSlider.value;
        document.querySelector(maxValueId).value = upperSlider.value;

        // Function to update the track background color based on slider values
        function updateBackground() {
            var lowerVal = parseInt(lowerSlider.value);
            var upperVal = parseInt(upperSlider.value);
            var maxVal = parseInt(lowerSlider.max);

            // Calculate percentage positions for both sliders
            var lowerPercent = (lowerVal / maxVal) * 100;
            var upperPercent = (upperVal / maxVal) * 100;

            // Set the background color of the slider track
            priceField.style.background = `linear-gradient(to right, #ccc ${lowerPercent}%,#829b2f ${lowerPercent}%, #829b2f ${upperPercent}%,#ccc ${upperPercent}%)`;
            priceField.style.height = `4px`;
        }

        // Function to update the values and background
        function updateValues() {
            var lowerVal = parseInt(lowerSlider.value);
            var upperVal = parseInt(upperSlider.value);

            // Ensure the upper slider is not below the lower slider
            if (upperVal < lowerVal + 4) {
                lowerSlider.value = upperVal - 4;
                if (lowerVal == lowerSlider.min) {
                    upperSlider.value = 4;
                }
            }

            // Update the displayed values
            document.querySelector(maxValueId).value = upperSlider.value;
            updateBackground();
        }

        // Lower slider input event
        lowerSlider.oninput = function () {
            var lowerVal = parseInt(lowerSlider.value);
            var upperVal = parseInt(upperSlider.value);
            if (lowerVal > upperVal - 4) {
                upperSlider.value = lowerVal + 4;
                if (upperVal == upperSlider.max) {
                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                }
            }
            document.querySelector(minValueId).value = lowerSlider.value;
            updateValues();
        };

        // Upper slider input event
        upperSlider.oninput = function () {
            updateValues();
        };

        // Initial background update
        updateBackground();
    }

    // Initialize sliders
    var width = $(window).width();
    if (width <= 768) {
        setupSliders('#mob_min_val', '#mob_max_val', '#mob_one', '#mob_two', '.price-field.mobile-view input[type="range"]');
    } else {
        setupSliders('#web_min_val', '#web_max_val', '#web_one', '#web_two', '.price-field.web-view input[type="range"]');
    }


</script>

<script>



    $(document).ready(function () {

        // function toggleMobileSearch() {
        //     let windowWidth = window.innerWidth;

        //     if (windowWidth <= 767) {
        //         $(".mobile-search").addClass("d-none");
        //     } else {
        //         $(".mobile-search").removeClass("d-none");
        //     }
        // }
        // toggleMobileSearch();

        // $(window).on("resize", function () {
        //     toggleMobileSearch();
        // });

        $(document).on('click', function (event) {
            if (
                !$(event.target).closest('#search_bar').length &&
                !$(event.target).closest('#suggestionsBox').length
            ) {
                $('#suggestionsBox').empty().addClass('d-none');
            }
        })

    })

    function fetchSuggestions() {
        var searchText = $('#search_bar').val().trim();

        if (searchText.length > 0) {
            $.ajax({
                url: base_Url + 'get-search-suggestions',
                type: 'GET',
                data: { query: searchText },
                success: function (response) {
                    displaySuggestions(response);
                },
                error: function () {
                    $('#suggestionsBox').html('Error fetching suggestions');
                }
            });
        } else {
            $('#suggestionsBox').empty();
        }
    }

    function displaySuggestions(suggestions) {
        var suggestionsBox = $('#suggestionsBox');
        suggestionsBox.empty();

        if (suggestions.length > 0) {
            suggestions.forEach(function (suggestion) {
                const redirectUrl = suggestion.redirect_url
                    .toLowerCase()
                    .replace(/\s+/g, '-');

                const encodedId = btoa(suggestion.prod_id);

                let url = "#";
                switch (suggestion.tbl_name) {
                    case "tbl_products":
                        url = `${base_Url}detail/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_accessories_list":
                        url = `${base_Url}accessories-detail/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_rproduct_list":
                        url = `${base_Url}riding-details/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_helmet_products":
                        url = `${base_Url}helmet-details/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_luggagee_products":
                        url = `${base_Url}tour-detail/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_camping_products":
                        url = `${base_Url}camp-details/${redirectUrl}/${encodedId}`;
                        break;
                }

                let searchResHtml = $(`
                    <a href="${url}" class="suggestion-link">
                        <div class="suggestion">
                            <img class="suggestion-img" src="${base_Url + suggestion.product_img}" alt="${suggestion.product_name}" />
                            <p>${suggestion.product_name}</p>
                        </div>
                    </a>
                `);

                // Attach click event properly
                searchResHtml.on('click', function () {
                    $('#search_bar').val(suggestion.product_name);
                    $('#suggestionsBox').empty();
                });

                suggestionsBox.removeClass("d-none");
                suggestionsBox.append(searchResHtml);
            });
        } else {
            suggestionsBox.removeClass('d-none');
            suggestionsBox.html('<div class="no-suggestions">No suggestions found</div>');
        }
    }
</script>



<!-- To scroll search suggestions -->
<script>
    const suggestionsBox = document.getElementById("suggestionsBox");

    suggestionsBox.addEventListener("wheel", function (e) {
        const scrollTop = this.scrollTop;
        const scrollHeight = this.scrollHeight;
        const height = this.clientHeight;
        const delta = e.deltaY;

        // Prevent page scroll when suggestions box can still scroll
        if (
            (delta > 0 && scrollTop + height < scrollHeight) ||
            (delta < 0 && scrollTop > 0)
        ) {
            e.preventDefault();
            this.scrollTop += delta;
        }
    });


</script>

<script>
    var count = $('.carousel-recent').data('count');
    $('.carousel-recent').owlCarousel({

        items: 4,

        loop: count > 1,

        // autoplay: true,

        autoplayTimeout: 7000000,

        margin: 2,

        nav: true,


        dots: false,

        responsiveClass: true,

        responsive: {

            0: {

                items: 1,

                nav: true,

                loop: count > 1,

            },

            600: {

                items: 2,

                nav: false,

                loop: count > 2,

            },

            1200: {

                items: 5,

                nav: true,

                loop: count > 4,

            },

            1800: {

                items: 6,

                nav: true,

                loop: count > 6,

            }

        }

    });
</script>