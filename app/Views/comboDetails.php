<!DOCTYPE html>
<html lang="zxx">

<?php require("components/head.php"); ?>
<body onload="initialize()" class="dark-scheme">
    <div id="wrapper">
        
        <!-- page preloader begin -->
        <!-- <div id="de-preloader"></div> -->
        <!-- page preloader close -->
        <?php require("components/header.php"); ?>
        <!-- content begin -->    
        <div class="no-bottom no-top zebra" >
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">     
                <video autoplay muted loop id="myVideo" class="jarallax-img">
                    <source src="<?php echo base_url() ?>public/assets/images/background/video1.mp4" type="video/mp4">
                </video>           
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
									<h1><?php echo $comboDetails[0]['product_name'] ?></h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section id="section-product-details" class="p-0">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6">
                            <div id="slider-carousel" class="owl-carousel">
                                <div class="item">
                                    <img src="<?php echo base_url() ?>/<?php echo $comboDetails[0]['img_1'] ?>" alt="">
                                </div>
                                <div class="item">
                                    <img src="<?php echo base_url() ?>/<?php echo $comboDetails[0]['img_2'] ?>" alt="">
                                </div>
                                <div class="item">
                                    <img src="<?php echo base_url() ?>/<?php echo $comboDetails[0]['img_3'] ?>" alt="">
                                </div>
                                <div class="item">
                                   <img src="<?php echo base_url() ?>/<?php echo $comboDetails[0]['img_4'] ?>" alt="">
                                </div>
                            </div>
                            <span class="offerrate"><?php echo $comboDetails[0]['offer_details'] ?></span>
                        </div>
                        <div class="col-lg-6">
                            <div class="de-price text-center">
                                <span class="vehicle_name"><?php echo$comboDetails[0]['product_name'] ?></span>
                            </div>
                            <div class="de-box text-light mb25">
                            <form name="contactForm" id='product-form' method="post">                                   
                                    <div class="col-lg-12">
                                    <?php echo$comboDetails[0]['prod_desc'] ?>
                                    </div>
                                    
                                    <div class="addto_cart price">
                                        <div class="col-lg-12">                                            
                                            <p class="offer_price">
                                                <br><span class="m-0">₹<?php echo number_format($comboDetails[0]['offer_price'],2) ?></span>
                                                <span class="real_price strike">₹<?php echo number_format($comboDetails[0]['product_price'],2) ?></span>
                                            </p>
                                        </div>                                      
                                    </div>
                                    <input type="hidden" name="table_name[]" id="table_name" value="<?php echo $tbl_name ?>"/>
                                    <input type="hidden" name="prod_id[]" id="prod_id" value="<?php echo $comboDetails[0]['prod_id'] ?>"/>
                                    <input type="hidden"  name="prod_price[]" id="prod_price" value="<?php echo $comboDetails[0]['offer_price']?>" />
                                    <div class="addto_cart ">
                                            <div class="col-lg-12 btn-detail">
                                                <div class="col-lg-4 ">
                                                    <div class="number">
                                                        <span class="minus">-</span>
                                                        <input id="quantity" name ="quantity[]" type="text" value="1" placeholder="1" />
                                                        <span class="plus">+</span>
                                                    </div>                                    
                                                </div> 
                                        
                                                
                                                <div class="col-lg-4 ">
                                                <a  type='button' id='addtocart' class="btn-main btn-fullwidth addto_cartbtn">Add cart</a>
                                                </div>
                                                <div class="col-lg-4 ">
                                                    <a href="<?php echo base_url()?>buy-now"  type='button' id='send_message' class="btn-main btn-fullwidth book_now">Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="clearfix"></div>                                
                                </form>
                            </div>                            
                        </div>                
                    </div>
                </div>
            </section>
            <!-- section begin -->
            <section aria-label="section" id="details_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="spacer30"></div>
							
							<div class="tab-default">
								
								<nav>
                                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Description</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Specifications</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Features</button>
                                  </div>
                                </nav>
								
								<div class="tab-content" id="nav-tabContent">
								  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <p><?php echo$comboDetails[0]['prod_desc'] ?></p></div>
								    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <section id="product_specifications">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="spacer-10"></div>
                                                        <div class="de-spec">
                                                            <div class="d-row">
                                                                <span class="d-title">Material</span>
                                                                <spam class="d-value"><?php echo $comboDetails[0]['material'] ?></spam>
                                                            </div>
                                                            <div class="d-row">
                                                                <span class="d-title">Colour</span>
                                                                <spam class="d-value"><?php echo ucwords($acc_details[0]['color_name']) ?></spam>
                                                            </div>
                                                            <div class="d-row">
                                                                <span class="d-title">Product weight (kg)</span>
                                                                <spam class="d-value"><?php echo$comboDetails[0]['prod_weight'] ?></spam>
                                                            </div>
                                                            <div class="d-row">
                                                                <span class="d-title">Product measurement L*B*H (cm)</span>
                                                                <spam class="d-value"><?php echo$comboDetails[0]['measurement'] ?></spam>
                                                            </div>
                                                            <div class="d-row">
                                                                <span class="d-title">Fitment</span>
                                                                <spam class="d-value"><?php echo$comboDetails[0]['fitment'] ?></spam>
                                                            </div>
                                                            <div class="d-row">
                                                                <span class="d-title">Warranty</span>
                                                                <spam class="d-value"><?php echo$comboDetails[0]['warrenty'] ?></spam>
                                                            </div>
                                                                                                                  
                                                        </div>

                                                        <div class="spacer-single"></div>

                                                    </div>
                                    
                                                </div>
                                            </div>
                                        </section>
                                    </div>
								  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"><p><?php echo$comboDetails[0]['features'] ?></p></div>
								</div>								
							</div>							
                        </div>
					</div>
                </div>
            </section>
            <!-- section close -->
            </div>
        </div>
    <!-- content close -->
    <a href="#" id="back-to-top"></a>
    <?php require("components/footer.php"); ?>

</body>

</html>