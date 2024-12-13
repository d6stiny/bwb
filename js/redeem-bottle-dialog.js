const addBottleDialog = document.getElementById("redeem-bottle-dialog");

const openAddBottleDialogBtn = document.getElementById(
  "open-redeem-bottle-dialog-btn"
);

const closeAddBottleDialogBtn = document.getElementById(
  "close-redeem-bottle-dialog"
);

openAddBottleDialogBtn.addEventListener("click", () => {
  addBottleDialog.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddBottleDialogBtn.addEventListener("click", () => {
  addBottleDialog.style.display = "none";
  document.body.style.overflow = "auto";
});

window.addEventListener("click", (event) => {
  if (event.target === addBottleDialog) {
    addBottleDialog.style.display = "none";
    document.body.style.overflow = "auto";
  }
});

window.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && addBottleDialog.style.display === "flex") {
    addBottleDialog.style.display = "none";
    document.body.style.overflow = "auto";
  }
});

// ----------------------------------------------------------------------

const addBottleForm = document.getElementById("redeem-bottle-form");

const bottleIdField = document.getElementById("bottleId");
const bottleIdError = document.getElementById("bottleId-error");

const bottleNameField = document.getElementById("bottleName");
const bottleNameError = document.getElementById("bottleName-error");

function validateAddBottleForm(event) {
  event.preventDefault();

  bottleIdError.textContent = "";
  bottleNameError.textContent = "";

  let isValid = true;

  if (bottleIdField.value.trim() === "") {
    bottleIdError.textContent = "Bottle Id is required";
    bottleIdError.style.display = "block";
    isValid = false;
  } else if (bottleIdField.value.length < 3) {
    bottleIdError.textContent = "Bottle Id must be at least 3 characters";
    bottleIdError.style.display = "block";
    isValid = false;
  }

  if (bottleNameField.value.trim() === "") {
    bottleNameError.textContent = "Bottle Name is required";
    bottleNameError.style.display = "block";
    isValid = false;
  } else if (bottleNameField.value.length < 3) {
    bottleNameError.textContent = "Bottle Name must be at least 3 characters";
    bottleNameError.style.display = "block";
    isValid = false;
  }

  if (isValid) {
    const data = {
      bottleId: bottleIdField.value,
      bottleName: bottleNameField.value,
    };

    fetch("/redeem", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then(async (response) => {
        const jsonResponse = await response.json();

        if (response.ok) {
          window.location.reload();
          addBottleDialog.style.display = "none";
        } else {
          // Show error in the form
          bottleIdError.textContent = jsonResponse.message;
          bottleIdError.style.display = "block";
        }
      })
      .catch((error) => {
        bottleIdError.textContent = error.message || "An error occurred";
        bottleIdError.style.display = "block";
      });
  }
}

addBottleForm.addEventListener("submit", validateAddBottleForm);
