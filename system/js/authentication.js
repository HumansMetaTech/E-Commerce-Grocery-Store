$(document).ready(function () {
  $("form").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
console.log(formData);
    $.ajax({
      type: "POST",
      url: "../system/actions/authentication.php",
      data: formData,
      success: function (response) {
        if (response === "success") {
          // Redirect to the desired page
          window.location.href = "system-index.php";
        } else {
          alert("Invalid Username or Password");
        }
      },
      error: function () {
        alert("An error occurred during the AJAX request");
      },
    });
  });
});
