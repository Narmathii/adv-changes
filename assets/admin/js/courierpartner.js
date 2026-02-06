$(document).ready(function () {
  var mode, JSON, res_DATA, courier_id;

  getCourierDetails();

  $.when(getCourierDetails()).done(function () {
    dispCourierDetails(JSON);
  });

  function refreshDetails() {
    $.when(getCourierDetails()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
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
    } else if ($("#c_url").val() == "") {
      $.toast({
        icon: "error",
        heading: "Error",
        text: "Please Enter Couerier link ",
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
  function getCourierDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-courier",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        dispCourierDetails(res_DATA);
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

    courier_id = res_DATA[index].courier_id;
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
