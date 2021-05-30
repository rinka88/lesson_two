<?php
session_start();
require_once "function.php";
$status = $_POST['select_status'];
status($status, $_SESSION['id_user']);
set_flash_message('success', "Статус обновлён");
redirect_to('page_profile.php?id='.$_SESSION['id_user']);