<!-- SIDEBAR -->

<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="#" class="header-logo">


            <img src="<?php echo base_url() ?>assets/admin/images/logo.png" alt="logo" class="desktop-dark">
            <img src="<?php echo base_url() ?>assets/admin/images/logo.png" alt="logo" class="toggle-dark">

        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <?php $type = session()->get('auser_type');

            if ($type == 'A') {
                ?>

                <ul class="main-menu">
                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name category">Main</span></li>
                    <!-- End::slide__category -->


                    <!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="<?php echo base_url() ?>dashboard" class="side-menu__item">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">Dashboards<span
                                    class="badge bg-warning-transparent ms-2"></span></span>

                        </a>
                        <ul class="slide-menu child1-">

                        </ul>
                    </li>

                    <!-- End::slide -->

                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name category">Pages</span></li>
                    <!-- End::slide__category -->
                    <!-- Start::slide -->

                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="ri-briefcase-line side-menu__icon"></i>
                            <span class="side-menu__label">Home<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">

                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>banner-image" class="side-menu__item">Banner Image
                                </a>
                            </li>
                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>youtube" class="side-menu__item">Youtube Link
                                </a>
                            </li>
                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>brand-master" class="side-menu__item">Brand Master
                                </a>
                            </li>
                            <!-- <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>color-master" class="side-menu__item">Colors
                                </a>
                            </li> -->


                        </ul>
                    </li>


                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-task side-menu__icon"></i>
                            <span class="side-menu__label">Masters<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Shop By Bike
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2" style="box-sizing: border-box; display:none;">
                                    <!-- <li class="slide has-sub">
                                        <a href="<?php echo base_url() ?>add-products" class="side-menu__item">
                                            Products List</a>
                                    </li> -->
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>brand-list" class="side-menu__item">Brand list</a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>modal-list" class="side-menu__item">Model list</a>
                                    </li>


                                </ul>
                            </li>


                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Accessories
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2" style="box-sizing: border-box; display:none;">
                                    <li class="slide has-sub">
                                        <a href="<?php echo base_url() ?>accessories-list"
                                            class="side-menu__item">Accessories list</a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>accessories" class="side-menu__item">Accessories
                                            menu</a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>sub-accessories" class="side-menu__item">Sub
                                            accessories
                                        </a>
                                    </li>


                                </ul>
                            </li>


                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Riding Gears
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>riding-product-list"
                                            class="side-menu__item">Product List
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>main-menu-list" class="side-menu__item">Main Menu
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>sub-menu-list" class="side-menu__item">Sub Menu
                                        </a>
                                    </li>


                                </ul>
                            </li>



                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Luggage & Touring
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>luggage_product-list"
                                            class="side-menu__item">Product List
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>luggage_menu" class="side-menu__item">Main Menu
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>luggage_submenu" class="side-menu__item">Sub Menu
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Helment & Accessories
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>helmet-product-list"
                                            class="side-menu__item">Product List
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>helmet_menu" class="side-menu__item">Main Menu
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>helmet_submenu" class="side-menu__item">Sub Menu
                                        </a>
                                    </li>


                                </ul>
                            </li>


                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Camping
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>camp-product-list" class="side-menu__item">Product
                                            List
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>camp-menu" class="side-menu__item">Main Menu
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url() ?>camp-submenu" class="side-menu__item">Sub Menu
                                        </a>
                                    </li>


                                </ul>
                            </li>


                            <!-- <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">Combos
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                <li class="slide">
                                    <a href="<?php echo base_url() ?>combo-products-list"
                                        class="side-menu__item">Product List
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        </ul>
                    </li>

                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="ri-briefcase-line side-menu__icon"></i>
                            <span class="side-menu__label">Customer Details<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>cust-list" class="side-menu__item">Customer List
                                </a>
                            </li>
                            <!-- 
                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>state-list" class="side-menu__item">State List
                                </a>
                            </li>
                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>district-list" class="side-menu__item">District List
                                </a>
                            </li> -->

                        </ul>
                    </li>
                    <li class="slide has-sub">
                        <a href="<?php echo base_url() ?>order-details" class="side-menu__item">
                            <i class="ri-briefcase-line side-menu__icon"></i>
                            <span class="side-menu__label">Order List<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>

                        </a>
                        <ul class="slide-menu child1">

                        </ul>
                    </li>
                    <li class="slide has-sub">
                        <a href="<?php echo base_url() ?>payment-list" class="side-menu__item">
                            <i class="ri-briefcase-line side-menu__icon"></i>
                            <span class="side-menu__label">Payment List<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>

                        </a>
                        <ul class="slide-menu child1">

                        </ul>
                    </li>


                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="ri-briefcase-line side-menu__icon"></i>
                            <span class="side-menu__label">Courier Details<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">

                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>courier-charges" class="side-menu__item">Courier Charges
                                </a>
                            </li>
                            <li class="slide has-sub">
                                <a href="<?php echo base_url() ?>courier-partners" class="side-menu__item">Courier partners
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="slide has-sub">
                        <a href="<?php echo base_url() ?>wishlist-details" class="side-menu__item">
                            <i class="ri-briefcase-line side-menu__icon"></i>
                            <span class="side-menu__label">Wishlist Details<span
                                    class="badge bg-secondary-transparent ms-2"></span></span>

                        </a>
                        <ul class="slide-menu child1">

                        </ul>
                    </li>


                    <!-- End::slide -->

                </ul>
            <?php } else if ($type == 'U') {
                ?>
                    <ul class="main-menu">
                        <!-- Start::slide__category -->
                        <li class="slide__category"><span class="category-name category">Main</span></li>
                        <!-- End::slide__category -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="<?php echo base_url() ?>dashboard" class="side-menu__item">
                                <i class="bx bx-home side-menu__icon"></i>
                                <span class="side-menu__label">Dashboards<span
                                        class="badge bg-warning-transparent ms-2"></span></span>

                            </a>
                            <ul class="slide-menu child1-">

                            </ul>
                        </li>
                        <!-- End::slide -->

                        <!-- Start::slide__category -->
                        <li class="slide__category"><span class="category-name category">Pages</span></li>
                        <!-- End::slide__category -->
                        <!-- Start::slide -->

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <i class="bx bx-task side-menu__icon"></i>
                                <span class="side-menu__label">Masters<span
                                        class="badge bg-secondary-transparent ms-2"></span></span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Shop By Bike
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2" style="box-sizing: border-box; display:none;">
                                        <li class="slide has-sub">
                                            <a href="<?php echo base_url() ?>add-products" class="side-menu__item">
                                                Products List</a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>brand-list" class="side-menu__item">Brand list</a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>modal-list" class="side-menu__item">Model list</a>
                                        </li>


                                    </ul>
                                </li>


                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Accessories
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2" style="box-sizing: border-box; display:none;">
                                        <li class="slide has-sub">
                                            <a href="<?php echo base_url() ?>accessories-list"
                                                class="side-menu__item">Accessories list</a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>accessories" class="side-menu__item">Accessories
                                                menu</a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>sub-accessories" class="side-menu__item">Sub
                                                accessories
                                            </a>
                                        </li>


                                    </ul>
                                </li>


                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Riding Gears
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>riding-product-list"
                                                class="side-menu__item">Product List
                                            </a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>main-menu-list" class="side-menu__item">Main Menu
                                            </a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>sub-menu-list" class="side-menu__item">Sub Menu
                                            </a>
                                        </li>


                                    </ul>
                                </li>



                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Luggage & Touring
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>luggage_product-list"
                                                class="side-menu__item">Product List
                                            </a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>luggage_menu" class="side-menu__item">Main Menu
                                            </a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>luggage_submenu" class="side-menu__item">Sub Menu
                                            </a>
                                        </li>


                                    </ul>
                                </li>

                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Helment & Accessories
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>helmet-product-list"
                                                class="side-menu__item">Product List
                                            </a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>helmet_menu" class="side-menu__item">Main Menu
                                            </a>
                                        </li>
                                        <li class="slide">
                                            <a href="<?php echo base_url() ?>helmet_submenu" class="side-menu__item">Sub Menu
                                            </a>
                                        </li>


                                    </ul>
                                </li>


                                <!-- <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">Combos
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2" style="box-sizing: border-box; display: none;">
                                <li class="slide">
                                    <a href="<?php echo base_url() ?>combo-products-list"
                                        class="side-menu__item">Product List
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                            </ul>
                        </li>

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <i class="ri-briefcase-line side-menu__icon"></i>
                                <span class="side-menu__label">Customer Details<span
                                        class="badge bg-secondary-transparent ms-2"></span></span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide has-sub">
                                    <a href="<?php echo base_url() ?>cust-list" class="side-menu__item">Customer List
                                    </a>
                                </li>

                                <!-- <li class="slide has-sub">
                                    <a href="<?php echo base_url() ?>state-list" class="side-menu__item">State List
                                    </a>
                                </li>
                                <li class="slide has-sub">
                                    <a href="<?php echo base_url() ?>district-list" class="side-menu__item">District List
                                    </a>
                                </li> -->

                            </ul>
                        </li>




                        <!-- End::slide -->

                    </ul>
            <?php } ?>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- END SIDEBAR -->