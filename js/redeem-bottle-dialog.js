const addBottleDialog = document.getElementById("redeem-bottle-dialog");

const openAddBottleDialogBtn = document.getElementById(
  "open-redeem-bottle-dialog-btn"
);

const closeAddBottleDialogBtn = document.getElementById(
  "close-redeem-bottle-dialog"
);

openAddBottleDialogBtn.addEventListener("click", () => {
  addBottleDialog.style.display = "flex";
});

closeAddBottleDialogBtn.addEventListener("click", () => {
  addBottleDialog.style.display = "none";
});

window.addEventListener("click", (event) => {
  if (event.target === addBottleDialog) {
    addBottleDialog.style.display = "none";
  }
});

window.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && addBottleDialog.style.display === "flex") {
    addBottleDialog.style.display = "none";
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

  //   let userId = document.getElementById("userId").value;

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
      console.log("Response:", jsonResponse);

      if (response.ok) {
        window.location.reload();
        addBottleDialog.style.display = "none";
      } else {
        throw new Error(jsonResponse.message);
      }
    })
    .catch((error) => {
      alert(error.message || "An error occurred");
    });
}

addBottleForm.addEventListener("submit", validateAddBottleForm);
