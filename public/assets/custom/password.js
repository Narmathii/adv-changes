$(document).ready(function () {
  $("#btn-submit").click(function () {
    if ($("#email").val() == "") {
      $("#invalid-email").html("Please Enter Email").show();
    } else {
      insertData();
    }
  });

  function IsEmail(email) {
    var regex =
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function insertData() {
    var form = $("#reset-form")[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      enctype: "multipart/form-data",
      url: base_Url + "verify-password",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,

      success: function (data) {
        if (data.code == 200) {
          $("#invalid-emaill").html(data.msg);
        } else {
          $("#invalid-emaill").html(data.msg);
        }
      },
    });
  }
});
