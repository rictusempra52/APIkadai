<?php
require_once "..//functions.php";

// 変数定義 idはPOSTできる(=問い合わせデータ編集の)時だけ代入し、そうでなければnullにしておく
$id = $_POST['id'] ?? null;
$roomNo = trim($_POST["room_id"]);
$inquiry = trim($_POST["inquiry"]);
$deadline = $_POST["deadline"];

// 入力チェック
if (empty($roomNo) || empty($inquiry) || empty($deadline)) {

} else {
    // 部屋番号、問い合わせ内容、締切日が入力されている場合、MySQLの問い合わせデータを更新
    // idがnullの場合は追加する
    updateDatatoMySQL($id, $roomNo, $inquiry, $deadline);

    header("Location:./inquiry_list.php");
}