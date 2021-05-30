<?php
session_start();
require_once "function.php";
$email = $_POST["email"];
$password = $_POST["password"];
$id = $_SESSION['user_data']['id'];
$username = $_SESSION['user_data']['username'];

$exist_Email = get_user_by_email($email); // функция возвращает в переменную false, если email свободен

if (($email == ($_SESSION['user_data']['email'])) || ($exist_Email == false))
// если email совпадает с данным юзером, меняем только пароль или в базе нет такого email, меняем всё
{
    edit_credencials($id, $email, $password);
    set_flash_message("success","Данные {$username} изменены.");
    redirect_to('page_profile.php?id='.$id);
}
//если не пустое значение, возвращённое по данному email, то выдать сообщение, что данный email уже занят
elseif ($exist_Email != false) {
    set_flash_message("danger","Данный {$email} занят.");
    redirect_to('security.php?id='.$id);
}
