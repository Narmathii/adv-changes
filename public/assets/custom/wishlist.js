$(document).ready(function () {
  $(".delete_cart").click(function () {
    $("#myModal").modal("show");

    let prodID = $(this).attr("prod_id");

    if (
      $(".deleteBtn").on("click", function () {
        $.ajax({
          type: "POST",
          url: base_Url + "delete-wishlist",
          data: { prod_id: prodID },
          //   headers: {
          //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          //   },

          success: function (data) {
            $("#myModal").modal("hide");
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              //   updateCSRF(resData.csrf);
              location.reload();
            } else {
              //   updateCSRF(resData.csrf);
              $.toast({
                text: resData.msg,
                hideAfter: 2000,
                position: "top-center",
              });
            }
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

  $(".addto_cart").click(function () {
    var form = $(this).closest(".wishlistForm")[0];
    insertData(form);
  });

  function insertData(form) {
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: base_Url + "user-cart-details",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,

      success: function (data) {
        var result = JSON.parse(data);
        console.log(result);
        if (result.code == 200) {
          $.toast({
            icon: "success",
            heading: "Suucess",
            text: result.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
          // $("#addtocart").html("Goto cart");
        } else {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: result.msg,
            position: "top-right",
            bgColor: "#res",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        }
      },
    });
  }
});
