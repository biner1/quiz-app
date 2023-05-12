<div class="container">
  <h2>Quizzes</h2>

  <div class="row">
    <div class="col-md-6">
      <form class="form-inline float-right" id="search-quizzes" method="GET" action="quizzes">
        <div class="form-group">
          <input type="text" class="form-control" name="search" id="search-key" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-primary ml-2 mt-1">Search</button>
      </form>
    </div>

    <ul class="list-group mt-3">
      <?php foreach ($quizzes as $quiz): ?>
        <li class="list-group-item mb-3">
          <h3>
            <?php echo $quiz['title']; ?>
          </h3>
          <div class="small text-muted">Mode:
            <?php echo $quiz['mode']; ?>
          </div>
          <div class="small text-muted">Created at:
            <?php echo $quiz['created_at']; ?>
          </div>
          <div class="mt-2">
            <?php echo $quiz['description']; ?>
          </div>
          <a class="btn btn-primary mt-3" href="quiz?id=<?php echo $quiz['id']; ?>">Take Quiz</a>
        </li>
      <?php endforeach; ?>

      <div id="quiz-error" class="text-danger"></div>
    </ul>
  </div>