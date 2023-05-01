<h2>Quiz</h2>
<ul class="list-group">
  <ol>
  <?php foreach($quiz as $qu): ?>
    <li class="list-group-item">
      <div class="d-flex justify-content-between align-items-center">
        <h3><?php echo $qu['title']; ?></h3>
        <span class="badge badge-primary badge-pill">Created by: <?php echo $qu['user_id']; ?></span>
      </div>
      <p class="mt-2">Created at: <?php echo $qu['created_at']; ?></p>
    </li>
  <?php endforeach; ?>
</ul>


<h2>Questions</h2>
<ol class="list-group">
<?php foreach ($questions as $quiz_id => $quiz_data) { ?>
  <?php foreach ($quiz_data['questions'] as $question_text => $question_data) { ?>
  <li class="list-group-item">

  <div class="d-flex justify-content-between align-items-center">
    
    <!-- question update form -->
    <form action="question/update" method="post" class="update-question-form">
      <li><input type="text" class="form-control" id="question_text" name="question_text" value="<?= $question_data['question_text']; ?>"></li>
      <input type="hidden" name="qid" value="<?= $_GET['id']; ?>">
      <input type="hidden" name="update_question" value="<?= $question_data['question_id']; ?>">
      <button type="submit" class="btn btn-primary btn-sm mr-2">Update</button>
    </form>

    <div>
    <div class="update-question-error"></div>
      <a class="btn btn-danger btn-sm delete-question-link" href="question/delete?qid=<?= $_GET['id']; ?>&id=<?= $question_data['question_id']; ?>">Delete Question</a>
    </div>
  </div>
    
<ol type="A">
<?php  foreach ($question_data['options'] as $option_data) { ?>
  <li class="d-flex align-items-center">
    <div class="form-group">

      <!-- option update form -->
      <form action="option/update" method="POST" class="update-option-form">
        
        <div class="form-group form-check">
          <li><input type="text" class="form-control" id="option_text" name="option_text" value="<?php echo $option_data['option_text']; ?>"></li>
          <input type="checkbox" class="form-check-input" name="is_correct" id="is_correct_<?php echo $option_data['option_id']; ?>" value="1" <?php if($option_data['is_correct']) echo 'checked'; ?>>
          <label class="form-check-label" for="is_correct_<?php echo $option_data['option_id']; ?>">Correct?</label>
        </div>

        <input type="hidden" name="qid" value="<?php echo $_GET['id']; ?>">

        <input type="hidden" name="update_option" value="<?php echo $option_data['option_id']; ?>">
        <button type="submit" class="btn btn-primary btn-sm mr-2">Update</button>
      </form>
      
      <div>
        <a class="btn btn-danger btn-sm delete-option-link" href="option/delete?qid=<?= $_GET['id']; ?>&id=<?php echo $option_data['option_id']; ?>">Delete Option</a>
      </div>

    </div>
    
  </li>
  <?php  }  ?>
</ol>

<!-- option create form -->
<form action="option/store" method="POST" class="create-option-form mt-2">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Write option" id="option-text" name="option-text" required>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" name="is_correct" id="is_correct_new" value="1">
      <label class="form-check-label" for="is_correct_new">Correct?</label>
    </div>
    <input type="hidden" name="create_option" value="<?= $question_data['question_id']; ?>">
    <button type="submit" class="btn btn-success btn-sm">Add Option</button>
  </form>
  </li>
  <?php } ?>

<?php  } ?>

</ol>

<div id="option-error"></div>
<?php if(isset($_GET['id'])): ?>

<form method="POST" id="create-question-form">
  <label for="question-text">Question Text:</label>
  <input type="text" id="question-text" name="question-text" required>

  <input type="hidden" name="create_question" value="<?= $_GET['id']?>">
  <input type="submit" value="Add Question">
</form>
<div id='create-question-error'></div>

<?php endif; ?>