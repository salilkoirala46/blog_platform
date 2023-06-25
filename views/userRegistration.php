<?php
include '../includes/header.php';
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 70vh;">
  <div class="w-100" style="max-width: 400px;">
    <h2 class="text-center">User Registration</h2>
    <form action="../register.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password">
      </div>
      <button type="submit" name="registration" class="btn btn-primary">Register</button>
    </form>
  </div>
</div>

<?php
include '../includes/footer.php';
?>
