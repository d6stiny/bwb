const deleteBottleDialog = document.getElementById("delete-bottle-dialog");

const openDeleteBottleDialogBtn = document.getElementById(
  "open-delete-bottle-dialog-btn"
);

const closeDeleteBottleDialogBtn = document.getElementById(
  "close-delete-bottle-dialog"
);

openDeleteBottleDialogBtn.addEventListener("click", () => {
  deleteBottleDialog.style.display = "flex";
});

closeDeleteBottleDialogBtn.addEventListener("click", () => {
  deleteBottleDialog.style.display = "none";
});

window.addEventListener("click", (event) => {
  if (event.target === deleteBottleDialog) {
    deleteBottleDialog.style.display = "none";
  }
});

window.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && deleteBottleDialog.style.display === "flex") {
    deleteBottleDialog.style.display = "none";
  }
});

// ----------------------------------------------------------------------

const deleteBottleForm = document.getElementById("delete-bottle-form");

const bottleNameField = document.getElementById("bottle-name");
const bottleNameError = document.getElementById("bottle-name-error");

function validateDeleteBottleForm(event) {
  event.preventDefault();

  const correctBottleName = bottleData.name;
  bottleNameError.textContent = "";

  let isValid = true;

  if (bottleNameField.value.trim() === "") {
    bottleNameError.textContent =
      "To confirm, type the bottle name in the box above";
    bottleNameError.style.display = "block";
    isValid = false;
  } else if (bottleNameField.value.trim() !== correctBottleName) {
    bottleNameError.textContent =
      "The bottle name you entered does not match the bottle name of the bottle you want to delete";
    bottleNameError.style.display = "block";
    isValid = false;
  }

  if (isValid) {
    fetch(`/bottles/${bottleData.id}`, {
      method: "POST",
    }).then(() => {
      window.location.href = "/dashboard";
    });
  }
}

deleteBottleForm.addEventListener("submit", validateDeleteBottleForm);
