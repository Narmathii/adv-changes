$(document).ready(function () {
  $(".wishlist-icon").click(function () {
    let prod_id = $(this).attr("data-id");
    let tbl_name = $(this).attr("tbl-name");

    
    $.ajax({
      type: "POST",
      url: base_Url + "add-wishlist",
      data: { prod_id: prod_id, tbl_name: tbl_name },

      success: function (data) {
        let res = $.parseJSON(data);
        if (res.code == 200) {
          $.toast({
            icon: "success",
            heading: "Success",
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
});
