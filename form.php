<?php
session_start();
require_once "function.php";
$email = $_POST["email"];
$password= $_POST["password"];

$user = $_POST["name"];
$job_title = $_POST["job_title"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$status = $_POST["status"];
$arr_file = $_FILES["avatar"];
$avatar = $_FILES["avatar"];
$vk = $_POST["vk"];
$telegram = $_POST["telegram"];
$instagram = $_POST["instagram"];

if (isset($email) && !empty($email)) {
    $exist = get_user_by_email($email);

    if ($exist) {
        set_flash_message('danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');
        redirect_to('create_user.php');
        exit;
    } else {
        if (isset($password) && !empty($password)) {
            if (empty($user) || empty($job_title) || empty($phone) || empty($address)) {
                set_flash_message('danger', "Введите полностью общую информацию о пользователе. Пользователь не добавлен");
                redirect_to('create_user.php');
            } else {
                $id = add_users($email, $password);
                edit_information($id, $user, $job_title, $phone, $address);
                status($status, $id);
                upload_avatar($avatar, $id);
                add_social_links($vk, $telegram, $instagram, $id);
                set_flash_message('success', 'Пользователь добавлен');
                redirect_to('users.php');
            }
        } else {
            set_flash_message('danger', 'введите пароль'); // если email уникальный, но не введён пароль
            redirect_to("create_user.php");
            exit;
        }
    }
}

/*$email = $_POST["email"];
$password= $_POST["password"];

$name = $_POST["name"];
$job_title = $_POST["job_title"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$status = $_POST["status"];
$arr_file = $_FILES["avatar"];
$avatar = $_FILES["avatar"];
$vk = $_POST["vk"];
$telegram = $_POST["telegram"];
$instagram = $_POST["instagram"];

if (get_user_by_email($email)){
    set_flash_message('danger', "Этот эл. адрес уже используется.");
    redirect_to('create_user.php');
}
$user = add_users($email,$password);
upload_avatar($_FILES['avatar'], $user);

status($status, $user);
edit_information($name, $job_title, $phone, $address, $user);
add_social_links($telegram, $vk, $instagram, $user);

set_flash_message('success',"Пользователь успешно добавлен");
redirect_to('users.php');*/
