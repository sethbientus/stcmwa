import { validateEmail } from "./validators.js";
$(document).ready(function () {
  $("#register").click(function () {
    $(".requiredField").addClass("d-none");
    $(".form-control").removeClass("is-invalid");
    if ($("#firstName").val().trim() == "") {
      $("#firstNameRequired").removeClass("d-none");
      $("#firstNameRequired").text("Enter user first name");
      $("#firstName").addClass("is-invalid");
      return false;
    } else if ($("#lastName").val().trim() == "") {
      $("#lastNameRequired").removeClass("d-none");
      $("#lastNameRequired").text("Enter user last name");
      $("#lastName").addClass("is-invalid");
      return false;
    } else if ($("#email").val().trim() == "") {
      $("#emailRequired").removeClass("d-none");
      $("#emailRequired").text("Enter user email address");
      $("#email").addClass("is-invalid");
      return false;
    } else if (validateEmail($("#email").val().trim()) != "Valid") {
      $("#emailRequired").removeClass("d-none");
      $("#emailRequired").text("Invalid email address");
      $("#email").addClass("is-invalid");
      return false;
    } else if (checkUserEmail($("#email").val().trim()) == "Taken") {
      $("#emailRequired").removeClass("d-none");
      $("#emailRequired").text("This email is already taken.");
      $("#email").addClass("is-invalid");
      return false;
    } else if ($("#userType").val().trim() == "0") {
      $("#roleRequired").removeClass("d-none");
      $("#roleRequired").text("Select type / role of user");
      $("#userType").addClass("is-invalid");
      return false;
    } else {
      $(".requiredField").addClass("d-none");
      $(".form-control").removeClass("is-invalid");
      return true;
    }
  });

  function checkUserEmail($email) {
    var checker = 0;
    let link = $("#globalLink").val().trim() + "controllers/user.php";
    $.ajax({
      async: false,
      url: link,
      method: "POST",
      data: { email: $email, checkUserEmail: "checkUserEmail" },
      success: function (response) {
        if (response == "Email Found") {
          checker = 1;
        }
      },
    });
    if (checker == 1) {
      return "Taken";
    } else {
      return "Not Taken";
    }
  }
});
