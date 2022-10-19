// var regexPattern = "(?=(?:[^a-zA-Z]*[a-zA-Z]){2}).*";
function validateEmail($email) {
  if ($email != "") {
    var filter =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!filter.test($email)) {
      return "Not valid";
    } else {
      return "Valid";
    }
  } else {
    return "Valid";
  }
}
function validateAmountNumber(e) {
  var key = e.keyCode;
  var result = key == 8 || key == 32 || (key >= 48 && key <= 57) || key == 43;
  return result;
}

export { validateAmountNumber };
export { validateEmail };
// export { validateImageFileType };
