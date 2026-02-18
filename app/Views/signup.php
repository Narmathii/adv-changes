<!DOCTYPE html>
<html lang="en">
<title>Signup</title>
<?php require("components/head.php"); ?>

<style>
    #loading,
    {
    text-align: center;
    display: none;
    color: #fff !important
    }

    #invalid-smsnumber,
    #invalid-smsuname {
        color: #ff0000;
    }

    .signup-wrapper .tabs h3 {
        float: left;
        width: 50%;
    }

    .signup-wrapper .tabs h3 a {
        padding: 0.5em 0;
        text-align: center;
        font-weight: 400;
        display: block;
        border: 1px solid #a4c735;
        color: #a4c735;
    }

    .signup-wrapper a.active {
        background-color: #a4c735;
        color: #fff !important;
    }

    .signup-wrapper .tabs-content div[id$="signup-content"] {
        display: none;
    }

    .signup-wrapper .tabs-content .active {
        display: block !important;
    }

    .form-modal input:focus,
    .form-modal input:active {
        transform: scaleX(1.02);
    }

    .form-modal input::-webkit-input-placeholder {
        color: #222;
    }

    #sms-tab-content .inputBox {
        margin-top: 70px;
    }

    .signup-wrapper form .button:hover {
        background-color: #4FDA8C;
    }

    .signup-wrapper form .checkbox {
        visibility: hidden;
        padding: 20px;
        margin: .5em 0 1.5em;
    }

    .signup-wrapper form .checkbox:checked+label:after {
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
        filter: alpha(opacity=100);
        opacity: 1;
    }

    .signup-wrapper form label[for] {
        position: relative;
        padding-left: 20px;
        cursor: pointer;
    }

    .signup-wrapper form label[for]:before {
        content: '';
        position: absolute;
        border: 1px solid #CFCFCF;
        width: 17px;
        height: 17px;
        top: 0px;
        left: -14px;
    }

    .signup-wrapper form label[for]:after {
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        filter: alpha(opacity=0);
        opacity: 0;
        content: '';
        position: absolute;
        width: 9px;
        height: 5px;
        background-color: transparent;
        top: 4px;
        left: -10px;
        border: 3px solid #28A55F;
        border-top: none;
        border-right: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }

    .signup-wrapper .help-text {
        margin-top: .6em;
    }

    .signup-wrapper .help-text p {
        text-align: center;
        font-size: 14px;
    }

    .signup-wrapper {
        opacity: 0.8;
        background-color: #0c0c0c;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 53px;
    }

    .signup-wrapper .inputBox {
        position: relative;
        width: 300px;
        margin-top: 35px;
    }

    .signup-wrapper .inputBox input {
        position: relative;
        width: 100%;
        padding: 10px 9px 10px;
        background: transparent;
        border: none;
        outline: none;
        color: #000;
        font-size: 1em;
        letter-spacing: 0.05em;
        z-index: 14;
        font-weight: 500;
    }

    .signup-wrapper .inputBox span {
        position: absolute;
        left: 0;
        padding: 5px 0;
        font-size: 1em;
        color: #8f8f8f;
        pointer-events: none;
        letter-spacing: 0.05em;
        transition: 0.5s;
    }

    .signup-wrapper .inputBox input:valid~span,
    .signup-wrapper .inputBox input:focus~span {
        color: #8aa928;
        transform: translateX(0px) translateY(-34px);
        font-size: 0.75em;
    }

    .signup-wrapper .inputBox i {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #8aa928;
        border-radius: 4px;
        transition: 0.5s;
        pointer-events: none;
        z-index: 9;
    }

    .signup-wrapper .inputBox input:valid~i,
    .signup-wrapper .inputBox input:focus~i {
        height: 44px;
        background: whitesmoke;
    }

    #btn-signup input {
        border: 2px solid #8aa928;
        padding: 3px 0;
        margin-bottom: 20px;
    }

    #invalid-data {
        color: #fff !important
    }

    .invalid,
    {
    color: #fff !important
    }

    /*  Krish  */
    
    @media only screen and (max-width: 600px) {
        .signup-wrapper {
            padding: 20px;
        }
        .signup-wrapper .inputBox {
            width: 100%;
        }
        .signup-wrapper .box {
            width: 100%;
        }
        body.sms-signup-mobile-active .signup-wrapper .form {
            
            margin-bottom: 50px !important;
            margin-top: 75px !important;
        }

        body.sms-signup-mobile-active .signup-wrapper .box {
            height: 330px !important;
        } */

        body.sms-signup-mobile-active .signup-wrapper .box::before,
        body.sms-signup-mobile-active .signup-wrapper .box::after {
            width: 100%;
            height: 110%;
            
        }
    }

    .links a {
        font-weight: bold;
        font-size: 0.85rem;
        color: #ddd;
    }

    input.w-25 {
        border-radius: 5px;
     border: 2px solid #8aa928;
     /* margin-bottom: 20px; */

    }

    @media only screen and (min-width: 601px) {
        body.sms-signup-desktop-active .signup-wrapper .form {
            
            margin-bottom: 190px;
            margin-top: 0px;
        }
    }

   

    /* .sms-signup.form.active {
        padding: 55px 45px;
        margin-bottom: 75px;
        margin-top: 125px;

    }  */
</style>

<body>
    <div id="wrapper">

        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close 

        < header begin -->
        <?php require("components/header.php"); ?>

        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="jarallax p-0">
                <img src="<?php echo base_url() ?>public/assets/images/background/bg2.jpg" class="jarallax-img" alt="">
                <div class="signup-wrapper ">
                    <div class="box">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="form">
                            <h2>Signup</h2>
                            <span id="loading"></span>
                            <span id="invalid-data"></span><br>
                            <div class="tabs">
                                <h3 class="signup-tab"><a class="active" href="#email-signup-content">Mail</a></h3>
                                <h3 class="login-tab"><a href="#sms-signup-content">SMS</a></h3>
                            </div>
                            <div class="tabs-content">
                                <div id="email-signup-content" class="active">
                                    <form id="form_register">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <div class="inputBox signupname_input">
                                            <input type="text" id='username' name='username' required="">
                                            <span>Name</span>
                                            <i></i>
                                        </div>
                                        <span id="invalid-name"></span>
                                        <div class="inputBox">
                                            <input type="tel" id="number" name="number" required="" maxlength="10" inputmode="numeric" autocomplete="tel">
                                            <span>Mobile Number</span>
                                            <i></i>
                                        </div>
                                        <span id="invalid-number"></span>
                                        <div class="inputBox">
                                            <input type="email" id="email" name="email" required="">
                                            <span>Email</span>
                                            <i></i>
                                        </div>
                                        <span id="invalid-email"></span>
                                        <div class="password_wrapper relative">
                                            <span toggle="#password-field"
                                                class="fa fa-fw fa-eye field-icon toggle-password toggle-btn"
                                                onClick="togglePassword()"></span>
                                            <div class="inputBox">
                                                <input type="password" id="password" name="password" required="">
                                                <span>Password</span>
                                                <i></i>
                                            </div>
                                            <span id="invalid-password"></span>
                                        </div>
                                        <div class="mt-5">
                                            <a id="btn-signup"><input type="button" value="Sign Up" class="w-25"></a>
                                            <div class="links">
                                                <a href="#">Already have an account?</a>
                                                <a href="<?php echo base_url() ?>login" class="w-25">Sign in</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="sms-signup-content" class="sms-signup">

                                    <form id="sms_form" class="mt-0">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <div class="inputBox signupname_input">
                                            <input type="text" id='sms-uname' name='sms-uname'>
                                            <span>Name</span>
                                            <i></i>
                                        </div>
                                        <span class="invalid-data input-data" id="invalid-smsuname"></span>
                                        <div class="inputBox">
                                            <input type="tel" id="sms-number" name="sms-number" maxlength="10" inputmode="numeric" autocomplete="tel">
                                            <span>Mobile Number</span>
                                            <i></i>
                                        </div>
                                        <span class="invalid-data input-data" id="invalid-smsnumber"></span>
                                        <div class="mt-5">
                                            <a id="send-otp"><input type="button" value="Sign Up" class="w-25"></a>
                                            <div class="links mt-3">
                                                <a href="#">Already Have an Account?</a>
                                                <a href="<?php echo base_url() ?>login">Sign In</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>


        <?php require("components/footer.php"); ?>
        <script src="<?php echo base_url() ?>public/assets/custom/signup.js"></script>
          <script>
            jQuery(document).ready(function ($) {
                tab = $('.tabs h3 a');

                function updateSmsLayout() {
                    var isSmsActive = $('.tabs h3 a.active').attr('href') === '#sms-signup-content';
                    $('body').toggleClass('sms-signup-mobile-active', isSmsActive);
                    $('body').toggleClass('sms-signup-desktop-active', isSmsActive && window.innerWidth > 600);
                }

                tab.on('click', function (event) {

                    event.preventDefault();
                    tab.removeClass('active');
                    $(this).addClass('active');

                    tab_content = $(this).attr('href');
                    $('div[id$="signup-content"]').removeClass('active');
                    $(tab_content).addClass('active');
                    updateSmsLayout();
                });

                $(window).on('resize', updateSmsLayout);
                updateSmsLayout();
            });
        </script>
</body>

</html>
