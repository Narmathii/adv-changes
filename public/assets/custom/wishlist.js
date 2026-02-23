$(document).ready(function () {
  let deleteProdID = null;

  $(".delete_cart").on("click", function () {
    deleteProdID = $(this).attr("prod_id");
    $("#myModal").modal("show");
  });

  $(".btnclose, .modal .close").on("click", function () {
    $("#myModal").modal("hide");
  });

  $(".deleteBtn").on("click", function () {
    if (!deleteProdID) {
      return;
    }

    $.ajax({
      type: "POST",
      url: base_Url + "delete-wishlist",
      data: { prod_id: deleteProdID },
      success: function (data) {
        $("#myModal").modal("hide");
        var resData = $.parseJSON(data);

        if (resData.code == 200) {
          location.reload();
        } else {
          $.toast({
            text: resData.msg,
            hideAfter: 2000,
            position: "top-center",
          });
        }
      },
    });
  });

  $(".addto_cart").click(function (event) {
    event.preventDefault();
    const $btn = $(this);
    const stock = parseInt($btn.data("stock"), 10) || 0;

    if (parseInt($btn.data("added"), 10) === 1) {
      return;
    }

    if (stock <= 0) {
      $.toast({
        icon: "warning",
        heading: "Warning",
        text: "Product is out of stock",
        position: "top-right",
        bgColor: "#28292d",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
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
          setTimeout(function () {
            location.reload();
          }, 700);
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
          setTimeout(function () {
            location.reload();
          }, 700);
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
