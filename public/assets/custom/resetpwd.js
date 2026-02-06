$(document).ready(function () {
  $("#btn-reset").click(function () {
    if ($("#new-password").val() == "") {
      $("#invalid-pwd").html("Please Enter Password").show();
    } else if ($("#confirm-pwd").val() == "") {
      $("#invalid-confirm").html("Enter Confirm password").show();
    } else {
      insertData();
    }
  });

  function insertData() {
    var form = $("#reset-password")[0];
    var formData = new FormData(form);
  
    formData.append('reset-id',$('#reset_id').val());
    console.log(formData);

    $.ajax({
      type: "POST",
      url: base_Url + "reset-pwd",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,

      success: function (data) {
        if (data.code === 200) {
          $("#invalid-data").html(data.msg);
        } else if (data.code === 400) {
          $("#invalid-data").html(data.msg);
        } else {
          $("#invalid-data").html(data.msg);
        }
      },
    });
  }
});
