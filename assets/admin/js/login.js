$(document).ready(function () {});
$("#signin-btn").click(function () {
  $username = $("#username").val();
  $password = $("#password").val();

  if ($username == "") {
    $.toast({
      icon: "warning",
      heading: "Warning",
      text: "Please Enter username!!",
      position: "top-left",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  } else if ($password == "") {
    $.toast({
      icon: "warning",
      heading: "Warning",
      text: "Please Enter Password!!",
      position: "top-left",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  } else {
    loginCheck($username, $password);
  }

  function loginCheck(username, password) {
    $.ajax({
      type: "POST",
      url: base_url + "login-check",
      data: {
        username: username,
        password: password,
      },
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          updateCSRF(data.csrf);
          window.location.replace(base_url + "dashboard");
        } else {
          $.toast({
            icon: "warning",
            heading: "Warning",
            text: data.message,
            position: "top-left",
            bgColor: "#28292d",
            loader: true,
            hideAfter: 2000,
            stack: false,
            showHideTransition: "fade",
          });
        }
      },
      error: function (textStatus) {
        console.error("Error:", textStatus);
      },
    });
  }

  //  ************************************************** CSRF update Token  *****************************************************************
  function updateCSRF(newToken) {
    $('meta[name="csrf-token"]').attr("content", newToken);
  }
});
