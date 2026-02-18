$(document).ready(function () {
  var mode, JSON, res_DATA, brand_id;

  getbrandDetails(function (brandDetails) {
    dispbrandDetails(brandDetails);
  });

  function refreshDetails() {
    var currentPage = 0;

    if ($.fn.DataTable.isDataTable("#datatable")) {
      currentPage = $("#datatable").DataTable().page();
    }

    getbrandDetails(function (brandDetails) {
      dispbrandDetails(brandDetails);

      var table = $("#datatable").DataTable();
      var pageInfo = table.page.info();
      var targetPage = Math.min(currentPage, Math.max(pageInfo.pages - 1, 0));
      table.page(targetPage).draw("page");
    });
  }

  $("#addData").click(function () {
    mode = "new";

    $("#brand_image_url").css("display", "none");
    $("#model-data").val("");
    $("#model-data").modal("show");
  });

  // *************************** [Validation] ********************************************************************

  $("#brand-submit").click(function () {
    $(".error").hide();
    if ($("#brand_name").val() === "" && mode == "new") {
      $(".brand_error").html("Please enter brand name*").show();
    } else if ($("#brand_img").val() === "" && mode == "new") {
      $(".brand_img").html("Please select brand image*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#brand-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-brandList";
    } else if (mode == "edit") {
      url = base_Url + "update-brand-list";
      data.append("brand_id", brand_id);
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

  $("#brand_img").on("change", function () {
    dispImg(this, "brand_image_url");
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
  function getbrandDetails(callback) {
    return $.ajax({
      type: "POST",
      url: base_Url + "get-brandData",
      dataType: "json",
      success: function (data) {
        res_DATA = data;

        if (typeof callback === "function") {
          callback(res_DATA);
        }
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispbrandDetails(JSON) {
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
          mDataProp: "brand_name",
        },
        {
          mDataProp: function (data, type, full, meta) {
            if (data.brand_img !== null)
              return (
                "<a href=" +
                base_Url +
                +data.brand_img +
                "><img src=" +
                base_Url +
                data.brand_img +
                " alt='not-image' width=100></a>"
              );
            else return "";
          },
        },
        {
          mDataProp: function (data, type, full, meta) {
            return `
            <div class="toggle-switch">
              <input
                type="checkbox"
                class="statusToggle"
                id="toggle-${meta.row}"
                data-id="${meta.row}"
                ${data.is_active == 1 ? "checked" : ""}
              >
              <label for="toggle-${meta.row}"></label>
            </div>
    `;
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

  $("#datatable").on("change", ".statusToggle", function () {
    var $this = $(this);
    var index = $this.data("id");
    var brand_id = res_DATA[index].brand_id;

    var previousState = !$this.is(":checked");
    var isChecked = $this.is(":checked") ? 1 : 0;

    Swal.fire({
      title: "Are you sure?",
      text: "You want to update the active status?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: base_Url + "deactivate-menu",
          data: {
            id: brand_id,
            column_name: "brand_id",
            tbl_name: "tbl_brand_master",
            active_status: isChecked,
          },
          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire("Success", resData.msg, "success");
              refreshDetails();
            } else {
              Swal.fire("Failure", resData.msg, "error");
              $this.prop("checked", previousState);
            }
          },
          error: function () {
            $this.prop("checked", previousState);
          },
        });
      } else {
        $this.prop("checked", previousState);
      }
    });
  });

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#model-data").modal("show");
    mode = "edit";

    var index = $(this).attr("id");
    console.log(index);
    $("#brand_name").val(res_DATA[index].brand_name);

    $("#brand_image_url").attr("src", base_Url + res_DATA[index].brand_img);
    $("#brand_image_url").addClass("active");
    $("#brand_image_url").css("display", "block");
    brand_id = res_DATA[index].brand_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    brand_id = res_DATA[index].brand_id;

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
          url: base_Url + "delete-brand-list",
          data: { brand_id: brand_id },

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
