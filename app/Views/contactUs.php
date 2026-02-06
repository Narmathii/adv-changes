<!DOCTYPE html>
<html lang="en">
<?php require ("components/head.php"); ?>
<style>
    main {
        height: auto;
    }

    .page-width--narrow {
        max-width: 800px;
        margin: 0 auto;
    }

    .section-padding {
        padding: 36px 20px;
    }

    .main-page-title {
        margin-top: 8%;
        font-size: 2rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .contact-info,
    .contact-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .contact-info p {
        margin: 10px 0;
    }

    .contact-form form {
        display: flex;
        flex-direction: column;
    }

    .contact-form .field {
        margin-bottom: 15px;
    }

    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .contact-form label {
        margin-bottom: 5px;
    }

    .contact-form button {
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        align-self: flex-end;
    }

    .contact-form button:hover {
        background-color: #555;
    }

    .table td {
        border-top: 0 !important
    }
</style>

<body onload="initialize()">
    <div id="wrapper">
        <?php require ("components/header.php"); ?>

        <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
            <div class="page-width--narrow section-padding">
                <h1 class="main-page-title">Contact Us</h1>

                <div class="contact-info">
                    <div class="container">
                        <table class="table table-borderless">

                            <tbody>
                                <tr>
                                    <td>WhatsApp / Call</td>
                                    <td>: +91-7358992528</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: abhishek@adventureshoppe.com</td>
                                </tr>
                                <tr>
                                    <td>Main Office</td>
                                    <td>
                                        <p><strong>: Sri Saaraa Towers,6-9 Dr, Balasundaram Rd<span
                                                    style="text-decoration: underline;"><br></span></strong></p>
                                        <p><strong></strong></p>
                                        <p><strong>&nbsp;Coimbatore - 641018, Tamil Nadu</strong></p>

                                        <p><strong>&nbsp;Phone: +91-7358992528</strong></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </main>


    </div>
    <?php require ("components/footer.php"); ?>
</body>

</html>