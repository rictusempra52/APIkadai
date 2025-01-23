<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/header.css" />
</head>

<body>
    <div class="card" id="login-area">
        <h1 class="card-header">ログイン</h1>
        <form action="./login_post.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <!-- 入力されているかどうかで内容が変更されるdiv -->
                <div class="input-check"></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <!-- 入力されているかどうかで内容が変更されるdiv -->
                <div class="input-check"></div>

            </div>
            <div class="button-area">
                <button type="submit" class="btn btn-primary">ログイン</button>
                <!-- 新規登録 -->
                <button type="button" class="btn btn-secondary" id="button1"
                    onclick="location.href='./register.php'">新規登録</button>
            </div>
        </form>
    </div>
</body>

</html>