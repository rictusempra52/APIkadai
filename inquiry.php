<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>問い合わせ管理</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <form action="./inquiry_post_create.php" method="POST">
        <fieldset>
            <legend>問い合わせ内容を記入してください</legend>
            <label for="room_no">
                部屋番号
            </label>
            <input type="text" id="room_no" name="room_no">

            <label for="inquiry">
                問い合わせ内容
            </label>
            <textarea name="inquiry" id="inquiry"></textarea>
        </fieldset>
    </form>
</body>

</html>