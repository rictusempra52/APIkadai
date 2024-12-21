<?php
// セッションの開始
session_start();
$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
// エラー情報を削除
unset($_SESSION["error"]);

// 以下、既存の内容
// データまとめ用の空文字変数
$str = '';

// ファイルを開く（読み取り専用）
$file = fopen('data/inquiry.csv', 'r');
flock($file, LOCK_EX);

if ($file) {
    while ($line = fgets($file)) {
        $line = trim($line);
        $cells = explode(',', $line);
        if (count($cells) >= 3) {
            $timestamp = htmlspecialchars($cells[0]);
            $room_no = htmlspecialchars($cells[1]);
            $inquiry = htmlspecialchars($cells[2]);

            $str .= "
            <div class='card mb-3'>
                <div class='card-header'>$room_no</div>
                <div class='card-body'>
                    <h6 class='card-subtitle mb-2 text-muted'>$timestamp</h6>
                    <p class='card-text'>$inquiry</p>
                </div>
            </div>";
        }
    }
}

flock($file, LOCK_UN);
fclose($file);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>問い合わせ管理</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+H8gka+0D9H7CIE1FknH+4Kd6EElx"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    <?php endif; ?>

    <!-- 残りの既存のHTML部分 -->
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
                <input type="submit" value="送信" class="btn btn-primary mt-3">
            </div>
        </div>
    </form>
    <div class="task_list">
        <div class="card">
            <h1 class="card-title">問い合わせ履歴</h1>
            <div class="card-body">
                <?= $str ?>
            </div>
        </div>
    </div>
</body>

</html>