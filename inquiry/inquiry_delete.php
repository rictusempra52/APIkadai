<?php
require_once "../functions.php";
var_dump($_GET);
exit;

// idがGETできる(=問い合わせデータ削除の)時だけ処理を実行する
if (!empty($_GET['id'])) {
    softDeleteFromMySQL($_GET['id']);
}

header("Location:./inquiry_list.php");