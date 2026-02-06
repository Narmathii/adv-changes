$(document).ready(function () {
  // ****************************************************************** Validation **************************************************************
  $("#btn-signup").click(function () {
    if ($("#username").val() == "") {
      $("#invalid-name").html("Please Enter Name").show();
    } else if ($("#number").val() == "") {
      $("#invalid-number").html("Please Enter Number").show();
    } else if (!isPhoneNumber($("#number").val())) {
      $("#invalid-number").html("Please Enter valid Number").show();
    } else if ($("#email").val() == "") {
      $("#invalid-email").html("Please Enter Email").show();
    } else if (!IsEmail($("#email").val())) {
      $("#invalid-email").html("Please Enter valid Email").show();
    } else if ($("#password").val() == "") {
      $("#invalid-password").html('Please Enter Password"').show();
    } else {
      $("#invalid-data").addClass("d-none");
      $("#loading")
        .text("Please wait... Loading.")
        .removeClass("d-none")
        .css("color", "#fff");

      insertData();
    }
  });

  $("#send-otp").click(function () {
    if ($("#sms-uname").val() === "") {
      $("#invalid-smsuname").html("Please enter username").show();
    } else if ($("#sms-number").val() === "") {
      $("#invalid-smsnumber").html("Please Enter Mobile number").show();
    } else if (!isPhoneNumber($("#sms-number").val())) {
      $("#invalid-smsnumber").html("Please Enter valid Number").show();
    } else {
      // $("#invalid-smsnumber").hide();
      $("#invalid-data").addClass("d-none");
      $("#loading")
        .text("Please wait... Loading.")
        .removeClass("d-none")
        .css("color", "#fff");
      sendOTP();
    }
  });

  function IsEmail(email) {
    var regex =
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function isPhoneNumber(phone_no) {
    var pattern = /^\d{10}$/;
    return pattern.test(phone_no);
  }

  function sendOTP() {
    var form = $("#sms_form")[0];
    // var data = new FormData(form);
    var number = $("#sms-number").val();
    var uname = $("#sms-uname").val();

    $.ajax({
      type: "POST",
      url: base_Url + "signup-otp",
      data: { number: number, uname: uname },
      dataType: "json",
      success: function (data) {
        localStorage.setItem("token", data.token);
        if (data.code == 400) {
          $("#loading").addClass("d-none");
          $("#invalid-data").text(data.msg).removeClass("d-none");
        } else if (data.code == 200) {
          $("#loading").hide();
          window.location.href = base_Url + "signup-otppage";
        }
      },
      error: function (xhr, status, error) {
        $("#loading").addClass("d-none");
        $("#invalid-data")
          .text("Error inserting data. Please try again.")
          .removeClass("d-none");
      },
    });
  }

  function insertData() {
    var form = $("#form_register")[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      enctype: "multipart/form-data",
      url: base_Url + "signup-mailcheck",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      success: function (data) {
        var JSONdata = $.parseJSON(data);
        localStorage.setItem("token", JSONdata.token);

        if (JSONdata.code == 400) {
          $("#loading").addClass("d-none");
          $("#invalid-data").text(JSONdata.msg).removeClass("d-none");
        } else if (JSONdata.code == 200) {
          $("#loading").hide();
          window.location.href = base_Url + "verify-email-otp";
        }
      },
      error: function (xhr, status, error) {
        $("#loading").addClass("d-none");
        $("#invalid-data")
          .text("Error inserting data. Please try again.")
          .removeClass("d-none");
      },
    });
  }

  // function update_csrf_fields(val) {
  //   let allForms = document.forms;
  //   for (e of allForms) {
  //     e.querySelector("input[name=csrf_test_name]").value = val;
  //   }
  // }
});
