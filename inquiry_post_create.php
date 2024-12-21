<?php
// var_dump($_POST);

// 変数定義
$roomNo = $_POST["room_no"];
$inquiry = $_POST["inquiry"];
$createdAt = date("Y/m/d H:i:s");

// ファイルに書き込む形式に変換
$writeData = "{$createdAt},{$roomNo},{$inquiry}\n";

var_dump($writeData);

// CSSファイルを作成、更新
$file = fopen("./data/inquiry.csv", "a");
saveData($file, $writeData);

header("./inquiry.php");
exit();

function saveData($file, $writeData)
{
    flock($file, LOCK_EX);
    fwrite($file, $writeData);
    flock($file, LOCK_UN);
    fclose($file);
}