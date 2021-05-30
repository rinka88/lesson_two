<?php
session_start();
require_once "function.php";
$username = $_POST["username"];
$job_title = $_POST["job_title"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$id = $_SESSION['user_data']['id'];


edit_information($id, $username, $job_title, $phone, $address);
set_flash_message('success', "Данные пользователя изменены");
redirect_to("users.php");
