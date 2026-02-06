$(document).ready(function () {
  prodDesc.setData("");
  specificationss.setData("");

  $('input[type="radio"]').click(function () {
    var radioBtn = $(this).attr("id");
    console.log(radioBtn);
  });

  //Filter
  var mode, JSON, res_DATA, prod_id, config_Data, config_id;

  getConfigData();

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
    $("#model-data").val("");
    $("#model-data").modal("show");
  });

  // *************************** [] ********************************************************************

  // Selecting Model name based on brands
  $("#brand_id").change(function () {
    let brand_id = $(this).val();

    if (mode == "new" && brand_id != 0) {
      $.ajax({
        type: "POST",
        url: base_Url + "get-modal",
        data: { brand_id: brand_id },
        success: function (data) {
          var res = $.parseJSON(data);
          var modalData = "";

          for (let i = 0; i < res.length; i++) {
            modalData += `
            <option value="${res[i]["modal_id"]}">${res[i]["modal_name"]}</option>`;
          }
          $("#modal_id").html(modalData);
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "get-modal",
        data: { brand_id: brand_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var modalData = "";

          modalData += `<option value="${modalID}">${modalname}</option>`;
          for (let i = 0; i < res.length; i++) {
            modalData += `<option value="${res[i]["modal_id"]}">${res[i]["modal_name"]}</option>`;
          }

          $("#modal_id").html(modalData);
        },
      });
    } else {
      var modalData = "";

      modalData += `<option value="0">All Models</option>`;

      $("#modal_id").html(modalData);
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

    let offerAmt = OriginalAmt - (OriginalAmt * offerDetail) / 100;

    $("#offer_price").val(offerAmt);
  });

  // # *************************** [Prod Configuration] *************************************************************************

  var count = 0;
  var inc = 0;

  // $(document).on("click", "#btn-addConfig", function () {
  //   if (mode == "new") {
  //     count++;

  //     var dynamiColor = "";
  //     for (i = 0; i < config_Data.length; i++) {
  //       dynamiColor += `
  //             <option value=${config_Data[i]["color_id"]}>
  //                ${config_Data[i]["color_name"]}
  //             </option>
  //        `;
  //     }
  //   } else if (mode == "edit") {
  //     var index = $(this).attr("index");
  //     inc++;

  //     var dynamiColor = "";
  //     for (i = 0; i < config_Data.length; i++) {
  //       dynamiColor += `
  //             <option value=${config_Data[i]["color_id"]}>
  //                ${config_Data[i]["color_name"]}
  //             </option>
  //        `;
  //     }
  //     var imgCount = res_DATA[index]["config_img1"].length;

  //     count = imgCount + inc;
  //   }

  //   var Config = `
  //               <div class="mb-3 mt-3 field-set d-flex justify-content-between" id="Field${count}">
  //                   <div class="col-lg-3">
  //                       <label for="soldout_status_${count}" class="form-label">Stock status</label><br>
  //                       <select class="form-select" name="soldout_status[]" id="soldout_status_${count}">
  //                           <option value="">Select status</option>
  //                           <option value="1">Available</option>
  //                           <option value="0">Out of Stock</option>
  //                       </select>
  //                       <span class="error text-danger soldout_status mt-10"></span>
  //                   </div>
  //                   <div class="col-xl-3">
  //                       <label for="colour_${count}" class="form-label">Color</label>
  //                       <select class="form-control floating" name="colour[]" id="colour_${count}">
  //                           <option value="">Select Color</option>
  //                           ${dynamiColor}
  //                       </select>
  //                   </div>
  //                   <div class="col-lg-3">
  //                       <label for="size_${count}" class="form-label">Size</label><br>
  //                       <input type="text" class="form-control size" id="size_${count}" placeholder="Size" name="size[]" value="">
  //                       <span class="error text-danger size mt-10"></span>
  //                   </div>
  //                   <div class="col-lg-2 mt-12">
  //                       <button class="btn btn-danger delete-size" data-id="${count}">Delete</button>
  //                   </div>
  //               </div>

  //               <div class="mb-3 field-set2 d-flex" id="Field2_${count}">
  //                   <div class="col-lg-3 me-3" style="width: 22%;">
  //                       <label for="config_img1" class="form-label">Image1
  //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
  //                       </label>
  //                       <input class="form-control config_img1" type="file" id="config_img1_${count}" name="config_img1[]">
  //                       <img src="" id="config_img1_url_${count}" alt="image" width="80px" style="padding-top: 15px; display:none;" data-id="${count}">
  //                   </div>
  //                   <div class="col-lg-3 me-3" style="width: 22%;">
  //                       <label for="config_img2" class="form-label">Image2
  //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
  //                       </label>
  //                       <input class="form-control config_img2" type="file" id="config_img2_${count}" name="config_img2[]">
  //                       <img src="" id="config_img2_url_${count}" alt="image" width="80px" style="padding-top: 15px; display:none;" data-id="${count}">
  //                   </div>
  //                   <div class="col-lg-3 me-3" style="width: 22%;">
  //                       <label for="config_img3" class="form-label">Image3
  //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
  //                       </label>
  //                       <input class="form-control config_img3" type="file" id="config_img3_${count}" name="config_img3[]">
  //                       <img src="" id="config_img3_url_${count}" alt="image" width="80px" style="padding-top: 15px; display:none;" data-id="${count}">
  //                   </div>
  //                   <div class="col-lg-3 me-3" style="width: 22%;">
  //                       <label for="config_img4" class="form-label">Image4
  //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
  //                       </label>
  //                       <input class="form-control config_img4" type="file" id="config_img4_${count}" name="config_img4[]">
  //                       <img src="" id="config_img4_url_${count}" alt="image" width="80px" style="padding-top: 15px; display:none;" data-id="${count}">
  //                       <span class="error text-danger config_img4 mt-5"></span>
  //                   </div>
  //               </div>`;

  //   $("#parent-config").append(Config);
  // });

  // Delete config field
  // $(document).on("click", ".delete-size", function () {
  //   var id = $(this).data("id");
  //   $("#Field" + id).remove();
  //   $("#Field2_" + id).remove();
  // });

  // Handle change event for dynamic file inputs
  // $(document).on("change", ".config_img1", function () {
  //   var input = this;
  //   var count = $(input).attr("id").split("_").pop();
  //   var imgElement = "config_img1_url_" + count;
  //   console.log(imgElement);
  //   dispImg(input, imgElement);
  // });
  // $(document).on("change", ".config_img2", function () {
  //   var input = this;
  //   var count = $(input).attr("id").split("_").pop();
  //   var imgElement = "config_img2_url_" + count;
  //   console.log(imgElement);
  //   dispImg(input, imgElement);
  // });
  // $(document).on("change", ".config_img3", function () {
  //   var input = this;
  //   var count = $(input).attr("id").split("_").pop();
  //   var imgElement = "config_img3_url_" + count;
  //   console.log(imgElement);
  //   dispImg(input, imgElement);
  // });
  // $(document).on("change", ".config_img4", function () {
  //   var input = this;
  //   var count = $(input).attr("id").split("_").pop();
  //   var imgElement = "config_img4_url_" + count;
  //   console.log(imgElement);
  //   dispImg(input, imgElement);
  // });

  // Display image function
  // function dispImg(input, id) {
  //   if (input.files && input.files[0]) {
  //     var reader = new FileReader();
  //     reader.onload = function (e) {
  //       $("#" + id).attr("src", e.target.result);
  //       $("#" + id).css("display", "block");
  //     };
  //     reader.readAsDataURL(input.files[0]);
  //   }
  // }

  // =========================== Get Configg Color =================================================================================
  function getConfigData() {
    $.ajax({
      type: "GET",
      url: base_Url + "get-config-details",
      dataType: "json",
      success: function (data) {
        config_Data = data;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error Details:");
        console.log("Status: " + textStatus);
        console.log("Error Thrown: " + errorThrown);
        console.log("Response Text: " + jqXHR.responseText);
      },
    });
  }

  // *************************** [Validation] *********************************************************************************

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
    if ($("#brand_id").val() === "" && mode == "new") {
      validateError("Please Select Brand name*");
    } else if ($("#modal_id").val() === "" && mode == "new") {
      validateError("Please select Modal*");
    } else if ($("#billing_name").val() === "" && mode == "new") {
      validateError("Please Enter Billing name*");
    } else if ($("#product_name").val() === "" && mode == "new") {
      validateError("Please Enter short name*");
    } else if ($("#product_price").val() === "" && mode == "new") {
      validateError("Please Enter Price*");
    } else if ($("#offer_type").val() === "" && mode == "new") {
      validateError("Please Select offer type*");
    } else if ($("#offer_price").val() === "" && mode == "new") {
      validateError("Please Enter Offer Price*");
    } else if ($("#arrival_status").val() === "" && mode == "new") {
      validateError("Please Select inventory status*");
    } else if ($("#stock_status").val() === "" && mode == "new") {
      validateError("Please Select stock status*");
    } else if ($("#redirect_url").val() === "" && mode == "new") {
      validateError("Please Enter url*");
    } else if ($("#quantity").val() === "" && mode == "new") {
      validateError("Please Enter quantity*");
    } else if ($("#weight").val() === "" && mode == "new") {
      validateError("Please Enter weight*");
    } else if ($("#weight_units").val() === "" && mode == "new") {
      validateError("Please Select Units*");
    } else if ($("#product_img").val() === "" && mode == "new") {
      validateError("Please Select Product Image*");
    }

    // Product Details
    else if ($("#img_1").val() === "" && mode == "new") {
      validateError("Please Select  Image*");
    } else if ($("#img_2").val() === "" && mode == "new") {
      validateError("Please Select  Image*");
    } else if ($("#img_3").val() === "" && mode == "new") {
      validateError("Please Select  Image*");
    } else if ($("#img_4").val() === "" && mode == "new") {
      validateError("Please Select  Image*");
    } else if (prodDesc.getData() === "" && mode == "new") {
      validateError("Please Enter Product Description*");
    } else if ($("#search_brand").val() === "" && mode == "new") {
      validateError("Please Enter Search Filter*");
    } else {
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
      url = base_Url + "insert-product";
      data.append("prod_desc", proddesc);
      data.append("specifications", specification);
      data.append("hot_sale", hdata);
    } else if (mode == "edit") {
      url = base_Url + "update-product";
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
      dataType: "json",

      success: function (resultData) {
        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });

          $("#model-data").modal("hide");
          setTimeout(function () {
            window.location.reload();
          }, 1000);

          refreshDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "error",
          });

          $("#model-data").modal("hide");

          refreshDetails();
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
      url: base_Url + "get-product-details",
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
          mDataProp: "modal_name",
        },
        {
          mDataProp: "product_name",
        },
        // {
        //   mDataProp: function (data, type, full, meta) {
        //     return (
        //       '<a id="' +
        //       meta.row +
        //       '" class="btn btnConfig text-info fs-14 lh-1"> <i class="ri-edit-line"></i> Edit</a>'
        //     );
        //   },
        // },

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
    $("#product-feature").empty();
    var index = $(this).attr("id");

    $("#description").append(res_DATA[index].prod_desc);
    $("#offer").html(res_DATA[index].offer_details);
    $("#offer-price").html(res_DATA[index].offer_price);
    $("#billing-name").html(res_DATA[index].billing_name);
    $("#search-brand").html(res_DATA[index].brand_name);

    // new
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
    let img1 = res_DATA[index].img_1;
    let img2 = res_DATA[index].img_2;
    let img3 = res_DATA[index].img_3;
    let img4 = res_DATA[index].img_4;
    let img5 = res_DATA[index].img_5;
    let img6 = res_DATA[index].img_6;
    let img7 = res_DATA[index].img_7;
    let img8 = res_DATA[index].img_8;
    let img9 = res_DATA[index].img_9;
    let img10 = res_DATA[index].img_10;

    imgRow += `<tr>
    <td><img width="130px" src="${base_Url}${img1}" alt="Image 1"></td>
    <td><img  width="130px" src="${base_Url}${img2}" alt="Image 2"></td>
    <td><img width="130px" src="${base_Url}${img3}" alt="Image 3"></td>
    <td><img width="130px" src="${base_Url}${img4}" alt="Image 4"></td>
    <td><img width="130px" src="${base_Url}${img5}" alt="Image 5"></td>
    </tr>
    <tr>
    <td><img width="130px" src="${base_Url}${img6}" alt="Image 6"></td>
    <td><img width="130px" src="${base_Url}${img7}" alt="Image 7"></td>
    <td><img width="130px" src="${base_Url}${img8}" alt="Image 8"></td>
    <td><img width="130px" src="${base_Url}${img9}" alt="Image 9"></td>
    <td><img width="130px" src="${base_Url}${img10}" alt="Image 10"></td>
    </tr>`;
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
    //                 <td>Material</td>
    //                 <td>${material}</td>
    //              </tr>
    //              <tr>
    //                 <td>Product weight (kg)</td>
    //                 <td>${prod_weight}</td>
    //              </tr>
    //              <tr>
    //                 <td>Product measurement L*B*H (cm)</td>
    //                 <td>${measurement}</td>
    //              </tr>
    //              <tr>
    //                 <td>Fitment</td>
    //                 <td>${fitment}</td>
    //              </tr>
    //              <tr>
    //                 <td>Warranty</td>
    //                 <td>${warranty}</td>
    //              </tr>`;

    // $("#specific tbody").html(tblSpecific);

    $("#product-feature").append(res_DATA[index].features);
  });

  // *************************** [Edit Data] *************************************************************************
  var modalID;
  var modalname;

  $(document).on("click", ".btnEdit", function () {
    $("#model-data").modal("show");
    mode = "edit";

    var index = $(this).attr("id");

    $("#btn-addConfig").attr("index", index);

    var brandID = res_DATA[index].brand_id;
    modalID = res_DATA[index].modal_id;
    modalname = res_DATA[index].modal_name;
    $("#brand_id").val(brandID).trigger("change");

    $("#billing_name").val(res_DATA[index].billing_name);
    $("#product_name").val(res_DATA[index].product_name);
    $("#redirect_url").val(res_DATA[index].redirect_url);
    $("#product_price").val(res_DATA[index].product_price);

    $("#offer_type").val(res_DATA[index].offer_type);
    var offerType = res_DATA[index].offer_type;
    if (offerType == 1) {
      $("#offer_details").val("");
      $("#offer_details").attr("readonly", true);
      $("#offer_price").val("");
    } else if (offerType == 2) {
      $("#offer_details").val("");
      $("#offer_details").attr("readonly", true);
      let originalAmt = $("#product_price").val();
      $("#offer_details").html(originalAmt);
      $("#offer_price").val(originalAmt);
    } else {
      $("#offer_details").attr("readonly", false);
    }

    $("#stock_status").val(res_DATA[index].stock_status);

    // new data
    $("#quantity").val(res_DATA[index].quantity);
    $("#weight").val(res_DATA[index].weight);
    $("#weight_units").val(res_DATA[index].weight_units);

    $("#specifications").val(res_DATA[index].specifications);
    specificationss.setData(res_DATA[index].specifications);

    $("#img5_url").attr("src", base_Url + res_DATA[index].img_5);
    $("#img5_url").addClass("active");
    $("#img5_url").css("display", "block");

    $("#img6_url").attr("src", base_Url + res_DATA[index].img_6);
    $("#img6_url").addClass("active");
    $("#img6_url").css("display", "block");

    $("#img7_url").attr("src", base_Url + res_DATA[index].img_7);
    $("#img7_url").addClass("active");
    $("#img7_url").css("display", "block");

    $("#img8_url").attr("src", base_Url + res_DATA[index].img_8);
    $("#img8_url").addClass("active");
    $("#img8_url").css("display", "block");

    $("#img9_url").attr("src", base_Url + res_DATA[index].img_9);
    $("#img9_url").addClass("active");
    $("#img9_url").css("display", "block");

    $("#img10_url").attr("src", base_Url + res_DATA[index].img_10);
    $("#img10_url").addClass("active");
    $("#img10_url").css("display", "block");
    // new data End

    $("#offer_price").val(res_DATA[index].offer_price);
    $("#offer_details").val(res_DATA[index].offer_details);
    $("#arrival_status").val(res_DATA[index].arrival_status);
    $("#soldout_status").val(res_DATA[index].soldout_status);

    // product img
    $("#product_image_url").attr("src", base_Url + res_DATA[index].product_img);
    $("#product_image_url").addClass("active");
    $("#product_image_url").css("display", "block");
    // images

    $("#img1_url").attr("src", base_Url + res_DATA[index].img_1);
    $("#img1_url").addClass("active");
    $("#img1_url").css("display", "block");

    $("#img2_url").attr("src", base_Url + res_DATA[index].img_2);
    $("#img2_url").addClass("active");
    $("#img2_url").css("display", "block");

    $("#img3_url").attr("src", base_Url + res_DATA[index].img_3);
    $("#img3_url").addClass("active");
    $("#img3_url").css("display", "block");

    $("#img4_url").attr("src", base_Url + res_DATA[index].img_4);
    $("#img4_url").addClass("active");
    $("#img4_url").css("display", "block");

    $("#search_brand").val(res_DATA[index].search_brand);

    $("#prod_desc").val(res_DATA[index].prod_desc);
    prodDesc.setData(res_DATA[index].prod_desc);

    $("#features").val(res_DATA[index].features);
    // featuress.setData(res_DATA[index].features);

    // specification
    $("#material").val(res_DATA[index].material);

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
    //   let totalCount = res_DATA[index]["soldout_status"].length;
    //   let inccc = 0;
    //   var Config = "";
    //   for (let i = 0; i < totalCount; i++) {
    //     inccc++;
    //     let colorID = res_DATA[index]["color_data"][i].color_id;
    //     let selectedColr = res_DATA[index]["colour_id"][i];
    //     let colorOptions = res_DATA[index]["color_data"]
    //       .map((color) => {
    //         let selected = color.color_id === selectedColr ? "selected" : "";
    //         return `<option value="${color.color_id}" ${selected}>${color.color_name}</option>`;
    //       })
    //       .join("");

    //     if (selectedColr === "") {
    //       colorOptions = `<option value="">Select Color</option>` + colorOptions;
    //     }

    //     let color = "";
    //     color += `<option value="${res_DATA[index]["color_data"][i]["color_id"]}">${res_DATA[index]["color_data"][i]["color_name"]}</option>`;

    //     Config += `
    //     <div class="mb-3 field-set d-flex justify-content-between" id="Field${i}">
    //         <div class="col-lg-3">
    //             <label for="soldout_status_${index}_${i}" class="form-label">Stock status</label><br>
    //             <select class="form-select" name="soldout_status[]" id="soldout_status_${index}_${i}">

    //             <option value="" ${
    //               res_DATA[index]["soldout_status"][i] == "" ? "selected" : ""
    //             }>Select status</option>
    //             <option value="1" ${
    //               res_DATA[index]["soldout_status"][i] == "1" ? "selected" : ""
    //             }>Available</option>
    //             <option value="0" ${
    //               res_DATA[index]["soldout_status"][i] == "0" ? "selected" : ""
    //             }>Out of Stock</option>

    //             </select>
    //             <span class="error text-danger soldout_status mt-10"></span>
    //         </div>
    //         <div class="col-xl-3">
    //             <label for="colour_${index}_${i}" class="form-label">Color</label>
    //             <select class="form-control floating" name="colour[]" id="colour_${index}_${i}">
    //               ${colorOptions}
    //             </select>
    //         </div>
    //         <div class="col-lg-3">
    //             <label for="size_${index}_${i}" class="form-label">Size</label><br>
    //             <input type="text" class="form-control size" id="size_${index}_${i}" placeholder="Size" name="size[]" value="${
    //       res_DATA[index]["size"][i]
    //     }">
    //         </div>
    //         <div class="col-lg-2 mt-12">
    //             <button class="btn btn-danger delete-size" data-id="${i}">Delete</button>
    //         </div>
    //     </div>

    //     <div class="mb-3 field-set2 d-flex" id="Field2_${i}">
    //                   <div class="col-lg-3 me-3" style="width: 22%;">
    //                       <label for="config_img1" class="form-label">Image1
    //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
    //                       </label>
    //                       <input class="form-control config_img1" type="file" id="config_img1_${inccc}" name="config_img1[]">
    //                       <img src="${
    //                         base_Url + res_DATA[index]["config_img1"][i]
    //                       }" id="config_img1_url_${inccc}" alt="image" width="80px" style="padding-top: 15px; display:${
    //       res_DATA[index]["config_img1"][i] ? "block" : "none"
    //     };" data-id="${index}">
    //                   </div>
    //                   <div class="col-lg-3 me-3" style="width: 22%;">
    //                       <label for="config_img2" class="form-label">Image2
    //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
    //                       </label>
    //                       <input class="form-control config_img2" type="file" id="config_img2_${inccc}" name="config_img2[]">
    //                       <img src="${
    //                         base_Url + res_DATA[index]["config_img2"][i]
    //                       }" id="config_img2_url_${inccc}" alt="image" width="80px" style="padding-top: 15px;display:${
    //       res_DATA[index]["config_img1"][i] ? "block" : "none"
    //     };" data-id="${index}">
    //                   </div>
    //                   <div class="col-lg-3 me-3" style="width: 22%;">
    //                       <label for="config_img3" class="form-label">Image3
    //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
    //                       </label>
    //                       <input class="form-control config_img3" type="file" id="config_img3_${inccc}" name="config_img3[]">
    //                       <img src="${
    //                         base_Url + res_DATA[index]["config_img3"][i]
    //                       }" id="config_img3_url_${inccc}" alt="image" width="80px" style="padding-top: 15px;display:${
    //       res_DATA[index]["config_img1"][i] ? "block" : "none"
    //     };" data-id="${index}">
    //                   </div>
    //                   <div class="col-lg-3 me-3" style="width: 22%;">
    //                       <label for="config_img4" class="form-label">Image4
    //                           &nbsp;<span class="text text-success">AllowedFiles:png,jpeg,jpg</span>
    //                       </label>
    //                       <input class="form-control config_img4" type="file" id="config_img4_${inccc}" name="config_img4[]">
    //                       <img src="${
    //                         base_Url + res_DATA[index]["config_img4"][i]
    //                       }" id="config_img4_url_${inccc}" alt="image" width="80px" style="padding-top: 15px; display:${
    //       res_DATA[index]["config_img1"][i] ? "block" : "none"
    //     };" data-id="${index}">
    //                       <span class="error text-danger config_img4 mt-5"></span>
    //                   </div>
    //               </div>`;
    //   }

    //   $("#parent-config").html(Config);
    // });
    // $(document).on("click", ".delete-size", function () {
    //   var id = $(this).data("id");
    //   $("#Field" + id).remove();
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
          url: base_Url + "delete-product",
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
