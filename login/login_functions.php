<?php
require_once "../functions.php";

/** ユーザーがすでに存在しているかチェック
 * @param string $mail_address ユーザーのメールアドレス
 * @return bool true:存在している false:存在していない
 */
function isUserExist($mail_address)
{
    // SQL文を準備
    // メールアドレスが存在するかを確認するSQL文
    // deleted_at IS NULLは論理削除されたユーザーを除く
    $sql = "SELECT * FROM user_table WHERE mail_address = :mail_address AND deleted_at IS NULL";
    $bindings = [":mail_address" => [$mail_address, PDO::PARAM_STR]];
    $result = executeQuery($sql, $bindings);
    if ($result instanceof PDOException) {
        // エラー処理
        throw $result;
    } else {
        return !empty($result);

    }
}

/** ユーザー新規登録
 * @param string $mail_address ユーザーのメールアドレス
 * @param string $password ユーザーのパスワード
 * @return mixed 
 */
function registerUser($mail_address, $password)
{
    // パスワードをハッシュ化
    $password = password_hash($password, PASSWORD_DEFAULT);
    // SQL文
    $sql = "INSERT INTO `user_table` 
    (`id`, `mail_address`, `password`, `user_type`, `created_at`, `updated_at`, `deleted_at`) 
    VALUES (NULL, :mail_address, :password, '0', NOW(), NOW(), NULL)";
    $bindings = [
        ":mail_address" => [$mail_address, PDO::PARAM_STR],
        ":password" => [$password, PDO::PARAM_STR]
    ];
    return executeQuery($sql, $bindings);
}

/** ログイン
 * @param string $mail_address ユーザーのメールアドレス
 * @param string $password ユーザーのパスワード
 * @return bool true:ログイン成功 false:ログイン失敗
 */
function login($mail_address, $password)
{
    $sql = "SELECT * FROM user_table
    WHERE mail_address = :mail_address AND deleted_at IS NULL";
    $bindings = [":mail_address" => [$mail_address, PDO::PARAM_STR]];
    $result = executeQuery($sql, $bindings);
    if (!empty($result)) {
        $record = $result->fetch(PDO::FETCH_ASSOC);
        return password_verify($password, $record["password"]);
    } else {
        return false;
    }
}
