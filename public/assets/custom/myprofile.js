$(document).ready(function () {
  getProfileData();

  // ****************************************************************** get data **************************************************************

  function getProfileData() {
    var token = localStorage.getItem("token");

    $.ajax({
      url: base_Url + "get-profile",
      dataType: "json",
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        $("#username").val(data[0]["username"]);
        $("#email").val(data[0]["email"]);
        $("#number").val(data[0]["number"]);
        $("#wanumber").val(data[0]["wanumber"]);

        $("#profile_name").html(data[0]["username"]);
        $("#profile_email").html(data[0]["email"]);
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

  function resultData(data) {
    $.toast({
      icon: "error",
      heading: "Warning",
      text: data,
      position: "top-right",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  function successData(data) {
    $.toast({
      icon: "success",
      heading: "success",
      text: data,
      position: "top-right",
      bgColor: "#008000",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }
  // ****************************************************************** validation **************************************************************

  $("#update-btn").click(function () {
    if ($("#username").val() == "") {
      resultData("Please Enter Username!");
    } else if ($("#email").val() == "") {
      resultData("Please Enter Email!");
    } else if (!IsEmail($("#email").val())) {
      resultData("Please enter valid email!");
    } else if ($("#number").val() == "") {
      resultData("Please Enter number!");
    } else if (!isPhoneNumber($("#number").val())) {
      resultData("Please enter valid number!");
    } else {
      updateData();
    }

    function IsEmail(email) {
      var regex =
        /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    function isPhoneNumber(phone_no) {
      var pattern = /^\d{10}$/;
      return pattern.test(phone_no);
    }

    // ****************************************************************** Update Data **************************************************************

    function updateData() {
      var form = $("#profile_form")[0];
      var data = new FormData(form);
      var token = localStorage.getItem("token");
      $.ajax({
        type: "POST",
        data: data,
        url: base_Url + "update-profile",
        dataType: "json",
        contentType: false,
        processData: false,
        headers: { Authorization: "Bearer " + token },
        success: function (data) {
          if (data.code == 200) {
            successData(data.msg);
            setTimeout(function () {
              window.location.reload();
            }, 2000);
          } else {
            resultData(data.msg);
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
  });

  // function update_csrf_fields(val) {
  //   let all_forms = document.forms;
  //   for (e of all_forms) {
  //     e.querySelector("input[name=csrf_test_name]").value = val;
  //   }
  // }
});
