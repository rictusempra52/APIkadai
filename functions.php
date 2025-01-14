<?php
// データベース関数

/** データベースに接続する関数
 * @return PDO 接続オブジェクト
 */
function db_conn()
{
    // データベース接続
    try {
        require_once "env.php";
        // DB接続情報
        $dbInfo = dbInfo();
        $dsn =
            "mysql:dbname={$dbInfo['db_name']};charset=utf8;host={$dbInfo['db_host']}";
        return new PDO($dsn, $dbInfo['db_id'], $dbInfo['db_pw']);
    } catch (PDOException $e) {
        exit("DB接続エラー@db_conn: " . $e->getMessage());
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
        error_log("SQL error@executeQuery: " . $e->getMessage());
        exit(json_encode(["error" => "Database query failed"]));
    }

}

/** IDをキーに問い合わせデータを取得する
 * @param int $id 問い合わせデータのID
 * @param bool $includeSoftDeletedItems 削除された問い合わせデータを含めるか (デフォルト：false)
 * @return array|null 問い合わせデータ
 */
function getDataFromMySQL($id, $includeSoftDeletedItems = false)
{
    $sql = "SELECT * FROM inquiry WHERE id = :id"
        . (
            $includeSoftDeletedItems
            ? ""
            : " AND deleted_at IS NULL"
        );
    $bindings = [':id' => [$id, PDO::PARAM_INT]];
    $record = executeQuery($sql, $bindings, false);

    // inquiryはURLエンコードされているので、decodeする
    $record['inquiry'] = isset($record['inquiry'])
        ? trim_all(urldecode($record['inquiry']))
        : '';
    return $record;

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
    $record['created_at'] = JPDate($record['created_at']);
    $record['deadline'] = JPDate($record['deadline']);

    return "
    <div class='card mb-3'>
        <div class='card-header'>{$record['room_no']}</div>
        <div class='card-body'>
            <h6 class='card-subtitle mb-2 text-muted'>
                登録日時:{$record['created_at']} 対応期限:{$record['deadline']}
            </h6>
            <p class='card-text'>{$record['inquiry']}</p>
            <a id='btn-edit-{$id}' 
            href='./inquiry_edit.php?id={$id}'
            class='btn btn-primary'>編集</a>
            <a id='btn-delete-{$id}' class='btn btn-danger'>削除</a>
        </div>
    </div>";
}

/** すべての問い合わせデータを取得し、HTML形式で返す
 * @return string HTML形式の問い合わせデータのリスト
 */
function getAllInquiriesHTML($includeSoftDeletedItems = false)
{
    $sql = "SELECT id FROM inquiry"
        . (
            $includeSoftDeletedItems
            //  論理削除された問い合わせデータを含める
            ? ""
            // 論理削除された問い合わせデータを含めない
            : " WHERE deleted_at IS NULL"
        );
    $ids = executeQuery($sql, [], true);
    $output = '';

    foreach ($ids as $row) {
        $output .= getInquiryHTML($row['id'], );
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

/** 問い合わせデータを更新または追加する
 * @param int|null $id 更新するデータのID（新規追加の場合はnull）
 * @param string|null $room_no 部屋番号
 * @param string|null $inquiry 問い合わせ内容
 * @param string|null $deadline 締切日
 */
function updateDatatoMySQL($id = null, $room_no = null, $inquiry = null, $deadline = null)
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
    if (!empty($room_no)) {
        $room_no = trim($room_no);
        $setClauses[] = "room_no = :room_no";
        $bindings[":room_no"] = [$room_no, PDO::PARAM_STR];
    }
    if (!empty($inquiry)) {
        $inquiry = trim($inquiry);
        $setClauses[] = "inquiry = :inquiry";
        $bindings[":inquiry"] = [$inquiry, PDO::PARAM_STR];
    }
    if (!empty($deadline)) {
        $deadline = trim($deadline);
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
        exit(json_encode(["error" => " id=" . $id . " の問い合わせデータには更新する項目がありません"]));
    }
}

/** 問い合わせデータを論理削除する
 * @param int $id 削除するデータのID
 */
function softDeleteFromMySQL($id)
{
    $sql = "UPDATE inquiry SET deleted_at = NOW() WHERE id = :id";
    $bindings = [":id" => [$id, PDO::PARAM_INT]];
    executeQuery($sql, $bindings);
}

/**
 * Google Cloud Vision APIにアクセスし、画像内に含まれるテキストを取得する
 *
 * @param string $imagePath 画像ファイルのパス
 * @return string 画像内に含まれるテキストのjsonデータ
 */
function getCloudVision($imagePath)
{
    require_once "./env.php";
    // APIキーを取得
    $apiKey = cloudVisionInfo()['apiKey'];

    // Vision APIのURL
    $url = "https://vision.googleapis.com/v1/images:annotate?key=$apiKey";

    // 画像ファイルをbase64エンコード
    $imageData = base64_encode(file_get_contents($imagePath));

    // リクエストボディ
    $data = [
        "requests" => [
            [
                // 画像
                "image" => [
                    "content" => $imageData,
                ],
                // 画像の特徴
                "features" => [
                    [
                        // テキストの検出
                        "type" => "TEXT_DETECTION",
                        // 最大検出数
                        "maxResults" => 1,
                    ],
                ],
            ],
        ],
    ];

    // cURLのオプション
    $options = [
        // URL
        CURLOPT_URL => $url,
        // POSTメソッド
        CURLOPT_POST => true,
        // POSTデータ
        CURLOPT_POSTFIELDS => json_encode($data),
        //レスポンスを文字列として取得
        CURLOPT_RETURNTRANSFER => true,
    ];

    // cURLの初期化
    $ch = curl_init();

    // cURLのオプションの設定
    curl_setopt_array($ch, $options);

    // cURLの実行
    $response = curl_exec($ch);

    // cURLの終了
    curl_close($ch);

    // レスポンスをJSONデコード
    $responseData = json_decode($response, true);

    return $responseData;
}

// 文字列修正などこまごました関数

/** trimでは全角空白を削除できないので、全角も含めて空白を削除する関数*/
function trim_all($str)
{
    return trim
    (str_replace("\u{3000}", ' ', $str));
}

/** created_atやdeadlineを"yyyy年mm月dd日(曜日(日本語))"形式に変換する関数
 * 
 * @param string $date "Y-m-d"形式の日付
 * @return string "yyyy年mm月dd日(曜日(日本語))"形式の日付
 */
function JPDate($date)
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