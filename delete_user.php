<?php
session_start();
require "function.php";
$id = $_GET['id'];

if (is_not_logged_in()) {
    redirect_to("/page_login.php");
}

if (!is_admin() and !is_author($_SESSION['id'], $id)) {
    set_flash_message("danger", "Можно редактировать только свой профиль");
    redirect_to("/users.php");
}

$user = get_user_by_id($id);

delete($id);

if ($_SESSION['log-in'] == $user['email']) {
    session_unset();
    session_destroy();
    redirect_to('/page_register.php');
} else {
    set_flash_message("success", "Пользователь " . $user['username'] . " удален");
    redirect_to("/users.php");
}