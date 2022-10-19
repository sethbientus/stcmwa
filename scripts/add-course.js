import { validateAmountNumber } from "./validators.js";
$(document).ready(function () {
  $(function () {
    $(".startDate").datetimepicker({
      minDate: new Date(),
      format: "YYYY-MM-DD",
    });
  });

  $(function () {
    $(".endDate").datetimepicker({
      minDate: new Date(),
      format: "YYYY-MM-DD",
    });
  });
  $("#courseCost").keypress(function (e) {
    if (!validateAmountNumber(e)) {
      return false;
    }
  });
  $("#courseCost").on("paste", function (e) {
    if (!validateAmountNumber(e)) {
      return false;
    }
  });

  $("#addCoure").click(function () {
    $(".requiredField").addClass("d-none");
    $(".form-control").removeClass("is-invalid");
    if ($("#courseName").val().trim() == "") {
      $("#courseNameRequired").removeClass("d-none");
      $("#courseNameRequired").text("Enter name (title) of the course");
      $("#courseName").addClass("is-invalid");
      return false;
    } else if ($("#courseCode").val().trim() == "") {
      $("#courseCodeRequired").removeClass("d-none");
      $("#courseCodeRequired").text("Enter the code of the course");
      $("#courseCode").addClass("is-invalid");
      return false;
    } else if (checkCourseCode($("#courseCode").val().trim()) == "Taken") {
      $("#courseCodeRequired").removeClass("d-none");
      $("#courseCodeRequired").text("This course code is already exist.");
      $("#courseCode").addClass("is-invalid");
      return false;
    } else if ($("#courseCost").val().trim() == "") {
      $("#courseCostRequired").removeClass("d-none");
      $("#courseCostRequired").text("Enter the cost (price) of the course");
      $("#courseCost").addClass("is-invalid");
      return false;
    } else if (parseInt($("#courseCost").val().trim()) <= 0) {
      $("#courseCostRequired").removeClass("d-none");
      $("#courseCostRequired").text(
        "The cost (price) of the course must be greater than zero"
      );
      $("#courseCost").addClass("is-invalid");
      return false;
    } else if ($("#courseStartDate").val().trim() == "") {
      $("#startAtRequired").removeClass("d-none");
      $("#startAtRequired").text("Enter the starting date of the course");
      $("#courseStartDate").addClass("is-invalid");
      return false;
    } else if ($("#courseEndDate").val().trim() == "") {
      $("#endAtRequired").removeClass("d-none");
      $("#endAtRequired").text("Enter the ending date of the course");
      $("#courseEndDate").addClass("is-invalid");
      return false;
    } else {
      $(".requiredField").addClass("d-none");
      $(".form-control").removeClass("is-invalid");
      return true;
    }
  });

  function checkCourseCode($code) {
    var checker = 0;
    let link = $("#globalLink").val().trim() + "controllers/course.php";
    $.ajax({
      async: false,
      url: link,
      method: "POST",
      data: { courseCode: $code, checkCourseCode: "checkCourseCode" },
      success: function (response) {
        if (response == "Code Found") {
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
