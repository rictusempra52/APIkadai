<?php
require_once "../include/functions.php";
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