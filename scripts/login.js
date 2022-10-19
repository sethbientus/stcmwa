import { togglePassword } from "./password.js";
import { validateEmail } from "./validators.js";
$(document).ready(function () {
  $("#login").click(function () {
    $(".required_field").addClass("d-none");
    $(".form-control").removeClass("is-invalid");
    if ($("#email").val().trim() == "") {
      $("#email_required").removeClass("d-none");
      $("#email_required").text("Enter email address");
      $("#email").addClass("is-invalid");
      return false;
    } else if (validateEmail($("#email").val().trim()) != "Valid") {
      $("#email_required").removeClass("d-none");
      $("#email_required").text("Invalid email address");
      $("#email").addClass("is-invalid");
      return false;
    } else if ($("#password").val().trim() == "") {
      $("#password_required").removeClass("d-none");
      $("#password_required").text("Password required");
      $("#password").addClass("is-invalid");
      return false;
    } else {
      $(".required_field").addClass("d-none");
      $(".form-control").removeClass("is-invalid");
      return true;
    }
  });

  $("#showPwd").click(function () {
    togglePassword("password", "showPwdEye");
    $("#password").focus();
  });
});
