<?php

// 変数定義
$id = $_GET['id'];
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
    addDatatoMySQL($roomNo, $inquiry, $deadline);
}
// idをキーにMySQLから問い合わせデータを取得
$mySQLdata = getDatafromMySQL($id);

header("Location:./inquiry_edit.php");
exit();

/** idをキーにMySQLから問い合わせデータを取得する関数
 * @param int $id 取得する問い合わせデータのid
 * @return array 取得した問い合わせデータ
 */
function getDatafromMySQL($id)
{
    // env.phpからデータベースのキーなどを取得し、db_connを使えるようにする
    include "../env/env.php";
    // DB接続
    $pdo = db_conn();

    // SQL文作成
    $sql = "SELECT * FROM inquiry WHERE id = :id";

    // SQL実行（実行に失敗すると `sql error ...` が出力される）
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }

    // 結果の取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// sql実行関数
function executeQuery($sql, $bindings)
{
    // env.phpからデータベースのキーなどを取得し、db_connを使えるようにする
    include "../env/env.php";
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

// MySQLに新しい問い合わせデータを追加する関数
function addDatatoMySQL($room_no, $inquiry, $deadline)
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

/**  
 * $idがnullの場合はaddDatatoMySQL関数を呼び出す
 * $idがnullでない場合は、nullでない項目に限り更新する
 * @param int $id 更新するレコードのid
 * @param string $room_no 部屋番号
 * @param string $inquiry 問い合わせ内容
 * @param string $deadline 締切日
 */
function updateDatatoMySQL($id, $room_no, $inquiry, $deadline)
{
    // idが空の場合はaddDatatoMySQL関数を呼び出し
    if (empty($id)) {
        addDatatoMySQL($room_no, $inquiry, $deadline);
        return;
    }
    // 更新するカラムのセットとバインディング変数の準備
    $setClauses = [];
    $bindings = [':id' => [$id, PDO::PARAM_INT]];

    // 空白でない項目をセット句に追加し、バインディング変数も設定
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