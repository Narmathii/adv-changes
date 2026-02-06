<head>

    <link rel="icon" href="<?php echo base_url() ?>public/assets/images/logo.png" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>
        <?php
        if ($meta_title != '') {
            echo $meta_title;
        } else {
            echo "Top Quality Riding Gear & Accessories in India | Adventure Shoppe";

        }
        ?>
    </title>

    <!-- canonical tag -->
    <link rel="canonical" href=<?php echo current_url() ?> />

    <meta name="description" content=" <?php
    if ($meta_description != '') {
        echo $meta_description;
    } else {
        echo "Shop top-quality riding gear and bike accessories in India at Adventure Shoppe. Find helmets, jackets, gloves & more for a safe and stylish ride.";
    }
    ?>">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <meta name="google-site-verification" content="izMlw7KJz9tUSJDcHvmH0LXkBypn7uzszSfntMY2jsk" />

    <link href="<?php echo base_url() ?>public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"
        id="bootstrap">
    <link href="<?php echo base_url() ?>public/assets/css/mdb.min.css" rel="stylesheet" type="text/css" id="mdb">
    <link href="<?php echo base_url() ?>public/assets/css/plugins.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/coloring.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/custom/custom.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/custom/login.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/custom/requirement.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/custom/mobile.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url() ?>public/assets/css/custom/productdetails.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>public/assets/css/custom/responsive.css" rel="stylesheet" type="text/css">


    <!-- <link href="<?php echo base_url() ?>public/assets/css/custom/static.css" rel="stylesheet" type="text/css"> -->

    <link id="colors" href="<?php echo base_url() ?>public/assets/css/colors/scheme-01.css" rel="stylesheet"
        type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css">
    <!-- header -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

    <link rel="stylesheet" href="https://www.atlasestateagents.co.uk/css/tether.min.css">


    <!-- Font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!--TOAST CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootesrap -->

    <!-- SWEETALERTS CSS -->
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/admin/build/assets/libs/sweetalert2/sweetalert2.min.css">


    <!-- header -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Road Rage' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQmP2ykN4PmPyrk0jfwP9U93YIH6h9yHSTeP5G1woPQzn+76ZW4Cz9Ra1" crossorigin="anonymous">

    <script>
        var base_Url = '<?php echo base_url() ?>'
    </script>

    <!-- SEO Script -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MDQ60ZS0S1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-MDQ60ZS0S1');
    </script>

    <!-- Meta Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1111226807029422');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1111226807029422&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    
    
    <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "uwrmpeaekz");
    </script>
    


</head>