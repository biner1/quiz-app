<div class="container my-4">

  <section class="quizzes-section">
    <h2 class="section-title mb-4">Quizzes</h2>

    <div class="row">

      <div class="col-md-6">

        <form class="form-inline float-right" method="GET" action="quizzes">
          <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-primary ml-2 mt-1">Search</button>
        </form>

      </div>


      <ol>
        <?php foreach ($quizzes as $quiz): ?>

          <form class="update-quiz-form mb-4">
            <div class="quiz-card border p-3">

              <div class="d-flex justify-content-between align-items-center mb-3">
                <li><input class="quiz-title form-control" type="text" name="quiz_title"
                    value="<?php echo $quiz['title']; ?>"></li>
                <a class="delete-quiz-link btn btn-danger" href="quiz/delete?id=<?php echo $quiz['id']; ?>">Delete</a>
              </div>

              <div>
                <small class="text-muted mb-3">Created at:
                  <?php echo $quiz['created_at']; ?>
                </small>
              </div>
              <div>
                <small class="text-muted mb-3">Question Count:
                  <?php echo $quiz['question_count']; ?>
                </small>
              </div>
              <div>
                <small class="text-muted mb-3">Quiz Mode:
                  <?php echo $quiz['mode']; ?>
                </small>
              </div>


              <div class="form-group mb-3">
                <label for="quiz-description">Description:</label>
                <textarea class="form-control quiz-description" id="quiz-description"
                  name="quiz_description"><?php echo $quiz['description']; ?></textarea>
              </div>

              <div class="form-check mb-3">
                
                <label class="form-check-label"><input class="form-check-input quiz-submittable" type="checkbox" id="submittable" name="submittable"
                  value="1" <?php if ($quiz['submittable']) {
                    echo "checked";
                  } ?>>Submittable?</label>
              </div>

              <div class="d-flex justify-content-end">
                <a class="btn btn-outline-secondary me-2 quiz-view-link"
                  href="quiz?id=<?php echo $quiz['id']; ?>">View</a>
                <input type="hidden" name="update_quiz" value="<?php echo $quiz['id']; ?>">
                <button class="btn btn-primary quiz-update-btn" type="submit">Update</button>
              </div>

            </div>
          </form>

        <?php endforeach; ?>
      </ol>
      <div id="quiz-error" class="text-danger"></div>
    </div>



    <form method="POST" id="create-quiz-form" class="create-quiz-form">
      <h3 class="section-subtitle mb-3">Create a New Quiz</h3>
      <div class="form-group mb-3">
        <label class="form-label" for="quiz-title">Quiz Title:</label>
        <input class="form-control quiz-title" type="text" id="quiz-title" name="quiz_title" required>
      </div>
      <div class="form-group mb-3">
        <label class="form-label" for="quiz-description">Description:</label>
        <textarea class="form-control quiz-description" id="quiz-description" name="quiz_description"></textarea>
      </div>

      <div class="form-group mb-3">
        <select name="quiz_mode" id="">
          <option value="all">All questions at once</option>
          <option value="one">One question at a time Correct</option>
        </select>
      </div>

      <input type="hidden" name="create_quiz" value="create_quiz">
      <button class="btn btn-success create-quiz-btn" type="submit">Create Quiz</button>
    </form>

    <div id="create-quiz-error" class="text-danger"></div>
  </section>

</div>