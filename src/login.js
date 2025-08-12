const verifyLogin = () => {
  fullName = document.getElementById("fullName");
  nameValue = fullName.value.trim();

  if (nameValue === "") {
    fullName.setCustomValidity("Please enter your full name.");
    return;
  }

  if (!nameValue.match(/^[a-zA-Z\s]*$/)) {
    fullName.setCustomValidity(
      "Full name should only contain letters and spaces"
    );
    return;
  }
}

const togglePasswordVisibility = () => {
  var passwordInput = document.getElementById("password");
  if (passwordInput.type === "password") {
      passwordInput.type = "text";
  } else {
      passwordInput.type = "password";
  }
}

window.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const registrationStatus = urlParams.get('registration');

  // Check if registration was successful
  if (registrationStatus === 'success') {
    // Display a success message to the user after a delay
    setTimeout(function() {
      alert('Registration successful! Please log in.');
    }, 100);
  }
});