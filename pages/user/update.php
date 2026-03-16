<?php

$id = $_GET["id"];
$targetUser = readUser($id);
if ($targetUser == null || $targetUser->Level == 'admin') {
    header("location : ./?page=user/list");
}


$nameError = $usernameError = $passwordError = '';
$name = $targetUser->name;
$username = $targetUser->name;

if (isset($_POST['name'], $_POST['username'], $_POST['password'], $_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (empty($name)) {
        $nameError = 'please input name!';
    }
    if (empty($username)) {
        $usernameError = 'please input username!';
    }
    if ($username != $targetUser->username && usernameExists($username)) {
        $usernameError = 'please choose another username !';
    }
    if (empty($nameError) && empty($usernameError) && empty($passwordError)) {
        try {
            if (updateUser($id, $name, $username, $password, $photo)) {
                echo '<div class="alert alert-success" role="alert">
            Update successful! <a href="./?page=user/list" class="alert-link">go to List</a>.
            </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
            Update failed! Please try again.
            </div>';
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">
            Update failed! Please try again.
            </div>';
        }
    }
}
?>




<form method="post" action="./?page=user/update&id=<?php echo $id ?>" enctype="multipart/form-data" class="col-md-10 col-lg-6 mx-auto">
    <h3>Update User</h3>
    <div class="d-flex justify-content-center">
        <input name="photo" type="file" id="profileUpload" hidden>
        <label role="button" for="profileUpload">
            <img src="<?php echo $targetUser->photo ?? './assets/img/image.jpg' ?>" class="rounded img-thumbnail" style="max-width:200px">
        </label>
    </div>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" value="<?php echo $name ?>" type="text" class="form-control
        <?php echo empty($nameError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $nameError ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" value="<?php echo $username ?>" type="text" class="form-control
        <?php echo empty($usernameError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $usernameError ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control
        <?php echo empty($passwordError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $passwordError ?></div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>