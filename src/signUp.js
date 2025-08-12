Loggedin = false;
if (!Loggedin) {
  document.getElementById("navProfilePic").innerHTML =
    '<a href="login.html">Login</a>';
}
document.getElementById("logo").addEventListener("click", () => {
  window.location.href = "index.html";
});

verifySignup = (e) => {
  e.preventDefault();
  const fullName = document.getElementById("fullName").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document
    .getElementById("confirm-password")
    .value.trim();
  const genderOptions = document.querySelectorAll('input[name="gender"]');

  let isValid = true;
  let errorMessage = "";

  if (
    fullName === "" ||
    email === "" ||
    password === "" ||
    confirmPassword === ""
  ) {
    isValid = false;
    errorMessage += "Please fill in all the required fields.\n";
  }

  // Validate full name
  if (!fullName.match(/^[a-zA-Z\s]*$/)) {
    isValid = false;
    errorMessage += "Full name should only contain letters and spaces.\n";
  }

  // Validate email
  if (!/\S+@\S+\.\S+/.test(email)) {
    isValid = false;
    errorMessage += "Please enter a valid email address.\n";
  }

  // Validate password
  if (password.length < 6) {
    isValid = false;
    errorMessage += "Password should be at least 6 characters long.\n";
  } else if (
    !/[A-Z]/.test(password) ||
    !/[0-9]/.test(password) ||
    !/[\W]/.test(password) ||
    /\s/.test(password)
  ) {
    isValid = false;
    errorMessage +=
      "Password should contain at least one uppercase letter, one numeric character, one special character, and no spaces.\n";
  }

  if (password !== confirmPassword) {
    isValid = false;
    errorMessage += "Please make sure re-enter password is same as password\n";
  }

  let isGenderSelected = false;

  genderOptions.forEach((option) => {
    if (option.checked) {
      isGenderSelected = true;
    }
  });

  if (!isGenderSelected) {
    isValid = false;
    errorMessage += "Please select your gender\n";
  }

  if (isValid) {
    alert("Form submitted successfully");
    window.location.href = "login.html";
  } else {
    alert(errorMessage);
  }
};
