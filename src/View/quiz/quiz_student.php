
    
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <form action="quiz/take" method="POST" id="take-quiz-form">
                <h1>Quiz Form</h1>

<?php foreach ($questions as $quiz_id => $quiz_data) {
 echo "<input type='hidden' name='quiz_id' value='{$quiz_id}' />";
   foreach ($quiz_data['questions'] as $question_text => $question_data) { 

        echo '<div class="card mt-3">';
        echo '<div class="card-header">' . $question_data['question_text'] . '</div>';
        echo '<div class="card-body">';
        echo '<div class="form-group">';

    foreach ($question_data['options'] as $option_data) { 
        echo '<div class="form-check">';
      
        echo '<input class="form-check-input" type="radio" name="question_' . $question_data['question_id'] . '" id="option_' . $option_data['option_id'] . '" value="' . $option_data['option_id'] . '">';

        // echo '<input class="form-check-input" type="radio" name="question_' . $question_data['question_id'] . '" id="option_' . $option_data['option_id'] . '" value="' . $option_data['option_id'] . '">';
        echo '<label class="form-check-label" for="option_' . $option_data['option_id'] . '">' . $option_data['option_text'] . '</label>';
        echo '</div>';

    } 
    echo '</div>';
    echo '</div>';
    echo '</div>';

 }
} 
 ?>
<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">Submit Quiz</button>
</div>

</form>
<div id='take-quiz-error'></div>
        </div>
    </div>
</div>