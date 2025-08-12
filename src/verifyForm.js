
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
  if (contactNumber.length < 9 || contactNumber.length > 10) {
    contactNumberInput.setCustomValidity(
      "Contact number must be between 9-10 digit"
    );
    return false;
  }
  return true;
};

const validateDates = () => {
  const startDateInput = document.getElementById("start-date");
  const endDateInput = document.getElementById("end-date");

  const startDate = new Date(startDateInput.value);
  const endDate = new Date(endDateInput.value);

  if (endDate < startDate) {
    endDateInput.setCustomValidity("End date cannot be before start date.");
    return false;
  }
  return true;
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

  if (startDate.getTime() === endDate.getTime() && endTime <= startTime) {
    endTimeInput.setCustomValidity("End time must be after start time.");
    return false;
  }
  return true;
};

const resetError = (id) => {
  const inputField = document.getElementById(id);
  inputField.setCustomValidity("");
};

const validateForm = (e) => {
  const eventname = document.getElementById("event-name");
  const contactNumber = document.getElementById("contact-number");
  const startDate = document.getElementById("start-date");
  const endDate = document.getElementById("end-date");
  const startTime = document.getElementById("start-time");
  const endTime = document.getElementById("end-time");
  const venue = document.getElementById("venue");
  const guest = document.getElementById("guest");

  let valid = true;

  if (eventname.value.trim() === "") {
    eventname.setCustomValidity("Please enter your event name.");
    valid = false;
  }

  if (contactNumber.value.trim() === "") {
    contactNumber.setCustomValidity("Please enter your contact number.");
    valid = false;
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
  }

  if (guest.value.trim() === "") {
    guest.setCustomValidity("Please enter the number of guests.");
    valid = false;
  }

  const eventThemeOptions = document.querySelectorAll(
    'input[name="event-theme"]'
  );

  if (eventThemeOptions.length !== 0) {
    let isEventThemeSelected = false;

    eventThemeOptions.forEach((option) => {
      if (option.checked) {
        isEventThemeSelected = true;
      }
    });

    valid = isEventThemeSelected ? true : false;

    if (!isEventThemeSelected) {
      const option = document.getElementById("wedding");
      option.setCustomValidity("Please select one of these options");
      return;
    }
  }

  if(valid){
    valid = validateContactNum();
    valid = validateDates();
    valid = validateTimes();
  }
  
};
