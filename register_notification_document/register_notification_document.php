<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/header.css">
</head>

<body>
  <?php require_once "../include/header.php"; ?>
  <div id="main">
    <div id="register_area" class="card">
      <h1 class="card-header">提出された書類を撮影</h1>
      <form action="./register_notification_document_post.php" method="POST">
        <input type="file" id="notification_document" capture="environment" accept="image/*" />
        <!-- 送信ボタン デフォルトではdisabled -->
        <input type="submit" value="送信" class="btn btn-primary mt-3" disabled />
      </form>
      <img id="preview" src="" alt="プレビュー画像" />
    </div>

    <div id="analysis_result" class="cardArea">
      <button type="button" class="btn btn-primary" id="display_result_history">
        これまでの結果を表示
      </button>
    </div>
  </div>

  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <script type="module" src="./js/apikey.js" type="module"></script>
  <script type="module" src="./js/register_notification_document.js"></script>
</body>

</html>