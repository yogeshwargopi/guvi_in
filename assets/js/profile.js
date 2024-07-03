$(document).ready(function () {
  // Retrieve session ID from local storage
  var sessionID = localStorage.getItem("sessionID");
  console.log(sessionID);

  // Fetch profile data on page load
  $.ajax({
    url: "/guvi_in/php/profile.php",
    method: "POST",
    data: { sessionID: sessionID },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        $("#age").val(response.profile.age);
        $("#dob").val(response.profile.dob);
        $("#contact").val(response.profile.contact);
        console.log(response);
      } else {
        alert(response.message);
      }
    },
  });

  // Update profile data on form submission
  $("#update-profile-form").submit(function (e) {
    e.preventDefault();
    var age = $("#age").val();
    var dob = $("#dob").val();
    var contact = $("#contact").val();

    $.ajax({
      url: "/guvi_in/php/update_profile.php",
      method: "POST",
      dataType: "json",
      data: {
        sessionID: sessionID,
        age: age,
        dob: dob,
        contact: contact,
      },
      success: function (response) {
        alert(response.message);
      },
    });
  });

  $("#logout-button").click(function () {
    $.ajax({
      url: "/guvi_in/php/logout.php",
      method: "POST",
      dataType: "json",
      data: {
        sessionID: sessionID,
      },
      success: function (response) {
        if (response.success) {
          alert("Logged out successfully!");
          sessionID = ""; // Clear sessionID in JavaScript
          window.location.href = "/guvi_in/templates/login.html"; // Redirect to login page
        } else {
          alert("Logout failed: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: " + status + ": " + error);
      },
    });
  });
});
