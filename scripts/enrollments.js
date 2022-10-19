$(document).ready(function () {
  $("#enrollmentsTable").DataTable();
  $(document).on("click", ".btn-approve", function () {
    let enroll = $(this).data("enrollment");
    var choice = confirm(
      "Are you sure you want to approve this trainee course enrollment?"
    );
    if (choice) {
      var url = $("#globalLink").val().trim() + "enroll/enrollments";
      var field = "";
      field +=
        '<input type="hidden" name="enrollToApprove" value="' + enroll + '"/>';
      if (enroll != "") {
        $("body").append(
          '<form action="' +
            url +
            '" method="POST" id="enrollForm">' +
            field +
            "</form>"
        );
        $("#enrollForm").submit();
      }
    }
  });
  $(document).on("click", "#btnPrint", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $("#enrollmentsTable").printThis({
      debug: false,
      importCSS: true,
      importStyle: true,
      printContainer: true,
      loadCSS: "/styles/bootstrap.min.css",
      pageTitle: "",
      removeInline: false,
      printDelay: 333,
      header: null,
      formValues: true,
    });
  });
});
