<?php
$db_host = 'localhost';
$db_name = 'g19bcsy3a';
$db_user = 'root';
$db_pass = '';
$db_port = 3307;
// for store connection database
$db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
$basedUrl = '/g19bcsy3a/';
if ($db->connect_error) {
    echo $db->connect_error;
    die();
}
?>