<?php
require_once "..//functions.php";
// セッションの開始
session_start();
// データまとめ用の変数
$cardHTML = getAllInquiriesHTML();

/** 問い合わせデータの総数を部屋ごとに取得し、HTMLに出力する関数
 * @return string 問い合わせデータの総数を部屋番号ごとに記載したcard
 */
function getInquiryAmount()
{

    // 部屋ごとの問い合わせデータの総数を取得
    $sql =
        "SELECT
            r.room_no,
            COUNT(i.id) AS inquiry_count
        FROM
            rooms r
        LEFT OUTER JOIN
            inquiry i ON r.id = i.room_id
        GROUP BY
            r.room_no;";
    $records = executeQuery($sql, []);

    // 部屋ごとの問い合わせデータの総数を表にしてHTMLに出力
    $output = '';
    foreach ($records as $record) {
        $output .= "
            <tr>
                <td>{$record['room_no']}:</td>
            </tr>
            <tr>
                <td>{$record['inquiry_count']}件</td>
            </tr>
        ";
    }
    return $output;

}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/header.css" />
    <title>問い合わせ履歴</title><!--  -->
</head>

<body>
    <!-- ヘッダー -->
    <?php require_once "../header.php"; ?>

    <div id="main_contents">
        <div id="buttons">
            <!-- 問い合わせを登録するボタン -->
            <button type="button" class="btn btn-primary" id="button1"
                onclick="location.href='./inquiry_edit.php'">問い合わせを登録する</button>
        </div>
        <div id="task_list" class="card">
            <h1 class="card-header">問い合わせ履歴</h1>
            <div class="card-body">
                <div class="card" id="task_amount">
                    <!-- 部屋番号ごとのinquiry数 -->
                    <?= getInquiryAmount() ?>
                </div>
                <?= $cardHTML ?>
            </div>
        </div>
    </div>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // $_SESSION["result"]の内容があればalertを表示
            const result = <?=
                isset($_SESSION["result"])
                ? json_encode($_SESSION["result"])
                : null ?>;
            if (result) alert(result);

            // $_SESSION["result"]を空にする(しないと繰り返し表示される)
            <?php unset($_SESSION["result"]) ?>

        });
    </script>
</body>

</html>