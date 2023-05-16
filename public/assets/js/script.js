const sendFormData = async (formId, errorId, url) => {
  const form = document.getElementById(formId);
  if (form) {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      const formData = new FormData(form);
      try {
        const response = await fetch(url, {
          method: "POST",
          body: formData,
        });

        if (response.ok) {
          const text = await response.json();
          console.log(text);
          parsed_text_data = JSON.parse(text["data"]);
          if (text["success"] === true) {
            if (parsed_text_data["redirect"]) {
              window.location.href = parsed_text_data["redirect"];
            }
          } else {
            printErrors(text["errors"], errorId);
          }
        } else {
          console.log("Error: " + response.status);
        }
      } catch (error) {
        console.log("Error: " + error);
      }
    });
  }
};

function sendMultipleFormsData(form, errorId, url = "") {
  const forms = document.querySelectorAll(form);
  if (forms) {
    forms.forEach((form) => {
      form.addEventListener("submit", async (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        try {
          const response = await fetch(url, {
            method: "POST",
            body: formData,
          });

          if (response.ok) {
            const text = await response.json();
            console.log(text);
            parsed_text_data = JSON.parse(text["data"]);
            if (text["success"] === true) {
              if (parsed_text_data["redirect"]) {
                window.location.href = parsed_text_data["redirect"];
              }
            } else {
              printErrors(text["errors"], errorId);
            }
          } else {
            console.log("Error: " + response.status);
          }
        } catch (error) {
          console.log("Error: " + error);
        }
      });
    });
  }
}

// sendFormData('form-id', 'success-redirect', 'error-id', 'url');

// auth
sendFormData("login-form", "login-error", "login");
sendFormData("signup-form", "signup-error", "signup");

sendFormData(
  "change-password-form",
  "change-password-error",
  "account/password"
);
sendFormData("update-account-form", "update-error", "account/update");

// quiz
sendFormData("create-quiz-form", "create-quiz-error", "quiz/store");
sendFormData("take-quiz-form", "take-quiz-error", "quiz/take");
sendMultipleFormsData(".update-quiz-form", "quiz-error", "quiz/update");

// question
sendFormData("create-question-form", "create-question-error", "question/store");
sendMultipleFormsData(
  ".update-question-form",
  "update-question-error",
  "question/update"
);

// option
sendMultipleFormsData(".create-option-form", "option-error", "option/store");
sendMultipleFormsData(".delete-option-form", "option-error", "option/delete");
sendMultipleFormsData(".update-option-form", "option-error", "option/update");

// admin
sendFormData("update-account-admin", "update-error", "users/update");
sendFormData(
  "change-password-admin",
  "change-password-error",
  "users/password"
);

const image = document.getElementById("image");
if (image) {
  image.addEventListener("change", async (event) => {
    event.preventDefault();
    const formData = new FormData(document.getElementById("profile-form"));
    const url = "account/image";
    try {
      const response = await fetch(url, {
        method: "POST",
        body: formData,
        headers: {
          Accept: "multipart/form-data",
        },
      });
      if (response.ok) {
        const text = await response.json();
        parsed_text_data = JSON.parse(text["data"]);
        if (text["success"] === true) {
          if (parsed_text_data["redirect"]) {
            window.location.href = parsed_text_data["redirect"];
          }
        } else {
          printErrors(text["errors"], errorId);
          document.getElementById("profile-error").innerHTML = text["errors"];
        }
      } else {
        console.log("Error: " + response.status);
      }
    } catch (error) {
      console.log("Error: " + error);
    }
  });
}

const delLinkRequest = (anchorTags, errorId) => {
  const delLink = document.querySelectorAll(anchorTags);
  if (delLink) {
    delLink.forEach((link) => {
      link.addEventListener("click", async (event) => {
        event.preventDefault();
        try {
          const url = link.getAttribute("href");
          const response = await fetch(url, {
            method: "GET",
          });
          if (response.ok) {
            const text = await response.json();
            parsed_text_data = JSON.parse(text["data"]);
            if (text["success"] === true) {
              if (parsed_text_data["redirect"]) {
                window.location.href = parsed_text_data["redirect"];
              }
            } else {
              printErrors(text["errors"], errorId);
            }
          } else {
            console.log("Error: " + response.status);
          }
        } catch (error) {
          console.log("Error: " + error);
        }
      });
    });
  }
};

delLinkRequest(".delete-quiz-link", "quiz-error");
delLinkRequest(".delete-user-link", "user-error");
delLinkRequest(".delete-option-link", "user-error");

// TODO: make search requests ayanc render the data
const searchRequests = (fromId) => {
  const form = document.getElementById(fromId);
  if (form) {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      let searchValue = document.getElementById("search-key").value;
      const url = form.getAttribute("action") + "?search=" + searchValue;
      try {
        const response = await fetch(url, {
          method: "GET",
        });
        if (response.ok) {
          const text = await response.json();
          if (text["success"] === true) {
            window.location.href = url;
          }
        } else {
          console.log("Error: " + response.status);
        }
      } catch (error) {
        console.log("Error: " + error);
      }
    });
  }
};
// searchRequests('search-quizzes');
// searchRequests('search-users');

function printErrors(errors, errorId) {
  let error = "";
  errors = JSON.parse(errors);
  for (let key in errors) {
    error += "<div class='error'>" + errors[key] + "</div>";
  }
  document.getElementById(errorId).innerHTML = error;
}
