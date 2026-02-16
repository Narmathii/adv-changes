$(document).ready(function () {
  var mode, JSON, res_DATA, h_submenu_id;

  getSubMenuList();

  $.when(getSubMenuList()).done(function () {
    dispSubMenuList(JSON);
  });

  function refreshDetails() {
    $.when(getSubMenuList()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  $("#addData").click(function () {
    mode = "new";
    $("#model-data").val("");
    $("#model-data").modal("show");
    $("#modal_image_url").css("display", "none");
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();

    if ($("#h_menu_id").val() === "" && mode == "new") {
      $(".h_menu_id").html("Please Select Menu*").show();
    } else if ($("#h_submenu").val() === "" && mode == "new") {
      $(".h_submenu").html("Please Enter SubMenu*").show();
    } else if ($("#hsubmenu_img").val() === "" && mode == "new") {
      $(".hsubmenu_img").html("Please Select Image*").show();
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
      url = base_Url + "insert-helmet-submenu";
    } else if (mode == "edit") {
      url = base_Url + "update-helmet-submenu";
      data.append("h_submenu_id", h_submenu_id);
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
  function getSubMenuList() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-helmet-submenu",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        dispSubMenuList(res_DATA);
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
          mDataProp: "h_menu",
        },
        {
          mDataProp: "h_submenu",
        },
        {
          mDataProp: function (data, type, full, meta) {
            if (data.hsubmenu_img !== null)
              return (
                "<a href='" +
                base_Url +
                data.hsubmenu_img +
                "'><img src='" +
                base_Url +
                data.hsubmenu_img +
                "' alt='not-image' width='100'></a>"
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
  // *************************** [Display the image on Modal ] ****************************************************

  $("#hsubmenu_img").on("change", function () {
    dispImg(this, "modal_image_url");
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#model-data").modal("show");
    mode = "edit";

    var index = $(this).attr("id");

    $("#h_menu_id").val(res_DATA[index].h_menu_id);
    $("#h_submenu").val(res_DATA[index].h_submenu);

    $("#modal_image_url").attr("src", base_Url + res_DATA[index].hsubmenu_img);
    $("#modal_image_url").addClass("active");
    $("#modal_image_url").css("display", "block");

    h_submenu_id = res_DATA[index].h_submenu_id;
    console.log(h_submenu_id);
  });

  $("#datatable").on("change", ".statusToggle", function () {
  var $this = $(this);
  var index = $this.data("id");
  var h_submenu_id = res_DATA[index].h_submenu_id;
  var h_menu_id = res_DATA[index].h_menu_id;

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
          menu_id: h_menu_id,
          sub_menu_id: h_submenu_id,
          menu_col: "h_menu_id",
          sub_menu_col: "h_submenu_id",
          tbl_name: "tbl_helmet_submenu",
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
    h_submenu_id = res_DATA[index].h_submenu_id;

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
          url: base_Url + "del-helmet-submenu",
          data: { h_submenu_id: h_submenu_id },

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
