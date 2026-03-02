<?php
$username = $password = '';
$usernameError = $passwordError = '';

if (isset($_POST['username'], $_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) {
    $usernameError = 'please input username';
  }
  if (empty($password)) {
    $passwordError = 'Please input password.';
  }
  if (empty($usernameError) && empty($passwordError)) {
    $user = loginUserIn($username, $password);
    if ($user !== false) {
      $_SESSION['user_id'] = $user->id;
      header('Location: ./?dashboard');
    } else {
      echo '<div class="alert alert-danger" role="alert">Username or password is incorrect</div>';

    }
  }

}
?>

<form method="post" action="?page=login" class=" col-md-10 col-lg-6 mx-auto">
  <h3>Login page</h3>
  <div class="mb-3">
    <label class="form-label">username</label>
    <input name="username" type="text" class="form-control 
            <?php echo empty($usernameError) ? '' : 'is-invalid' ?>
            " value="<?php echo $username ?>">
    <div class="invalid-feedback">
      <?php echo $usernameError ?>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input name="password" type="password" class="form-control 
    <?php echo empty($passwordError) ? '' : 'is-invalid' ?>">
    <div class="invalid-feedback"></div>
    <?php echo $passwordError ?>
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>