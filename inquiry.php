<?php
// セッションの開始
session_start();
$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
// エラー情報を削除
unset($_SESSION["error"]);

// データまとめ用の空文字変数
$str = getDatafromMySQL();

// // ファイルを開く（読み取り専用）
// $file = fopen('data/inquiry.csv', 'r');
// flock($file, LOCK_EX);

// if ($file) { // ファイルが開けているか確認
//     // ファイルから1行ずつ読み込み
//     while ($line = fgets($file)) {
//         // 行の前後の不要な空白や改行を削除
//         $line = trim($line);
//         // カンマで区切ってデータを分割
//         $cells = explode(',', $line);

//         // データが3つ以上存在する場合のみ処理
//         if (count($cells) >= 3) {
//             // 配列からそれぞれの値を取得し、HTMLエスケープを行って安全にする
//             $timestamp = htmlspecialchars($cells[0]);
//             $room_no = htmlspecialchars($cells[1]);
//             // 問い合わせ内容をデコードし、改行をHTMLの<br>タグに変換してHTMLエスケープ
//             $inquiry = nl2br(
//                 htmlspecialchars(
//                     urldecode($cells[2])
//                 )
//             );

//             // HTMLに問い合わせデータをカード形式で追加する
//             $str .= "
//             <div class='card mb-3'> 
//                 <!-- 部屋番号 -->
//                 <div class='card-header'>$room_no</div> 
//                 <!-- カードの本文部分 -->
//                 <div class='card-body'> 
//                     <!-- タイムスタンプ -->
//                     <h6 class='card-subtitle mb-2 text-muted'>$timestamp</h6> 
//                     <!-- 問い合わせ内容 -->
//                     <p class='card-text'>$inquiry</p> 
//                 </div>
//             </div>";
//         } else {
//             echo "ファイルにデータが3つ未満しかありません";
//         }
//     }
// } else {
//     echo "ファイルを開けません";
// }

// flock($file, LOCK_UN);
// fclose($file);

/** MySQLから問い合わせデータを取得し、HTMLにして返す関数
 * @return string 問い合わせデータをHTMLに変換した文字列
 */
function getDatafromMySQL(): string
{
    // env.phpからデータのオブジェクトを取得
    include "./env/env.php";
    // DB接続
    $pdo = db_conn();

    // SQL文作成
    $sql = "SELECT * FROM inquiry";

    $stmt = $pdo->prepare($sql);

    // SQL実行（実行に失敗すると `sql error ...` が出力される）
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
    // 結果の取得
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = '';

    foreach ($result as $record) {
        // inquiryをデコード
        $record['inquiry'] = urldecode($record['inquiry']);
        // HTMLに問い合わせデータをカード形式で追加する
        $output .= "
            <div class='card mb-3'> 
                <!-- 部屋番号 -->
                <div class='card-header'>{$record['room_no']}</div> 
                <!-- カードの本文部分 -->
                <div class='card-body'> 
                    <!-- タイムスタンプ -->
                    <h6 class='card-subtitle mb-2 text-muted'>登録日時:{$record['created_at']} 対応期限：{$record['deadline']}</h6>
                    <!-- 問い合わせ内容 -->
                    <p class='card-text'>{$record['inquiry']}</p> 
                </div>
            </div>";
    }
    return $output;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>問い合わせ管理</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/header.css" />
</head>

<body>
    <!-- ヘッダー -->
    <?php include "./include/header.php"; ?>
    <!-- エラーモーダル -->
    <?php if ($error): ?>
        <div class="modal fade show" id="errorModal" tabindex="-1" style="display: block;" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">入力エラー</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <?= htmlspecialchars($error) ?>
                    </div>

                    <div class="modal-footer">
                        <!-- モーダルを閉じるボタン　フォーカスが当たっているようにする -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" autofocus>閉じる</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                const errorModal = new bootstrap.Modal($('#errorModal'));
                errorModal.show();
                console.log(errorModal);
            });
        </script>
    <?php endif; ?>
    <header></header>
    <div id="main_contents">
        <form action="./inquiry_post_create.php" method="POST">
            <div class="card">
                <h1 class="card-title">問い合わせ内容を記入してください</h1>
                <div class="card-body">
                    <label for="room_no">
                        部屋番号
                    </label>
                    <input type="text" id="room_no" name="room_no" class="form-control" />

                    <label for="inquiry" class="mt-3">
                        問い合わせ内容
                    </label>
                    <textarea name="inquiry" id="inquiry" class="form-control"></textarea>
                    <label for="inquiry" class="mt-3">
                        対応期日
                    </label>
                    <input type="date" id="deadline" name="deadline" class="form-control">

                    <input type="submit" value="送信" class="btn btn-primary mt-3">
                </div>
            </div>
        </form>
        <div id="task_list">
            <div class="card">
                <h1 class="card-title">問い合わせ履歴</h1>
                <div class="card-body"> <?= $str ?> </div>
            </div>
        </div>
    </div>
    <footer></footer>
</body>

</html>