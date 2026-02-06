<!DOCTYPE html>
<html lang="en">
<title>Password</title>
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
                <form id="reset-form" method="post" action="">
                    <div class="box">
                        <div class="form">
                            <h2>Password Assistance</h2>

                            <div class="inputBox">
                                <p style="color:#ffff">Enter the email address associated with your account!</p>
                            </div>
                            <div class="inputBox">
                                <input type="email" id="email" name="email" required="">
                                <span>Email</span>
                                <i></i>
                            </div>
                            <span id="invalid-email"></span><br>
                            <span id="invalid-emaill"></span>
                            <br><br>
                            <a id="btn-submit"><input type="button" value="Submit"></a>
                            <div class="links mt-3">
                                <a href="#"></a>
                                <a href="<?php echo base_url() ?>login">Cancel</a>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <?php require ("components/footer.php"); ?>
        <script src="<?php echo base_url() ?>public/assets/custom/password.js"></script>
</body>

</html>