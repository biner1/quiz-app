

<div class="container">
  <h2>Quizzes</h2>
  <ul class="list-group mt-3">
  <?php foreach($quizzes as $quiz): ?>
  <li class="list-group-item mb-3">
    <h3><?php echo $quiz['title']; ?></h3>
    <div class="small text-muted">Mode: <?php echo $quiz['mode']; ?></div>
    <div class="small text-muted">Created at: <?php echo $quiz['created_at']; ?></div>
    <div class="mt-2"><?php echo $quiz['description']; ?></div>
    <a class="btn btn-primary mt-3" href="quiz?id=<?php echo $quiz['id']; ?>">Take Quiz</a>
  </li>
<?php endforeach; ?>

<div id="quiz-error" class="text-danger"></div>
</ul>
</div>





