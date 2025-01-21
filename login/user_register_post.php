<?php
require_once "./login_functions.php";

// POSTの値チェック
if (empty($_POST['mail_address']) || empty($_POST['password']))
    exit("入力されていない項目があります。");

// POSTの値を変数に代入
$mail_address = $_POST['mail_address'];
$password = $_POST['password'];

// ユーザー新規登録
if (isUserExist($mail_address)) {
    echo
        "<script>
            alert('このメールアドレスは既に登録されています。\\nログイン画面に戻ります。');
            location.href='./login.php';
        </script>";
} else {
    registerUser($mail_address, $password);
    header("Location:./login.php");
}

exit;