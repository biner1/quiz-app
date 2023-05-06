<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

  <a class="navbar-brand" href="#">My Application</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <?php if(isset($_SESSION['user'])): ?>
      <li class="nav-item">
        <a class="nav-link" href="quizzes"><i class="fas fa-book"></i> Quizzes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="leaderboard"><i class="fas fa-clipboard-list"></i> Leaderboard</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="account"><i class="fas fa-user-circle"></i> Account</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
        <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="login"><i class="fas fa-sign-in-alt"></i> Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signup"><i class="fas fa-user-plus"></i> Signup</a>
      </li>
          <?php endif; ?>
        </ul>
        
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">

                        <!-- <img src="asset/image/user.png" alt="" style='width: 30px'> -->
                        <?= $_SESSION['user'] ?>
                    </button>
                    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="account" >
                            account</a>

                        <a class="dropdown-item" href="logout">Logout</a>
                    </div>
  </div>

  </div>

</nav>
