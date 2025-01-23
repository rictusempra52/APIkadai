<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once __DIR__ . "/login_functions.php";
session_start();

// POSTの値チェック
if (empty($_POST['email']) || empty($_POST['password']))
    echo "
        <script>
            alert('入力されていない項目があります。');
            location.href='../login.php';
        </script>";

// POSTの値を変数に代入
$email = $_POST['email'];
$password = $_POST['password'];

// ログイン
if (login($email, $password)) {
    // ログイン成功のalert
    echo
        "<script>
            alert('こんにちは！{$email}にてログインしました。');
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