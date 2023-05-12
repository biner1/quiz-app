<div class="container">
  <h1>User List</h1>

  <div class="row">
    <div class="col-md-6">
      <form class="form-inline float-right" method="GET" action="users" id="search-users">
        <div class="form-group">
          <input type="text" class="form-control" name="search" id="search-key" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-primary ml-2 mt-1">Search</button>
      </form>
    </div>

    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>

      <tbody>

        <?php foreach ($users as $user): ?>
          <tr>
            <td>
              <?= $user['id'] ?>
            </td>
            <td><a href="users?user=<?= $user['id'] ?>"><?= $user['name'] ?></a></td>
            <td>
              <?= $user['email'] ?>
            </td>
            <td>
              <?php
              if ($user['is_admin']) {
                echo 'Admin';
              } else if ($user['is_teacher']) {
                echo 'Teacher';
              } else {
                echo 'Student';
              }
              ?>
            </td>
            <td>
              <a href="users/delete?user_id=<?= $user['id']; ?>" class="btn btn-danger delete-user-link">Delete</a>
            </td>

          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>

    <div class="user-error"></div>

  </div>