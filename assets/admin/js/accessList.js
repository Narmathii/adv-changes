$(document).ready(function () {
  prodDesc.setData("");
  specificationss.setData("");

  $('input[type="radio"]').click(function () {
    var radioBtn = $(this).attr("id");
  });

  var mode, JSON, res_DATA, prod_id, config_Data, config_id;

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

  //Filter  Submenu
  $("#access_id").change(function () {
    let access_id = $(this).val();
    if (mode == "new") {
      $.ajax({
        type: "POST",
        url: base_Url + "get-sub-access",
        data: { access_id: access_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var subAccess = "";

          for (let i = 0; i < res.length; i++) {
            subAccess += `
            <option value="${res[i]["sub_access_id"]}">${res[i]["sub_access_name"]}</option>`;
          }
          $("#sub_access_id").html(subAccess);
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "get-sub-access",
        data: { access_id: access_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var subAccess = "";

          subAccess += `<option value="${subAccessID}">${subAccessName}</option>`;
          for (let i = 0; i < res.length; i++) {
            subAccess += `<option value="${res[i]["sub_access_id"]}">${res[i]["sub_access_name"]}</option>`;
          }

          $("#sub_access_id").html(subAccess);
        },
      });
    }
  });

  let selectedBrands = [];
  // For brands & modals
  $("#brand-container").on("change", ".brand-checkbox", function () {
    let brand_id = $(this).val();

    let isChecked = $(this).is(":checked");

    if (isChecked) {
      selectedBrands.push(brand_id);
    } else {
      selectedBrands = selectedBrands.filter((id) => id !== brand_id);
    }

    if (mode == "new" && brand_id != 0 && brand_id != -1) {
      if (selectedBrands.length > 0) {
        $.ajax({
          type: "POST",
          url: base_Url + "get-modal",
          data: { brand_id: selectedBrands },
          success: function (data) {
            var res = $.parseJSON(data);

            var modalData = "";

            for (let i = 0; i < res.length; i++) {
              modalData += `
              <div class="form-check">
                  <input class="form-check-input" name="modal_name[]" type="checkbox" id="modal_${res[i]["modal_name"]}" 
                  value="${res[i]["modal_id"]}">
                  <label class="form-check-label" for="modal_${res[i]["modal_name"]}">
                      ${res[i]["modal_name"]}
                  </label>
              </div>`;
            }

            $("#modal-container").html(
              `<input class="form-check-input" type="checkbox" id="modal_0" 
                  value="0" name="modal_name[]">
                  <label class="form-check-label" for="modal_0">
                      All Models
                  </label>` + modalData
            );
          },
        });
      } else {
        // $("#modal-container").html("No Selected Models*");
        $("#modal-container")
          .html(`<input class="form-check-input" type="checkbox" id="modal_-1" 
          value="-1" name="modal_name[]" checked>
          <label class="form-check-label" for="modal_-1">
              No Selected modal
          </label>`);
      }
    } else if (mode == "edit" && brand_id != 0 && brand_id != -1) {
      if (brandID != null) {
        let selectedBrandIDs = brandID.split(",");
        for (let x = 0; x < selectedBrandIDs.length; x++) {
          if (!selectedBrands.includes(selectedBrandIDs[x])) {
            let isChecked = $(`#brand_id_${selectedBrandIDs[x]}`).is(
              ":checked"
            );

            if (isChecked) {
              selectedBrands.push(selectedBrandIDs[x]);
            } else {
              selectedBrands = selectedBrands.filter(
                (id) => id !== selectedBrandIDs[x]
              );
            }
          }
        }

        if (selectedBrands.length > 0) {
          $.ajax({
            type: "POST",
            url: base_Url + "get-modal",
            data: { brand_id: selectedBrands },
            success: function (data) {
              var res = $.parseJSON(data);

              if (modalID != null && modalID != "") {
                var selectedModalIds = modalID.split(",").map(Number);
              }

              var modalData = "";

              for (let i = 0; i < res.length; i++) {
                let modalId = parseInt(res[i]["modal_id"]);
                let modalName = res[i]["modal_name"];
                var isChecked;
                if (modalID != null && modalID != "") {
                  isChecked = selectedModalIds.includes(modalId)
                    ? "checked"
                    : "";
                } else {
                  isChecked = "empty";
                }

                modalData += `
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="modal_${modalId}" 
              value="${modalId}" name="modal_name[]" ${isChecked}>
              <label class="form-check-label" for="modal_${modalId}">
                  ${modalName}
              </label>
            </div>`;
              }

              $("#modal-container").html(`
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="modal_0" name="modal_name[]" value="0">
              <label class="form-check-label" for="modal_0">All Models</label>
            </div> 
            ${modalData}
          `);
            },
          });
        } else {
          $("#modal-container")
            .html(`<input class="form-check-input" type="checkbox" id="modal_-1" 
          value="-1" name="modal_name[]">
          <label class="form-check-label" for="modal_-1">
              No Selected modal
          </label>`);
        }
      } else {
        if (selectedBrands.length > 0) {
          $.ajax({
            type: "POST",
            url: base_Url + "get-modal",
            data: { brand_id: selectedBrands },
            success: function (data) {
              var res = $.parseJSON(data);

              var modalData = "";

              for (let i = 0; i < res.length; i++) {
                modalData += `
                <div class="form-check">
                    <input class="form-check-input" name="modal_name[]" type="checkbox" id="modal_${res[i]["modal_name"]}" 
                    value="${res[i]["modal_id"]}">
                    <label class="form-check-label" for="modal_${res[i]["modal_name"]}">
                        ${res[i]["modal_name"]}
                    </label>
                </div>`;
              }

              $("#modal-container").html(
                `<input class="form-check-input" type="checkbox" id="modal_0" 
                    value="0" name="modal_name[]">
                    <label class="form-check-label" for="modal_0">
                        All Models
                    </label>` + modalData
              );
            },
          });
        } else {
          $("#modal-container")
            .html(`<input class="form-check-input" type="checkbox-" id="modal_" 
          value=" " name="modal_name[]">
          <label class="form-check-label" for="modal_">
              No Selected modal
          </label>`);
        }
      }
    } else {
      let brand_id = $(this).val();
      let isChecked = $(this).is(":checked");

      if (mode == "edit" && brand_id != "" && brand_id == 0 && isChecked) {
        $("#modal-container")
          .html(`<input class="form-check-input" type="checkbox" id="modal_0" 
              value="0" name="modal_name[]" checked>
              <label class="form-check-label" for="modal_0">
                  All Models
              </label>`);
      } else if (mode == "new" && brand_id == -1 && isChecked) {
        $("#modal-container")
          .html(`<input class="form-check-input" type="checkbox" id="modal_-1" 
              value="-1" name="modal_name[]" checked>
              <label class="form-check-label" for="modal_-1">
                  No Selected Modals
              </label>`);
      } else if (mode == "edit" && brand_id == -1 && isChecked) {
        $("#modal-container")
          .html(`<input class="form-check-input" type="checkbox" id="modal_-1" 
              value="-1" name="modal_name[]" checked>
              <label class="form-check-label" for="modal_-1">
                  No Selected Modals
              </label>`);
      } else {
        $("#modal-container")
          .html(`<input class="form-check-input" type="checkbox" id="modal_0" 
              value="0" name="modal_name[]">
              <label class="form-check-label" for="modal_0">
                  All Models
              </label>`);
      }
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
    if ($("#access_id").val() === "" && mode == "new") {
      validateError("Please Select Menu");
    }
    // else if ($("#sub_access_id").val() === "" && mode == "new") {
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
    // }
    else if ($("#redirect_url").val() === "" && mode == "new") {
      validateError("Please Enter url*");
    }

    // else if ($("#quantity").val() === "" && mode == "new") {
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
    var form = $("#Sub-product")[0];
    data = new FormData(form);

    let proddesc = prodDesc.getData();
    let specification = specificationss.getData();
    let hotsale = $("#hot_sale").prop("checked");
    let hdata = hotsale ? 1 : 0;

    var url;
    if (mode == "new") {
      url = base_Url + "insert-product-list";
      data.append("prod_desc", proddesc);
      data.append("specifications", specification);
      data.append("hot_sale", hdata);
    } else if (mode == "edit") {
      url = base_Url + "update-product-list";
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
        // console.log(data);
        var resultData = $.parseJSON(data);

        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });

          $("#model-data").modal("hide");
          getproductDetails();
          // setTimeout(function () {
          //   window.location.reload();
          // }, 1000);
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
      url: base_Url + "get-product-list",
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
          mDataProp: "access_title",
        },
        {
          mDataProp: "sub_access_name",
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
    $("#search-brand").html(res_DATA[index].brand_name);
    $("#specificaion-view").append(res_DATA[index].specifications);

    $("#drop_shipping").val(res_DATA[index].drop_shipping);

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

    // Specification
    let tblSpecific = "";
    let material = res_DATA[index].material;
    let color = res_DATA[index].color_name;
    let prod_weight = res_DATA[index].prod_weight;
    let measurement = res_DATA[index].measurement;
    let fitment = res_DATA[index].fitment;
    let warranty = res_DATA[index].warrenty;

    tblSpecific += `<tr>
                      <td>Material</td>
                      <td>${material}</td>
                   </tr>
                   <tr>
                      <td>Color</td>
                      <td>${color}</td>
                   </tr>
                   <tr>
                      <td>Product weight (kg)</td>
                      <td>${prod_weight}</td>
                   </tr>
                   <tr>
                      <td>Product measurement L*B*H (cm)</td>
                      <td>${measurement}</td>
                   </tr>
                   <tr>
                      <td>Fitment</td>
                      <td>${fitment}</td>
                   </tr>
                   <tr>
                      <td>Warranty</td>
                      <td>${warranty}</td>
                   </tr>`;

    $("#specific tbody").html(tblSpecific);

    $("#product-feature").append(res_DATA[index].features);
  });

  // *************************** [Edit Data] *************************************************************************

  var subAccessID;
  var subAccessName;

  var modalID;
  var modalname;

  var brandID;
  var brandName;
  $(document).on("click", ".btnEdit", function () {
    $("#model-data").modal("show");
    mode = "edit";
    var index = $(this).attr("id");
    // console.log(res_DATA[index]);

    // Only for Brands and Models
    brandID = res_DATA[index].commonbrand_id;
    modalID = res_DATA[index].commonmodal_id;
    modalname = res_DATA[index].common_model;
    brandName = res_DATA[index].common_brands;

    if (brandID != null && modalID != null) {
      getBrand(brandID, brandName);
      getModel(modalID, brandID);
    }

    $("#btn-addConfig").attr("index", index);
    $("#access_id").val(res_DATA[index].access_id);
    $("#brand_id").val(res_DATA[index].brand_id);

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

    var accessId = res_DATA[index].access_id;
    subAccessID = res_DATA[index].sub_access_id;
    subAccessName = res_DATA[index].sub_access_name;
    $("#access_id").val(accessId).trigger("change");

    $subAccess = "";
    $subAccess += `<option value="${res_DATA[index].sub_access_id}">${res_DATA[index].sub_access_name}</option>`;
    $("#sub_access_id").append($subAccess);

    $("#product_name").val(res_DATA[index].product_name);
    $("#billing_name").val(res_DATA[index].billing_name);
    $("#redirect_url").val(res_DATA[index].redirect_url);
    $("#product_price").val(res_DATA[index].product_price);
    $("#search_brand").val(res_DATA[index].search_brand);

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

    $("#offer_price").val(res_DATA[index].offer_price);
    $("#offer_details").val(res_DATA[index].offer_details);
    $("#stock_status").val(res_DATA[index].stock_status);

    $("#arrival_status").val(res_DATA[index].arrival_status);

    $("#soldout_status").val(res_DATA[index].soldout_status);

    // product img
    $("#product_image_url").attr("src", base_Url + res_DATA[index].product_img);
    $("#product_image_url").addClass("active");
    $("#product_image_url").css("display", "block");
    // images

    $("#prod_desc").val(res_DATA[index].prod_desc);
    prodDesc.setData(res_DATA[index].prod_desc);

    $("#features").val(res_DATA[index].features);
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
  });

  function getBrand(brandID, brandName) {
    let selectedBrandIDs = brandID.split(",");
    $.ajax({
      url: base_Url + "get-shop-brands",
      type: "GET",
      dataType: "json",
      success: function (res) {
        $("#brand-container").empty();
        $("#brand-container").append(`
          <div class="form-check me-3" style="width: auto;">
              <input class="form-check-input brand-checkbox" name="brand_name[]"
                     type="checkbox" id="brand_id_-1" value="-1"
                     ${selectedBrandIDs.includes("-1") ? "checked" : ""}>
              <label class="form-check-label" for="brand_id_-1">No Selected Brands</label>
          </div>
      `);
        $("#brand-container").append(`
          <div class="form-check me-3" style="width: auto;">
              <input class="form-check-input brand-checkbox" name="brand_name[]"
                     type="checkbox" id="brand_id_0" value="0"
                     ${selectedBrandIDs.includes("0") ? "checked" : ""}>
              <label class="form-check-label" for="brand_id_0">All Brands</label>
          </div>
      `);

        res.forEach((brand) => {
          $("#brand-container").append(`
            <div class="form-check me-3" style="width: auto;">
                <input class="form-check-input brand-checkbox" name="brand_name[]"
                       type="checkbox" id="brand_id_${brand.brand_id}"
                       value="${brand.brand_id}" 
                       ${
                         selectedBrandIDs.includes(brand.brand_id.toString())
                           ? "checked"
                           : ""
                       }>
                <label class="form-check-label" for="brand_id_${
                  brand.brand_id
                }">
                    ${brand.brand_name}
                </label>
            </div>
        `);
        });
      },
    });
  }

  function getModel(modalID, brandID) {
    let selectedModalIDs = modalID.split(",");
    let selectedBrands = brandID.split(",");

    $.ajax({
      url: base_Url + "get-shop-modals",
      type: "POST",
      data: { brand_id: selectedBrands },
      dataType: "json",
      success: function (res) {
        $("#modal-container").empty();
        $("#modal-container").append(`
          <div class="form-check me-3" style="width: auto;">
              <input class="form-check-input" name="modal_name[]"
                     type="checkbox" id="modal_id_-1" value="-1"
                     ${selectedModalIDs.includes("-1") ? "checked" : ""}>
              <label class="form-check-label" for="modal_id_-1">No Selected Modals</label>
          </div>
      `);
        $("#modal-container").append(`
          <div class="form-check me-3" style="width: auto;">
              <input class="form-check-input" name="modal_name[]"
                     type="checkbox" id="modal_id_0" value="0"
                     ${selectedModalIDs.includes("0") ? "checked" : ""}>
              <label class="form-check-label" for="modal_id_0">All Modals</label>
          </div>
      `);

        res.forEach((modal) => {
          $("#modal-container").append(`
            <div class="form-check me-3" style="width: auto;">
                <input class="form-check-input" name="modal_name[]"
                       type="checkbox" id="modal_id_${modal.modal_id}"
                       value="${modal.modal_id}" 
                       ${
                         selectedModalIDs.includes(modal.modal_id.toString())
                           ? "checked"
                           : ""
                       }>
                <label class="form-check-label" for="modal_id_${
                  modal.modal_id
                }">
                    ${modal.modal_name}
                </label>
            </div>
        `);
        });
      },
    });
  }

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
          url: base_Url + "delete-product-list",
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
