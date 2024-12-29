// LOGIN BUTTOM
function login() {
  window.location.href = "pages/login.php";
}

function logout() {
  window.location.href = "logout.php";
}

function register() {
  window.location.href = "pages/register.php";
}

// SHOW PASSWORD
function togglePasswordVisibility(passID, eyeIconID, offIconID) {
  var passField = document.getElementById(passID);
  var eyeIcon = document.getElementById(eyeIconID);
  var eyeOffIcon = document.getElementById(offIconID);

  if (passField.type === "password") {
    passField.type = "text";
    eyeIcon.style.display = "none";
    eyeOffIcon.style.display = "inline";
  } else {
    passField.type = "password";
    eyeIcon.style.display = "inline";
    eyeOffIcon.style.display = "none";
  }
}
