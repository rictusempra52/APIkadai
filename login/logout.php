<?php

session_start();
$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();

echo
    "<script>
        alert('ログアウトしました。');
        location.href='./login.php';
    </script>";

exit;