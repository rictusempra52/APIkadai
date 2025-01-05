<?php

// データベースに接続
require_once '../functions.php';

// セッションを開始
session_start();

var_dump($_FILES);

// アップロードされたファイル情報を変数に保存
$notifDoc = $_FILES['notifDoc'];
$notifDocName = $notifDoc['name'];
$notifDocTmp = $notifDoc['tmp_name'];

// アップロードされた画像をgoogle vision APIで分析する
$analysisResult = getCloudVision($notifDocTmp);

// 分析結果をデータベースに保存