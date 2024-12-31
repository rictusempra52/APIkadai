<?php
// セッションの開始
session_start();
$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
// エラー情報を削除
unset($_SESSION["error"]);

// データまとめ用の変数
$cardHTML = getDatafromMySQL();

/** MySQLから問い合わせデータを取得し、HTMLにして返す関数
 * @return string 問い合わせデータをHTMLに変換した文字列
 */
function getDatafromMySQL()
{
    // env.phpからデータベースのキーなどを取得し、db_connを使えるようにする
    include "../env/env.php";
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
        // カードには編集ボタンもつける
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
                    <!-- 編集ボタン -->
                    <a href='./inquiry_edit.php?id={$record['id']}' class='btn btn-primary'>編集</a>
                </div>
            </div>";
    }
    return $output;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- ヘッダー -->
    <?php include "../include/header.php"; ?>
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
    <div id="main_contents">
        <div id="task_list">
            <div class="card">
                <h1 class="card-title">問い合わせ履歴</h1>
                <div class="card-body"> <?= $cardHTML ?> </div>
            </div>
        </div>
    </div>
    <footer></footer>
</body>

</html>