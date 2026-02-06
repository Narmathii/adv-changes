<!DOCTYPE html>
<html lang="en">
<?php require("components/head.php"); ?>
<link href="<?php echo base_url() ?>public/assets/css/custom/tracking.css" rel="stylesheet" type="text/css">
<style>
    *{
        font-family : 'poppins'
    }
    .tracking-text .card-title
    {
        text-overflow: ellipsis;
        text-wrap: auto;
    }
</style>
<body>
    <?php require("components/header.php"); ?>
    <div id="orderlist" class="bg-gray-100 text-align-center pt-0">
        <div class="container pt-5">
            <h2 class="text-center pb-4 mt-5">Order Details</h2>
                <?php
                $deliverySts = $order_detail[0]['delivery_status'];
                if ($deliverySts == "Cancelled" || $deliverySts == 'Order Pending') {
                    $AlertMsg = "danger";
                } else {
                    $AlertMsg = "success";
                }
                ?>
                <div class="alert alert-<?= $AlertMsg ?>" role="alert">
                <?= $order_detail[0]['delivery_message'] ?>
                </div>

    
                <?php for ($i = 0; $i < count($order_detail); $i++) { ?>
                            <?php
                            $deliverySts = $order_detail[$i]['delivery_status'];
                            if ($deliverySts == "New") {
                                $step = 0;
                            } else if ($deliverySts == "Pending") {
                                $step = 1;
                            } else if ($deliverySts == "Shipped") {
                                $step = 2;
                            } else if ($deliverySts == "Delivered") {
                                $step = 3;
                            } ?>                                                                                                                                                                                                             

                            <input type="hidden" id="stepper" value="<?= $step ?>" /> 
                            <div class="card mb-3 d-flex" style="">
                                <div class="row g-0">                                                                                  
                                    <div class="col-md-3">
                                        <img class="order_image" src="<?= base_url() ?><?= $order_detail[$i]['config_image1'] ?>"
                                            class="img-fluid rounded-start" alt="order_image" >   
                                    </div>

                                    <div class="col-md-9">
                                        <div class="card-body tracking-text">
                                            <h5 class="card-title">
                                                <?= $order_detail[$i]['product_name'] ?>
                                            </h5>
                                            <p class="card-text">
                                                Order ID : <?= $order_detail[$i]['order_no'] ?>
                                            </p>

                                            <?php if ($order_detail[$i]['size'] != "" && $order_detail[$i]['color_name'] != "") {
                                                $classname = "";
                                            } else {
                                                $classname = "d-none";
                                            }
                                            ?>
                                            <p class="card-text  varients ">
                                                <small class="text-muted <?= $classname ?>">
                                                    Size :<?= $order_detail[$i]['size'] ?>
                                                </small><br>
                                                <small class="text-muted color-view <?= $classname ?>">
                                                    Color : <?= $order_detail[$i]['color_name'] ?>
                                                </small><br>
                                                <small class="text-muted">
                                                    Quantity : <?= $order_detail[$i]['quantity'] ?>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                <?php } ?>


                <!-- For Tracking ID Display start -->
                <?php if (
                    ($order_detail[0]['delivery_status'] == 'New' || $order_detail[0]['delivery_status'] == 'Pending' || $order_detail[0]['delivery_status'] == 'Shipped') && $order_detail[0]['tracking_id'] != ""
                ) { ?>  
                                                                                     <span class="badge badge-info mb-0">Courier Partner: <?= $order_detail[0]['courier_partner'] ?></span>   
                                                                                     <span class="badge badge-info mb-0">Tracking ID: <?= $order_detail[0]['tracking_id'] ?></span>   
                <?php } ?>
                <!-- For Tracking ID Display end -->
         
                <input type="hidden" id="order_Date"  value="<?= $order_detail[0]['order_date'] ?>"/>
                <input type="hidden" id="updated_Date"  value="<?= $order_detail[0]['updatedDate'] ?>"/>
                <?php
                $deliverySts = $order_detail[0]['delivery_status'];
                if ($deliverySts == "New" || $deliverySts == "Pending" || $deliverySts == "Shipped" || $deliverySts == 'Delivered') {
                    $ClassName = "";
                } else if ($deliverySts == "Cancelled" || $deliverySts == "Refund Created" || $deliverySts == "Refund Processed" || $deliverySts == 'Refund Failed' || $deliverySts == 'Order Pending') {
                    $ClassName = "d-none";
                }

                ?>

               
                <div class="row <?= $ClassName ?> mb-3" >
                    <div class="col-12 mb-3 w-100 address_detail">
                        <div class="tracking-detail">
                            <div class="mainWrapper">
                                <div class="statusBar">
                                    <span class="pBar"></span>
                                    <div class="node n0 done nConfirm0">
                                        <div class="main done m0 done nConfirm0"></div>
                                        <span class="text t0 done nConfirm0">Order Placed</span>
                                        <p class="stepper orders-msg0"><?= $order_detail[0]['ordered_date'] ?></p>
                                        <span class="order_time"><?= $order_detail[0]['ordered_time'] ?></span>
                                    </div>
                                
                                    <div class="node n1 nConfirm1">
                                        <div class="main m1 nConfirm1"></div>
                                        <span class="text t1 nConfirm1">Order In Progress</span>
                                        <p class="stepper orders-msg0"><?= $order_detail[0]['process_date'] ?></p>
                                        <span class="order_time"><?= $order_detail[0]['process_time'] ?></span>
                                    </div>
                                    <div class="node n2 nConfirm2">
                                        <div class="main m2 nConfirm2"></div>
                                        <span class="text t2 nConfirm2">Shipped</span>
                                        <p class="stepper orders-msg0"><?= $order_detail[0]['shipped_date'] ?></p>
                                        <span class="order_time"><?= $order_detail[0]['shipped_time'] ?></span>
                                    </div>
                                    <div class="node n3 nConfirm3">
                                        <div class="main m3 nConfirm3"></div>
                                        <span class="text t3 nConfirm3">Delivered</span>
                                        <p class="stepper orders-msg0"><?= $order_detail[0]['delivery_date'] ?></p>
                                        <span class="order_time"><?= $order_detail[0]['delivery_time'] ?></span>
                                    </div>

                                </div>
                                <!-- <div class="buttonHolder">
                                    <div class="button b-back disabled" id="back">Back</div>
                                    <div class="button b-next" id="next">Next</div>
                                </div> -->
                            </div>

                        </div>
                    </div>
                </div>


                <?php if (
                    ($order_detail[0]['delivery_status'] == 'New' || $order_detail[0]['delivery_status'] == 'Pending' || $order_detail[0]['delivery_status'] == 'Shipped')
                ) { ?>  
                                                                                                                            <div class="cancelorder mb-1 text-end">
                                                                                                                            <a class="mb-1 btn btn-warning text-end" id="cancel-model1"><span class="mb-3 cancel-order" >Cancel Order</span></a>
                                                                                                                            </div>
                <?php } ?> 


                <div class="modal fade" id="modal1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content cancel-modalcontent">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Cancel Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <h5>Do you really want to cancel your order?</h5>
                    <p>This action can't be reversed.</p>

                    </div>
                    <div class="modal-footer">
                    <button  class="btn btn-secondary" type="button" data-bs-dismiss="modal" aria-label="Close">No</button>
                        <button class="btn btn-warning" id="cancel-model2">Yes</button>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal fade" id="modal2" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content cancel-modalcontent">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Reason</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        Please provide a reason for cancellation 
                        <div class="form-group">
                        <input type="hidden" value="<?php echo $order_detail[0]['order_id'] ?>" id="cancel-id">
                            <textarea class="form-control" name="cancel_reason" id="message-text"></textarea>
                            <p id="error-message"></p>
                        </div>
                        </div><div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" aria-label="Close">No, Keep Order</button>

                            <button class="btn btn-warning" id="cancel-btn">Yes, Cancel Order</button>
                        </div>
                        </div>
                    </div>
                </div>               
        </div>
    </div>
</body>
<?php require("components/footer.php"); ?>
<script>
    var state = 0;
    var stateMax = 3;
    
    var stepperArr = [] ;
    var updatedDate = $("#updated_Date").val();
   
    stepperArr.push(updatedDate);

    $(document).ready(function () {
        state = $("#stepper").val();
        stateBar = $("#stepper").val();
       
        state += 1;

        $(".nConfirm" + stateBar).each(function () {
            $(this).addClass("done");
        });

        // Progress bar animation
        var pBar = (stateBar / stateMax) * 100;
        $(".pBar").css("width", `${pBar}%`);
        if (state == 4) {
            $("#next").addClass("disabled");
        }
    }) ;


    // function next() {
    //     console.log("Next", state);
    // }

    // function back() {
    //     console.log("Back", state);
    // }
  
    // $("#next").click(function () {
    //     if (state < stateMax) {
    //         next();

    //         state += 1;

    //         // Enables 'back' button if disabled
    //         $("#back").removeClass("disabled");

    //         // Adds class to make nodes green
    //         $(".nConfirm" + state).each(function () {
    //             $(this).addClass("done");
    //         });

    //         // Progress bar animation
    //         var pBar = (state / stateMax) * 100;
    //         $(".pBar").css("width", `${pBar}%`);

    //         // Disables 'next' button if end of steps
    //         if (state == 4) {
    //             $("#next").addClass("disabled");
    //         }
    //     }
    // });

    // $("#back").click(function () {
    //     if (state > 0) {
    //         back();

    //         // Enables 'next' button if disabled
    //         $("#next").removeClass("disabled");

    //         // removes class that makes nodes green
    //         $(".nConfirm" + state).each(function () {
    //             $(this).removeClass("done");
    //         });

    //         state -= 1;

    //         // Progress bar animation
    //         var pBar = (state / stateMax) * 100;
    //         $(".pBar").css("width", `${pBar}%`);

    //         // Disables 'back' button if end of steps
    //         if (state == 0) {
    //             $("#back").addClass("disabled");
    //         }
    //     }
    
// });
</script>

<script>
   $(document).ready(function(){
    $("#cancel-model1").click(function(){
       $("#modal1").modal("show");
    });

    $("#cancel-model2").click(function(){
        $("#modal1").modal("hide");
        $("#modal2").modal("show");
    })
   })
</script>


<script src="<?php echo base_url() ?>public/assets/custom/trackingorder.js"></script>
    
</script>
</html>