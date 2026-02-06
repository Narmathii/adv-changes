<!DOCTYPE html>
<?php
require ("components/head.php");
?>
<style>
    .input-group {
        margin: 20px 0;
        flex-direction: column;
        display: flex;
        align-items: center;
    }

    #qrcode {
        margin-top: 20px;
    }

    label {
        color: #000 !important;
        text-transform: capitalize;
    }

    .input-group input {
        border: 1px solid #d3d3d3;
        border-radius: 5px;
        padding: 10px;
        width: 50%;
        margin-bottom: 20px;
    }

    p {
        margin-bottom: 0px;
    }

    .gpay_number_banner {
        border: 1px solid #d3d3d3;
        border-radius: 5px;
        padding: 27px;
        display: flex;
        flex-direction: column;
        align-items: center;
        line-height: 2;
    }

    input::placeholder {
        color: #ccc;
    }

    .btnSubmit {
        padding: 10px 20px;
        border: none;
        color: #fff !important;
        /* border-radius: 5px; */
        background-color: #28a745;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btnSubmit:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .btnSubmit:active {
        background-color: #1e7e34;
        transform: translateY(0);
    }

    h2 {
        display: flex;
        justify-content: center;
    }

    .gpay_number_banner p {
        font-size: 17px;
    }

    .gpay_number_banner h3 {
        font-size: 23px !important;
    }
</style>

<body>
    <?php
    require ("components/header.php");
    ?>
    <div class="container container py-5">
        <h2 class="mb-4">Confirm your Payment</h2>
        <div class="d-flex justify-content-evenly align-items-center mb-5">
            <img id="qrImage" src="<?php base_url() ?>public/assets/images/QRcode.jpeg" alt="QR Code" width="250" />
            <h1>OR</h1>
            <div class="gpay_number_banner">
                <h3> Gpay Number</h3>
                <p>7358992528</p>
            </div>
        </div>
        <div class="input-group">
            <label for="transaction">Please enter your transaction ID after completing the payment:</label>
            <input type="text" id="transaction" name="transaction" placeholder="Enter Transaction ID" />
            <a class="btn btnSubmit" id="btn-submit">Submit</a>

        </div>

    </div>

    <script src="<?php echo base_url() ?>public/assets/custom/transaction.js"></script>
    <?php
    require ("components/footer.php");
    ?>
</body>

</html>