document.addEventListener("DOMContentLoaded", function () {
  // code akan berjalan setelah DOM selesai dimuat
  const form = document.getElementById("registrationForm");
  if (form) {
    form.addEventListener("submit", function (event) {
      const password = document.getElementById("pass").value;
      const confirmPassword = document.getElementById("cpass").value;

      if (password !== confirmPassword) {
        alert("Konfirmasi password tidak sesuai.");
        event.preventDefault();
      }
    });
  }
});

function toggleDropdown() {
  var dropdown = document.getElementById("myDropdown");
  dropdown.style.display =
    dropdown.style.display === "block" ? "none" : "block";
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".nav-link")) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.style.display === "block") {
        openDropdown.style.display = "none";
      }
    }
  }
};
