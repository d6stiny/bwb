const loginForm = document.getElementById("login-form");
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");
const emailError = document.getElementById("email-error");
const passwordError = document.getElementById("password-error");

function validateLoginForm(event) {
  event.preventDefault();
  let isValid = true;

  // Reset errors
  emailError.style.display = "none";
  passwordError.style.display = "none";

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

  // If validation passes, submit the form via AJAX
  if (isValid) {
    const formData = new FormData(loginForm);

    fetch(loginForm.action, {
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
          passwordError.textContent = "Invalid credentials";
          passwordError.style.display = "block";
        } else {
          console.error("Error:", error);
        }
      });
  }
}

loginForm.addEventListener("submit", validateLoginForm);
