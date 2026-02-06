$(document).ready(function () {
  var mode, JSON, res_DATA, order_id, acc_id;

  $.when(getPaymentList()).done(function () {
    dispPaymentList(JSON);
  });

  function refreshDetails() {
    $.when(getPaymentList()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  // *************************** [get Data] *************************************************************************
  function getPaymentList() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-payment-list",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        dispPaymentList(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispPaymentList(JSON) {
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
          mDataProp: "order_no",
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a  order-id = "' +
              data.order_id +
              '" id="' +
              meta.row +
              '" class="btn paymentDetails text-info fs-14 lh-1"> <i class="fe fe-eye" data-bs-effect="effect-scale" data-bs-toggle="modal"></i> View</a>'
            );
          },
        },
        {
          mDataProp: function (data, type, row) {
            // Assuming 'data' is a number
            return data.sub_total.toLocaleString("en-US", {
              style: "currency",
              currency: "USD",
            });
          },
        },

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

  // *************************** [View Payment Details] *************************************************************************

  $(document).on("click", ".paymentDetails", function () {
    $("#model-data").modal("show");
    var index = $(this).attr("id");

    $("#payment_id").val(res_DATA[index]["razerpay_payment_id"]);
    $("#method").val(res_DATA[index]["payment_method"]);
    $("#time").val(res_DATA[index]["payment_time"]);
  });
  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    order_id = res_DATA[index].order_id;

    const result = Swal.fire({
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
          url: base_Url + "delete-payment-list",
          data: { order_id: order_id },

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

  // *************************** [Filter Data] *************************************************************************

  $("#filter-btn").click(function () {
    let filterDate = $("#date").val();

    $.ajax({
      type: "POST",
      url: base_Url + "filter-payment-list",
      data: { filter_date: filterDate },
      dataType: "json",

      success: function (data) {
        dispPaymentList(data);
      },
      error: function (jqXHR, textStatus, errorThrown) {},
    });
  });
});
