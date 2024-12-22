<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/header.css">
</head>

<body>
  <?php include "include/header.php"; ?>
  <div id="buttonArea">
    <div class="card">
      <h1 class="card-title">作業予定・実績</h1>
      </button>
      <button type="button" class="btn btn-primary" id="button2">
        管理日報を見る・登録する
      </button>
    </div>
    <div class="card">
      <h1 class="card-title">作業記録</h1>
      <button type="button" class="btn btn-primary" id="button3">水道検針の結果を登録する</button>
      <button type="button" class="btn btn-primary" id="button4">清掃・作業を登録する</button>
      <button type="button" class="btn btn-primary" id="button5">工事立ち合いを登録する</button>
    </div>

    <div class="card">
      <h1 class="card-title">届け出・問い合わせ処理</h1>
      <button type="button" class="btn btn-primary" id="button6"
        onclick="location.href='./register_notification_document.html'">
        届出書類を登録する
      </button>
      <button type="button" class="btn btn-primary" id="button7" onclick="location.href='./inquiry.php'">
        お客様・支店からの問い合わせ
      </button>
    </div>
    <div class="card">
      <h1 class="card-title">マニュアル</h1>
      <button type="button" class="btn btn-primary" id="button9">業務の手順を見る</button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>


</body>

</html>