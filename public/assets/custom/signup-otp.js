$(document).ready(function () {
  $("#btn-submit").click(function (event) {
    event.preventDefault();
    if ($("#verify-otp").val() == "") {
      $("#invalid-otp").html("Please Enter OTP").css({ color: "#fff" }).show();
    } else {
      $("#invalid-otp").hide();
      $("#loader")
        .text("Please wait... Loading.")
        .css("color", "#fff")
        .removeClass("d-none");
      $("#invalid").hide();
      insertData();
    }
  });

  $("#resend-btn").click(function (event) {
    event.preventDefault();
    $("#loader")
      .text("Please wait... Loading.")
      .css("color", "#fff")
      .removeClass("d-none");
    $("#loader").show();
    $.ajax({
      type: "POST",
      url: base_Url + "resend-signup-otp",
      success: function (data) {
        var datas = $.parseJSON(data);
        console.log(datas);
        if (datas.code == 200) {
          $("#loader").hide();
          $("#invalid-otp").hide();
          $("#invalid").html(datas.msg).show();
        } else {
          $("#loader").hide();
          $("#invalid-otp").hide();
          $("#invalid").html(datas.msg).show();
        }
      },
    });
  });

  function insertData() {
    var form = $("#form_otp")[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: base_Url + "check-sms-otp",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      success: function (data) {
        if (data.c_url == "") {
          var redirectURL = base_Url;
        } else {
          var redirectURL = data.c_url;
        }
        if (data.code == 200) {
          if (data.token) {
            localStorage.setItem("token", data.token);
          }
          window.location.href = redirectURL;
          update_csrf_fields(data.csrf_test_name);
        } else if (data.code == 400) {
          $("#loader").hide();
          $("#invalid").text(data.msg).show();
          update_csrf_fields(data.csrf_test_name);
        }
      },
    });
  }

  function update_csrf_fields(val) {
    let all_forms = document.forms;
    for (let e of all_forms) {
      e.querySelector("input[name=csrf_test_name]").value = val;
    }
  }
});
