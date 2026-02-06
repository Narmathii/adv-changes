// // ********************************************************** ADDRESS INSERTION  *************************************************************

$(document).ready(function () {
  var mode;
  var emailSubmitted = false;

  var oldEmailID = "";

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
            `<option value=''> Select District </option>` + distDta
          );
        },
        error: function (error) {
          let status = error.status;
          if (status === 401) {
            localStorage.removeItem("token");
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
            localStorage.removeItem("token");
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
      emailSubmitted = true;
      insertEmail();
    }
  });

  $("#change-email-btn").click(function () {
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
      changeEmailSubmit = true;
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
          setTimeout(function () {
            $(".step-1").hide();
            $(".step-2").show();
            $(".step").removeClass("active");
            $(".step-2").addClass("active");
          }, 1200);
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
          setTimeout(function () {
            $(".step-1").hide();
            $(".step-2").show();
            $(".step").removeClass("active");
            $(".step-2").addClass("active");
          }, 1200);
        }
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          localStorage.removeItem("token");
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
          localStorage.removeItem("token");
          window.location.href = base_Url;
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

  $("#save_address").click(function () {
    if ($("#state_id_val").val() === "") {
      validateError("Please Select State!");
    } else if ($("#dist_id_val").val() === "") {
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
          setTimeout(function () {
            location.reload();
          }, 1200);
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
          localStorage.removeItem("token");
          window.location.href = base_Url + "login";
        }
        console.log(error);
      },
    });
  }

  // ********************************************************** PROGRESS BAR *************************************************************
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
    $("#multi-step-form").find(".step").slice(1, 3).hide();

    $(".next-step").click(function () {
      if (currentStep < 3) {
        if (currentStep == 2) {
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
              bgColor: "#red",
              loader: true,
              hideAfter: 2000,
              stack: false,
              showHideTransition: "fade",
            });
          } else if (
            $("#email-check").val().trim() != "" &&
            !$(".add_email").hasClass("d-none") &&
            emailSubmitted === false
          ) {
            $.toast({
              icon: "error",
              heading: "Warning",
              text: "You entered an email but didn’t submit it!",
              position: "top-right",
              bgColor: "#red",
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
          } else if (
            $("#change-email-ip").val() != "" &&
            !$(".change_email").hasClass("d-none") &&
            $("#change-email-ip").val().trim() !== oldEmailID
          ) {
            $.toast({
              icon: "error",
              heading: "Warning",
              text: "Please submit updated email",
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
            let stateID = $("#cart-state-id").val();
            let courierType = $('input[name="courier_option"]:checked').val();
            let charge = "";
            let token = localStorage.getItem("token");
            $("#step3-final").removeClass("d-none");

            $.ajax({
              type: "POST",
              url: base_Url + "assign-couriercharge",
              data: { state_id: stateID, courierType: courierType },
              dataType: "json",
              headers: { Authorization: "Bearer " + token },
              success: function (data) {
                charge = data;

                if (charge !== "") {
                  $(".goto-buy")
                    .addClass("next-step")
                    .trigger("click")
                    .off("click");
                }

                $("#courier-charge").html("₹" + charge);

                let subTotal = $("#final_total").val();
                let overAlltotal = parseFloat(
                  parseFloat(subTotal) + parseFloat(charge)
                ).toFixed(2);

                // INR converter
                const formatter = new Intl.NumberFormat("en-IN", {
                  style: "currency",
                  currency: "INR",
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 2,
                });

                let Total = formatter.format(overAlltotal);
                $(".overAllTotalValue").text(Total);

                $(".step-" + currentStep).addClass(
                  "animate__animated animate__fadeOutLeft"
                );

                currentStep = 3;
                $(".step")
                  .removeClass("animate__animated animate__fadeOutLeft")
                  .hide();
                $(".step-3")
                  .show()
                  .addClass("animate__animated animate__fadeInRight");

                updateProgressBar();
              },
              error: function (error) {
                let status = error.status;
                if (status === 401) {
                  localStorage.removeItem("token");
                  window.location.href = base_Url;
                }
                console.log(error);
              },
            });
          }
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
    });
    $(".prev-step").click(function () {
      if (currentStep > 1) {
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
      var progressPercentage = ((currentStep - 1) / 2) * 100;
      $(".progress-bar").css("width", progressPercentage + "%");
    };

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

    intialCartCalculation();

    $(".btn-increment").click(function () {
      var cartID = $(this).attr("cart_id_data");
      var totalStock = parseInt($(this).attr("data-stock"));

      var inputField = this.parentNode.querySelector("input[type=number]");
      var currentQty = parseInt($(inputField).val());

      if (currentQty < totalStock) {
        inputField.stepUp();
        var incQty = parseInt($(`.quantity_${cartID}`).val());
        updateCartQuantity(incQty, cartID);
      }
    });

    $(".btn-decrement").click(function () {
      var cartID = $(this).attr("cart_id_data");
      this.parentNode.querySelector("input[type=number]").stepDown();
      var decQty = parseInt($(`.quantity_${cartID}`).val());
      updateCartQuantity(decQty, cartID);
    });

    function updateCartQuantity(qty, cartID) {
      $.ajax({
        type: "POST",
        url: base_Url + "update-cart",
        data: {
          quantity: qty,
          cart_id: cartID,
        },
        dataType: "json",
        success: function (data) {
          if (data.code == 200) {
            $(`.quantity_${cartID}`).val(qty);
            $(`.disp_${cartID}`).text("₹" + number_formate(data.sub_total));

            $(".total_amt_cal").text("₹" + number_formate(data.total));
            $("#final_total").val(data.total);
          } else {
            alert("Something went wrong: " + data.status);
          }
        },
        error: function () {
          alert("Network error. Please try again.");
        },
      });
    }

    function number_formate(x) {
      return parseFloat(x).toLocaleString("en-IN", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
    }

    function intialCartCalculation() {
      $.ajax({
        type: "GET",
        url: base_Url + "get-inital-cart",
        dataType: "json",
        success: function (data) {
          if (data.status_code == 200) {
            $("#final_total").val(data.total_price.toFixed(2));
            $(".total_amt_cal").text("₹" + number_formate(data.total_price));
          } else if (data.status_code == 400) {
            alert(data.message);
          }
        },
        error: function () {
          alert("Network error. Please try again.");
        },
      });
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
        dataType: "json",
        success: function (data) {
          if (data.code == 400) {
            window.location.href = base_Url + "login";
          } else if (data.code == 200) {
            getEmail();
          }
        },
      });
    });

    function getEmail() {
      let token = localStorage.getItem("token");

      $.ajax({
        type: "GET",
        url: base_Url + "get-email",
        dataType: "json",
        headers: { Authorization: "Bearer " + token },
        success: function (data) {
          if (data.email.length == 0) {
            $(".add_email").removeClass("d-none");
            $(".change_email").addClass("d-none");
          } else {
            $(".change_email").removeClass("d-none");
            $("#change-email-ip").val(data.email);
            oldEmailID = data.email.trim();
            $(".add_email").addClass("d-none");
          }
        },
        error: function (error) {
          let status = error.status;
          if (status === 401) {
            localStorage.removeItem("token");
            window.location.href = base_Url;
          }
          console.log(error);
        },
      });
    }
  });

  // ************************************************** Buy Now   *************************************************************************

  $("#buy-now").click(function () {
    let totalAmt = $(".overAllTotalValue").text().trim();
    let amt = totalAmt.replace("₹", "");
    let Amtt = parseInt(amt.replace(",", ""));

    let State = $("#cart-state-id").val();
    let CourierType = $('input[name="courier_option"]:checked').val();

    let courier = $("#courier-charge").text();
    let courierCharge = courier.replace("₹", "");
    var token = localStorage.getItem("token");
    $.ajax({
      type: "POST",
      url: base_Url + "cart-checkout",
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
          localStorage.removeItem("token");
          window.location.href = base_Url;
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
          localStorage.removeItem("token");
          window.location.href = base_Url;
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

  // ************************************************** Change Address *************************************************************************

  $("#address-close").click(function () {
    $("#edit_address").modal("hide");
  });
  $("#btn-cancel").click(function () {
    $("#edit_address").modal("hide");
  });

  var distID;
  var distName;
  var stateID;
  var state_name;
  var token;

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
          localStorage.removeItem("token");
          window.location.href = base_Url;
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
    } else if (isValidPincode($("#pincode_val").val()) == false) {
      validateError("Please Enter Valid Pincode");
    } else if ($("#pincode_val").val().length < 6) {
      validateError("Please Enter Valid Pincode");
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
  function isValidPincode(pincode) {
    const pattern = /^[1-9][0-9]{5}$/;
    return pattern.test(pincode);
  }

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
          localStorage.removeItem("token");
          window.location.href = base_Url;
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
          localStorage.removeItem("token");
          window.location.href = base_Url;
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
