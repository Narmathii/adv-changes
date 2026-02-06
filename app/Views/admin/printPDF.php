<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Order PDF</title>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4812959302242779"
     crossorigin="anonymous"></script>
<meta name="google-adsense-account" content="ca-pub-4812959302242779">

<body>
    <iframe id="pdfFrame" src="data:application/pdf;base64,<?= $pdfBase64 ?>" style="display:none;"></iframe>

    <script>
        window.onload = function () {
            const pdfFrame = document.getElementById('pdfFrame').contentWindow;
            pdfFrame.focus();
            pdfFrame.print(); 
        };
    </script>
</body>

</html>