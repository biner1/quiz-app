<?php
// Display user name
echo "<h2>User:" . $user . "</h2>";
?>
<div class="container">
	<h1>Quiz Results</h1>
	<hr>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Quiz</th>
					<th>Score</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>


				<?php $i = 1;
				foreach ($quiz_attempts as $attempt) { ?>

					<tr>
						<td>
							<?= $i; ?>-<a href="quiz/result?id=<?= $attempt['attempt_id']; ?>"><?= $attempt['title'] ?></a>
						</td>
						<td>
							<?= $attempt['score'] ?>
						</td>
						<td>
							<?= date('F j, Y, g:i a', strtotime($attempt['created_at'])) ?>
						</td>
					</tr>


					<?php $i++;
				} ?>


			</tbody>
		</table>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title">Quiz Results</h3>
					<table class="table">
						<thead>
							<tr>
								<th>Quizzes Taken</th>
								<th>Quizzes Attempt Count</th>
								<th>num_answers</th>
								<th>Correct Answers</th>
								<th>Incorrect Answers</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Loop through each row in the query result
							
							// Display the quiz statistics in a table row
							if (isset($result)) {
								echo "<tr>";
								echo "<td>" . $result['num_quizzes_taken'] . "</td>";
								echo "<td>" . $result['num_quizzes_attempted'] . "</td>";
								echo "<td>" . $result['num_questions_answered'] . "</td>";
								echo "<td>" . $result['num_questions_answered_correctly'] . "</td>";
								echo "<td>" . $result['num_questions_answered_incorrectly'] . "</td>";
								echo "</tr>";
							}

							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>