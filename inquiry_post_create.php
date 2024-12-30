<?php

// 変数定義
$roomNo = $_POST["room_no"];
// urlencodeを使うことで、改行を無視してcsvファイルに書き込める
$inquiry = urlencode($_POST["inquiry"]);
$deadline = $_POST["deadline"];

// 入力チェック
if (empty($roomNo) || empty($inquiry) || empty($deadline)) {
    // セッションにエラー情報を保存
    session_start();
    // 部屋番号または問い合わせ内容または締切日が入力されていない場合、どれが入力されていないかをエラー情報として保存する。
    // 複数が入力されていない場合にも対応する
    $errmsg = '次の項目が入力されていません：';
    if (empty($roomNo))
        $errmsg .= " 部屋番号";
    if (empty($inquiry))
        $errmsg .= " 問い合わせ内容";
    if (empty($deadline))
        $errmsg .= " 締切日";

    $_SESSION["error"] = $errmsg;
} else {
    saveDatatoMySQL($roomNo, $inquiry, $deadline);
    // // タイムゾーンを設定
    // date_default_timezone_set('Asia/Tokyo');
    // // 日本語で曜日を追加する
    // $days = ["(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)"];
    // $createdAt = date("Y/m/d") . $days[date("w")] . date(" H:i");
    // // ファイルに書き込む形式に変換
    // $writeData = "{$createdAt},{$roomNo},{$inquiry}\n";
    // CSVファイルを作成、更新
    // saveData("./data/inquiry.csv", $writeData);
}

header("Location:./inquiry.php");
exit();

// CSVファイルにデータを書き込む関数
function saveData($filename, $writeData)
{
    $file = fopen($filename, "a");
    flock($file, LOCK_EX);
    fwrite($file, $writeData);
    flock($file, LOCK_UN);
    fclose($file);
}

function saveDatatoMySQL($room_no, $inquiry, $deadline)
{
    // env.phpからデータのオブジェクトを取得
    include "./env/env.php";
    // DB接続
    $pdo = db_conn();

    // SQL文作成
    $sql = "INSERT INTO 
    inquiry (  id,  room_no,  inquiry,  deadline, created_at, updated_at)
    VALUES  (NULL, :room_no, :inquiry, :deadline, now(),      now())";

    $stmt = $pdo->prepare($sql);

    // バインド変数を設定
    $stmt->bindValue(':room_no', $room_no, PDO::PARAM_STR);
    $stmt->bindValue(':inquiry', $inquiry, PDO::PARAM_STR);
    $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);

    // SQL実行（実行に失敗すると `sql error ...` が出力される）
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
}