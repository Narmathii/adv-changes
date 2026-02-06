$(document).ready(function () {
  var mode, JSON, res_DATA, ytube_id;

  $.when(getYtubeDetails()).done(function () {
    dispYtubeDetails(JSON);
  });

  $("#addData").click(function () {
    mode = "new";

    $("#ytube_image_url").css("display", "none");
    $("#model-data").val("");
    $("#model-data").modal("show");
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#ytube_link").val() === "" && mode == "new") {
      $(".ytube_link").html("Please enter youtube link*").show();
    } else if ($("#ytube_img").val() === "" && mode == "new") {
      $(".ytube_img").html("Please Select Thumbnail Image*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#ytube-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-ytube";
    } else if (mode == "edit") {
      url = base_Url + "update-ytube";
      data.append("ytube_id", ytube_id);
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

        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });

          $("#model-data").modal("hide");
          location.reload();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#model-data").modal("hide");
          location.reload();
        }
      },
    });
  }

  // *************************** [Display the image on Modal ] ****************************************************

  $("#ytube_img").on("change", function () {
    dispImg(this, "ytube_image_url");
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
  function getYtubeDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-ytube",
      dataType: "json",
      success: function (data) {
        res_DATA = data;

        dispYtubeDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispYtubeDetails(JSON) {
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
          mDataProp: "ytube_link",
        },

        {
          mDataProp: function (data, type, full, meta) {
            if (data.ytube_img !== null)
              return (
                "<a href=" +
                base_Url +
                +data.ytube_img +
                "><img src=" +
                base_Url +
                data.ytube_img +
                " alt='not-image' width=80></a>"
              );
            else return "";
          },
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
    mode = "edit";

    var index = $(this).attr("id");

    $("#ytube_link").val(res_DATA[index].ytube_link);
    $("#ytube_image_url").attr("src", base_Url + res_DATA[index].ytube_img);
    $("#ytube_image_url").addClass("active");
    $("#ytube_image_url").css("display", "block");
    ytube_id = res_DATA[index].ytube_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    ytube_id = res_DATA[index].ytube_id;

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
          url: base_Url + "delete-ytube",
          data: { ytube_id: ytube_id },

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
