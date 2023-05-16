<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center mt-3">Quiz</h3>
			<div class="card mt-3">
				<div class="card-body">

					<div id="quiz-form-one">

						<form id="quiz-form" method="POST">

							<div class="form-group">
								<label>Question:</label>
								<p id="question-text">
									<?= $question['question_text']; ?>
								</p>
							</div>

							<div class="form-group">
								<label>Options:</label>
								<?php foreach ($options as $option) {
									$i = 1;
									?>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="option" id="option<?= $i; ?>"
											value="<?= $option['id'] ?>">
										<label class="form-check-label" for="option1" id="option1-text">
											<?= $option['option_text'] ?>
										</label>
									</div>
								<?php } ?>


							</div>
							<input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
							<button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
						</form>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>




<script>
	// Function to set up event listener for quiz form
	function setUpQuizForm() {
		const quizForm = document.querySelector('#quiz-form');
		quizForm.addEventListener('submit', async (event) => {
			event.preventDefault();
			const formData = new FormData(quizForm);
			let url = 'quiz/take/one';
			try {
				const response = await fetch(url, {
					method: 'POST',
					body: formData,
				});

				if (response.ok) {
					const text = await response.json();
					parsed_text_data = JSON.parse(text['data']);
					console.log(parsed_text_data);
					if (text['success'] === true) {
						if (parsed_text_data['redirect']) {
							window.location.href = parsed_text_data['redirect'];
						}

						let next_question_form = getQuizForm(parsed_text_data);
						document.getElementById('quiz-form-one').innerHTML = next_question_form;
						// Call the function to set up event listener for the new form
						setUpQuizForm();
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

	setUpQuizForm();



	function getQuizForm(array) {
		let question = array['question'];
		let options = array['options'];

		let result_form = `
			<form id="quiz-form" method="POST">
			<div class="form-group">
				<label>Question:</label>
				<p id="question-text">${question['question_text']}</p>
			</div>

			<div class="form-group">
				<label>Options:</label>
			`;

		for (let i = 0; i < options.length; i++) {
			result_form += `<div class="form-check">
				<input class="form-check-input" type="radio" name="option" id="option1" value="${options[i]['id']}">
				<label class="form-check-label" for="option${i + 1}" id="option1-text">${options[i]['option_text']}</label>
				</div>`;

		}


		result_form += `
			<input type="hidden" name="quiz_id" value="${question['quiz_id']}">
			<button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
			</form>
		`;

		return result_form;
	}



</script>