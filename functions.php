<?php

// .envを読み込むための準備
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// .envからDB接続情報を取得
$sakura_db_info = [
    "db_name" => $_ENV["sakuraName"],
    "db_host" => $_ENV["sakuraHost"],
    "db_id" => $_ENV["sakuraID"],
    "db_pw" => $_ENV["sakuraPW"],
];
/** データベースに接続する関数
 * @return PDO 接続オブジェクト
 */
function db_conn()
{
    $serverName = $_SERVER["SERVER_NAME"];

    // サーバー情報に基づきデータベース接続情報を設定
    // dbinfoの値は、ローカル環境ならlocalhost、サーバー環境ならsakura_db_infoの返り値をとる
    // sakura_db_infoが万が一返り値を返さない場合、空の配列をとる
    // ternary演算子,null coalescing演算子について学ぶこと
    $dbInfo = ($serverName === "localhost")
        ? [
            "db_name" => "mskanriapp",
            "db_host" => "127.0.0.1",
            "db_id" => "root",
            "db_pw" => "",
        ]
        : $sakura_db_info ?? [];

    // データベース接続
    try {
        $dsn = "mysql:dbname={$dbInfo['db_name']};charset=utf8;host={$dbInfo['db_host']}";
        return new PDO($dsn, $dbInfo['db_id'], $dbInfo['db_pw']);
    } catch (PDOException $e) {
        exit("DB Connection Error: " . $e->getMessage());
    }
}

/** SQL文を実行し、結果を取得する汎用関数
 * @param string $sql 実行するSQL文
 * @param array $bindings プレースホルダーにバインドする値
 * @param bool $fetchAll 結果を全件取得するかどうか
 * @return mixed クエリ実行結果
 */
function executeQuery($sql, $bindings = [], $fetchAll = true)
{
    $pdo = db_conn();
    try {
        // SQL文を準備
        $stmt = $pdo->prepare($sql);

        // プレースホルダーに値をバインド
        foreach ($bindings as $key => $value) {
            $stmt->bindValue($key, $value[0], $value[1]);
        }

        // クエリを実行
        $stmt->execute();

        // 結果を取得
        // fetchAll()で全件取得、fetch()で1件取得
        return $fetchAll
            ? $stmt->fetchAll(PDO::FETCH_ASSOC)
            : $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // エラーが発生した場合はエラーメッセージをJSON形式で出力
        exit(json_encode(["sql error" => $e->getMessage()]));
    }
}

/** IDをキーに問い合わせデータを取得する
 * @param int $id 問い合わせデータのID
 * @return array|null 問い合わせデータ
 */
function getDataFromMySQL($id)
{
    $sql = "SELECT * FROM inquiry WHERE id = :id";
    $bindings = [":id" => [$id, PDO::PARAM_INT]];
    $record = executeQuery($sql, $bindings, false);
    // inquiryはURLエンコードされているので、decodeする
    $record['inquiry'] = isset($record['inquiry'])
        ? trim(urldecode($record['inquiry']))
        : '';
    return $record;

}

/** created_atやdeadlineを"yyyy年mm月dd日(曜日(日本語))"形式に変換する関数
 * 
 * @param string $date "Y-m-d"形式の日付
 * @return string "yyyy年mm月dd日(曜日(日本語))"形式の日付
 */
function convertDateToJapanese($date)
{
    // 曜日を日本語に対応させる配列
    $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

    // DateTimeオブジェクトを作成
    $datetime = new DateTime($date);

    // 曜日を数値で取得 (0=日曜日, 6=土曜日)
    $weekdayNumber = $datetime->format('w');

    // 曜日を日本語に変換
    $weekday = $weekdays[$weekdayNumber];

    // フォーマットを出力
    return $datetime->format('Y年m月d日') . "($weekday)";
}

/**
 * 問い合わせデータをHTML形式で返す
 * @param int $id 問い合わせデータのID
 * @return string HTML形式の問い合わせデータ
 */
function getInquiryHTML($id)
{
    $record = getDataFromMySQL($id);

    if (!$record) {
        return "<p>データが見つかりませんでした。（ID: {$id}）</p>";
    }

    $record['inquiry'] = urldecode($record['inquiry']);
    // 登録日時と対応期限を日本語日付形式に変換
    $record['created_at'] = convertDateToJapanese($record['created_at']);
    $record['deadline'] = convertDateToJapanese($record['deadline']);

    return "
        <div class='card mb-3'> 
            <div class='card-header'>{$record['room_no']}</div>
            <div class='card-body'> 
                <h6 class='card-subtitle mb-2 text-muted'>登録日時:{$record['created_at']} 対応期限:{$record['deadline']}</h6>
                <p class='card-text'>{$record['inquiry']}</p>
                <a href='./inquiry_edit.php?id={$record['id']}' class='btn btn-primary'>編集</a>
            </div>
        </div>";
}

/**
 * すべての問い合わせデータを取得し、HTML形式で返す
 * @return string HTML形式の問い合わせデータのリスト
 */
function getAllInquiriesHTML()
{
    $sql = "SELECT id FROM inquiry";
    $ids = executeQuery($sql, [], true);
    $output = '';

    foreach ($ids as $row) {
        $output .= getInquiryHTML($row['id']);
    }

    return $output;
}

/**
 * 新しい問い合わせデータを追加する
 * @param string $room_no 部屋番号
 * @param string $inquiry 問い合わせ内容
 * @param string $deadline 締切日
 */
function addDatatoMySQL($room_no, $inquiry, $deadline)
{
    // トリム処理を実施
    $room_no = trim($room_no);
    $inquiry = trim($inquiry);
    $deadline = trim($deadline);
    // SQL文
    $sql = "INSERT INTO inquiry (room_no, inquiry, deadline, created_at, updated_at)
            VALUES (:room_no, :inquiry, :deadline, NOW(), NOW())";
    $bindings = [
        ":room_no" => [$room_no, PDO::PARAM_STR],
        ":inquiry" => [$inquiry, PDO::PARAM_STR],
        ":deadline" => [$deadline, PDO::PARAM_STR],
    ];
    // SQL実行
    executeQuery($sql, $bindings);
}

/**
 * 問い合わせデータを更新または追加する
 * @param int|null $id 更新するデータのID（新規追加の場合はnull）
 * @param string|null $room_no 部屋番号
 * @param string|null $inquiry 問い合わせ内容
 * @param string|null $deadline 締切日
 */
function updateDatatoMySQL($id, $room_no = null, $inquiry = null, $deadline = null)
{
    // idが指定されていない場合は新規追加
    if (!$id) {
        addDatatoMySQL($room_no, $inquiry, $deadline);
        return;
    }

    // 更新するカラムのセットとバインディング変数の準備
    $setClauses = [];
    $bindings = [":id" => [$id, PDO::PARAM_INT]];

    // 各項目が空でないかつnullでない場合、トリム処理を適用してセット句に追加
    if ($room_no) {
        $room_no = trim($room_no); // トリム
        $setClauses[] = "room_no = :room_no";
        $bindings[":room_no"] = [$room_no, PDO::PARAM_STR];
    }
    if ($inquiry) {
        $inquiry = trim($inquiry); // トリム
        $setClauses[] = "inquiry = :inquiry";
        $bindings[":inquiry"] = [$inquiry, PDO::PARAM_STR];
    }
    if ($deadline) {
        $deadline = trim($deadline); // トリム
        $setClauses[] = "deadline = :deadline";
        $bindings[":deadline"] = [$deadline, PDO::PARAM_STR];
    }

    // 更新するカラムがある場合のみSQL文を作成
    if ($setClauses) {
        $sql = "UPDATE inquiry SET " . implode(", ", $setClauses)
            . ", updated_at = NOW() WHERE id = :id";
        executeQuery($sql, $bindings);
    } else {
        // 更新する項目がない場合はエラーを返す
        exit(json_encode(["error" => "更新する項目がありません"]));
    }
}