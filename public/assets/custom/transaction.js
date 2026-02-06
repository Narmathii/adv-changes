$(document).ready(function () {
  $("#btn-submit").click(function () {
    if ($("#transaction").val() == "") {
      validateError("Please Enter transactionID");
    } else {
      insertData();
    }
  });

  function validateError(data) {
    $.toast({
      icon: "error",
      heading: "Warning",
      text: data,
      position: "top-right",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  function insertData() {
    var transaction = $("#transaction").val();
    console.log(typeof transaction);
    $.ajax({
      type: "POST",
      url: base_Url + "insert-transaction",
      data: { transaction: transaction },
      dataType: "json",

      success: function (resultData) {
        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });
          $("#transaction").val("");
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "error",
          });
          $("#transaction").val("");
        }
      },
    });
  }
});
