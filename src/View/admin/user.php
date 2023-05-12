
<div class="container">
  <h2>User Account</h2>
  <div class='d-flex'>

  <div class="image px-4">

    <form id="profile-form" class>
    <img src="/mvc/public/upload/<?php
      if ($user['image'] == '') {
        echo 'default.jpg';
      } else {
       echo $user['image'] ;
      }
     ?>" width="200" height="200" alt="">

      <div class="form-group">
          <input type="file" class="form-control px-2 my-2" name="image" id="image">
      </div>

      <input type="hidden" name="update_picture" value="update_picture">
    </form>

      <div id="profile-error"></div>
  </div>

  <div class="information">
    <h3>Basic Information</h3>

  <form id="update-account-admin" action="users/update" method="POST">

    <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" placeholder="Full Name">
    </div>

    <div class="form-group">
      <label for="phone">Phone No.</label>
      <input type="text" class="form-control" id="phone" name="phone"value="<?= $user['phone'] ?>" placeholder="phone">
    </div>

    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="email" name="email"value="<?= $user['email'] ?>">
    </div>

    <div class="form-group">
      <input type="checkbox" class="form-check-input" name="is_teacher" id="is_teacher" value="1" <?php if($user['is_teacher']) echo 'checked'; ?>>
      <label for="is_teacher">Is Teacher?</label>
    </div>

    <div class="form-group">
      <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin" value="1" <?php if($user['is_admin']) echo 'checked'; ?>>
      <label for="is_admin">Is Admin?</label>
    </div>

    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <div id="update-error"></div>
    <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
  </form>


    <div class="my-5">
      <h3>Security</h3>

      <form id="change-password-admin" action="users/password" method="post">
        <div class="form-group">
          <label for="password">Current Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div id="change-password-error"></div>
        <button type="submit" name="change_password" class="btn btn-primary mt-1">Save Passwords</button>
      </form>

    </div>
    
  </div>
</div>

<hr>


<div class="informations">
<h4>
<?php 
if($user['is_teacher']) echo 'quizzes CRETED by user';
else echo 'quizzes TAKEN by user'; 
?>
</h4>

<ul class="list-group mt-3">
  <?php foreach($quizzes as $quiz): ?>
  <li class="list-group-item mb-3">
    <h3><?php echo $quiz['title']; ?></h3>
    <div class="small text-muted">Mode: <?php echo $quiz['mode']; ?></div>
    <div class="small text-muted">Created at: <?php echo $quiz['created_at']; ?></div>
    <div class="mt-1"><small>description: </small><?php echo $quiz['description']; ?></div>
  </li>
<?php endforeach; ?>

</ul>

</div>


  </div>