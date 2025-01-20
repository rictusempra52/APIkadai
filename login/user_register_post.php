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
    echo
        "<script>
            alert('このメールアドレスは既に登録されています。\\nログイン画面に戻ります。');
            location.href='./login.php';
        </script>";
} else {
    registerUser($email, $password);
    header("Location:./login.php");
}

exit;