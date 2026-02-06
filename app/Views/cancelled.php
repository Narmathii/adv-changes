<!DOCTYPE html>
<html lang="en">
<?php
require("components/head.php");
?>

<body class="dark-scheme h-100">
    <section class="h-100" id="failurepage_wrapper">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success _failed">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>

                    <h2> Your payment was Cancelled </h2>



                    <div class="confirm_order">
                        <a href="<?php echo base_url() ?>myorders" type="button"
                            class="continue_shoppingBtn pay_btn prev-step me-4">
                            <i class="arrow_left me-2"></i> Back to purchase </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>

</html>