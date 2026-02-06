$(document).ready(function () {
  $(".addto_cartbtn").click(function () {
    insertData();
  });

  $("#buynowBtn").click(function () {
    checkUserLogin();
  });

  function checkData(data) {
    $.toast({
      icon: "warning",
      heading: "Warning",
      text: data,
      position: "top-right",
      bgColor: "#28292d",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  function success(data) {
    $.toast({
      icon: "success",
      heading: "success",
      text: data,
      position: "top-right",
      bgColor: "#28292d",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
    setTimeout(function () {
      location.reload();
    }, 1000);
  }
  function insertData() {
    var form = $("#product-form")[0];
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

        if (result.code == 200) {
          success(result.msg);

          // update_csrf_fields(result.csrf_test_name);
          $("#addtocart").html("Goto cart");
        } else {
          // update_csrf_fields(result.csrf_test_name);
          checkData(result.msg);
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

  $(".wishlist-btn").click(function () {
    var prod_id = $("#prod_id").val();
    var tbl_name = $("#tbl_name").val();
    var size = $(".size-details").val();
    console.log(size);

    $.ajax({
      type: "POST",
      url: base_Url + "add-wishlist",
      data: { prod_id: prod_id, tbl_name: tbl_name, size: size },

      success: function (data) {
        let res = $.parseJSON(data);
        if (res.code == 200) {
          $.toast({
            icon: "success",
            heading: "Suucess",
            text: res.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          $.toast({
            icon: "error",
            heading: "Warning",
            text: res.msg,
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
  });

  function checkUserLogin() {
    $.ajax({
      type: "GET",
      url: base_Url + "check-loginsts",
      success: function (data) {
        var d = $.parseJSON(data);

        if (d.code == 400) {
          window.location.href = base_Url + "login";
        } else if (d.code == 200) {
          storeOrder();
        }
      },
    });
  }

  function storeOrder() {
    var form = $("#product-form")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: base_Url + "buynow-products",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      success: function (data) {
        var result = JSON.parse(data);
        if (result.code == 200) {
          window.location.href = base_Url + "buy-now";
        } else {
        }
      },
    });
  }
});
