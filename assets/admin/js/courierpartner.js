$(document).ready(function () {
  var mode, res_DATA, courier_id;

  getCourierDetails(function (courierDetails) {
    dispCourierDetails(courierDetails);
  });

  function refreshDetails() {
    var currentPage = 0;

    if ($.fn.DataTable.isDataTable("#datatable")) {
      currentPage = $("#datatable").DataTable().page();
    }

    getCourierDetails(function (courierDetails) {
      dispCourierDetails(courierDetails);

      var table = $("#datatable").DataTable();
      var pageInfo = table.page.info();
      var targetPage = Math.min(currentPage, Math.max(pageInfo.pages - 1, 0));
      table.page(targetPage).draw("page");
    });
  }

  $("#addData").click(function () {
    mode = "new";
    $("#courier_modal").modal("show");
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    if ($("#courier_name").val() == "") {
      $.toast({
        icon: "error",
        heading: "Error",
        text: "Please Enter Couerier Name ",
        position: "top-right",
        bgColor: "#red",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
    } else if ($("#disp_order").val() == "") {
      $.toast({
        icon: "error",
        heading: "Error",
        text: "Please Enter Display Order",
        position: "top-right",
        bgColor: "#red",
        loader: true,
        hideAfter: 2000,
        stack: false,
        showHideTransition: "fade",
      });
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#courier_form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-courier";
    } else if (mode == "edit") {
      url = base_Url + "update-courier";
      data.append("courier_id", courier_id);
    }

    $.ajax({
      type: "POST",
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

          $("#courier_modal").modal("hide");

          refreshDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#courier_modal").modal("hide");
          refreshDetails();
        }
      },
    });
  }

  // *************************** [get Data] *************************************************************************
  function getCourierDetails(callback) {
    return $.ajax({
      type: "POST",
      url: base_Url + "get-courier",
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

  function dispCourierDetails(JSON) {
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
          mDataProp: "courier_name",
        },
        {
          mDataProp: "c_url",
        },
        {
          mDataProp: function (data) {
            return data.disp_order ?? "";
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
                ${parseInt(data.active_status, 10) === 1 ? "checked" : ""}
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#courier_modal").modal("show");
    mode = "edit";

    var index = $(this).attr("id");

    $("#courier_name").val(res_DATA[index].courier_name);
    $("#c_url").val(res_DATA[index].c_url);
    $("#disp_order").val(res_DATA[index].disp_order);

    courier_id = res_DATA[index].courier_id;
  });

  $("#datatable").on("change", ".statusToggle", function () {
    var $this = $(this);
    var index = $this.data("id");
    var currentCourierId = res_DATA[index].courier_id;
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
          url: base_Url + "update-courier-status",
          data: {
            courier_id: currentCourierId,
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

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    courier_id = res_DATA[index].courier_id;

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
          url: base_Url + "delete-courier",
          data: { courier_id: courier_id },

          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });
              $("#courier_modal").modal("hide");
              refreshDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "danger",
              });
              $("#courier_modal").modal("hide");
              refreshDetails();
            }
          },
        });
      }
    });
  });
});
