<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/header.css">
</head>

<body>
  <?php include "./include/header.php"; ?>
  <div id="main">
    <input type="file" id="notification_document" capture="environment" accept="image/*" />
    <img id="preview" src="" alt="" />

    <button type="button" class="btn btn-primary" id="display_result_history">
      これまでの結果を表示
    </button>

    <div id="analysis_result">
      <p>分析結果</p>
      <div id="analysis_result_timestamp">日時：</div>
      <div id="analysis_result_text">テキスト：</div>
    </div>
  </div>

  <script src="./js/apikey.js"></script>
  <script type="module" src="./js/register_notification_document.js"></script>
</body>

</html>