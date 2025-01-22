<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once __DIR__ . "/login_functions.php";
session_start();

// POSTの値チェック
if (empty($_POST['mail_address']) || empty($_POST['password']))
    echo "
        <script>
            alert('入力されていない項目があります。');
            location.href='../login.php';
        </script>";

// POSTの値を変数に代入
$mail_address = $_POST['mail_address'];
$password = $_POST['password'];

// ログイン
if (login($mail_address, $password)) {
    // ログイン成功のalert
    echo
        "<script>
            alert('こんにちは！{$mail_address}にてログインしました。');
            location.href='../index.php';
        </script>";

} else {
    // ログイン失敗のalert
    echo
        "<script>
            alert('ログインに失敗しました。');
            location.href='../login.php';
        </script>";
}