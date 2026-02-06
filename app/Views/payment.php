<!DOCTYPE html>
<html lang="en">

<?php
require("components/head.php");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="loader" style="display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;

        /* Center the loader image */
        display: flex;
        justify-content: center;
        align-items: center;">
        <img width="200px" src="<?= base_url('public/assets/images/loader.gif') ?>" alt="Loading..." />
    </div>

    <button id="rzp-button1" hidden></button>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        var pendingData = {
            rzporder_id: "<?= $order['id'] ?>",
            order_id: "<?= $customerdata['order_id'] ?>",
            user_id: "<?= $customerdata['user_id'] ?>",
            amount: "<?= $order['amount'] / 100 ?>"
        };

        $.ajax({
            url: "<?= base_url('payment-pending') ?>",
            type: "POST",
            data: pendingData,
            success: function (data) {
                console.log("Pending order stored:", data);
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", status, error);

            }
        });


        var options = {
            "key": "<?php echo $key_id ?>",
            "amount": <?php echo $order['amount'] ?>,
            "currency": "INR",
            "name": "AdventureShoppe",
            "description": "Transaction",
            "image": "<?php echo base_url() ?>public/logo.png",
            "order_id": "<?php echo $order['id'] ?>",
            "callback_url": "<?php echo base_url() ?>payment-status",
            "prefill": {
                "name": "<?php echo $customerdata['name'] ?>",
                "email": "<?php echo $customerdata['email'] ?>",
                "contact": "<?php echo $customerdata['number'] ?>"
            },
            "notes": {
                "address": "Razorpay Corporate Office",
                'user_id': "<?php echo $customerdata['user_id'] ?>",
                'order_id': "<?php echo $order['id'] ?>",
                'username': "<?php echo $customerdata['name'] ?>"
            },
            "theme": {
                "color": "#012652"
            },
            "modal": {
                "ondismiss": function () {
                    var error_data = {
                        reason: "User dismissed the payment modal",
                        order_id: "<?php echo $order['id'] ?>"
                    };
                    var error_query = new URLSearchParams(error_data).toString();
                    window.location.href = "<?php echo base_url() ?>payment-cancelled" + '/' + error_query;
                }
            },
            "handler": function (response) {
                var payment_data = {
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    payment_method: response.method,
                    order_id: "<?php echo $order['id'] ?>"
                };

                $.ajax({
                    url: "<?php echo base_url() ?>payment-status",
                    method: "POST",
                    data: payment_data,
                    success: function (response) {
                        try {
                            if (response.code === 200 && response.status === 'success') {

                                // Facebook Pixel event
                                fbq('track', 'Purchase', {
                                    value: <?= number_format($order['amount'] / 100, 2, '.', '') ?>,
                                    currency: 'INR'
                                });


                                var loader = document.querySelector(".loader");
                                loader.style.display = "flex";
                                loader.style.position = "fixed";
                                loader.style.top = "0";
                                loader.style.left = "0";


                                setTimeout(function () {
                                    window.location.href = "<?= base_url('success') ?>";
                                }, 500);
                            } else {
                                console.error("Error:", response.message);
                            }
                        } catch (e) {
                            console.error("Invalid JSON response:", response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }

        };

        var rzp1 = new Razorpay(options);

        rzp1.on('payment.failed', function (response) {
            var error_data = {
                code: response.error.code,
                description: response.error.description,
                source: response.error.source,
                step: response.error.step,
                reason: response.error.reason,
                order_id: response.error.metadata.order_id,
                payment_id: response.error.metadata.payment_id
            };

            var error_query = new URLSearchParams(error_data).toString();

            window.location.href = "<?php echo base_url() ?>payment-failed/" + error_query;
        });


        $('#rzp-button1').on('click', function (e) {
            e.preventDefault();
            rzp1.open();
        });


        $('#rzp-button1').trigger('click');




    </script>

</body>

</html>