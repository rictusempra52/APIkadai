<?php
require_once "./login_functions.php";

// POSTの値チェック
if (empty($_POST['mail_address']) || empty($_POST['password']))
    exit("入力されていない項目があります。");

// POSTの値を変数に代入
$mail_address = $_POST['mail_address'];
$password = $_POST['password'];

// ログイン
if (login($mail_address, $password)) {
    // ログイン成功のalert
    echo
        "<script>
            alert('{$mail_address}にてログインしました。');
            location.href='../index.php';
        </script>";

} else {
    // ログイン失敗のalert
    echo
        "<script>
            alert('ログインに失敗しました。');
            location.href='./login.php';
        </script>";
}