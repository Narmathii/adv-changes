$(document).ready(function () {
  var mode, JSON, res_DATA, banner_id;

  $.when(getBannerDetails()).done(function () {
    dispBannerDetails(JSON);
  });

  function refreshDetails() {
    $.when(getBannerDetails()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  $("#addData").click(function () {
    mode = "new";

    $("#mobile_image_url").css("display", "none");
    $("#desktop_image_url").css("display", "none");
    $("#model-data").val("");
    $("#mobile_img").val("");
    $("#desktop_img").val("");
    $("#link").val("");

    $("#model-data").modal("show");
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#mobile_img").val() === "" && mode == "new") {
      $(".mobile_img").html("Please Select Mobile Image*").show();
    } else if ($("#desktop_img").val() === "" && mode == "new") {
      $(".desktop_img").html("Please select Desktop image*").show();
    } else if ($("#link").val() === "" && mode == "new") {
      $(".link").html("Please Enter redirect link*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#banner-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-banner-list";
    } else if (mode == "edit") {
      url = base_Url + "update-banner-list";
      data.append("banner_id", banner_id);
    }

    $.ajax({
      type: "POST",
      enctype: "multipart/form-data",
      url: url,
      data: data,
      processData: false,
      contentType: false,
      cache: false,

      success: function (data) {
        var resultData = $.parseJSON(data);
        console.log(resultData);

        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });

          $("#model-data").modal("hide");
          refreshDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#model-data").modal("hide");
          refreshDetails();
        }
      },
    });
  }

  // *************************** [Display the image on Modal ] ****************************************************

  $("#mobile_img").on("change", function () {
    dispImg(this, "mobile_image_url");
  });
  $("#desktop_img").on("change", function () {
    dispImg(this, "desktop_image_url");
  });
  function dispImg(input, id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#" + id).attr("src", e.target.result);
        $("#" + id).css("display", "block");
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  // *************************** [get Data] *************************************************************************
  function getBannerDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-banner",
      dataType: "json",
      success: function (data) {
        res_DATA = data;

        dispBannerDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispBannerDetails(JSON) {
    var i = 1;
    $("#datatable").DataTable({
      destroy: true,
      aaSorting: [],
      aaData: JSON,
      aoColumns: [
        {
          mDataProp: null,
          render: function (data, type, row, meta) {
            return i++;
          },
        },
        {
          mDataProp: function (data, type, full, meta) {
            if (data.mobile_img !== null)
              return (
                "<a href='" +
                base_Url +
                data.mobile_img +
                "' target='_blank'>" +
                "'<img src='" +
                base_Url +
                data.mobile_img +
                "' alt='not-image' width='100' target='_blank'></a>"
              );
            else return "";
          },
        },

        {
          mDataProp: function (data, type, full, meta) {
            if (data.desktop_img !== null)
              return (
                "<a href='" +
                base_Url +
                data.desktop_img +
                "' target='_blank'>" +
                "<img src='" +
                base_Url +
                data.desktop_img +
                "' alt='not-image' width='100'>" +
                "</a>"
              );
            else return "";
          },
        },

        {
          mDataProp: "link",
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a id="' +
              meta.row +
              '" class="btn btnEdit text-info fs-14 lh-1"> <i class="ri-edit-line"></i></a>' +
              '<a id="' +
              meta.row +
              '" class="btn BtnDelete text-danger fs-14 lh-1"> <i class="ri-delete-bin-5-line"></i></a>'
            );
          },
        },
      ],
    });
  }

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#model-data").modal("show");

    $("#mobile_image_url").css("display", "none");
    $("#desktop_image_url").css("display", "none");
    $("#model-data").val("");
    $("#mobile_img").val("");
    $("#desktop_img").val("");
    $("#link").val("");

    mode = "edit";

    var index = $(this).attr("id");

    $("#link").val(res_DATA[index].link);

    $("#mobile_image_url").attr("src", base_Url + res_DATA[index].mobile_img);
    $("#mobile_image_url").addClass("active");
    $("#mobile_image_url").css("display", "block");

    $("#desktop_image_url").attr("src", base_Url + res_DATA[index].desktop_img);
    $("#desktop_image_url").addClass("active");
    $("#desktop_image_url").css("display", "block");
    banner_id = res_DATA[index].banner_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    banner_id = res_DATA[index].banner_id;
    console.log(banner_id);

    Swal.fire({
      title: "Are you sure?",
      text: "You want to delete it?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: base_Url + "delete-banner",
          data: { banner_id: banner_id },

          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#model-data").modal("hide");
              refreshDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              refreshDetails();
            }
          },
        });
      }
    });
  });
});
