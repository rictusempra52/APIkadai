<?php
require_once "..//functions.php";

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
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>問い合わせ管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/header.css" />
</head>

<body>
    <!-- ヘッダー -->
    <?php require_once "../include/header.php"; ?>
    <!-- メインコンテンツ -->
    <div id="main_contents">
        <form action="./inquiry_post_edit.php" method="POST">
            <div class="card">
                <h1 class="card-header">問い合わせ内容を記入してください</h1>
                <!-- 入力フォーム -->
                <div id="inquiry_form" class="card-body">
                    <!-- 部屋番号 -->
                    <label for="room_no">部屋番号</label>
                    <input type="text" id="room_no" name="room_no" class="form-control"
                        value="<?= $mySQLdata['room_no'] ?>" required />
                    <!-- 入力されているかどうかで内容が変更されるdiv -->
                    <div class="input-check"></div>
                    <!-- 問い合わせ内容 -->
                    <label for="inquiry" class="mt-3">問い合わせ内容</label>
                    <textarea id="inquiry" name="inquiry" class="form-control"
                        required><?= $mySQLdata['inquiry'] ?></textarea>
                    <!-- 入力されているかどうかで内容が変更されるdiv -->
                    <div class="input-check"></div>
                    <!-- 対応期日 -->
                    <label for="inquiry" class="mt-3">対応期日</label>
                    <input type="date" id="deadline" name="deadline" class="form-control"
                        value="<?= $mySQLdata['deadline'] ?>" required />
                    <!-- 入力されているかどうかで内容が変更されるdiv -->
                    <div class="input-check"></div>
                    <!-- 送信ボタン -->
                    <input type="submit" value="送信" class="btn btn-primary mt-3">
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="../js/inquiry_edit.js"></script>
</body>

</html>