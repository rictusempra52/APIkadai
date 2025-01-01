<?php
require_once "../include/functions.php";

// 変数定義 idはGETできる(=問い合わせデータ編集の)時だけ代入し、そうでなければnullにしておく
$id = $_GET['id'] ?? null;
$roomNo = trim($_POST["room_no"]);
$inquiry = urlencode(trim($_POST["inquiry"])); // urlencodeを使うことで、改行を無視
$deadline = $_POST["deadline"];

// 入力チェック
if (empty($roomNo) || empty($inquiry) || empty($deadline)) {
    session_start();
    // 部屋番号または問い合わせ内容または締切日が入力されていない場合、どれが入力されていないかをエラー情報として保存する。
    $errmsg = '次の項目が入力されていません：';
    if (empty($roomNo))
        $errmsg .= " 部屋番号";
    if (empty($inquiry))
        $errmsg .= " 問い合わせ内容";
    if (empty($deadline))
        $errmsg .= " 締切日";
    // セッションにエラー情報を保存
    $_SESSION["error"] = $errmsg;
} else {
    // 部屋番号、問い合わせ内容、締切日が入力されている場合、MySQLの問い合わせデータを更新
    // idがnullの場合は追加する
    updateDatatoMySQL($id, $roomNo, $inquiry, $deadline);
}

header("Location:./inquiry_list.php");