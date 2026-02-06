<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4812959302242779"
     crossorigin="anonymous"></script>
<meta name="google-adsense-account" content="ca-pub-4812959302242779">

<body>
    <script>
        <?php if (isset($payment_successful) && $payment_successful === true): ?>
            window.location.href = "<?= base_url('success'); ?>";
        <?php endif; ?>
    </script>
</body>

</html>