<?php
require_once './init/init.php';
$user = loggedInUser();
$isAdmin = isAdmin();
include './includes/header.inc.php';
include './includes/navbar.inc.php';

$logged_in_pages = ['dashboard', 'Profile'];
$non_logged_in_pages = ['login', 'register'];
$Admin_pages = ['user/list', 'user/create', 'user/update', 'user/deleted'];
$available_pages = ['logout', ...$logged_in_pages, ...$non_logged_in_pages, ...$Admin_pages];

$page = '';
if (isset($_GET['page'])) {
    $page = $_GET['page']; // dashboard
}
if (in_array($page, $logged_in_pages) && empty($user)) {
    header('Location: ./?page=login');
}
if (in_array($page, $non_logged_in_pages) && !empty($user)) {
    header('Location: ./?page=dashboard');
}
if (in_array($page, $available_pages)) {
    if (in_array($page, $Admin_pages) && !isAdmin()) {
        header('Location: ./?page=dashboard');
    }


    include './pages/' . $page . '.php';
} else {
    header('Location: ./?page=dashboard');
}
include './includes/footer.inc.php';