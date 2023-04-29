const sendFormData = async (formId, successRedirect, errorId, url) => {
    const form = document.getElementById(formId);
    if (form) {
      form.addEventListener('submit', async (event) => {

        event.preventDefault();
        const formData = new FormData(form);
        try {
          const response = await fetch(url, {
            method: 'POST',
            body: formData,
          });

          if (response.ok) {
            const text = await response.json();
            console.log(text);
            if (text['success'] === true) {

                if(successRedirect !== null){
                     window.location.href = successRedirect;
                    // console.log('success');
                }else{
                    printErrors(text['errors'], errorId);
                }
                
            } else {
              printErrors(text['errors'], errorId);
            }
          } else {
            console.log('Error: ' + response.status);
          }

        } catch (error) {
          console.log('Error: ' + error);
        }

      });
    }
  };

  function sendMultipleFormsData(form, successRedirect, errorId, url='controller/option-controller.php'){
    const forms = document.querySelectorAll(form);
    if (forms) {
      forms.forEach((form) => {
        form.addEventListener('submit', async (event) => {
          event.preventDefault();
          const formData = new FormData(form);
          try {
            const response = await fetch(url, {
              method: 'POST',
              body: formData,
            });
  
            if (response.ok) {
              const text = await response.json();
              console.log(text);
              if (text['success'] === true) {
  
                  if(successRedirect !== null){
                       window.location.href = successRedirect;
                      // console.log('success');
                  }else{
                      printErrors(text['errors'], errorId);
                  }
                  
              } else {
                printErrors(text['errors'], errorId);
              }
            } else {
              console.log('Error: ' + response.status);
            }
  
          } catch (error) {
            console.log('Error: ' + error);
          }
  
        });
      });
    }
  }
  
  // sendFormData('form-id', 'success-redirect', 'error-id', 'url');

  // auth
  sendFormData('login-form', 'dashboard', 'login-error','login');
  sendFormData('signup-form', 'login', 'signup-error','signup');

  sendFormData('change-password-form', 'account', 'change-password-error','account/password');
  sendFormData('update-account-form', 'account', 'update-error', 'account/update');

  // quiz
  sendFormData('create-quiz-form', 'quizzes', 'create-quiz-error', 'quiz/store');
  sendFormData('take-quiz-form', 'qizzes', 'take-quiz-error','quiz/take')
  sendMultipleFormsData('.update-quiz-form', 'quizzes', 'quiz-error', 'quiz/update');
  // sendMultipleFormsData('.delete-quiz-form', 'quizzes', 'quiz-error', 'quiz/delete');
  
  // question
  sendFormData('create-question-form', 'quizzes', 'create-question-error', 'question/store');
  sendMultipleFormsData('.update-question-form','quizzes', 'update-question-error', 'question/update');

  // option
  sendMultipleFormsData('.create-option-form', 'quizzes', 'option-error', 'option/store');
  sendMultipleFormsData('.delete-option-form', 'quizzes', 'option-error', 'option/delete');
  sendMultipleFormsData('.update-option-form', 'quizzes', 'option-error', 'option/update');


  const image = document.getElementById('image');
  if (image) {
    image.addEventListener('change', async (event) => {
      event.preventDefault();
      const formData = new FormData(document.getElementById('profile-form'));
      const url = 'account/image';
      try {
        const response = await fetch(url, {
          method: 'POST',
          body: formData,
          headers: {
            Accept: 'multipart/form-data',
          },
        });
        if (response.ok) {
          const text = await response.json();
          if (text['success'] === true) {
            window.location.href = 'account';
          } else {
            printErrors(text['errors'], 'profile-error');
            document.getElementById('profile-error').innerHTML = text['errors'];
          }
        } else {
          console.log('Error: ' + response.status);
        }
      } catch (error) {
        console.log('Error: ' + error);
      }
    });
  }

const delQuizLink = document.querySelectorAll('.delete-quiz-link');
if (delQuizLink) {
  delQuizLink.forEach((link) => {
    link.addEventListener('click', async (event) => {
      event.preventDefault();
      try{
        const url = link.getAttribute('href');
        const response = await fetch(url, {
          method: 'GET',
        });
        if (response.ok) {
          const text = await response.json();
          if (text['success'] === true) {
            // window.location.href = 'quiz';
            console.log('success');
          } else {
            printErrors(text['errors'], 'quiz-error');
          }
        } else {
          console.log('Error: ' + response.status);
        }
      } catch (error) {
        console.log('Error: ' + error);
      }
    });
  });
}

  



function printErrors(errors, errorId) {
    let error = '';
    errors = JSON.parse(errors);
    for (let key in errors) {
        error += "<div class='error'>"+errors[key] + '</div>';
    }
    document.getElementById(errorId).innerHTML = error;
  }