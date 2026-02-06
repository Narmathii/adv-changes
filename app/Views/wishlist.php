<!DOCTYPE html>
<?php
require("components/head.php");
?>
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<style>
    #empty-cart {
        font-size: 100px;
        display: block;
        padding: 20px;
        color: #a4c735 !important;
    }

    .cart_head {
        color: #000 !important
    }

    .wish-status,
    .wish-price,
    .wish-title {
        color: #000 !important
    }

    .order_detail {
        box-shadow: 0px 4px 6px rgba(207, 207, 207, 0.25), 0px 2px 4px rgba(0, 0, 0, 0.25);
        background-color: #fff;
    }
</style>


<body id="wishlist_page" class="dark-scheme p-0">
    <?php
    require("components/header.php");
    ?>
    <!-- content begin -->
    <?php
    if (count($wishListProd) <= 0) { ?>
        <section class="wishlist_section p-5">

            <h5 class="mb-0 cart_head"> <strong>Wish Lists</strong></h5>

            <div class="row">
                <div class="col-lg-12 col-md-6 mb-4 mb-lg-0">
                    <span class="text-center justify-content-center" id="empty-cart"> <i class="fa fa-heart"></i></span>
                    <h3 class="product_name text-center"><strong>
                            You Haven't added any products yet!!!
                        </strong>
                    </h3>
                </div>
            </div>
        </section>
    <?php } else {
        ?>
        <section class="wishlist_section p-5">
            <h5 class="mb-0 cart_head">Wish Lists</h5>
            <div class="row d-flex justify-content-center my-4">
                <?php for ($i = 0; $i < count($wishListProd); $i++) { ?>
                    <div class="col-md-6">
                        <div class="card mb-4 order_detail">
                            <div class="card-body">
                                <form class='wishlistForm' id='wishlistForm_<?php echo $i; ?>' method="post">

                                    <!-- Single item -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                            <!-- Image -->
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded photo"
                                                data-mdb-ripple-color="light">
                                                <img src="<?php echo base_url() ?><?php echo $wishListProd[$i]->product_img ?>"
                                                    class="w-100 " alt="<?php echo $wishListProd[$i]->product_name ?>" />
                                            </div>
                                            <!-- Image -->
                                        </div>
                                        <input type="hidden" name="table_name" id="table_name_<?php echo $i; ?>"
                                            value="<?php echo $wishListProd[$i]->tbl_name ?>" />
                                        <input type="hidden" name="prod_id" id="prod_id_<?php echo $i; ?>"
                                            value="<?php echo $wishListProd[$i]->prod_id ?>" />
                                        <input type="hidden" name="prod_price" id="prod_price_<?php echo $i; ?>"
                                            value="<?php echo $wishListProd[$i]->offer_price ?>" />
                                        <input type="hidden" name="quantity" id="quantity_<?php echo $i; ?>" value="1" />

                                        <input type="hidden" name="size" id="size_<?php echo $i; ?>"
                                            value="<?php echo $wishListProd[$i]->size ?>" />
                                        <input type="hidden" name="size_stock" id="size_stock<?php echo $i; ?>"
                                            value="<?php echo $wishListProd[$i]->size_stock ?>" />

                                        <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                            <p class="product_name wish-title">
                                                <strong><?php echo $wishListProd[$i]->product_name ?></strong>
                                            </p>


                                            <?php
                                            $size = $wishListProd[$i]->size;
                                            $res = $size != 0 ? $size : ' ';
                                            ?>

                                            <?php
                                            if ($size != 0) { ?>
                                                <p class="d-flex wish-status">Size: <span class="d-flex align-items-center">
                                                        <span class="<?= $stockclass ?>"></span>
                                                        <?= $res ?></span></p>

                                            <?php } ?>
                                            <?php
                                            $stockSts = $wishListProd[$i]->stock_status;
                                            $res = $stockSts == 1 ? 'Available' : 'Outof Stock';
                                            $stockclass = $stockSts == 1 ? "product_status" : "product_outofstock";
                                            ?>
                                            <p class="d-flex wish-status">Status: <span class="d-flex align-items-center">
                                                    <span class="<?= $stockclass ?>"></span>
                                                    <?= $res ?></span></p>
                                        </div>

                                        <div class="col-lg-4 col-md-6 wl_pricewrapper">
                                            <!-- Price -->
                                            <p class="text-md-end cart_price">
                                                <strong><span
                                                        class="m-0 wish-price">₹<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $wishListProd[$i]->offer_price) ?></span></strong>
                                            </p>
                                            <input type="hidden" name="config_image1" id="config_image1"
                                                value="<?php echo $wishListProd[$i]->product_img ?>" />
                                            <input type="hidden" name="color" class="color-option" value="0">
                                            <!-- <input type="hidden" name="size" class="color-option" value="0"> -->
                                            <div class="cart_action">
                                                <div class="demo-icon-wrap-s2 cart_wrapper">
                                                    <span aria-hidden="true" class="icon_cart_alt mb-0"></span>
                                                    <a type="button" class="mb-0 addto_cart" id="addtocart">Add to
                                                        cart</a>
                                                </div>
                                                <a class="trigger-btn m-0 delete_cart" data-toggle="modal" id="delete_cart"
                                                    prod_id="<?php echo $wishListProd[$i]->prod_id ?>">
                                                    <i class=" icon_trash"></i>
                                                </a>
                                            </div>
                                </form>
                                <!-- Price -->
                            </div>
                        </div>
                        <!-- Single item -->
                        </form>

                    </div>
                </div>
                </div>
            <?php } ?>



            <!-- DELETE MODAL -->
            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content delete_modal">
                        <div class="modal-header flex-column p-0">
                            <div class="icon-box">
                                <i class="fa fa-close m-0" style="font-size:36px"></i>
                            </div>
                            <h4 class="modal-title w-100">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p class="m-0">Do you really want to Remove this product?</p>
                        </div>
                        <div class="modal-footer justify-content-center p-0">
                            <button type="button" class="btn btn-secondary btnclose" data-dismiss="modal">Cancel</button>
                            <a type="button" class="btn btn-danger deleteBtn" id="">Remove</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <?php } ?>
    <!-- Modal HTML -->
    <?php
    require("components/footer.php");
    ?>

    <script src="<?php echo base_url() ?>public/assets/custom/wishlist.js"></script>



</body>

</html>