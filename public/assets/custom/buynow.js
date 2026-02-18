// // ********************************************************** ADDRESS INSERTION  *************************************************************

$(document).ready(function () {
  var mode;
  mode = "new";

  var states = "";

  $("#state_id_val").change(function () {
    let state_id = $(this).val();

    let token = localStorage.getItem("token");

    if (mode == "new") {
      $.ajax({
        type: "POST",
        url: base_Url + "getcartdist-data",
        data: { state_id: state_id },
        dataType: "json",
        headers: { Authorization: "Bearer " + token },
        success: function (res) {
          var distDta = "";
          for (let i = 0; i < res.length; i++) {
            distDta += `<option value="${res[i]["dist_id"]}">${res[i]["dist_name"]}</option>`;
          }

          $("#dist_id_val").html(
            `<option value=''> Select District </option>` + distDta,
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
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "getcartdist-data",
        data: { state_id: state_id },
        dataType: "json",
        headers: { Authorization: "Bearer " + token },
        success: function (data) {
          var distDta = "";

          distDta += `<option value="${distID}">${distName}</option>`;
          for (let i = 0; i < data.length; i++) {
            distDta += `<option value="${data[i]["dist_id"]}">${data[i]["dist_name"]}</option>`;
          }
          $("#dist_id_val").html(distDta);
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

  //  ************************************** SUBMIT EMAIL **********
  $("#submit-email").click(function () {
    if ($("#email-check").val() == "") {
      $.toast({
        icon: "error",
        heading: "Warning",
        text: "Please Enter Email",
        position: "top-right",
        bgColor: "#red",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
    } else if (!IsEmail($("#email-check").val())) {
      $.toast({
        icon: "error",
        heading: "Warning",
        text: "Please Enter Valid Email",
        position: "top-right",
        bgColor: "#red",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
    } else {
      insertEmail();
    }
  });

  $("#change-email").click(function () {
    if ($("#change-email-ip").val() == "") {
      $.toast({
        icon: "error",
        heading: "Warning",
        text: "Please Enter Email",
        position: "top-right",
        bgColor: "#red",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
    } else if (!IsEmail($("#change-email-ip").val())) {
      $.toast({
        icon: "error",
        heading: "Warning",
        text: "Please Enter Valid Email",
        position: "top-right",
        bgColor: "#red",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
    } else {
      updateEmail();
    }
  });

  function insertEmail() {
    let email = $("#email-check").val();
    let token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "insert-email",
      data: { email: email },
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        if (data.code == 200) {
          $.toast({
            icon: "success",
            heading: "success",
            text: data.msg,
            position: "top-right",
            bgColor: "#green",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
          location.reload();
        }
        if (data.code == 400) {
          $.toast({
            icon: "error",
            heading: "warning",
            text: data.msg,
            position: "top-right",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
          location.reload();
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

  function updateEmail() {
    let email = $("#change-email-ip").val();
    let token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "update-email",
      data: { email: email },
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        console.log(data);
        if (data.code == 200) {
          $("#change-email-ip").val(data.email);
          $.toast({
            icon: "success",
            heading: "success",
            text: data.msg,
            position: "top-right",
            bgColor: "#green",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        }
        if (data.code == 400) {
          $.toast({
            icon: "error",
            heading: "warning",
            text: data.msg,
            position: "top-right",
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
  }

  function IsEmail(email) {
    var regex =
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  //  ************************************** INSERT ADDRESS **********

  $("#save_address").click(function () {
    if ($("#state_id_val").val() === "") {
      validation("Please Select State!");
    } else if ($("#dist_id_val").val() === "") {
      validation("Please Select District!");
    } else if ($("#landmark").val() === "") {
      validation("Please Enter Landmark");
    } else if ($("#city").val() === "") {
      validation("Please Enter City");
    } else if ($("#address").val() === "") {
      validation("Please Enter Address");
    } else if ($("#pincode").val() === "") {
      validation("Please Enter Pincode");
    } else if (!$("#default_addr").prop("checked")) {
      validation("Please Select as default address");
    } else {
      insertData();
    }
  });

  function validation(data) {
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

  function insertData() {
    var state_id = $("#state_id_val").val();
    var dist_id = $("#dist_id_val").val();
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

  $("#multi-step-form").find(".step").slice(1).hide();

  $(".next-step").click(function () {
    if (currentStep <= 2) {
      if (currentStep == 1) {
        if (
          $("#email-check").val().trim() == "" &&
          !$(".add_email").hasClass("d-none")
        ) {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: "Please Enter Email",
            position: "top-right",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        } else if (
          !IsEmail($("#email-check").val()) &&
          !$(".add_email").hasClass("d-none")
        ) {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: "Please Enter Valid Email",
            position: "top-right",
            bgColor: "#red", // Use valid color
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        } else if (
          $("#change-email-ip").val() == "" &&
          !$(".change_email").hasClass("d-none")
        ) {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: "Please Enter Email",
            position: "top-right",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        } else if (
          !IsEmail($("#change-email-ip").val()) &&
          !$(".change_email").hasClass("d-none")
        ) {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: "Please Enter Valid Email",
            position: "top-right",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        } else if (!$(".courier-type").is(":checked")) {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: "Please Select Courier Option!",
            position: "top-right",
            bgColor: "#red",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        } else {
          let stateID = $("#buynow-state-id").val();
          let price = $("#prod_price").val();

          let courierType = $('input[name="courier_option"]:checked').val();
          let charge = "";
          let token = localStorage.getItem("token");

          $.ajax({
            type: "POST",
            url: base_Url + "couriercharge-buynow",
            data: { state_id: stateID, courierType: courierType },
            dataType: "json",
            headers: { Authorization: "Bearer " + token },
            success: function (data) {
              var charge = data;

              $("#courier-charge").html("₹" + charge);
              let priceInt = parseInt(price);
              let chargeInt = parseInt(charge);

              let totalAmt = priceInt + chargeInt;
              // INR converter
              const formatter = new Intl.NumberFormat("en-IN", {
                style: "currency",
                currency: "INR",
                minimumFractionDigits: 0,
                maximumFractionDigits: 2,
              });

              let Total = formatter.format(totalAmt);

              $(".overAllTotalValue").text(Total);

              $(".step-" + currentStep).addClass(
                "animate__animated animate__fadeOutLeft",
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
            },
          });
        }
      }
    }
  });

  $(".prev-step").click(function () {
    if (currentStep > 1) {
      $(".step-" + currentStep).addClass(
        "animate__animated animate__fadeOutRight",
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

  var updateProgressBar = function () {
    var progressPercentage = (currentStep - 1) * 50;
    $(".progress-bar").css("width", progressPercentage + "%");
  };

  // ************************************************** Buy Now   *************************************************************************

  $("#buy-now").click(function () {
    let totalAmt = $(".overAllTotalValue").text().trim();
    let amt = totalAmt.replace("₹", "");
    let Amtt = parseInt(amt.replace(",", ""));

    let courier = $("#courier-charge").text();
    let courierCharge = courier.replace("₹", "");

    let State = $("#buynow-state-id").val();
    let CourierType = $('input[name="courier_option"]:checked').val();
    var token = localStorage.getItem("token");
    $.ajax({
      type: "POST",
      url: base_Url + "buynow-checkout",
      data: {
        totalamt: Amtt,
        courierCharge: courierCharge,
        stateid: State,
        courier_type: CourierType,
      },
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        if (data.code == 200) {
          window.location.href = base_Url + "payment";
        } else {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: data.message,
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

  // ************************************************** Change Address *************************************************************************

  $("#address-close").click(function () {
    $("#edit_address").modal("hide");
  });
  $("#btn-cancel").click(function () {
    $("#edit_address").modal("hide");
  });

  var distID, token;
  var distName;
  var stateID;
  var state_name;

  $(".change-address").click(function () {
    $("#address_title").html("Edit Address");
    $("#state_id_val").val("");
    $("#dist_id_val").html('<option value="">Select District</option>');
    $("#landmark_val").val("");
    $("#city_val").val("");
    $("#address_val").val("");
    $("#pincode_val").val("");
    $("#default_addr_val").prop("checked", false);

    let addID = $(this).data("id");

    $("#save_change_address").attr("data-addid", addID);

    token = localStorage.getItem("token");

    let index = 0;

    mode = "edit";

    $.ajax({
      type: "POST",
      url: base_Url + "change-address",
      data: { add_id: addID },
      cache: false,
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        var res_DATA = JSON.parse(data);

        stateID = res_DATA[index]["state_id"];

        state_name = res_DATA[index]["state_title"];
        distID = res_DATA[index]["dist_id"];
        distName = res_DATA[index]["dist_name"];
        $("#state_id_val").val(stateID).trigger("change");

        $("#landmark_val").val(res_DATA[index]["landmark"]);
        $("#city_val").val(res_DATA[index]["city"]);
        $("#address_val").val(res_DATA[index]["address"]);
        $("#pincode_val").val(res_DATA[index]["pincode"]);

        let defaultAddr = res_DATA[index]["default_addr"];
        if (defaultAddr == 1) {
          $("#default_addr_val").prop("checked", true);
        } else {
          $("#default_addr_val").prop("checked", false);
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

    $("#edit_address").modal("show");
  });

  // ************************************************** Save  Address *************************************************************************

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

  $("#save_change_address").click(function () {
    $addID = $(this).data("addid");

    if ($("#state_id_val").val() === "") {
      validateError("Please Select State!");
    } else if ($("#dist_id_val").val() === "") {
      validateError("Please Select District!");
    } else if ($("#landmark_val").val() === "") {
      validateError("Please Enter Landmark");
    } else if ($("#city_val").val() === "") {
      validateError("Please Enter City");
    } else if ($("#address_val").val() === "") {
      validateError("Please Enter Address");
    } else if ($("#pincode_val").val() === "") {
      validateError("Please Enter Pincode");
    } else if (!$("#default_addr_val").prop("checked")) {
      validateError("Please Select as default address");
    } else {
      if (mode == "new") {
        insertAddress();
      } else if (mode == "edit") {
        updateAddress($addID);
      }
    }
  });

  function insertAddress($addID) {
    var state_id = $("#state_id_val").val();
    var dist_id = $("#dist_id_val").val();
    var landmark = $("#landmark_val").val();
    var city = $("#city_val").val();
    var address = $("#address_val").val();
    var pincode = $("#pincode_val").val();
    var isChecked = $("#default_addr_val").prop("checked");
    var token;

    token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "insert-cart-address",
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
        if (resultData.code == 200) {
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
          location.reload();
        } else {
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
          $("#add_form").modal("hide");
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

  function updateAddress($addID) {
    var state_id = $("#state_id_val").val();
    var dist_id = $("#dist_id_val").val();
    var landmark = $("#landmark_val").val();
    var city = $("#city_val").val();
    var address = $("#address_val").val();
    var pincode = $("#pincode_val").val();
    var isChecked = $("#default_addr_val").prop("checked");
    var add_id = $addID;
    var jwt_token;

    jwt_token = localStorage.getItem("token");

    $.ajax({
      type: "POST",
      url: base_Url + "update-cart-address",
      data: {
        state_id: state_id,
        dist_id: dist_id,
        landmark: landmark,
        city: city,
        address: address,
        pincode: pincode,
        default_addr: isChecked,
        add_id: add_id,
      },
      dataType: "json",
      cache: false,
      headers: { Authorization: "Bearer " + jwt_token },
      success: function (resultData) {
        console.log(resultData);
        if (resultData.code == 200) {
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
          location.reload();
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
          $("#add_form").modal("hide");
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
  // ************************************************** Add  Address *************************************************************************

  $(".add-address").click(function () {
    mode = "new";
    $("#address_title").html("Add Address");
    $("#edit_address").modal("show");
    $("#state_id_val").val("");
    $("#dist_id_val").html('<option value="">Select District</option>');
    $("#landmark_val").val("");
    $("#city_val").val("");
    $("#address_val").val("");
    $("#pincode_val").val("");
    $("#default_addr_val").prop("checked", false);
  });
});
