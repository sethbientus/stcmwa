$(document).ready(function () {
  $("#paymentstable").DataTable();
  $(document).on("click", "#btnPrint", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $("#paymentstable").printThis({
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
