$(document).ready(function () {
  $("#usersTable").DataTable();
  $(document).on("click", ".btn-supsend", function () {
    let userNo = $(this).data("user");
    var choice = confirm(
      "Are you sure you want to suspend this user's account?"
    );
    if (choice) {
      var url = $("#globalLink").val().trim() + "users/users";
      var field = "";
      field +=
        '<input type="hidden" name="userToSuspend" value="' + userNo + '"/>';
      if (userNo != "") {
        $("body").append(
          '<form action="' +
            url +
            '" method="POST" id="usersForm">' +
            field +
            "</form>"
        );
        $("#usersForm").submit();
      }
    }
  });
  $(document).on("click", ".btn-activate", function () {
    let userNo = $(this).data("user");
    var choice = confirm(
      "Are you sure you want to activate this user's account?"
    );
    if (choice) {
      var url = $("#globalLink").val().trim() + "users/users";
      var field = "";
      field +=
        '<input type="hidden" name="userToActivate" value="' + userNo + '"/>';
      if (userNo != "") {
        $("body").append(
          '<form action="' +
            url +
            '" method="POST" id="usersForm">' +
            field +
            "</form>"
        );
        $("#usersForm").submit();
      }
    }
  });
});
