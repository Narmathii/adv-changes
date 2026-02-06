$(document).ready(function () {
  var mode, JSON, res_DATA, prod_id, config_Data, config_id, Overallcolors;

  getColors();
  function getColors() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-color",
      dataType: "json",
      success: function (data) {
        Overallcolors = data;
        if (data.length == "") {
          config_Data = 0;
        } else {
          config_Data = data;
        }
      },
      error: function () {
        console.log("Error");
      },
    });
  }

  prodDesc.setData("");
  specificationss.setData("");

  $('input[type="radio"]').click(function () {
    var radioBtn = $(this).attr("id");
    console.log(radioBtn);
  });

  $.when(getproductDetails()).done(function () {
    dispproductDetails(JSON);
  });

  function refreshDetails() {
    $.when(getproductDetails()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  $("#addData").click(function () {
    mode = "new";

    $("#parent-config").empty();
    $("#product-main")[0].reset();
    prodDesc.setData("");
    specificationss.setData("");

    // Reset main product image
    $("#product_img").val("");
    $("#product_image_url").attr("src", "").hide();
    for (let i = 1; i <= 10; i++) {
      $("#img_" + i).val("");
      $("#img" + i + "_url")
        .attr("src", "")
        .hide();
    }

    $("#model-data").modal("show");
  });

  //Filter  Submenu
  $("#camp_menu_id").change(function () {
    let camp_menu_id = $(this).val();
    if (mode == "new") {
      $.ajax({
        type: "POST",
        url: base_Url + "gett-camping-submenu",
        data: { camp_menu_id: camp_menu_id },
        success: function (data) {
          var res = $.parseJSON(data);
          var subMenu = "";

          for (let i = 0; i < res.length; i++) {
            subMenu += `
              <option value="${res[i]["c_submenu_id"]}">${res[i]["c_submenu"]}</option>`;
          }
          $("#c_submenu_id").html(subMenu);
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "gett-camping-submenu",
        data: { camp_menu_id: camp_menu_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var subMenu = "";

          subMenu += `<option value="${csubMenuID}">${csubMenu}</option>`;
          for (let i = 0; i < res.length; i++) {
            subMenu += `<option value="${res[i]["c_submenu_id"]}">${res[i]["c_submenu"]}</option>`;
          }

          $("#c_submenu_id").html(subMenu);
        },
      });
    }
  });

  // *************************** [Offer price CALCULATION] ********************************************************************

  $("#offer_type").change(function () {
    $offerType = $("#offer_type").val();

    if ($offerType == 1) {
      $("#offer_details").val("");
      $("#offer_details").attr("readonly", true);
      $("#offer_price").val("");
    } else if ($offerType == 2) {
      $("#offer_details").val("");
      $("#offer_details").attr("readonly", true);
      let originalAmt = $("#product_price").val();
      $("#offer_details").html(originalAmt);
      $("#offer_price").val(originalAmt);
    } else {
      $("#offer_details").attr("readonly", false);
    }
  });

  $("#offer_details").change(function () {
    let offerDetail = $("#offer_details").val();
    let OriginalAmt = $("#product_price").val();

    let offerAmount = OriginalAmt - (OriginalAmt * offerDetail) / 100;
    let offerAmt = offerAmount.toFixed(2);

    $("#offer_price").val(offerAmt);
  });

  // Search Brand Option
  $("#search_brand").change(function () {
    let searchBrand = $("#search_brand").val();
    $("#offer_type").val("");
    $("#offer_details").val("");
    $("#offer_price").val("");
    $.ajax({
      type: "POST",
      url: base_Url + "get-offerprice",
      data: { search_brand: searchBrand },
      success: function (data) {
        var res = $.parseJSON(data);

        if (res["code"] == 200) {
          let offer = res["offer"];

          $("#offer_type").val(0);

          let discountAmt = offer % 100;

          $("#offer_details").val(offer);
          let OriginalAmt = $("#product_price").val();
          let offerAmount = OriginalAmt - (OriginalAmt * discountAmt) / 100;
          let offerAmt = offerAmount.toFixed(2);
          $("#offer_price").val(offerAmt);
        }
      },
    });
  });

  // # *************************** [Prod Configuration] *************************************************************************

  var count = 0;
  var inc = 0;
  $(document).on("click", "#btn-addConfig", function () {
    if (mode == "new") {
      count++;
    } else if (mode == "edit") {
      var index = $(this).attr("index");
      inc++;
    }

    var Config = `
                <div class="mb-3 mt-3 field-set d-flex justify-content-between" id="Field${count}">
                    <div class="col-lg-4">
                        <label for="size_${count}" class="form-label">Size</label><br>
                        <input type="text" class="form-control size" id="size_${count}" placeholder="Size" name="size[]" value="">
                        <span class="error text-danger size mt-10"></span>
                    </div>

                    <div class="col-lg-4">
                                                <label for="soldout_status_${count}" class="form-label">Stock status
                                                </label><br>
                                                <input type="text" class="form-control size" id="soldout_statuss_${count}"
                                                    placeholder="Available stocks" name="soldout_status[]">
                                                <span class="error text-danger soldout_statuss mt-10"></span>
                                            </div>
                    <div class="col-lg-2 mt-12">
                        <button class="btn btn-danger delete-size" data-id="${count}">Delete</button>
                    </div>
                </div>
                </div>`;

    $("#parent-config").append(Config);
  });

  // Delete config field
  $(document).on("click", ".delete-size", function () {
    var id = $(this).data("id");
    $("#Field" + id).remove();
    $("#Field2_" + id).remove();
  });

  // *************************** [Validation] ********************************************************************

  function validateError(data) {
    $.toast({
      icon: "error",
      heading: "Warning",
      text: data,
      position: "bottom-left",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#camp_menu_id").val() === "" && mode == "new") {
      validateError("Please Select Menu");
    }
    // else if ($("#c_submenu_id").val() === "" && mode == "new") {
    //   validateError("Please Select SubMenu");
    // } else if ($("#billing_name").val() === "" && mode == "new") {
    //   validateError("Please Enter Billing name*");
    // }
    else if ($("#product_name").val() === "" && mode == "new") {
      validateError("Please Enter short name*");
    }
    // else if ($("#product_price").val() === "" && mode == "new") {
    //   validateError("Please Enter Price*");
    // } else if ($("#offer_type").val() === "" && mode == "new") {
    //   validateError("Please Select offer type*");
    // } else if ($("#offer_price").val() === "" && mode == "new") {
    //   validateError("Please Enter Offer Price*");
    // } else if ($("#arrival_status").val() === "" && mode == "new") {
    //   validateError("Please Select inventory status*");
    // } else if ($("#stock_status").val() === "" && mode == "new") {
    //   validateError("Please Select stock_status*");
    // } else if ($("#redirect_url").val() === "" && mode == "new") {
    //   validateError("Please Enter url*");
    // } else if ($("#quantity").val() === "" && mode == "new") {
    //   validateError("Please Enter quantity*");
    // } else if ($("#weight").val() === "" && mode == "new") {
    //   validateError("Please Enter weight*");
    // } else if ($("#weight_units").val() === "" && mode == "new") {
    //   validateError("Please Select Units*");
    // }
    else if ($("#product_img").val() === "" && mode == "new") {
      validateError("Please Select Product Image*");
    }

    // Product Details
    // else if ($("#img_1").val() === "" && mode == "new") {
    //   validateError("Please Select  Image*");
    // } else if ($("#img_2").val() === "" && mode == "new") {
    //   validateError("Please Select  Image*");
    // } else if ($("#img_3").val() === "" && mode == "new") {
    //   validateError("Please Select  Image*");
    // } else if ($("#img_4").val() === "" && mode == "new") {
    //   validateError("Please Select  Image*");
    // } else if (prodDesc.getData() === "" && mode == "new") {
    //   validateError("Please Enter Product Description*");
    // } else if ($("#search_brand").val() === "" && mode == "new") {
    //   validateError("Please Enter Search Filter*");
    // }
    else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#product-main")[0];
    data = new FormData(form);

    let proddesc = prodDesc.getData();
    let specification = specificationss.getData();
    let hotsale = $("#hot_sale").prop("checked");
    let hdata = hotsale ? 1 : 0;

    var url;
    if (mode == "new") {
      url = base_Url + "insert-camp-products";
      data.append("prod_desc", proddesc);
      data.append("specifications", specification);
      data.append("hot_sale", hdata);
    } else if (mode == "edit") {
      url = base_Url + "update-camp-products";
      data.append("prod_id", prod_id);
      data.append("config_id", config_id);
      data.append("prod_desc", proddesc);
      data.append("specifications", specification);
      data.append("hot_sale", hdata);
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

          getproductDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "error",
          });

          $("#model-data").modal("hide");
          getproductDetails();
        }
      },
    });
  }
  // *************************** [Prevent modal form closing ] ****************************************************
  $("#model-data").modal({
    backdrop: "static",
    keyboard: false,
  });

  // *************************** [Display the image on Modal ] ****************************************************

  $(document).on("change", "#product_img", function () {
    dispImg(this, "product_image_url");
  });

  $(document).on("change", "#img_1", function () {
    dispImg(this, "img1_url");
  });
  $(document).on("change", "#img_2", function () {
    dispImg(this, "img2_url");
  });
  $(document).on("change", "#img_3", function () {
    dispImg(this, "img3_url");
  });
  $(document).on("change", "#img_4", function () {
    dispImg(this, "img4_url");
  });
  $(document).on("change", "#img_5", function () {
    dispImg(this, "img5_url");
  });
  $(document).on("change", "#img_6", function () {
    dispImg(this, "img6_url");
  });
  $(document).on("change", "#img_7", function () {
    dispImg(this, "img7_url");
  });
  $(document).on("change", "#img_8", function () {
    dispImg(this, "img8_url");
  });
  $(document).on("change", "#img_9", function () {
    dispImg(this, "img9_url");
  });
  $(document).on("change", "#img_10", function () {
    dispImg(this, "img10_url");
  });

  // Images based on color
  $(document).on("change", "#config_img1", function () {
    dispImg(this, "config_img1_url");
  });
  $(document).on("change", "#config_img2", function () {
    dispImg(this, "config_img2_url");
  });
  $(document).on("change", "#config_img3", function () {
    dispImg(this, "config_img3_url");
  });
  $(document).on("change", "#config_img4", function () {
    dispImg(this, "config_img4_url");
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
  function getproductDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-cproducts",
      dataType: "json",
      success: function (data) {
        res_DATA = data;

        dispproductDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispproductDetails(JSON) {
    var i = 1;
    $("#datatable").DataTable({
      destroy: true,
      stateSave: true,
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
          mDataProp: "camp_menu",
        },
        {
          mDataProp: "c_submenu",
        },
        {
          mDataProp: "product_name",
        },
        {
          mDataProp: "offer_price",
        },

        {
          mDataProp: function (data, type, full, meta) {
            if (data.product_img !== null && data.product_img !== "") {
              return (
                "<img src='" +
                base_Url +
                data.product_img +
                "' alt='not-image' width='100'>"
              );
            } else {
              return "";
            }
          },
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a id="' +
              meta.row +
              '" class="btn btnView text-info fs-14 lh-1"> <i class="fe fe-eye"></i></a>' +
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
  // *************************** [View  Data] *************************************************************************
  $(document).on("click", ".btnView", function () {
    $("#model-view").modal("show");
    $("#description").empty();
    $("#specificaion-view").empty();
    var index = $(this).attr("id");

    $("#description").append(res_DATA[index].prod_desc);
    $("#offer").html(res_DATA[index].offer_details);
    $("#offer-price").html(res_DATA[index].offer_price);
    $("#billing-name").html(res_DATA[index].billing_name);

    $("#search-brand").html(res_DATA[index].search_brand);
    $("#specificaion-view").append(res_DATA[index].specifications);

    // Stock status view
    let sold_sts = res_DATA[index].stock_status;
    let status;
    let bgcolor;
    if (sold_sts == 0) {
      status = "Out of stock";
      bgcolor = "bg-danger";
    } else if (sold_sts == 1) {
      status = "Available";
      bgcolor = "bg-success";
    } else if (sold_sts == 2) {
      status = "contact us to order";
      bgcolor = "bg-primary";
    }
    $("#soldout-status").html(
      `<span class="badge rounded-pill ${bgcolor} "
      }">${status}</span></a>`
    );
    // Stock status view end

    let arrival_sts = res_DATA[index].arrival_status;
    $("#arrival-status").html(
      `<span class="badge rounded-pill ${
        arrival_sts == 1 ? "btn-success" : "btn-warning"
      }">${arrival_sts == 1 ? "New Arrival" : "current"}</span>`
    );

    let offerTypee = res_DATA[index].offer_type;
    let offername;
    if (offerTypee == 0) {
      offername = "Percentage(%)";
    } else if (offerTypee == 1) {
      offername = "Flat discount";
    } else if (offerTypee == 2) {
      offername = "None";
    }

    let badgeClass =
      offerTypee == 0
        ? "badge bg-primary-gradient"
        : "badge bg-purple-gradient";

    $("#offer-typee").html(
      `<span class="badge rounded-pill ${badgeClass}">${offername}</span>`
    );

    //  display image
    let imgRow = "";
    let row1 = "<tr>";
    let row2 = "<tr>";

    for (let i = 1; i <= 10; i++) {
      let img = res_DATA[index][`img_${i}`];
      if (img) {
        const imgTag = `<td><img width="130px" src="${base_Url}${img}" alt="Image ${i}"></td>`;
        if (i <= 5) {
          row1 += imgTag;
        } else {
          row2 += imgTag;
        }
      }
    }

    row1 += "</tr>";
    row2 += "</tr>";
    imgRow = row1 + row2;

    $("#tbl-img tbody").html(imgRow);

    // Specification
    // let tblSpecific = "";
    // let material = res_DATA[index].material;
    // let color = res_DATA[index].color_name;
    // let prod_weight = res_DATA[index].prod_weight;
    // let measurement = res_DATA[index].measurement;
    // let fitment = res_DATA[index].fitment;
    // let warranty = res_DATA[index].warrenty;

    // tblSpecific += `<tr>
    //                     <td>Material</td>
    //                     <td>${material}</td>
    //                  </tr>
    //                  <tr>
    //                     <td>Color</td>
    //                     <td>${color}</td>
    //                  </tr>
    //                  <tr>
    //                     <td>Product weight (kg)</td>
    //                     <td>${prod_weight}</td>
    //                  </tr>
    //                  <tr>
    //                     <td>Product measurement L*B*H (cm)</td>
    //                     <td>${measurement}</td>
    //                  </tr>
    //                  <tr>
    //                     <td>Fitment</td>
    //                     <td>${fitment}</td>
    //                  </tr>
    //                  <tr>
    //                     <td>Warranty</td>
    //                     <td>${warranty}</td>
    //                  </tr>`;

    // $("#specific tbody").html(tblSpecific);

    // $("#product-feature").append(res_DATA[index].features);
  });

  // *************************** [Edit Data] *************************************************************************

  var csubMenuID;
  var csubMenu;

  $(document).on("click", ".btnEdit", function () {
    let Config = "";
    $("#parent-config").empty();
    $("#product-main")[0].reset();
    $("#model-data").modal("show");

    mode = "edit";

    var index = $(this).attr("id");

    $("#btn-addConfig").attr("index", index);

    var cmenuID = res_DATA[index].camp_menu_id;
    csubMenuID = res_DATA[index].c_submenu_id;
    csubMenu = res_DATA[index].c_submenu;
    $("#camp_menu_id").val(cmenuID).trigger("change");

    $("#billing_name").val(res_DATA[index].billing_name);
    $("#product_name").val(res_DATA[index].product_name);
    $("#redirect_url").val(res_DATA[index].redirect_url);
    $("#product_price").val(res_DATA[index].product_price);
    $("#drop_shipping").val(res_DATA[index].drop_shipping);

    $("#offer_type").val(res_DATA[index].offer_type);
    var offerType = res_DATA[index].offer_type;
    if (offerType == 1) {
      $("#offer_details").val("");
      $("#offer_details").attr("readonly", true);
    } else if (offerType == 2) {
      $("#offer_details").val("");
      $("#offer_details").attr("readonly", true);
      let originalAmt = $("#product_price").val();
      $("#offer_details").html(originalAmt);
      $("#offer_price").val(originalAmt);
    } else {
      $("#offer_details").attr("readonly", false);
    }

    // new data
    $("#quantity").val(res_DATA[index].quantity);
    $("#weight").val(res_DATA[index].weight);
    $("#weight_units").val(res_DATA[index].weight_units);

    $("#specifications").val(res_DATA[index].specifications);
    specificationss.setData(res_DATA[index].specifications);

    let x;
    for (x = 1; x <= 10; x++) {
      let imgValue = res_DATA[index][`img_${x}`]?.trim() || "";

      if (!imgValue) {
        $("#img" + x + "_url").attr("src", "");
        $("#img" + x + "_url").removeClass("active");
        $("#img" + x + "_url").css("display", "none");
      } else {
        $("#img" + x + "_url").attr("src", base_Url + imgValue);
        $("#img" + x + "_url").addClass("active");
        $("#img" + x + "_url").css("display", "block");
      }
    }

    // new data End

    $("#offer_price").val(res_DATA[index].offer_price);
    $("#offer_details").val(res_DATA[index].offer_details);
    $("#arrival_status").val(res_DATA[index].arrival_status);
    $("#soldout_status").val(res_DATA[index].soldout_status);

    $("#stock_status").val(res_DATA[index].stock_status);

    // product img
    $("#product_image_url").attr("src", base_Url + res_DATA[index].product_img);
    $("#product_image_url").addClass("active");
    $("#product_image_url").css("display", "block");
    // images

    $("#prod_desc").val(res_DATA[index].prod_desc);
    prodDesc.setData(res_DATA[index].prod_desc);

    $("#search_brand").val(res_DATA[index].search_brand);

    // $("#features").val(res_DATA[index].features);
    // featuress.setData(res_DATA[index].features);

    // specification
    $("#material").val(res_DATA[index].material);

    var color = "";
    color += `<option value="${res_DATA[index].colour}?>${res_DATA[index].color_name}</option>`;
    $("#colour").val(res_DATA[index].colour);

    $("#prod_weight").val(res_DATA[index].prod_weight);
    $("#measurement").val(res_DATA[index].measurement);
    $("#fitment").val(res_DATA[index].fitment);
    $("#warrenty").val(res_DATA[index].warrenty);
    var updatehotSale = res_DATA[index].hot_sale;

    if (updatehotSale == 1) {
      $("#hot_sale").prop("checked", true);
    } else {
      $("#hot_sale").prop("checked", false);
    }

    prod_id = res_DATA[index].prod_id;
    config_id = res_DATA[index].config_id;

    // Prod Configuration Data

    let size = $.parseJSON(res_DATA[index].size); // Ensure res_DATA[index].size is valid JSON
    let soldout_status = $.parseJSON(res_DATA[index].soldout_status); // Ensure res_DATA[index].soldout_status is valid JSON

    for (let i = 0; i < size.length; i++) {
      // Loop through size array to populate fields
      Config += `
        <div class="mb-3 field-set d-flex justify-content-between" id="Field${i}">
            <div class="col-lg-4">
                <label for="size_${index}_${i}" class="form-label">Size</label><br>
                <input type="text" class="form-control size" id="size_${index}_${i}" placeholder="Size" name="size[]" value="${size[i]}">
            </div>
             <div class="col-lg-4">
                  <label for="soldout_status_${index}_${i}" class="form-label">Stock status</label><br>

                   <input type="text" class="form-control soldout_status_" id="soldout_status_${index}_${i}" placeholder="Size" name="soldout_status[]" value="${soldout_status[i]}">
                 
              </div>
            <div class="col-lg-2 mt-12">
                <button class="btn btn-danger delete-size" data-id="${i}">Delete</button>
            </div>
        </div>`;
    }

    $("#parent-config").html(Config);

    // Delete button functionality
    $(document).on("click", ".delete-size", function () {
      var id = $(this).data("id");
      $("#Field" + id).remove();
    });
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    prod_id = res_DATA[index].prod_id;

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
          url: base_Url + "delete-cproduct",
          data: { prod_id: prod_id },

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
