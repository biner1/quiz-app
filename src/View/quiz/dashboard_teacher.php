<div class="container my-4">
  <h2>Quiz Results</h2>
  
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Number of Students Attempted</h5>
          <p class="card-text"><?php echo $result['num_takers']; ?></p>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Average Score</h5>
          <p class="card-text"><?php echo $result['avg_score']; ?></p>
        </div>
      </div>
    </div>
  </div>
  
</div>



<div class="container">
  <h1>Quiz Results</h1>
  <table class="table">
    <thead>
      <tr>
        <th>Quiz ID</th>
        <th>Quiz Title</th>
        <th>Number of Students</th>
        <th>Average Score</th>
        <th>Number of Attempts</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Loop through the results and display them in the table
      foreach ($quiz_results as $quiz) {
        echo "<tr>";
        echo "<td>{$quiz['quiz_id']}</td>";
        echo "<td>{$quiz['title']}</td>";
        echo "<td>{$quiz['num_students']}</td>";
        echo "<td>{$quiz['avg_score']}</td>";
        echo "<td>{$quiz['num_attempts']}</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>
