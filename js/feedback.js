const feedbackForm = document.getElementById("feedback-form");

const nameField = document.getElementById("name");
const nameError = document.getElementById("name-error");

const emailField = document.getElementById("email");
const emailError = document.getElementById("email-error");

const bottleIdField = document.getElementById("bottle-id");
const bottleIdError = document.getElementById("bottle-id-error");

const feedbackField = document.getElementById("feedback");
const feedbackError = document.getElementById("feedback-error");

function validateFeedbackForm(event) {
  event.preventDefault();

  nameError.textContent = "";
  emailError.textContent = "";
  bottleIdError.textContent = "";
  feedbackError.textContent = "";

  let isValid = true;

  if (nameField.value.trim() === "") {
    nameError.textContent = "Name is required";
    nameError.style.display = "block";
    isValid = false;
  } else if (nameField.value.length < 3) {
    nameError.textContent = "Name must be at least 3 characters";
    nameError.style.display = "block";
    isValid = false;
  }

  if (emailField.value.trim() === "") {
    emailError.textContent = "Email is required";
    emailError.style.display = "block";
    isValid = false;
  } else if (!emailField.value.includes("@")) {
    emailError.textContent = "Invalid email";
    emailError.style.display = "block";
    isValid = false;
  }

  if (bottleIdField.value.trim() === "") {
    bottleIdError.textContent = "Bottle Id is required";
    bottleIdError.style.display = "block";
    isValid = false;
  } else if (bottleIdField.value.length < 3) {
    bottleIdError.textContent = "Bottle Id must be at least 3 characters";
    bottleIdError.style.display = "block";
    isValid = false;
  }

  if (feedbackField.value.trim() === "") {
    feedbackError.textContent = "Feedback is required";
    feedbackError.style.display = "block";
    isValid = false;
  } else if (feedbackField.value.length < 20) {
    feedbackError.textContent = "Feedback must be at least 20 characters";
    feedbackError.style.display = "block";
    isValid = false;
  }

  if (isValid) {
    feedbackForm.reset();
    window.location.href = "./thanksfeedback";
  }
}

feedbackForm.addEventListener("submit", validateFeedbackForm);
