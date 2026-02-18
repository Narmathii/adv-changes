// // ********************************************************** ADDRESS INSERTION  *************************************************************

$(document).ready(function () {
  var mode;

  $("#state_id").change(function () {
    let state_id = $(this).val();
    let token = localStorage.getItem("token");
    $.ajax({
      type: "POST",
      url: base_Url + "getdist-data",
      data: { state_id: state_id },
      headers: { Authorization: "Bearer " + token },
      dataType: "json",

      success: function (res) {
        console.log(res["response"].length);
        // changeCSRF(res["csrf"]);
        var distDta = "";
        for ($i = 0; $i < res["response"].length; $i++) {
          distDta += `<option value="${res["response"][$i]["dist_id"]}">${res["response"][$i]["dist_name"]}</option>`;
        }
        $("#dist_id").html(
          `<option value=''> Select District </option>` + distDta
        );
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          window.location.href = base_Url + "login";
        }
        console.log(error);
      },
    });
  });
  //  ************************************** INSERT ADDRESS **********
  mode = "new";
  function validateError(data) {
    $.toast({
      icon: "error",
      heading: "Warning",
      text: data,
      position: "bottom-left",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  $("#btn_save").click(function () {
    if ($("#state_id").val() === "") {
      validateError("Please Select State!");
    } else if ($("#dist_id").val() === "") {
      validateError("Please Select District!");
    } else if ($("#landmark").val() === "") {
      validateError("Please Enter Landmark");
    } else if ($("#city").val() === "") {
      validateError("Please Enter City");
    } else if ($("#address").val() === "") {
      validateError("Please Enter Address");
    } else if ($("#pincode").val() === "") {
      validateError("Please Enter Pincode");
    } else if (!$("#default_addr").prop("checked")) {
      validateError("Please Select as default address");
    } else {
      insertData();
    }
  });

  function insertData() {
    var state_id = $("#state_id").val();
    var dist_id = $("#dist_id").val();
    var landmark = $("#landmark").val();
    var city = $("#city").val();
    var address = $("#address").val();
    var pincode = $("#pincode").val();
    var isChecked = $("#default_addr").prop("checked");
    var token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "insert-address",
      data: {
        state_id: state_id,
        dist_id: dist_id,
        landmark: landmark,
        city: city,
        address: address,
        pincode: pincode,
        default_addr: isChecked,
      },
      dataType: "json",
      cache: false,
      headers: { Authorization: "Bearer " + token },
      success: function (resultData) {
        // var resultData = $.parseJSON(data);

        if (resultData.code == 200) {
          // changeCSRF(resultData.csrf);
          // update_csrf_fields(resultData.csrf_test_name);
          $.toast({
            icon: "success",
            heading: "Success",
            text: resultData.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 1000,
            stack: false,
            showHideTransition: "fade",
          });

          window.location.reload();
        } else {
          // changeCSRF(resultData.csrf);
          $.toast({
            icon: "warning",
            heading: "warning",
            text: resultData.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 1000,
            stack: false,
            showHideTransition: "fade",
          });
          window.location.reload();
        }
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          window.location.href = base_Url + "login";
        }
        console.log(error);
      },
    });
  }

  // **********************************************************get Courier charges *************************************************************

  $(document).ready(function () {
    let distID = $("#cart-dist-id").val();
    let price = $("#prod_price").val();
    let token = localStorage.getItem("item");
    function deliveryCharge() {
      $.ajax({
        type: "POST",
        url: base_Url + "assign-couriercharge",
        data: { dist_id: distID },
        dataType: "json",
        headers: { Authorization: "Bearer " + token },
        success: function (data) {
          var charge = data.charges;

          $("#courier-charge").html("₹" + charge);
          let priceInt = parseInt(price);
          let chargeInt = parseInt(charge);

          let totalAmt = priceInt + chargeInt;

          $(".overAllTotalValue").text("₹" + totalAmt);
        },
        error: function (error) {
          let status = error.status;
          if (status === 401) {
            window.location.href = base_Url + "login";
          }
          console.log(error);
        },
      });
    }
  });
  // **********************************************************PROGRESS BAR *************************************************************
  var currentStep = 1;
  var updateProgressBar;

  function displayStep(stepNumber) {
    if (stepNumber >= 1 && stepNumber <= 3) {
      $(".step-" + currentStep).hide();
      $(".step-" + stepNumber).show();
      currentStep = stepNumber;
      updateProgressBar();
    }
  }

  $(document).ready(function () {
    $("#multi-step-form").find(".step").slice(1).hide();

    $(".next-step").click(function () {
      console.log("hi");
      if (currentStep <= 2) {
        if (currentStep == 2) {
        } else {
          $(".step-" + currentStep).addClass(
            "animate__animated animate__fadeOutLeft"
          );
          currentStep++;
          setTimeout(function () {
            $(".step")
              .removeClass("animate__animated animate__fadeOutLeft")
              .hide();
            $(".step-" + currentStep)
              .show()
              .addClass("animate__animated animate__fadeInRight");
            updateProgressBar();
          }, 500);
        }
      }

      $(".prev-step").click(function () {
        if (currentStep >= 1) {
          $(".step-" + currentStep).addClass(
            "animate__animated animate__fadeOutRight"
          );
          currentStep--;
          setTimeout(function () {
            $(".step")
              .removeClass("animate__animated animate__fadeOutRight")
              .hide();
            $(".step-" + currentStep)
              .show()
              .addClass("animate__animated animate__fadeInLeft");
            updateProgressBar();
          }, 500);
        }
      });

      updateProgressBar = function () {
        console.log(currentStep);
        var progressPercentage = currentStep * 100;
        $(".progress-bar").css("width", progressPercentage + "%");
      };
    });

    // ************************************************** COLOR *************************************************************************
    // color Option
    $(".color_wrap ul li").each(function (item) {
      var color = $(this).attr("data-color");
      $(this).css("backgroundColor", color);
    });

    $(".color_wrap ul li").each(function (item) {
      $(this).click(function () {
        $(this)
          .parents(".product_item")
          .find(".color_wrap ul li")
          .removeClass("active");
        $(this).addClass("active");
        var img_src = $(this).attr("data-src");
        $(this).parents(".product_item").find("img").attr("src", img_src);
      });

      // ************************************************** QUANTITY *************************************************************************
    });

    totalAmount();
    $(".btn-increment").click(function () {
      var cartID = $(this).attr("cart_id_data");
      this.parentNode.querySelector("input[type=number]").stepUp();
      var incQty = $(`.quantity_${cartID}`).val();

      subTotal(incQty, cartID);
    });

    $(".btn-decrement").click(function () {
      var cartID = $(this).attr("cart_id_data");
      this.parentNode.querySelector("input[type=number]").stepDown();
      var decQty = $(`.quantity_${cartID}`).val();

      subTotal(decQty, cartID);
    });

    function subTotal(qty, cartID) {
      let original = `.offer_${cartID}`;
      let prodPrice = $(original).val();

      let p1 = prodPrice.replace(",", "");
      let price = parseInt(p1);

      let displayPrice = `.disp_${cartID}`;

      let subtotalAmt = qty * price;

      $(displayPrice).text("₹" + subtotalAmt.toLocaleString());

      // update the quantity and subtotal into cart tbl
      $.ajax({
        type: "POST",
        url: base_Url + "update-cart",
        data: {
          quantity: qty,
          sub_total: subtotalAmt,
          cart_id: cartID,
        },
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        dataType: "json",
        success: function (data) {
          // console.log(data.csrf_token);

          if (data.code == 200) {
            updateCSRF(data.csrf_token);
            $(".total_amt_cal").text(number_formate(subtotalAmt));
          }
        },
        error: function () {
          console.log("Error");
        },
      });
      totalAmount(subtotalAmt);
    }

    function totalAmount() {
      var totalAmt = 0;
      $(".display-price").each(function () {
        let price = $(this).text();
        let remov_space = price.replace(",", "");
        let amt = parseFloat(remov_space.replace("₹", "").trim());

        totalAmt += amt;
      });
      $("#final_total").val(parseFloat(totalAmt));
      $(".total_amt_cal").text("₹" + totalAmt.toLocaleString());
    }

    //  ************************************************** CSRF update Token  *****************************************************************
    function updateCSRF(newToken) {
      $('meta[name="csrf-token"]').attr("content", newToken);
    }

    // ************************************************** DELETE  *************************************************************************

    $(document).on("click", ".btnDlt", function () {
      var cart_id = $(this).attr("dlt_id");

      $("#myModal").modal("show");

      if (
        $(".btndelete").on("click", function () {
          $.ajax({
            type: "POST",
            url: base_Url + "delete-cart",
            data: { cart_id: cart_id },

            success: function (data) {
              $("#myModal").modal("hide");
              var resData = $.parseJSON(data);

              if (resData.code == 200) {
                updateCSRF(resData.csrf);
                refreshDetail();
              } else {
                updateCSRF(resData.csrf);
                $.toast({
                  text: resData.msg,
                  hideAfter: 2000,
                  position: "top-center",
                });
              }
            },
            error: function (err) {
              console.log(err);
            },
          });
        })
      );
      if (
        $(".btnclose").on("click", function () {
          $("#myModal").modal("hide");
        })
      );
    });

    // ************************************************** REFRESH   *************************************************************************

    function refreshDetail() {
      window.location.reload();
    }
    // ************************************************** Checkout  cart   *************************************************************************

    $("#place-order").click(function () {
      $.ajax({
        type: "GET",
        url: base_Url + "check-userlogin",
        success: function (data) {
          var d = $.parseJSON(data);
          if (d.code == 400) {
            window.location.href = "login";
          } else if (d.code == 200) {
          }
        },
      });
    });
  });

  // ************************************************** Buy Now   *************************************************************************

  $("#buy-now").click(function () {
    let totalAmt = $("#total-amt").text().trim();
    let amt = totalAmt.replace("₹", "");
    let Amtt = parseInt(amt.replace(",", ""));
    var token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "cart-checkout",
      data: { totalamt: Amtt },
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        if (data.code == 200) {
          window.location.href = base_Url + "payment/" + data.order_id;
        } else {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: data.msg,
            position: "bottom-left",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        }
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          window.location.href = base_Url + "login";
        }
        console.log(error);
      },
    });
  });
  // ************************************************** Add courier charges  *************************************************************************

  $("#step-next").click(function () {
    // let distID = $(this).attr("user_iid");
    let userID = $(this).attr("user_iid");
    var distID;
    let token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "get-dist",
      data: { user_id: userID },
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        if (data != "") {
          distID = data[0]["dist_id"];
          proceedWithNextStep(distID);
        } else if (data == "") {
          $.toast({
            icon: "warning",
            heading: "Warning",
            text: "Please Fill Address",
            position: "top-left",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        }
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          window.location.href = base_Url + "login";
        }
        console.log(error);
      },
    });

    function proceedWithNextStep(distID) {
      let currentStep = 3;

      $(".step-" + currentStep).addClass(
        "animate__animated animate__fadeOutLeft"
      );
      // currentStep++;
      setTimeout(function () {
        $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
        $(".step-" + currentStep)
          .show()
          .addClass("animate__animated animate__fadeInRight");
        updateProgressBar();
      }, 500);

      function number_formate(number) {
        return number.toLocaleString();
      }
    }
  });
});
