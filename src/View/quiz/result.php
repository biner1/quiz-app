<div class="container mt-5">
    <h1>Quiz Result</h1>
    <hr>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Title: <?= $result['title']; ?></h5>
            <p class="card-text">Your score: <?= $result['score']; ?>%</p>
            <p class="card-text">Mode: <?= $result['mode']; ?></p>
            <p class="card-text">Taken At: <?= $result['created_at']; ?></p>
            <p class="card-text">Description: <?= $result['description']; ?></p>
            
          </div>
        </div>
      </div>
    </div>
  </div>