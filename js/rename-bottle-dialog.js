const renameBottleDialog = document.getElementById("rename-bottle-dialog");

const renameBottleDialogBtn = document.getElementById(
  "open-rename-bottle-dialog-btn"
);

const closeRenameBottleDialogBtn = document.getElementById(
  "close-rename-bottle-dialog"
);

renameBottleDialogBtn.addEventListener("click", () => {
  renameBottleDialog.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeRenameBottleDialogBtn.addEventListener("click", () => {
  renameBottleDialog.style.display = "none";
  document.body.style.overflow = "auto";
});

window.addEventListener("click", (event) => {
  if (event.target === renameBottleDialog) {
    renameBottleDialog.style.display = "none";
    document.body.style.overflow = "auto";
  }
});

window.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && renameBottleDialog.style.display === "flex") {
    renameBottleDialog.style.display = "none";
    document.body.style.overflow = "auto";
  }
});

// ----------------------------------------------------------------------

const renameBottleForm = document.getElementById("rename-bottle-form");

const newBottleNameField = document.getElementById("new-bottle-name");
const newBottleNameError = document.getElementById("new-bottle-name-error");

const confirmBottleNameField = document.getElementById("confirm-bottle-name");
const confirmBottleNameError = document.getElementById(
  "confirm-bottle-name-error"
);

function validateRenameBottleForm(event) {
  event.preventDefault();

  const correctBottleName = bottleData.name;
  newBottleNameError.textContent = "";
  confirmBottleNameError.textContent = "";

  let isValid = true;

  if (newBottleNameField.value.trim() === "") {
    newBottleNameError.textContent = "New bottle name is required";
    newBottleNameError.style.display = "block";
    isValid = false;
  } else if (newBottleNameField.value.length < 3) {
    newBottleNameError.textContent =
      "New bottle name must be at least 3 characters";
    newBottleNameError.style.display = "block";
    isValid = false;
  }

  if (confirmBottleNameField.value.trim() === "") {
    confirmBottleNameError.textContent =
      "To confirm, type the bottle name in the box above";
    confirmBottleNameError.style.display = "block";
    isValid = false;
  } else if (confirmBottleNameField.value.trim() !== correctBottleName) {
    confirmBottleNameError.textContent =
      "To confirm, type the bottle name in the box above";
    confirmBottleNameError.style.display = "block";
    isValid = false;
  }

  if (isValid) {
    // Send PATCH request to update bottle name
    fetch(`/bottles/${bottleData.id}`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        newName: newBottleNameField.value.trim(),
      }),
    })
      .then(async (response) => {
        const jsonResponse = await response.json();

        if (response.ok) {
          window.location.reload();
          renameBottleDialog.style.display = "none";
        } else {
          // Show error in the form
          newBottleNameError.textContent = jsonResponse.message;
          newBottleNameError.style.display = "block";
        }
      })
      .catch((error) => {
        newBottleNameError.textContent = error.message || "An error occurred";
        newBottleNameError.style.display = "block";
      });
  }
}

renameBottleForm.addEventListener("submit", validateRenameBottleForm);
