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
    // // タイムゾーンを設定
    // date_default_timezone_set('Asia/Tokyo');
    // // 日本語で曜日を追加する
    // $days = ["(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)"];
    // $createdAt = date("Y/m/d") . $days[date("w")] . date(" H:i");
    // // ファイルに書き込む形式に変換
    // $writeData = "{$createdAt},{$roomNo},{$inquiry}\n";

    // CSVファイルを作成、更新
    // saveData("./data/inquiry.csv", $writeData);
    saveDatatomysql($roomNo, $inquiry, $createdAt);
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

function saveDatatomysql($room_no, $inquiry, $deadline)
{
    // 各種項目設定
    $dbn = 'mysql:dbname=mskanriapp;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    // DB接続
    try {
        $pdo = new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(
            ["database error" => "{$e->getMessage()}"]
        );
        exit();
    }

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
        $status = $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
}