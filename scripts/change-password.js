import { togglePassword } from "./password.js";
$(document).ready(function () {
  $("#changePassword").click(function () {
    $(".requiredField").addClass("d-none");
    $(".form-control").removeClass("is-invalid");
    if ($("#oldPassword").val().trim() == "") {
      $("#oldPwdRequired").removeClass("d-none");
      $("#oldPwdRequired").text("Enter your old password");
      $("#oldPassword").addClass("is-invalid");
      return false;
    } else if ($("#newPassword").val().trim() == "") {
      $("#newPwdRequired").removeClass("d-none");
      $("#newPwdRequired").text("Enter new password you want to use");
      $("#newPassword").addClass("is-invalid");
      return false;
    } else if ($("#reNewPassword").val().trim() == "") {
      $("#reNewPwdRequired").removeClass("d-none");
      $("#reNewPwdRequired").text("Re-enter the new password");
      $("#reNewPassword").addClass("is-invalid");
      return false;
    } else if (
      $("#reNewPassword").val().trim() != $("#newPassword").val().trim()
    ) {
      $("#reNewPwdRequired").removeClass("d-none");
      $("#reNewPwdRequired").text("New passwords do not macth");
      $("#reNewPassword").addClass("is-invalid");
      return false;
    } else if (
      $("#oldPassword").val().trim() == $("#newPassword").val().trim()
    ) {
      $("#newPwdRequired").removeClass("d-none");
      $("#newPwdRequired").text(
        "New password must be different to old password"
      );
      $("#newPassword").addClass("is-invalid");
      return false;
    } else {
      $(".requiredField").addClass("d-none");
      $(".form-control").removeClass("is-invalid");
      return true;
    }
  });

  $("#showOldPwd").click(function () {
    togglePassword("oldPassword", "showOldPwdEye");
    $("#oldPassword").focus();
  });
  $("#showReNewPwd").click(function () {
    togglePassword("reNewPassword", "showReNewPwdEye");
    $("#reNewPassword").focus();
  });
  $("#showNewPwd").click(function () {
    togglePassword("newPassword", "showNewPwdEye");
    $("#newPassword").focus();
  });
});
