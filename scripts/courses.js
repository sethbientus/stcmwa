$(document).ready(function () {
  $("#coursesTable").DataTable();
  $(document).on("click", ".btn-remove", function () {
    let course = $(this).data("course");
    var choice = confirm(
      "Are you sure you want to remove the selected course?"
    );
    if (choice) {
      var url = $("#globalLink").val().trim() + "course/courses";
      var field = "";
      field +=
        '<input type="hidden" name="courseToRemove" value="' + course + '"/>';
      if (course != "") {
        $("body").append(
          '<form action="' +
            url +
            '" method="POST" id="courseForm">' +
            field +
            "</form>"
        );
        $("#courseForm").submit();
      }
    }
  });
  $(document).on("click", ".btn-add-back", function () {
    let course = $(this).data("course");
    var choice = confirm(
      "Are you sure you want to add back the selected course?"
    );
    if (choice) {
      var url = $("#globalLink").val().trim() + "course/courses";
      var field = "";
      field +=
        '<input type="hidden" name="courseToAddBack" value="' + course + '"/>';
      if (course != "") {
        $("body").append(
          '<form action="' +
            url +
            '" method="POST" id="courseForm">' +
            field +
            "</form>"
        );
        $("#courseForm").submit();
      }
    }
  });
});
