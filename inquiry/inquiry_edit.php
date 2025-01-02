<?php
require_once "../include/functions.php";

// idがGETできる(=問い合わせデータ編集の)時だけ処理
if (!empty($_GET['id'])) {
    // GETできる場合は、mySQLから問い合わせデータを取得して変数に格納
    $id = $_GET['id'];
    $mySQLdata = getDatafromMySQL($id);
} else {
    // GETできない場合は空の配列を格納
    $mySQLdata = ['room_no' => '', 'inquiry' => '', 'deadline' => ''];
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
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/header.css" />
</head>

<body>
    <!-- ヘッダー -->
    <?php require_once "../include/header.php"; ?>
    <!-- エラーモーダル -->
    <?php session_start();
    if (isset($_SESSION["error"])):
        $error = $_SESSION["error"];
        unset($_SESSION["error"]);
        ?>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" autofocus>閉じる</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
                console.log(errorModal);
            });
        </script>
    <?php endif; ?>
    <!-- メインコンテンツ -->
    <div id="main_contents">
        <form action="./inquiry_post_edit.php" method="POST">
            <div class="card">
                <h1 class="card-title">問い合わせ内容を記入してください</h1>
                <!-- 入力フォーム -->
                <div id="inquiry_form" class="card-body">
                    <!-- 部屋番号 -->
                    <label for="room_no">部屋番号</label>
                    <input type="text" id="room_no" name="room_no" class="form-control"
                        value="<?= $mySQLdata['room_no'] ?>" />
                    <!-- 問い合わせ内容 -->
                    <label for="inquiry" class="mt-3">問い合わせ内容</label>
                    <textarea id="inquiry" name="inquiry" class="form-control">
                        <?= $mySQLdata['inquiry'] ?>
                    </textarea>
                    <!-- 対応期日 -->
                    <label for="inquiry" class="mt-3">対応期日</label>
                    <input type="date" id="deadline" name="deadline" class="form-control"
                        value="<?= $mySQLdata['deadline'] ?>" />
                    <!-- 送信ボタン -->
                    <input type="submit" value="送信" class="btn btn-primary mt-3">
                </div>
            </div>
        </form>
    </div>
    <script src="../js/inquiry_edit.js"></script>
</body>

</html>