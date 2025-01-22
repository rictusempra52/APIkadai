<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/header.css" />
</head>

<body>
    <div class="card">
        <h1 class="card-header">新規登録</h1>
        <form action="user_register_post.php" method="POST">
            <div class="mb-3">
                <label for="mail_address" class="form-label">メールアドレス</label>
                <input type="mail_address" class="form-control" name="mail_address" id="mail_address" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">登録</button>
            <!-- 戻るボタン -->
            <button type="button" class="btn btn-secondary" id="return"
                onclick="location.href='./login.php'">ログイン画面へ戻る</button>
        </form>
    </div>
</body>

</html>