<?php

// 変数定義
$roomNo = $_POST["room_no"];
// urlencodeを使うことで、改行を無視してcsvファイルに書き込める
$inquiry = urlencode($_POST["inquiry"]);

// 入力チェック
if (empty($roomNo) || empty($inquiry)) {
    // セッションにエラー情報を保存
    session_start();
    $_SESSION["error"] = "部屋番号または問い合わせ内容が入力されていません。";
    // var_dump($_SESSION["error"]);
} else {
    // タイムゾーンを設定
    date_default_timezone_set('Asia/Tokyo');
    // 日本語で曜日を追加する
    $days = ["(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)"];
    $createdAt = date("Y/m/d") . $days[date("w")] . date(" H:i");
    // ファイルに書き込む形式に変換
    $writeData = "{$createdAt},{$roomNo},{$inquiry}\n";

    // CSVファイルを作成、更新
    $file = fopen("./data/inquiry.csv", "a");
    saveData($file, $writeData);
}

header("Location:./inquiry.php");
exit();

// CSVファイルにデータを書き込む関数
function saveData($file, $writeData)
{
    flock($file, LOCK_EX);
    fwrite($file, $writeData);
    flock($file, LOCK_UN);
    fclose($file);
}
