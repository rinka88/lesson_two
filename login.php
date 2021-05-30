<?php
session_start();
require_once "function.php";

$email = $_POST["email"];
$password = $_POST["password"];

$user = login($email, $password);

if($user==false) {
    set_flash_message('danger', 'E-mail и пароль не правильные!');
    redirect_to('page_login.php');
    exit;
}

set_flash_message('success', 'Добро пожаловать!');
$_SESSION['log-in'] = $email;
    redirect_to('users.php');