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

  $(".addto_cart").click(function (event) {
    event.preventDefault();
    const $btn = $(this);

    if (parseInt($btn.data("added"), 10) === 1) {
      return;
    }

    var form = $(this).closest(".wishlistForm")[0];
    insertData(form, $btn);
  });

  function insertData(form, $btn) {
    var formData = new FormData(form);
    const setAddedState = function () {
      $btn
        .closest(".cart_wrapper")
        .addClass("added-to-cart");
      $btn
        .text("Item added to cart")
        .addClass("is-added")
        .css({
          "pointer-events": "none",
        })
        .data("added", 1);
    };

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
          setAddedState();

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
        } else if (
          result.code == 400 &&
          typeof result.msg === "string" &&
          result.msg.toLowerCase().includes("already in cart")
        ) {
          setAddedState();

          $.toast({
            icon: "info",
            heading: "Info",
            text: result.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
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
