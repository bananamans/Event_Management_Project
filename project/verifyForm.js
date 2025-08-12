Loggedin = false;
if (!Loggedin) {
  document.getElementById("navProfilePic").innerHTML =
    '<a href="login.html">Login</a>';
}
document.getElementById("logo").addEventListener("click", () => {
  window.location.href = "index.html";
});

const validateNumber = (event) => {
  const keyCode = event.keyCode || event.which;
  const keyValue = String.fromCharCode(keyCode);

  // Regular expression to match only numbers
  const numericRegex = /^[0-9]+$/;

  if (!numericRegex.test(keyValue)) {
    event.preventDefault(); // Prevent the default keypress behavior
    return false;
  }
};

const validateContactNum = () => {
  var contactNumberInput = document.getElementById("contact-number");
  var contactNumber = contactNumberInput.value.trim();
  if (contactNumber.length < 7 || contactNumber.length > 8) {
    contactNumberInput.setCustomValidity(
      "Contact number must be between 7-8 digit"
    );
  } else {
    contactNumberInput.setCustomValidity("");
  }
};

const validateDates = () => {
  const startDateInput = document.getElementById("start-date");
  const endDateInput = document.getElementById("end-date");

  const startDate = new Date(startDateInput.value);
  const endDate = new Date(endDateInput.value);

  if (endDate < startDate) {
    endDateInput.setCustomValidity("End date cannot be before start date.");
  } else {
    endDateInput.setCustomValidity("");
  }

  validateTimes();
};

const validateTimes = () => {
  const startTimeInput = document.getElementById("start-time");
  const endTimeInput = document.getElementById("end-time");
  const startDateInput = document.getElementById("start-date");
  const endDateInput = document.getElementById("end-date");

  const startDate = new Date(startDateInput.value);
  const endDate = new Date(endDateInput.value);

  const startTime = startTimeInput.value;
  const endTime = endTimeInput.value;

  if (!startTime || !endTime) {
    return;
  }

  if (startDate.getTime() === endDate.getTime() && endTime <= startTime) {
    endTimeInput.setCustomValidity("End time must be after start time.");
  } else {
    endTimeInput.setCustomValidity("");
  }
};

const validateName = () => {
  const fullname = document.getElementById("fullname");
  fullname.setCustomValidity("");
};
const validateVenue = () => {
  const venue = document.getElementById("venue");
  venue.setCustomValidity("");
};

const validateGuest = () => {
  const guest = document.getElementById("guest");
  guest.setCustomValidity("");
};

const validateForm = (e) => {
  //e.preventDefault();
  const fullname = document.getElementById("fullname");
  const contactNumber = document.getElementById("contact-number");
  const startDate = document.getElementById("start-date");
  const endDate = document.getElementById("end-date");
  const startTime = document.getElementById("start-time");
  const endTime = document.getElementById("end-time");
  const venue = document.getElementById("venue");
  const guest = document.getElementById("guest");

  let valid = true;

  if (fullname.value.trim() === "") {
    fullname.setCustomValidity("Please enter your full name.");
    valid = false;
  } else {
    fullname.setCustomValidity("");
  }

  if (contactNumber.value.trim() === "") {
    contactNumber.setCustomValidity("Please enter your contact number.");
    valid = false;
  } else {
    contactNumber.setCustomValidity("");
  }

  if (startDate.value.trim() === "") {
    startDate.setCustomValidity("Please enter the start date.");
    valid = false;
  } else {
    startDate.setCustomValidity("");
  }

  if (endDate.value.trim() === "") {
    endDate.setCustomValidity("Please enter the end date.");
    valid = false;
  } else {
    endDate.setCustomValidity("");
  }
  if (startTime.value.trim() === "") {
    startTime.setCustomValidity("Please enter the start time.");
    valid = false;
  } else {
    startTime.setCustomValidity("");
  }

  if (endTime.value.trim() === "") {
    endTime.setCustomValidity("Please enter the end time.");
    valid = false;
  } else {
    endTime.setCustomValidity("");
  }

  if (venue.value.trim() === "") {
    venue.setCustomValidity("Please enter the venue.");
    valid = false;
  } else {
    venue.setCustomValidity("");
  }

  if (guest.value.trim() === "") {
    guest.setCustomValidity("Please enter the number of guests.");
    valid = false;
  } else {
    guest.setCustomValidity("");
  }

  const eventThemeOptions = document.querySelectorAll(
    'input[name="event-theme"]'
  );

  if (eventThemeOptions.length !== 0) {
    let isEventThemeSelected = false;
    const eventThemeGroup = document.getElementById("genderGroup");

    eventThemeOptions.forEach((option) => {
      if (option.checked) {
        isEventThemeSelected = true;
      }
    });

    if (!isEventThemeSelected) {
      eventThemeGroup.setCustomValidity("Please select an event theme.");
      valid = false;
    } else {
      eventThemeGroup.setCustomValidity("");
      valid = true;
    }
  }
  console.log("run");
  if (valid && !Loggedin) {
    e.preventDefault();
    alert("Please log in first!");
    window.location.assign("login.html");
  }
};
