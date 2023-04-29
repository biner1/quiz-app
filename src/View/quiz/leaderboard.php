<div class="container mt-4">
  <h2>Leaderboard</h2>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Quizzes Taken</th>
        <th>Total Score</th>
        <th>Correct Answers</th>
        <th>Incorrect Answers</th>
        <th>Average Score</th>
        <th>Last Attempt</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $rank = 1;
      foreach ($results as $row) {
        echo "<tr>";
        echo "<td>{$rank}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['num_quizzes_taken']}</td>";
        echo "<td>{$row['total_max_score']}</td>";
        echo "<td>{$row['num_correct_answers']}</td>";
        echo "<td>{$row['num_incorrect_answers']}</td>";
        echo "<td>{$row['average_score']}</td>";
        echo "<td>{$row['last_attempt']}</td>";
        echo "</tr>";
        $rank++;
      }
      ?>
    </tbody>
  </table>
</div>
