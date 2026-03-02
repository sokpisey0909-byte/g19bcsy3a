<?php
function usernameExists($username)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}
function registerUser($name, $username, $password)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_users (name, username, password) VALUES (?, ?, ?)');    // ?? for bind parameter for care injection
    $query->bind_param('sss', $name, $username, $password);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function loginUserIn($username, $password)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ? AND password = ?');
    $query->bind_param('ss', $username, $password);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return false;
}
function loggedInUser()
{
    global $db;
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id = ?');
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return null;
}
function isAdmin()
{
    $user = loggedInUser();
    if ($user && $user->Level === 'Admin') {
        return true;
    }
    return false;
}
function isUserHasPassword($password)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare(
        "SELECT * FROM tbl_users WHERE id = ? AND password = ?"
    );
    $query->bind_param('ss', $user->id, $password);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}

function setUserNewPassowrd($password)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare(
        "UPDATE tbl_users SET password = ? WHERE id = ?"
    );
    $query->bind_param('ss', $password, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function changeProfileImage($image)
{
    global $db;
    $user = loggedInUser();
    $image_path = uploadImage($image);
    if ($image_path && $user->photo) {
        unlink($user->photo);
    }
    $query = $db->prepare('UPDATE tbl_users SET photo = ? WHERE id = ?');
    $query->bind_param('sd', $image_path, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function deleteProfileImage()
{
    global $db;
    $user = loggedInUser();
    if ($user->photo) {
        unlink($user->photo);
    }
    $query = $db->prepare('UPDATE tbl_users SET photo = NULL WHERE id = ?');
    $query->bind_param('d', $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function uploadImage($image)
{
    $img_name = $image['name'];
    $img_size = $image['size'];
    $tmp_name = $image['tmp_name'];
    $error = $image['error'];

    $dir = './assets/image/';

    $allowed_exs = ['jpg', 'jpeg', 'png'];
    // Pathinfo use to get the file extension and check if it's allowed
    $image_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_lowercase_ex = strtolower($image_ex);

    if (!in_array($img_lowercase_ex, $allowed_exs)) {
        throw new Exception("File extension is not allowed.");
    }
    if ($error !== 0) {
        throw new Exception("Unknown error occurred");
    }
    if ($img_size > 5000000) {
        throw new Exception("File size is too large.");
    }
    // uniqid use to generate a unique name for the image to avoid overwriting existing images with the same name
    $new_img_name = uniqid("PI-") . '.' . $img_lowercase_ex;
    $image_path = $dir . $new_img_name;
    move_uploaded_file($tmp_name, $image_path);
    return $image_path;
}