import { validateAmountNumber } from "./validators.js";
$(document).ready(function () {
  $("#courseCostToPay").keypress(function (e) {
    if (!validateAmountNumber(e)) {
      return false;
    }
  });
  $("#courseCostToPay").on("paste", function (e) {
    if (!validateAmountNumber(e)) {
      return false;
    }
  });

  $("#payCourse").click(function () {
    $(".requiredField").addClass("d-none");
    $(".form-control").removeClass("is-invalid");
    if ($("#courseCostToPay").val().trim() == "") {
      $("#amountToPayRequired").removeClass("d-none");
      $("#amountToPayRequired").text("Enter the amount to pay");
      $("#courseCostToPay").addClass("is-invalid");
      return false;
    } else if (parseInt($("#courseCostToPay").val().trim()) <= 0) {
      $("#amountToPayRequired").removeClass("d-none");
      $("#amountToPayRequired").text(
        "The amount to pay for the course must be greater than zero"
      );
      $("#courseCostToPay").addClass("is-invalid");
      return false;
    } else {
      $(".requiredField").addClass("d-none");
      $(".form-control").removeClass("is-invalid");
      return true;
    }
  });
});
