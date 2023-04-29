<h2 class="mb-4">Quizzes</h2>
<ul class="list-unstyled">
  <?php foreach($quizzes as $quiz): ?>
    <form class="update-quiz-form mb-4">
  <li class="border p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0"><input class="form-control" type="text" name="quiz_title" value="<?php echo $quiz['title']; ?>"></h3>
      <a class="delete-quiz-link btn btn-danger" href="quiz/delete?id=<?php echo $quiz['id']; ?>">Delete Quiz</a>
    </div>
    
    <div class="mb-3">
      <small class="text-muted">Created at: <?php echo $quiz['created_at']; ?></small>
    </div>
    
    <div class="mb-3">
      <label for="quiz-description">Description:</label>
      <textarea class="form-control" id="quiz-description" name="quiz_description"><?php echo $quiz['description']; ?></textarea>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="submittable" name="submittable" value="1" <?php if($quiz['submittable']){ echo "checked";} ?>>
      <label class="form-check-label" for="submittable">Submittable?</label>
    </div>

    <div class="d-flex justify-content-end">
      <a class="btn btn-outline-secondary me-2" href="quiz?id=<?php echo $quiz['id']; ?>">View Quiz</a>
      <input type="hidden" name="update_quiz" value="<?php echo $quiz['id']; ?>">
      <button class="btn btn-primary" type="submit">Update</button>
    </div>
  </li>
</form>
<?php endforeach; ?>
  <div id="quiz-error" class="text-danger"></div>
</ul>
<form method="POST" id="create-quiz-form">
  <div class="mb-3">
    <label class="form-label" for="quiz-title">Quiz Title:</label>
    <input class="form-control" type="text" id="quiz-title" name="quiz_title" required>
  </div>
  <div class="mb-3">
    <label class="form-label" for="quiz-description">Description:</label>
    <textarea class="form-control" id="quiz-description" name="quiz_description"></textarea>
  </div>
  <input type="hidden" name="create_quiz" value="create_quiz">
  <button class="btn btn-success" type="submit">Create Quiz</button>
</form>
<div id='create-quiz-error' class="text-danger"></div>













