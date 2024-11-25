// signup.js
const signUpForm = document.getElementById("signup-form");
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");
const confirmPasswordField = document.getElementById("confirm-password");
const emailError = document.getElementById("email-error");
const passwordError = document.getElementById("password-error");
const confirmPasswordError = document.getElementById("confirm-password-error");

function validateSignUpForm(event) {
  event.preventDefault();
  let isValid = true;

  // Reset errors
  emailError.style.display = "none";
  passwordError.style.display = "none";
  confirmPasswordError.style.display = "none";

  // Email validation
  if (!emailField.value) {
    emailError.textContent = "Email is required";
    emailError.style.display = "block";
    isValid = false;
  } else if (!emailField.value.includes("@")) {
    emailError.textContent = "Please enter a valid email";
    emailError.style.display = "block";
    isValid = false;
  }

  // Password validation
  if (!passwordField.value) {
    passwordError.textContent = "Password is required";
    passwordError.style.display = "block";
    isValid = false;
  } else if (passwordField.value.length < 3) {
    passwordError.textContent = "Password must be at least 3 characters";
    passwordError.style.display = "block";
    isValid = false;
  }

  // Confirm password validation
  if (confirmPasswordField.value.trim() === "") {
    confirmPasswordError.textContent = "Confirm password is required";
    confirmPasswordError.style.display = "block";
    isValid = false;
  } else if (confirmPasswordField.value !== passwordField.value) {
    confirmPasswordError.textContent = "Passwords do not match";
    confirmPasswordError.style.display = "block";
    isValid = false;
  }

  // If validation passes, submit form via AJAX
  if (isValid) {
    const formData = new FormData(signUpForm);

    fetch(signUpForm.action, {
      method: "POST",
      body: formData,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => {
        if (!response.ok) {
          return response.json().then((data) => Promise.reject(data));
        }
        window.location.href = "/dashboard";
      })
      .catch((error) => {
        if (error.error) {
          emailError.textContent = error.error;
          emailError.style.display = "block";
        } else {
          console.error("Error:", error);
        }
      });
  }
}

signUpForm.addEventListener("submit", validateSignUpForm);
