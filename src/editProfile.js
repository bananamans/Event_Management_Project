const resetValidity = (id) => {
    const inputField = document.getElementById(id);
    inputField.setCustomValidity("");
  };

  
const togglePasswordVisibility = () => {
  var passwordInput = document.getElementById("newPassword");
  if (passwordInput.type === "password") {
      passwordInput.type = "text";
  } else {
      passwordInput.type = "password";
  }
}

const toggleOldPasswordVisibility = () => {
  var passwordInput = document.getElementById("oldPassword");
  if (passwordInput.type === "password") {
      passwordInput.type = "text";
  } else {
      passwordInput.type = "password";
  }
}

const verifyChanges = (e) => {
    const newName = document.getElementById("newName");
    const newPassword = document.getElementById("newPassword");
    const newEmail = document.getElementById("newEmail");
  
    const newNameValue = newName.value.trim();
    const newPasswordValue = newPassword.value.trim();
    const newEmailValue = newEmail.value.trim();
  
    let valid = true;
  
    if (newNameValue === "") {
      fullName.setCustomValidity("Username cannot be empty");
      valid = false;
      return;
    }
  
    if (newPasswordValue === "") {
      password.setCustomValidity("Password cannot be empty");
      valid = false;
      return;
    }
  
    if (newEmailValue === "") {
      email.setCustomValidity("Email cannot be empty");
      valid = false;
      return;
    }
  
    if (valid) {
      // Validate full name
      if (!newNameValue.match(/^[a-zA-Z\s]*$/)) {
        valid = false;
        fullName.setCustomValidity(
          "Full name should only contain letters and spaces"
        );
        return;
      }
  
      // Validate email
      if (!/\S+@\S+\.\S+/.test(newEmailValue)) {
        valid = false;
        email.setCustomValidity("Please enter a valid email address");
        return;
      }
  
      // Validate password
      if (newPasswordValue.length < 6) {
        valid = false;
        password.setCustomValidity("Password at least 6 characters long");
        return;
      }
      if (!/[A-Z]/.test(newPasswordValue)) {
        valid = false;
        password.setCustomValidity("Password at least one uppercase letter");
        return;
      }
      if (!/[0-9]/.test(newPasswordValue)) {
        valid = false;
        password.setCustomValidity("Password at least one numeric character");
        return;
      }
      if (!/[\W]/.test(newPasswordValue)) {
        valid = false;
        password.setCustomValidity("Password at least one special character");
        return;
      }
      if (/\s/.test(newPasswordValue)) {
        valid = false;
        password.setCustomValidity("Password should not contain spaces");
        return;
      }
    }
  };