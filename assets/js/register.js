$(document).ready(function () {
  $("#registerBtn").click(function () {
    $.ajax({
      url: "/guvi_in/php/register.php",
      type: "POST",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      data: {
        username: $("#username").val(),
        password: $("#password").val(),
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          console.log(response.message);
          alert(response.message);
          window.location.href = "/guvi_in/templates/login.html";
        } else {
          console.log(response.message);
          alert(response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
        alert("An error occurred");
      },
    });
  });
});
