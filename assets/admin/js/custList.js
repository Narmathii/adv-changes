$(document).ready(function () {
  var mode, JSON, res_DATA, add_id;

  $.when(getCustList()).done(function () {
    dispCustList(JSON);
  });

  function refreshDetails() {
    $.when(getCustList()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  //   $("#addUserData").click(function () {
  //     mode = "new";
  //     $("#state_modal").modal("show");
  //   });

  // *************************** [Validation] ********************************************************************

  function displayError() {
    $.toast({
      icon: "error",
      heading: "Error",
      text: "Please Enter State ",
      position: "top-right",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }
  $("#update-btn").click(function () {
    if ($("#address").val() == "") {
      displayError("Please Fill Address");
    } else if ($("#landmark").val() == "") {
      displayError("Please Enter Landmark");
    } else if ($("#city").val() == "") {
      displayError("Please Enter city");
    } else if ($("#district").val() == "") {
      displayError("Please Enter district");
    } else if ($("#state").val() == "") {
      displayError("Please Enter state");
    } else if ($("#pincode").val() == "") {
      displayError("Please Enter pincode");
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#addr-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-state-";
    } else if (mode == "edit") {
      url = base_Url + "update-cust-address";
      data.append("add_id", add_id);
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

          $("#state_modal").modal("hide");

          refreshDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#state_modal").modal("hide");
          refreshDetails();
        }
      },
    });
  }

  // *************************** [get Data] *************************************************************************
  function getCustList() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-custlist",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        console.log(res_DATA);
        dispCustList(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispCustList(JSON) {
    console.log(JSON);
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
          mDataProp: "username",
        },
        {
          mDataProp: "email",
        },
        {
          mDataProp: "number",
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a id="' +
              meta.row +
              '" class="btn btnAddress text-info fs-14 lh-1"> <i class="fe fe-eye" data-bs-effect="effect-scale" data-bs-toggle="modal"></i> View</a>'
            );
          },
        },

        // {
        //   mDataProp: function (data, type, full, meta) {
        //     var status = data.status;
        //     var badgeClass =
        //       status == 1 ? "bg-success-gradient" : "bg-danger-gradient";
        //     var statusText = status == 1 ? "Active" : "Deactive";
        //     return (
        //       '<a id="' +
        //       meta.row +
        //       '">' +
        //       '<span class="badge ' +
        //       badgeClass +
        //       '">' +
        //       statusText +
        //       "</span>" +
        //       "</a>"
        //     );
        //   },
        // },

        {
          mDataProp: function (data, type, full, meta) {
            return (
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
    $("#addr-modal").modal("show");
    mode = "edit";
    var index = $(this).attr("id");
    $("#address").val(res_DATA[index].address);
    $("#landmark").val(res_DATA[index].landmark);
    $("#city").val(res_DATA[index].city);
    $("#district").val(res_DATA[index].dist_name);
    $("#state").val(res_DATA[index].state_title);
    $("#pincode").val(res_DATA[index].pincode);
    add_id = res_DATA[index].add_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    user_id = res_DATA[index].user_id;

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
          url: base_Url + "delete-custlist",
          data: { user_id: user_id },

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

  // *************************** [View Address] *************************************************************************

  $(document).on("click", ".btnAddress", function () {
    $("#addr-modal").modal("show");
    mode = "edit";
    var index = $(this).attr("id");
    console.log(res_DATA);

    let defaultAddr = res_DATA[index].default_addr;
    let status = defaultAddr == 1 ? "checked" : "";

    let checkedsts = "";
    checkedsts += `<input class="form-check-input me-1" type="radio" value="1"  ${status} >`;
    $("default_addr").html(checkedsts);

    $("#address").val(res_DATA[index].address);
    $("#landmark").val(res_DATA[index].landmark);
    $("#city").val(res_DATA[index].city);
    $("#district").val(res_DATA[index].dist_name);
    $("#state").val(res_DATA[index].state_title);
    $("#pincode").val(res_DATA[index].pincode);

    add_id = res_DATA[index].add_id;
  });
});
