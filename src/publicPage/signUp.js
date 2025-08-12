window.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const registrationStatus = urlParams.get('registration');

  // Check if registration was successful
  if (registrationStatus === 'failed') {
    // Display a success message to the user after a delay
    setTimeout(function() {
      alert('Sign up failed due to network error! Please try again.');
    }, 100);
  }
});

const togglePasswordVisibility = () => {
  var passwordInput = document.getElementById("password");
  if (passwordInput.type === "password") {
      passwordInput.type = "text";
  } else {
      passwordInput.type = "password";
  }
}

const toggleConfirmPasswordVisibility = () => {
  var passwordInput = document.getElementById("confirm-password");
  if (passwordInput.type === "password") {
      passwordInput.type = "text";
  } else {
      passwordInput.type = "password";
  }
}

const resetValidity = (id) => {
  const inputField = document.getElementById(id);
  inputField.setCustomValidity("");
};

const verifySignup = (e) => {
  const fullName = document.getElementById("fullName");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");
  const email = document.getElementById("email");

  const nameValue = fullName.value.trim();
  const passwordValue = password.value.trim();
  const conPassValue = confirmPassword.value.trim();
  const emailValue = email.value.trim();

  let valid = true;

  if (nameValue === "") {
    fullName.setCustomValidity("Please enter your full name.");
    valid = false;
    return;
  }

  if (passwordValue === "") {
    password.setCustomValidity("Please enter your password.");
    valid = false;
    return;
  }

  if (conPassValue === "") {
    confirmPassword.setCustomValidity("Please enter confirm password.");
    valid = false;
    return;
  }

  if (emailValue === "") {
    email.setCustomValidity("Please enter your email.");
    valid = false;
    return;
  }

  if (valid) {
    // Validate full name
    if (!nameValue.match(/^[a-zA-Z\s]*$/)) {
      valid = false;
      fullName.setCustomValidity(
        "Full name should only contain letters and spaces"
      );
      return;
    }

    // Validate email
    if (!/\S+@\S+\.\S+/.test(emailValue)) {
      valid = false;
      email.setCustomValidity("Please enter a valid email address");
      return;
    }

    // Validate password
    if (passwordValue.length < 6) {
      valid = false;
      password.setCustomValidity("Password at least 6 characters long");
      return;
    }
    if (!/[A-Z]/.test(passwordValue)) {
      valid = false;
      password.setCustomValidity("Password at least one uppercase letter");
      return;
    }
    if (!/[0-9]/.test(passwordValue)) {
      valid = false;
      password.setCustomValidity("Password at least one numeric character");
      return;
    }
    if (!/[\W]/.test(passwordValue)) {
      valid = false;
      password.setCustomValidity("Password at least one special character");
      return;
    }
    if (/\s/.test(passwordValue)) {
      valid = false;
      password.setCustomValidity("Password should not contain spaces");
      return;
    }

    if (passwordValue !== conPassValue) {
      valid = false;
      confirmPassword.setCustomValidity(
        "Please make sure re-enter password is same as password"
      );
      return;
    }
    //verify whether name is already in the database
    $.ajax({
      type: "POST",
      url: "../scanUsername.php",
      data: { username: nameValue },
      dataType: "json",
      async:false,
      beforeSend: function() {
        // Change the cursor style to "wait" before the request is sent
        $("body").addClass("loading");
      },
      success: function (res) {
        if (res.status == "taken") {
          valid = false;
          fullName.setCustomValidity("name has been taken");
        }
      },
      complete: function() {
        // Revert the cursor style back to default after the request is completed
        $("body").removeClass("loading");
      },
    });
  }
};
