$(document).ready(function () {
  var csrfToken = $('meta[name="csrf-token"]').attr("content");

  $("#btn-login").click(function () {
    if ($("#email").val() == "") {
      $("#invalid-email").html("Please Enter Email").show();
    } else if (!IsEmail($("#email").val())) {
      $("#invalid-email").html("Please Enter Valid Email").show();
    } else if ($("#password").val() == "") {
      $("#invalid-pwd").html("Please Enter password").show();
    } else {
      $("#invalid-data").hide();
      insertData();
    }
  });

  $("#sms-login").click(function () {
    if ($("#sms-number").val() == "") {
      $("#invalid-num")
        .html("Please Enter Mobile number")
        .css("color", "#fff")
        .show();
    } else if (!isPhoneNumber($("#sms-number").val())) {
      $("#invalid-num")
        .html("Please Enter valid Number")
        .css("color", "#fff")
        .show();
    } else {
      $(".err-loader")
        .text("Please wait... Loading.")
        .removeClass("d-none")
        .css("color", "#fff");
      $("#invalid-num").hide();
      sendOTP();
    }
  });

  function isPhoneNumber(phone_no) {
    var pattern = /^\d{10}$/;
    return pattern.test(phone_no);
  }
  function IsEmail(email) {
    var regex =
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function insertData() {
    var form = $("#form_login")[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      enctype: "multipart/form-data",
      url: base_Url + "check-login",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      dataTyppe: "json",

      success: function (res) {
        let resData = $.parseJSON(res);
        localStorage.setItem("token", resData.token);

        if (resData.c_url == "myprofile") {
          var redirectURL = base_Url + resData.c_url;
        } else {
          var redirectURL = resData.c_url;
        }

        if (resData.code == 200) {
          // update_csrf_fields(resData.csrf_test_name);
          window.location.href = redirectURL;
        } else if (resData.code == 400) {
          // update_csrf_fields(resData.csrf_test_name);
          $("#invalid-data").html(resData.message).show();
        }
      },
    });
  }

  function sendOTP() {
    var num = $("#sms-number").val();
    $.ajax({
      type: "POST",
      url: base_Url + "login-otp",
      data: { num: num },
      datatype: "json",
      success: function (Data) {
        var resData = $.parseJSON(Data);
        localStorage.setItem("token", resData.token);
        if (resData.code == 200) {
          // update_csrf_fields(resData.csrf_test_name);
          window.location.href = base_Url + "login-otppage";
        } else if (resData.code == 400) {
          $(".err-loader").hide();
          $("#invalid-num").hide();
          // update_csrf_fields(resData.csrf_test_name);
          $("#invalid-data").html(resData.message).show();
        }
      },
    });
  }

  // function update_csrf_fields(val) {
  //   let all_forms = document.forms;
  //   for (e of all_forms) {
  //     e.querySelector("input[name=csrf_test_name]").value = val;
  //   }
  // }
});
