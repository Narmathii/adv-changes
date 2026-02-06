<!DOCTYPE html>
<?php
require("components/head.php");
?>
<style>
    #products_page .de-item .d-img img {
        background-color: #fff;
        aspect-ratio: 4 / 2.7;
        width: 100%;
        object-fit: contain;
    }

    .productCard .d-img {
        padding: 10px;
    }

    .col-lg-3 {
        width: 20% !important;
    }

    .productCard {
        width: 20%
    }

    .flex-container {
        display: flex;
        ;
    }

    .flex-container>div {
        padding: 5px 10px;
    }

    .flex-container>div>img {
        width: 20%;
    }

    .products_wrapper {
        padding: 20px;
        background-color: #f9f9f9;
    }


    .products_wrapper h1 {
        text-align: center;
        margin-top: 30px;
        font-size: 24px;
    }


    .flex-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 15px;
    }


    .brand_container {
        flex: 1 1 calc(25% - 15px);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 0;
        background-color: #fff;
        min-height: 175px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(207, 207, 207, 0.25), 0px 2px 4px rgba(0, 0, 0, 0.25);
    }

    .brand_container img {
        width: 60%;
        margin-left: auto;
        margin-right: auto;
        height: auto;
        display: block;
        object-fit: cover;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .brand_container {
            flex: 1 1 calc(33.333% - 15px);
        }
    }

    @media (max-width: 768px) {
        .brand_container {
            flex: 1 1 calc(50% - 15px);
        }
    }

    @media (max-width: 576px) {
        .brand_container {
            flex: 1 1 100%;
        }
    }
</style>

<body id="products_page" class="dark-scheme">
    <?php
    require("components/header.php");
    ?>
    <!-- content begin -->

    <div class="no-bottom no-top zebra">
        <section id="section-cars" class="products_wrapper">
            <div class="container">
                <div class="row">
                    <h1>Brands We Deal</h1>
                    <div class="flex-container">
                        <div class="row">
                            <?php for ($i = 0; $i < count($brand_master); $i++) { ?>

                                <div class="col-lg-2 mt-3">
                                    <div class="brand_container">
                                        <a
                                            href='<?php echo base_url() ?>brands/<?php echo strtolower(str_replace(' ', '-', $brand_master[$i]['brand_name'])) ?>/<?php echo base64_encode($brand_master[$i]['brand_master_id']) ?>'>
                                            <img src="<?php echo base_url() ?><?php echo $brand_master[$i]['brand_img'] ?> "
                                                alt="<?= $brand_master[$i]['brand_name'] ?>" /></a>

                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                    </div>


                </div>
            </div>
        </section>

        <!-- content close -->
        <?php
        require("components/footer.php");
        ?>
</body>

</html>