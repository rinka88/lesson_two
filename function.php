<?php

function get_user_by_email($email) {
    $pdo = new PDO("mysql:host=localhost;dbname=two", "root", "root");
    $sql = "SELECT * FROM users WHERE email=:email";
    $statement = $pdo->prepare($sql);
    $statement->execute(["email" => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
}

function redirect_to($path) {
    header("Location: {$path}");
    exit;
}

function add_users($email, $password) {
    $pdo = new PDO("mysql:host=localhost;dbname=two", "root", "root");
    $sql = "INSERT INTO users (email,password) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);
    $userMail = $email;
    $statement = $pdo->prepare("SELECT `id` FROM email WHERE `email` = ?");
    $statement->execute([$userMail]);
    $id = $statement->fetchColumn();
    return $id;
}

function display_flash_message($name) {
    if(isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
        unset($_SESSION[$name]);
    }
}

function login($email, $password) {
    $user = get_user_by_email($email);
    if(empty($user)) {
        set_flash_message('danger', 'такого пользователя не существует');
        return false;
    } elseif (!password_verify($password, $user['password'])) {
        set_flash_message('danger', 'пароль не верный');
        return false;
    } else {
        /*$_SESSION['email'] = $user['email'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['id'] = $user['id'];*/
        return $user;
    }
}

function is_not_logged_in() {
    if (isset($_SESSION['log-in']) && !empty($_SESSION['log-in']))
        return true;
    else
        return false;
}

function check_admin() {
    if (isset($_SESSION['log-in']) && !empty($_SESSION['log-in'])) {
        $pdo = new PDO('mysql:host=localhost;dbname=two;','root','root');
        $userMail = $_SESSION['log-in'];
        $statement = $pdo->prepare('SELECT `role` FROM email WHERE `email` = ?');
        $statement->execute([$userMail]);
        $role = $statement->fetchColumn();
        if ($role == 0) {
            $_SESSION['role'] = 'admin';
        }
        else $_SESSION['role'] = 'user';
         }
    else
        return false;
}


function viewAllUsers() {
    $pdo = new PDO('mysql:host=localhost;dbname=two;','root','root');
    $sql = 'SELECT * FROM `users`';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $user_arr = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $user_arr;
}

function upload_avatar($avatar, $user_id){
    $name = $avatar['name'];
    $tmp_name = $avatar['tmp_name'];
    move_uploaded_file($tmp_name,"img/avatars/" . $name);
    $pdo = new PDO("mysql:host=localhost;dbname=two", "root", "");
    $sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['avatar' => $name, 'id' => $user_id]);
}

function has_image($name)
{
    if (!empty($name)) {
        echo 'img/avatars/' . $name;
    } else {
        echo 'img/demo/avatars/avatar-m.png';
    }
}

function get_user_by_id($id)
{
    $pdo = new PDO("mysql:host=localhost;dbname=two;", "root", "root");
    $sql = "SELECT * FROM `users` WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function status($status, $id = null) {
    if ($id) {
    $pdo = new PDO('mysql:host=localhost;dbname=two;', 'root', 'root');
    $sql = "UPDATE `users` SET status = :status WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    }
}

function edit_information($user, $job_title, $phone, $address, $id = null) {
   if ($id) {
       $pdo = new PDO('mysql:host=localhost;dbname=two','root','root');
       $sql = "UPDATE `users` SET `user`='$user',`job_title`='$job_title',`phone`='$phone',`address`='$address' WHERE id='$id'";
       $statement = $pdo->prepare($sql);
       $statement->execute();
   }
}

function add_social_links($telegram, $instagram, $vk, $id = null) {
    if ($id) {
        $pdo = new PDO('mysql:host=localhost;dbname=two;', 'root', 'root');
        $sql = 'UPDATE `users` SET telegram = :telegram, instagram = :instagram, vk = :vk WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute();
    }
}

function is_author ($log, $low_now){
    return ($log == $low_now);
}

function edit_credencials($id = null, $email, $password){
    if($id) {
        $pdo = new PDO("mysql:host=localhost; dbname=two;","root", "root");
        $sql = "UPDATE users SET email=:email, password=:password  WHERE id=:id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "id" => $id
        ]);
    }
}

function delete($id) {
    $pdo = new PDO("mysql:host=localhost; dbname=two;","root", "root");
    $sql = "DELETE FROM users WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":id", $id);
    $statement->execute();
}