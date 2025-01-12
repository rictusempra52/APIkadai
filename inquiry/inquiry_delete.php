<?php
require_once "../functions.php";

// idがGETできる(=問い合わせデータ削除の)時だけ処理を実行する
if (!empty($_GET['id'])) {
    softDeleteFromMySQL($_GET['id']);
}else {
    
}

header("Location:./inquiry_list.php");