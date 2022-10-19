function togglePassword(inputField, buttonField) {
  if ($("#" + inputField + "").attr("type") == "text") {
    $("#" + inputField + "").attr("type", "password");
    $("#" + buttonField + "").addClass("fa-eye");
    $("#" + buttonField + "").removeClass("fa-eye-slash");
  } else if ($("#" + inputField + "").attr("type") == "password") {
    $("#" + inputField + "").attr("type", "text");
    $("#" + buttonField + "").removeClass("fa-eye");
    $("#" + buttonField + "").addClass("fa-eye-slash");
  }
}

//   function validateNewPasswords() {
//     if ($("#newPassword").val().trim() == "") {
//       $("#new_password_required").removeClass("d-none");
//       $("#newPassword").addClass("is-invalid");
//       return false;
//     } else if (!passwordValidation($("#newPassword").val().trim())) {
//       $("#invalid_new_password_required").removeClass("d-none");
//       $("#newPassword").addClass("is-invalid");
//       return false;
//     } else if (
//       $("#reNewPassword").val().trim() != $("#newPassword").val().trim()
//     ) {
//       $("#renew_password_required").removeClass("d-none");
//       $("#reNewPassword").addClass("is-invalid");
//       return false;
//     } else {
//       $(".requiredField").addClass("d-none");
//       $(".form-control").removeClass("is-invalid");
//       return true;
//     }
//   }

//   function passwordValidation(password) {
//     if (!password.match("^(?=.*[a-z])")) {
//       return false;
//     } else if (!password.match("^(?=.*[A-Z])")) {
//       return false;
//     } else if (!password.match("^(?=.*[0-9])")) {
//       return false;
//     } else if (!password.match("^(?=.*[@$!%*?&])")) {
//       return false;
//     } else if (!password.match("(?=.{8,64})")) {
//       return false;
//     } else {
//       return true;
//     }
//   }

export { togglePassword };
// export { validateNewPasswords };
