<?php

// 変数定義
$roomNo = $_POST["room_no"];
// urlencodeを使うことで、改行を無視
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

header("Location:./inquiry/inquiry.php");
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
// sql実行関数
function executeQuery($sql, $bindings)
{
    // env.phpからデータのオブジェクトを取得
    include "./env/env.php";
    // DB接続
    $pdo = db_conn();

    // SQL文作成
    $stmt = $pdo->prepare($sql);

    // バインド変数を設定
    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key, $value[0], $value[1]);
    }

    // SQL実行（実行に失敗すると `sql error ...` が出力される）
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
}

// saveDatatoMySQL関数
function saveDatatoMySQL($room_no, $inquiry, $deadline)
{
    // SQL文
    $sql = "INSERT INTO inquiry (id, room_no, inquiry, deadline, created_at, updated_at)
            VALUES (NULL, :room_no, :inquiry, :deadline, now(), now())";

    // バインド変数の設定
    $bindings = [
        ':room_no' => [$room_no, PDO::PARAM_STR],
        ':inquiry' => [$inquiry, PDO::PARAM_STR],
        ':deadline' => [$deadline, PDO::PARAM_STR]
    ];

    // sql実行関数を呼び出し
    executeQuery($sql, $bindings);
}

/** updateDatatoMySQL関数 
 * $idが空の場合はエラーを吐く　空でない場合は更新
 * @param int $id 更新するレコードのid
 * @param string $room_no 部屋番号
 * @param string $inquiry 問い合わせ内容
 * @param string $deadline 締切日
 */
function updateDatatoMySQL($id, $room_no, $inquiry, $deadline)
{
    // idが空の場合はエラーを出力して終了
    if (empty($id)) {
        echo json_encode(["error" => "idが空のため更新すべきデータを探せません"]);
        exit();
    }
    // 更新するカラムのセットとバインディング変数の準備
    $setClauses = [];
    $bindings = [':id' => [$id, PDO::PARAM_INT]];

    // 各項目が空でないかつnullでない場合、セット句に追加し、バインディング変数も設定
    if (!empty($room_no)) {
        $setClauses[] = "room_no = :room_no";
        $bindings[':room_no'] = [$room_no, PDO::PARAM_STR];
    }
    if (!empty($inquiry)) {
        $setClauses[] = "inquiry = :inquiry";
        $bindings[':inquiry'] = [$inquiry, PDO::PARAM_STR];
    }
    if (!empty($deadline)) {
        $setClauses[] = "deadline = :deadline";
        $bindings[':deadline'] = [$deadline, PDO::PARAM_STR];
    }

    // 更新するカラムがある場合のみSQL文を作成
    if (count($setClauses) > 0) {
        // SQL文の生成
        $sql =
            "UPDATE inquiry SET "
            . implode(", ", $setClauses)
            . ", updated_at = NOW() WHERE id = :id";

        // SQL実行関数を呼び出し
        executeQuery($sql, $bindings);
    } else {
        // 更新する項目がない場合
        echo json_encode(["error" => "更新する項目がありません"]);
        exit();
    }
}
