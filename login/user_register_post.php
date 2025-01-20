<?php
require_once "./login_functions.php";

// POSTの値チェック
if (empty($_POST['email']) || empty($_POST['password']))
    exit("入力されていない項目があります。");

// POSTの値を変数に代入
$email = $_POST['email'];
$password = $_POST['password'];

// ユーザー新規登録
if (isUserExist($email)) {
    header("Location:./register.php?error=1");
}else {
    registerUser($email, $password);
}
header("Location:./login.php");

exit;