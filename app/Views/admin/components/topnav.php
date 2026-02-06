<!-- HEADER -->

<header class="app-header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="#" class="header-logo">
                        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/brand-logos/desktop-logo.png"
                            alt="logo" class="desktop-logo">
                        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/brand-logos/toggle-logo.png"
                            alt="logo" class="toggle-logo">
                        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/brand-logos/desktop-dark.png"
                            alt="logo" class="desktop-dark">
                        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/brand-logos/toggle-dark.png"
                            alt="logo" class="toggle-dark">
                        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/brand-logos/desktop-white.png"
                            alt="logo" class="desktop-white">
                        <img src="<?php echo base_url() ?>assets/admin/build/assets/images/brand-logos/toggle-white.png"
                            alt="logo" class="toggle-white">
                    </a>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->


        <!-- Start::header-content-right -->
        <div class="header-content-right">

            <div class="header-element notifications-dropdown">

                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <i class="bx bx-bell header-link-icon"></i>
                    <span class="badge bg-secondary rounded-pill header-icon-badge pulse pulse-secondary"
                        id="notification-icon-badge"><?php echo $stock_count ?></span>
                </a>


                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-17 fw-semibold">Stock Notifications</p>
                            <span class="badge bg-secondary-transparent"
                                id="notifiation-data"><?php echo $stock_count ?> Unread</span>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">

                        <?php if ($stock_count < 4) {

                            for ($i = 0; $i < $stock_count; $i++) {
                                ?>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-success-transparent avatar-rounded"><i
                                                    class="ti ti-clock fs-18"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><span class="text-success">Product ID:
                                                        <?= $stock_status[$i]['prod_id'] ?></span></p>
                                                <span
                                                    class="text-muted fw-normal fs-12 header-notification-text"><?= $stock_status[$i]['product_name'] ?></span>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                            <?php }
                        } else {
                            for ($i = 0; $i < 4; $i++) {
                                ?>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-success-transparent avatar-rounded"><i
                                                    class="ti ti-clock fs-18"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><span class="text-success">Product ID:
                                                        <?= $stock_status[$i]['prod_id'] ?></span></p>
                                                <span
                                                    class="text-muted fw-normal fs-12 header-notification-text"><?= $stock_status[$i]['product_name'] ?></span>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                            <?php }
                        } ?>

                    </ul>
                    <div class="p-3 empty-header-item1 border-top">
                        <div class="d-grid">
                            <a href="<?php base_url() ?>notification" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="p-5 empty-item1 d-none">
                        <div class="text-center">
                            <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                <i class="ri-notification-off-line fs-2"></i>
                            </span>
                            <h6 class="fw-semibold mt-3">No New Notifications</h6>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <i class="bx bx-moon header-link-icon"></i>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <i class="bx bx-sun header-link-icon"></i>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>




            <div class="header-element">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="<?php echo base_url() ?>assets/admin/build/assets/images/faces/9.jpg" alt="img"
                                width="32" height="g32" class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <?php $type = session()->get('auser_type');
                            if ($type == 'A') {
                                ?>
                                <p class="fw-semibold mb-0 lh-1">Admin</p>
                            <?php } else if ($type == 'U') { ?>
                                    <p class="fw-semibold mb-0 lh-1">User</p>
                            <?php } ?>

                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">

                    <li><a class="dropdown-item d-flex" href="<?php echo base_url() ?>admin-logout"><i
                                class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                </ul>
            </div>
            <!-- End::header-element -->



        </div>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>
<!-- END HEADER -->