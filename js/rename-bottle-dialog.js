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

function validateAddBottleForm(event) {
  event.preventDefault();

  const correctBottleName = "Bottle 1";
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
    renameBottleForm.reset();
    renameBottleDialog.style.display = "none";
    window.location.href = "./bottle.html";
  }
}

renameBottleForm.addEventListener("submit", validateAddBottleForm);
