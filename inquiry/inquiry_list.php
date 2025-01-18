
<?php
require_once "..//functions.php";
// セッションの開始
session_start();
// データまとめ用の変数
$cardHTML = getAllInquiriesHTML();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/header.css" />
    <title>問い合わせ履歴</title>
</head>

<body>
    <!-- ヘッダー -->
    <?php require_once "../include/header.php"; ?>

    <div id="main_contents">
        <div id="buttons">
            <!-- 問い合わせを登録するボタン -->
            <button type="button" class="btn btn-primary" id="button1"
                onclick="location.href='./inquiry_edit.php'">問い合わせを登録する</button>
        </div>
        <div id="task_list" class="card">
            <h1 class="card-header">問い合わせ履歴</h1>
            <div class="card-body"> <?= $cardHTML ?> </div>
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