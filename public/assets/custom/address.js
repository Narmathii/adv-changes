$(document).ready(function () {
  //Filter the Modal name based on their brands

  var mode, add_id, res_DATA;

  getAddressDetails();

  $("#add-address").click(function () {
    mode = "new";
    $("#add_form").modal("show");

    $("#state_id").change(function () {
      let state_id = $(this).val();

      let token = localStorage.getItem("token");

      $.ajax({
        type: "POST",
        url: base_Url + "getdist-data",
        data: { state_id: state_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "json",

        success: function (res) {
          console.log(res["response"].length);
          changeCSRF(res["csrf"]);
          var distDta = "";
          for ($i = 0; $i < res["response"].length; $i++) {
            distDta += `<option value="${res["response"][$i]["dist_id"]}">${res["response"][$i]["dist_name"]}</option>`;
          }
          $("#dist_id").html(
            `<option value=''> Select District </option>` + distDta
          );
        },
        error: function (error) {
          let status = error.status;
          if (status === 401) {
            localStorage.removeItem("token");
            window.location.href = base_Url;
          }
          console.log(error);
        },
      });
    });
  });

  $("#addAddress").click(function () {
    $("#add_form").modal("hide");
  });
  $("#close-btndlt").click(function () {
    $("#delete_modal").modal("hide");
  });
  // *************************** [Change csrf] ********************************************************************

  function changeCSRF(newToken) {
    $('meta[name="csrf-token"]').attr("content", newToken);
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

  function isValidPincode(pincode) {
    const pattern = /^[1-9][0-9]{5}$/;
    return pattern.test(pincode);
  }
  $("#btn_save").click(function () {
    if ($("#state_id").val() === "" && mode == "new") {
      validateError("Please Select State!");
    } else if ($("#dist_id").val() === "") {
      validateError("Please Select District!");
    } else if ($("#landmark").val() === "" && mode == "new") {
      validateError("Please Enter Landmark");
    } else if ($("#city").val() === "" && mode == "new") {
      validateError("Please Enter City");
    } else if ($("#address").val() === "" && mode == "new") {
      validateError("Please Enter Address");
    } else if ($("#pincode").val() === "" && mode == "new") {
      validateError("Please Enter Pincode");
    } else if (isValidPincode($("#pincode").val()) == false && mode == "new") {
      validateError("Please Enter Valid Pincode");
    } else if ($("#pincode").val().length < 6 && mode == "new") {
      validateError("Please Enter Valid Pincode");
    } else {
      insertData();
    }
  });

  // *************************** [Display ] ********************************************************************

  function DisplayResult(data) {
    $.toast({
      icon: "success",
      heading: "Success",
      text: data,
      position: "top-right",
      bgColor: "#28292d",
      loader: true,
      hideAfter: 1000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  // *************************** [Change CSRF token  ] ********************************************************************

  // function update_csrf_fields(val) {
  //   let all_forms = document.forms;
  //   for (e of all_forms) {
  //     e.querySelector("input[name=csrf_test_name]").value = val;
  //   }
  // }

  // *************************** [Insert Funtion ] ********************************************************************

  function insertData() {
    var form = $("#address_formdata")[0];
    var data = new FormData(form);
    var token = localStorage.getItem("token");

    var url;
    if (mode == "new") {
      url = base_Url + "insert-address";
      var isChecked = $("#default_addr").prop("checked");
      data.append("default_addr", isChecked);
    } else if (mode == "edit") {
      url = base_Url + "update-address";
      var isChecked = $("#default_addr").prop("checked");
      data.append("default_addr", isChecked);
      data.append("add_id", add_id);
    }

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        var resultData = $.parseJSON(data);

        if (resultData.code == 200) {
          // changeCSRF(resultData.csrf);
          // update_csrf_fields(resultData.csrf_test_name);
          $.toast({
            icon: "success",
            heading: "Success",
            text: resultData.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 1000,
            stack: false,
            showHideTransition: "fade",
          });
          $("#add_form").modal("hide");
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          // changeCSRF(resultData.csrf);
          $.toast({
            icon: "warning",
            heading: "warning",
            text: resultData.msg,
            position: "top-right",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 1000,
            stack: false,
            showHideTransition: "fade",
          });
          $("#add_form").modal("hide");
        }
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          localStorage.removeItem("token");
          window.location.href = base_Url;
        }
        console.log(error);
      },
    });
  }

  $("#btn-cancel").click(function () {
    $("#add_form").modal("hide");
  });

  // *************************** [get Data] *************************************************************************
  function getAddressDetails() {
    var token = localStorage.getItem("token");

    $.ajax({
      type: "GET",
      url: base_Url + "get-address",
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        res_DATA = data;

        editFunction(res_DATA);
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          localStorage.removeItem("token");
          window.location.href = base_Url;
        }
        console.log(error);
      },
    });
  }

  // *************************** [Edit Data] *************************************************************************

  function editFunction(res_DATA) {
    mode = "edit";

    $(".edit_btn").click(function () {
      var index = $(this).attr("index");

      $("#add_form").modal("show");

      var dist = "";
      dist += `<option value="${res_DATA[index]["dist_id"]}">${res_DATA[index]["dist_name"]}</option>`;
      $("#dist_id").html(dist);

      var states = "";
      states += `<option value="${res_DATA[index]["state_id"]}">${res_DATA[index]["state_title"]}</option>`;
      $("#state_id").html(states);

      $("#landmark").val(res_DATA[index]["landmark"]);
      $("#city").val(res_DATA[index]["city"]);
      $("#address").val(res_DATA[index]["address"]);
      $("#pincode").val(res_DATA[index]["pincode"]);

      let defaultAddr = res_DATA[index]["default_addr"];
      if (defaultAddr == 1) {
        $("#default_addr").prop("checked", true);
      } else {
        $("#default_addr").prop("checked", false);
      }
      add_id = res_DATA[index]["add_id"];
    });
  }

  // *************************** [Delete Data] *************************************************************************

  $(document).on("click", ".button_close", function () {
    $("#delete_modal").modal("hide");
  });
  $(document).on("click", ".delete_btn", function () {
    mode = "delete";

    var token = localStorage.getItem("token");

    $("#delete_modal").modal("show");

    $(".btndelete").click(function () {
      var addID = $(this).attr("add_id");

      $.ajax({
        type: "POST",
        url: base_Url + "delete-address",
        data: { add_id: addID },
        headers: { Authorization: "Bearer " + token },

        success: function (data) {
          var resultData = $.parseJSON(data);

          if (resultData.code == 200) {
            changeCSRF(resultData.csrf);
            $.toast({
              icon: "success",
              heading: "Success",
              text: resultData.message,
              position: "top-right",
              bgColor: "#28292d",
              loader: true,
              hideAfter: 1000,
              stack: false,
              showHideTransition: "fade",
            });
            $("#delete_modal").modal("hide");
            setTimeout(function () {
              window.location.reload();
            }, 1000);
          } else {
            changeCSRF(resultData.csrf);
            $.toast({
              icon: "warning",
              heading: "Warning",
              text: resultData.message,
              position: "top-right",
              bgColor: "#28292d",
              loader: true,
              hideAfter: 2000,
              stack: false,
              showHideTransition: "fade",
            });
            $("#delete_modal").modal("hide");
          }
        },

        error: function (error) {
          let status = error.status;
          if (status === 401) {
            localStorage.removeItem("token");
            window.location.href = base_Url;
          }
          console.log(error);
        },
      });
    });
  });
});
