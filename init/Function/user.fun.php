<?php
function createUser($name, $username, $password, $photo){
   global $db;

   $image_path = null;
   if (!empty($photo['name'])) {
      $image_path = uploadImage($photo);

   }
   $query = $db->prepare('INSERT INTO tbl_users (name, username, password, photo) VALUES (?, ?, ?, ?)');
   $query->bind_param('ssss', $name, $username, $password, $image_path);
   $query->execute();
   if ($db->affected_rows) {
      return true;
   }
   return false;
}

function getUsers(){
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE Level <> "admin"');
    //<> = khos pi 
    $query->execute();
    $result = $query->get_result();
    if($result->num_rows){
        return $result;
    }
    return null;
}

function readUser($id){
   global $db;
   $query = $db->prepare('SELECT * FROM tbl_users WHERE id=?');
   $query->bind_param('i',$id);
   $query->execute();
   $result = $query->get_result();
   if($result->num_rows > 0){
      return $result->fetch_object();
   }
   return null;
}
function deleteUser($id){
    global $db;
    $query = $db->prepare('DELETE FROM tbl_users WHERE id = ?');
    $query->bind_param('i', $id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function updateUser($id, $name, $username, $password, $photo){
    global $db;
    $image_path = null;
    if(empty($password)){
        $password = readUser($id)->password;
   }
    if (!empty($photo['name'])) {
        $image_path = uploadImage($photo);
    }
    $query = $db->prepare('UPDATE tbl_users SET name=?, username=?, password=?, photo=? WHERE id=?');
    $query->bind_param('ssssi', $name, $username, $password, $image_path, $id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

?>