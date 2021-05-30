<?php
session_start();
require_once "function.php";

$avatar = $_FILES['avatar'];
$user_id = $_POST["id"];


upload_avatar($avatar, $user_id);
set_flash_message("success", "Профиль успешно обновлен.");
redirect_to("page_profile.php?id=" . $user_id);