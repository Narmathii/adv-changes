$(document).ready(function () {
  var mode, JSON, res_DATA, order_id, dispStatus, PrintID;
  var orderID = "";

  $.when(getOrderList()).done(function () {
    dispOrderDetails(JSON);
  });

  function refreshDetails() {
    $.when(getOrderList()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  // *************************** [get Data] *************************************************************************
  function getOrderList() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-neworder",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        dispOrderDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispOrderDetails(JSON) {
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
          mDataProp: "order_no",
        },
        {
          mDataProp: "username",
        },
        {
          data: null,
          render: function (data, type, row) {
            return row.order_date + " " + row.order_time;
          },
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a  order-id = "' +
              data.order_id +
              '" id="' +
              meta.row +
              '" class="btn orderDetails text-info fs-14 lh-1"> <i class="fe fe-eye" data-bs-effect="effect-scale" data-bs-toggle="modal"></i> View</a>'
            );
          },
        },
        {
          mDataProp: function (data, type, full, meta) {
            var status = data.payment_status;

            var backgroundclr;
            if (status == "PENDING") {
              backgroundclr = "badge bg-warning";
            } else if (status == "COMPLETED") {
              backgroundclr = "badge bg-success";
            } else if (status == "FAILED") {
              backgroundclr = "badge bg-danger";
            } else if (status == "CANCELLED") {
              backgroundclr = "badge bg-danger";
            } else if (status == "REFUNDED") {
              backgroundclr = "badge bg-info";
            }
            return (
              '<a id="' +
              meta.row +
              '" class="btn" merchant-id="' +
              data.transaction_id +
              '" tnx-id="' +
              data.txnid +
              '" salt="' +
              data.salt +
              '"><span class="badge ' +
              backgroundclr +
              '">' +
              status +
              "</span></a>"
            );
          },
        },
        {
          mDataProp: "delivery_date",
        },
        {
          mDataProp: function (data, type, full, meta) {
            var status = data.delivery_status;

            var backgroundclr;
            if (status == "New") {
              backgroundclr = "badge bg-info";
            } else if (status == "Pending") {
              backgroundclr = "badge bg-warning";
            } else if (status == "Shipped") {
              backgroundclr = "badge bg-secondary-gradient";
            } else if (status == "Delivered") {
              backgroundclr = "badge bg-success";
            } else if (status == "Cancelled") {
              backgroundclr = "badge bg-danger";
            } else if (status == "Refund Created") {
              backgroundclr = "badge bg-warning";
            } else if (status == "Refund Processed") {
              backgroundclr = "badge bg-success";
            } else if (status == "Refund Failed") {
              backgroundclr = "badge bg-danger";
            }
            return (
              '<a id="' +
              meta.row +
              '" class="btn BtnOrdersts" merchant-id="' +
              data.transaction_id +
              '" tnx-id="' +
              data.txnid +
              '" salt="' +
              data.salt +
              '"><span class="badge ' +
              backgroundclr +
              '">' +
              status +
              "</span></a>"
            );
          },
        },
        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a id="' +
              meta.row +
              '" class="btn BtnEdit text-danger fs-14 lh-1"><i class="ri-edit-line"></i></a>' +
              '<a order-id="' +
              data.order_id +
              '" id="' +
              meta.row +
              '" class="btn BtnTrackView text-danger fs-14 lh-1"><i class="fe fe-eye" data-bs-effect="effect-scale"></i></a>' +
              '<a id="' +
              meta.row +
              '" class="btn BtnDelete text-danger fs-14 lh-1"><i class="ri-delete-bin-5-line"></i></a>'
            );
          },
        },
      ],
    });
  }
  // *************************** [Change delivery status] *************************************************************************

  $("#delivery_status").on("change", function () {
    var delivery_status = $("#delivery_status").val();
    if (delivery_status == 6) {
      $("#delivery-status").modal("hide");
      $("#cancel_product_modal").modal("show");
    }
  });

  // Cancel Reason
  $("#submit-reason").click(function () {
    var delivery_status = $("#delivery_status").val();
    let cancelReason = $("#cancel_reason").val();

    $.ajax({
      type: "post",
      url: base_Url + "update-cancel-reason",
      data: {
        order_id: orderID,
        cancelReason: cancelReason,
        delivery_status: delivery_status,
      },
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          Swal.fire({
            title: "Success",
            text: data.msg,
            icon: "success",
          });
          $("#delivery-status").modal("hide");
          $("#cancel_product_modal").modal("hide");
          location.reload();
        } else {
          Swal.fire({
            title: "Failure",
            text: data.msg,
            icon: "error",
          });
          $("#delivery-status").modal("hide");
          $("#cancel_product_modal").modal("hide");
        }
      },
    });
  });

  $(document).on("click", ".BtnOrdersts", function () {
    $("#delivery-status").modal("show");

    var index = $(this).attr("id");
    orderID = res_DATA[index].order_id;
  });

  $("#submit-status").click(function () {
    var delivery_status = $("#delivery_status").val();
    $.ajax({
      type: "post",
      url: base_Url + "update-delivery-status",
      data: { order_id: orderID, delivery_status: delivery_status },
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          location.reload();
        } else {
          Swal.fire({
            title: "Failure",
            text: data.msg,
            icon: "error",
          });
          $("#delivery-status").modal("hide");
        }
      },
    });
  });

  // *************************** [Check order status] *************************************************************************

  $(document).on("click", ".BtnOrdersts", function () {
    $tnxID = $(this).attr("tnx-id");
    $merchantID = $(this).attr("merchant-id");
    $salt = $(this).attr("salt");
  });

  // *************************** [Edit Data] *************************************************************************
  $(document).on("click", ".BtnEdit", function () {
    $("#tracking-order").modal("show");

    var index = $(this).attr("id");
    orderID = res_DATA[index].order_id;

    $.ajax({
      type: "post",
      url: base_Url + "get-trackingdetails",
      data: { order_id: orderID },

      success: function (data) {
        let result = $.parseJSON(data);
        if (result.code == 200) {
          $("#courier_partner").val(result.track_detail[0]["courier_partner"]);
          $("#tracking_id").val(result.track_detail[0]["tracking_id"]);
          // $("#coupon_code").val(result.track_detail[0]["coupon_code"]);
          let billDate = result.track_detail[0]["bill_date"];
          $("#bill_no").val(result.track_detail[0]["bill_no"]);
          let deliveryDate = result.track_detail[0]["delivery_date"];

          if (deliveryDate == "0000-00-00" || billDate == "0000-00-00") {
            $(".del-date").val("");
            $(".bill-date").val("");
          } else {
            $(".del-date").val(deliveryDate);
            $(".bill-date").val(billDate);
          }
        }
      },
    });
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    order_id = res_DATA[index].order_id;

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
          url: base_Url + "delete-orderlist",
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
  // *************************** [Order Details] *************************************************************************
  $(document).on("click", ".orderDetails", function () {
    $("#order_form").modal("show");
    var orderid = $(this).attr("order-id");
    PrintID = orderid;
    var index = $(this).attr("id");

    $.ajax({
      type: "POST",
      data: { order_id: orderid },
      url: base_Url + "get-order-details",
      success: function (data) {
        let viewOrder = $.parseJSON(data);
        $("#order-details tbody").html("");

        let sizee = viewOrder.length;

        // Address
        $("#user-name").html(viewOrder[0]["username"]);
        $("#email-data").html(viewOrder[0]["email"]);
        $("#order-date").html("Order Date -" + viewOrder[0]["order_date"]);

        $("#address").html(
          viewOrder[0]["address"] + " ," + viewOrder[0]["landmark"]
        );
        $("#city").html(viewOrder[0]["city"] + "," + viewOrder[0]["dist_name"]);
        $("#number").html(viewOrder[0]["number"]);
        $("#state_title").html(
          viewOrder[0]["state_title"] + "-" + viewOrder[0]["pincode"]
        );

        //Payment status
        $("#total-amt").html(
          "Total Amount - &#8377;" + viewOrder[0]["sub_total"]
        );
        $("#trans-id").html("Order ID -" + viewOrder[0]["order_no"]);
        $("#payment-id").html(
          "Payment ID -" + viewOrder[0]["razerpay_payment_id"]
        );

        var status = "";
        if (
          viewOrder[0]["payment_status"] == "FAILED" ||
          viewOrder[0]["payment_status"] == "CANCELLED"
        ) {
          status += `Payment Status - <span class="badge bg-danger-gradient">${viewOrder[0]["payment_status"]}</span>`;
        } else if (viewOrder[0]["payment_status"] == "PENDING") {
          status += `Payment Status - <span class="badge bg-warning">${viewOrder[0]["payment_status"]}</span>`;
        } else if (viewOrder[0]["payment_status"] == "REFUNDED") {
          status += `Payment Status - <span class="badge bg-info">${viewOrder[0]["payment_status"]}</span>`;
        } else {
          status += `Payment Status - <span class="badge bg-success">${viewOrder[0]["payment_status"]}</span>`;
        }

        $("#payment-sts").html("" + status);

        let tblData = "";
        for (i = 0; i < sizee; i++) {
          let size = viewOrder[i]["size"] != 0 ? viewOrder[i]["size"] : "";
          let className = viewOrder[i]["size"] != 0 ? " " : "d-none";
          let color =
            viewOrder[i]["color"] != 0 ? viewOrder[i]["color_name"] : "N/A";
          let classNamee = viewOrder[i]["color"] != 0 ? " " : "d-none";

          let OfferType = viewOrder[0]["offer_type"];
          let dispOffer;
          if (OfferType != "") {
            dispOffer =
              OfferType == 0
                ? "Percentage"
                : OfferType == 1
                ? "Flat Discount"
                : "none";
          } else {
            dispOffer = "none";
          }

          let dropShipp = viewOrder[0]["drop_shipping"];
          let dispDropShipping = dropShipp == 1 ? "DropShipping" : "Retail";

          tblData += `
          <tr>

           <td> 

          <div class="mb-1 fs-14 fw-semibold">
              <a href="javascript:void(0);">${i + 1}.</a>
          </div>

          </td>
          <td>
              <div class="d-flex align-items-center">
                  <div class="me-3">
                      <span class="avatar avatar-xxl bg-light">
                          <img src="${base_Url}${
            viewOrder[i]["config_image1"]
          }" alt="">
                      </span>
                  </div>
                 
              </div>
          </td>
          <td> 

          <div class="mb-1 fs-12 fw-semibold order-prodname">
              <a href="javascript:void(0);">${viewOrder[i]["product_name"]}</a>

          </div>
          
          <div class="fs-12 fw-semibold size ${className}">
              <p>Size : ${size}</p>
          </div>
          <div class="fs-1 fw-semibold color ${classNamee}">
              <p>Color : ${color}</p>
          </div>

          </td>

          <td>
              <span class="fs-15 fw-semibold">${
                viewOrder[i]["actual_price"]
              }</span>
          </td>
          <td>
          <span class="badge bg-danger-gradient">${dispOffer}</span></td>
          <td>${viewOrder[i]["offer_details"]}</td>
          <td>${viewOrder[i]["quantity"]}</td>
          <td><span class="badge bg-danger-gradient">${dispDropShipping}</span></td>
          <td style="text-align:right">₹${viewOrder[i]["product_price"]}</td>
         
      </tr>
     
      
  </tr>`;
          $("#order-details tbody").html(tblData);
        }

        const totalAmt = `
        <tr>
          <td colspan="3"></td>
          <td colspan="3">
               <div class="fw-semibold" style="text-align: right;">Delivery Charge(${viewOrder[0]["courier_type"]}) :</div>
          </td>
          <td colspan="3" style="text-align: right;">
              <span class="fs-16 fw-semibold"> ₹${viewOrder[0]["courier_charge"]}</span>
          </td>
        </tr>

        <tr>
          <td colspan="3"></td>
          <td colspan="3">
              <div class="fw-semibold" style="text-align: right;">Total Price :</div>
          </td>
          <td colspan="3" style="text-align: right;">
              <span class="fs-16 fw-semibold"> ₹${viewOrder[0]["sub_total"]}</span>
          </td>
        </tr>
       `;

        $("#order-details tbody").append(totalAmt);
      },
      error: function () {
        console.log("Error");
      },
    });
  });

  // *************************** [Submit Tracking Detail] *************************************************************************
  $("#submit-track").click(function () {
    if ($("#courier_partner").val() == "") {
      $(".courier_partner").html("Please Enter the Courier Partner");
    } else if ($("#tracking_id").val() == "") {
      $(".tracking_id").html("Please Enter the Tracking ID");
    } else {
      insertTrackingDetails();
    }
  });

  function insertTrackingDetails() {
    var form = $("#tracking-form")[0];
    data = new FormData(form);
    data.append("order_id", orderID);

    $.ajax({
      type: "POST",
      data: data,
      url: base_Url + "update-trackingdetail",
      dataType: "json",
      processData: false,
      contentType: false,

      success: function (data) {
        if (data.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: data.msg,
            icon: "success",
          });
          $("#tracking-order").modal("hide");
          location.reload();
        } else {
          Swal.fire({
            title: "Failure!",
            text: data.msg,
            icon: "danger",
          });
          $("#tracking-order").modal("hide");
        }
      },
    });
  }

  // *************************** [View Tracking Detail] *************************************************************************

  $(document).on("click", ".BtnTrackView", function () {
    $("#tracking-view").modal("show");

    var orderid = $(this).attr("order-id");

    $.ajax({
      type: "POST",
      data: { order_id: orderid },
      url: base_Url + "view-trackingdetail",
      dataType: "json",

      success: function (data) {
        $("#tracking-details tbody").empty();
        let tblData = "";
        tblData += `
        <tr>
       <td>${data[0]["courier_partner"]}</td>
       <td>${data[0]["tracking_id"]}</td>
    
         <td>${data[0]["delivery_date"]}</td>
          <td>${data[0]["delivery_message"]}</td>
           <td>${data[0]["bill_no"]}</td>
          <td>${data[0]["bill_date"]}</td>
       </tr>`;

        $("#tracking-details tbody").append(tblData);
      },
    });
  });

  // *************************** [Print Details] *************************************************************************
  $("#btn-print").click(function () {
    let print_id = PrintID;
    var encodedPrintID = btoa(print_id);
    var pdfURL = base_Url + "pdf-viewpage/" + encodedPrintID;

    var printWindow = window.open(pdfURL, "_blank");

    if (printWindow) {
      printWindow.print();
      printWindow.onafterprint = function () {
        printWindow.close();
      };
    } else {
      alert("Popup blocked! Please allow popups for this site.");
    }
  });
});
