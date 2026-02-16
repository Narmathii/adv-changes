$(document).ready(function () {
  var mode, JSON, res_DATA, r_sub_id;

  getSubMenuList(function (subMenuDetails) {
    dispSubMenuList(subMenuDetails);
  });

  function refreshDetails() {
    var currentPage = 0;

    if ($.fn.DataTable.isDataTable("#datatable")) {
      currentPage = $("#datatable").DataTable().page();
    }
    getSubMenuList(function (subMenuDetails) {
      dispSubMenuList(subMenuDetails);

      var table = $("#datatable").DataTable();
      var pageInfo = table.page.info();
      var targetPage = Math.min(currentPage, Math.max(pageInfo.pages - 1, 0));
      table.page(targetPage).draw("page");
    });
  }

  $("#addData").click(function () {
    mode = "new";
    $("#model-data").val("");
    $("#model-data").modal("show");
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();

    if ($("#r_menu_id").val() === "" && mode == "new") {
      $(".r_menu_id").html("Please Select Menu*").show();
    }
    if ($("#r_sub_menu").val() === "" && mode == "new") {
      $(".r_sub_menu").html("Please Enter SubMenu*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#submenu-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-submenu-list";
    } else if (mode == "edit") {
      url = base_Url + "update-submenu-list";
      data.append("r_sub_id", r_sub_id);
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

  // *************************** [get Data] *************************************************************************
  function getSubMenuList(callback) {
    return $.ajax({
      type: "POST",
      url: base_Url + "get-submenu-list",
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

  function dispSubMenuList(JSON) {
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
          mDataProp: "r_menu",
        },
        {
          mDataProp: "r_sub_menu",
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#model-data").modal("show");
    mode = "edit";

    var index = $(this).attr("id");

    $("#r_menu_id").val(res_DATA[index].r_menu_id);
    $("#r_sub_menu").val(res_DATA[index].r_sub_menu);

    r_sub_id = res_DATA[index].r_sub_id;
  });

 $("#datatable").on("change", ".statusToggle", function () {
  var $this = $(this);
  var index = $this.data("id");
  var r_sub_id = res_DATA[index].r_sub_id;
  var r_menu_id = res_DATA[index].r_menu_id;

  var previousState = !$this.is(":checked"); // state before change
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
        url: base_Url + "deactivate-submenu",
        data: {
          menu_id: r_menu_id,
          sub_menu_id: r_sub_id,
          menu_col: "r_menu_id",
          sub_menu_col: "r_sub_id",
          tbl_name: "tbl_riding_submenu",
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
        }
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
    r_sub_id = res_DATA[index].r_sub_id;

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
          url: base_Url + "delete-submenu-list",
          data: { r_sub_id: r_sub_id },

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
                icon: "danger",
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
