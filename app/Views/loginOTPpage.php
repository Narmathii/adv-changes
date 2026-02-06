<!DOCTYPE html>
<html lang="en">
<title>OTP-verfication</title>
<?php require("components/head.php"); ?>

<style>
    #resend-btn {
        color: #8aa928;
    }

    #loader {
        color: #fff;
        display: none;
    }

    .otp-info {
        color: #fff;
        display: none;
    }

    #invalid-otp,
    #invalid {
        color: #fff;
    }
</style>

<body>
    <div id="wrapper">

        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close -->

        <!-- header begin -->
        <?php require("components/header.php"); ?>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="jarallax p-0">

                <img src="<?php echo base_url() ?>public/assets/images/background/bg.jpg" class="jarallax-img" alt="">
                <form id="form_otp" class="mt-0">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="box">
                        <div class="form">
                            <h2>OTP verification</h2><br><br>
                            <p class="otp-info">Please Check your Mobile!!!</p>
                            <div class="inputBox mt-10">
                                <input type="text" id='verify-otp' name='verify-otp' required="">
                                <span>Enter OTP</span>
                                <i></i>
                            </div>


                            <br>
                            <p id='invalid'></p>
                            <p id='invalid-otp'></p>
                            <p id='loader'></p>

                            <br>
                            <a id="btn-submit"><input type="button" value="Submit"></a>
                            <div class="links mt-3">
                                <a href="#">Didn't receive code?</a>
                                <a type="button" id="resend-btn">Resend Again!!</a>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <?php require("components/footer.php"); ?>
        <script src="<?php echo base_url() ?>public/assets/custom/login-otp.js"></script>
</body>

</html>