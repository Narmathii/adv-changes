<!DOCTYPE html>
<html lang="en">
<title>Login</title>
<?php require("components/head.php"); ?>
<style>
    .social-container {
        margin: 20px 0;
        display: block;
        position: absolute;
        z-index: 99;
        bottom: 30%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }


    .social-container a {
        border: 1px solid #cccdcc;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 10px;
        height: 53px;
        width: 53px;
        transition: 333ms;
        padding: 10px;
        background: #fff;
    }

    .social-container a:hover {
        /* transform: rotateZ(13deg);
    border: 1px solid #0e263d; */
    }

    .social-container span {
        position: inherit;
        z-index: 99;
    }

    #invalid-data {
        text-align: center;
    }

    .login-wrapper .tabs h3 {
        float: left;
        width: 50%;
    }

    .login-wrapper .tabs h3 a {
        padding: 0.5em 0;
        text-align: center;
        font-weight: 400;
        display: block;
        border: 1px solid #a4c735;
        color: #a4c735;
    }

    .login-wrapper a.active {
        background-color: #a4c735;
        color: #fff !important;
    }

    .login-wrapper .tabs-content div[id$="tab-content"] {
        display: none;
    }

    .login-wrapper .tabs-content .active {
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

    .login-wrapper form .button:hover {
        background-color: #4FDA8C;
    }

    .login-wrapper form .checkbox {
        visibility: hidden;
        padding: 20px;
        margin: .5em 0 1.5em;
    }

    .login-wrapper form .checkbox:checked+label:after {
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
        filter: alpha(opacity=100);
        opacity: 1;
    }

    .login-wrapper form label[for] {
        position: relative;
        padding-left: 20px;
        cursor: pointer;
    }

    .login-wrapper form label[for]:before {
        content: '';
        position: absolute;
        border: 1px solid #CFCFCF;
        width: 17px;
        height: 17px;
        top: 0px;
        left: -14px;
    }

    .login-wrapper form label[for]:after {
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

    .login-wrapper .help-text {
        margin-top: .6em;
    }

    .login-wrapper .help-text p {
        text-align: center;
        font-size: 14px;
    }

    .login-wrapper {
        opacity: 0.8;
        background-color: #0c0c0c;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 53px;
    }

    .login-wrapper .box {
        min-height: 685px;
    }

    .login-wrapper .inputBox {
        position: relative;
        width: 300px;
        margin-top: 35px;
    }

    .login-wrapper .inputBox input {
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

    .login-wrapper .inputBox span {
        position: absolute;
        left: 0;
        padding: 5px 0;
        font-size: 1em;
        color: #8f8f8f;
        pointer-events: none;
        letter-spacing: 0.05em;
        transition: 0.5s;
    }

    .login-wrapper .inputBox input:valid~span,
    .login-wrapper .inputBox input:focus~span {
        color: #8aa928;
        transform: translateX(0px) translateY(-34px);
        font-size: 0.75em;
    }

    .login-wrapper .inputBox i {
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

    .login-wrapper .inputBox input:valid~i,
    .login-wrapper .inputBox input:focus~i {
        height: 44px;
        background: whitesmoke;
    }

    #btn-login {
        margin-top: 40px;
    }

    .err-loader {
        /* color: #fff; */
        /* display: none; */
        text-align: center;
    }

    @media only screen and (max-width: 600px) {
        .login-wrapper {
            padding: 20px;
        }

        .login-wrapper .inputBox {
            width: 100%;
        }

        .login-wrapper .box {
            width: 100%;
        }

        body.sms-login-mobile-active .login-wrapper .form {
            padding: 50px 10px;
            margin-bottom: 120px;
            
        }
    }

    .w-25 {
    width: 28% !important;
    height: 32px;
    border-radius: 6px;
    border: 2px solid #8aa928;
}

.links a {
        font-weight: bold;
        font-size: 0.85rem;
        color: #ddd;
    }

    @media (max-width: 768px) {
            .form {
        padding: 10px !important;
        padding-top: 40px !important;
        margin-top: 100px !important;
        margin-bottom: 70px !important;
    }
}

.form {
    position: absolute;
    inset: 2px;
    border-radius: 8px;
    background: #28292d;
    z-index: 10;
    padding: 31px 45px;
    display: flex;
    flex-direction: column;
    margin-bottom: 185px;
}

a#sms-login {
    padding-top: 30px;
}
</style>

<body>
    <div id="wrapper">
        <?php require("components/header.php"); ?>
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="jarallax p-0">
                <img src="<?php echo base_url() ?>public/assets/images/background/bg2.jpg" class="jarallax-img" alt="">
                <div class="login-wrapper">
                    <div class="box">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                        <div class="form">
                            <h2>Log In</h2>
                            <span class="err-loader"></span>
                            <span style="color:#fff" id="invalid-data"></span><br>
                            <div class="tabs">
                                <h3 class="signup-tab"><a class="active" href="#email-tab-content">Mail</a></h3>
                                <h3 class="login-tab"><a href="#sms-tab-content">SMS</a></h3>
                            </div>
                            <div class="tabs-content">
                                <div id="email-tab-content" class="active">
                                    <form id="form_login" class="mt-0">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <input type="hidden" id="redirect_url" name="redirect_url"
                                            value="<?= $prev_url ?>">
                                        <div class="inputBox">
                                            <input type="email" id='email' name='email' required="">
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
                                                <span class="password_input">Password</span>
                                                <i></i>
                                            </div>
                                            <span id="invalid-pwd"></span>
                                        </div>
                                        <a id="btn-login"><input type="button" value="Log In" class="w-25"></a>
                                        <div class="links mt-3">
                                            <a href="#">New to Adventure Shoppe?</a>
                                            <a href="<?php echo base_url() ?>signup">Sign Up</a>
                                        </div>
                                    </form>
                                </div>
                                <div id="sms-tab-content">
                                    <form id="form_login" class="mt-0">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <div class="inputBox">
                                            <input type="number" id='sms-number' name='sms-number'>
                                            <span>Mobile Number</span>
                                            <i></i>
                                        </div>
                                        <span id="invalid-num"></span>
                                        <a id="sms-login"><input type="button" value="Log In" class="w-25 mt-3"></a>
                                        <div class="links mt-3">
                                            <a href="#">New to Adventure Shoppe?</a>
                                            <a href="<?php echo base_url() ?>signup">Sign Up</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php require("components/footer.php"); ?>
    <script src="<?php echo base_url() ?>public/assets/custom/login.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            tab = $('.tabs h3 a');

            function updateMobileSmsLoginLayout() {
                var isSmsActive = $('.tabs h3 a.active').attr('href') === '#sms-tab-content';
                $('body').toggleClass('sms-login-mobile-active', isSmsActive);
            }

            tab.on('click', function (event) {
                event.preventDefault();
                tab.removeClass('active');
                $(this).addClass('active');

                tab_content = $(this).attr('href');
                $('div[id$="tab-content"]').removeClass('active');
                $(tab_content).addClass('active');
                updateMobileSmsLoginLayout();
            });

            updateMobileSmsLoginLayout();
        });

        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleText = document.querySelector(".toggle-btn");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>


</body>

</html>
