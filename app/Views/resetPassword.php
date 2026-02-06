<!DOCTYPE html>
<html lang="en">
<title>Reset-Password</title>
<?php require ("components/head.php"); ?>

<body>
    <div id="wrapper">

        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close -->

        <!-- header begin -->
        <?php require ("components/header.php"); ?>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="jarallax p-0">
                <!-- <video autoplay muted loop id="myVideo" class="jarallax-img">
                    <source src="<?php echo base_url() ?>public/assets/images/background/video.mp4" type="video/mp4">
                </video>   -->
                <img src="<?php echo base_url() ?>public/assets/images/background/bg.jpg" class="jarallax-img" alt="">
                <form id="reset-password">
                    <div class="box">
                        <div class="form">
                            <h2>Reset Password</h2>
                            <div class="inputBox">
                                <input type="text" id='new-password' name='new-password' required="">
                                <span>New Password</span>
                                <i></i>
                            </div>
                            <span id="invalid-pwd"></span>
                            <div class="inputBox">
                                <input type="password" id="confirm-pwd" name="confirm-pwd" required="">
                                <span>Confirm Password</span>
                                <i></i>
                            </div>
                            <span id="invalid-confirm"></span><br>
                            <span id="invalid-data"></span><br>
                            <input type="hidden" id="reset_id" value="<?php echo $user_id ?>">
                            <br>
                            <a id="btn-reset"><input type="button" value="Reset"></a>
                            <div class="links mt-3">
                                <a href="#">Back to Home ?</a>
                                <a href="<?php echo base_url() ?>">Click here!</a>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <?php require ("components/footer.php"); ?>
        <script src="<?php echo base_url() ?>public/assets/custom/resetpwd.js"></script>
</body>

</html>