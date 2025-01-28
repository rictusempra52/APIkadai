<?php
require_once(__DIR__ . '/../functions.php');

/** ユーザーがすでに存在しているかチェック
 * @param string $email ユーザーのメールアドレス
 * @return bool true:存在している false:存在していない
 */
function isUserExist($email)
{
    // SQL文を準備
    // メールアドレスが存在するかを確認するSQL文
    // deleted_at IS NULLは論理削除されたユーザーを除く
    $sql = "SELECT * FROM users WHERE email = :email AND deleted_at IS NULL";
    $bindings = [":email" => [$email, PDO::PARAM_STR]];
    $result = executeQuery($sql, $bindings);
    if ($result instanceof PDOException) {
        // エラー処理
        throw $result;
    } else {
        return !empty($result);

    }
}

/** ユーザー新規登録
 * @param string $email ユーザーのメールアドレス
 * @param string $password ユーザーのパスワード
 * @param integer $user_type ユーザーの種類 (0:管理者 1:居住者　2:管理会社)
 * @return mixed 
 */
function registerUser
(
    $email,
    $password,
    $user_type = 0,
    $building_id = null,
    $room_id = null
) {
    // パスワードをハッシュ化
    $password = password_hash($password, PASSWORD_DEFAULT);
    // SQL文
    $sql = "INSERT INTO `users` 
    (`id`, `email`, `password`, `user_type`, `created_at`, `updated_at`, `deleted_at`) 
    VALUES 
    (NULL, :email, :password, :user_type, NOW(), NOW(), NULL);";

    $bindings = [
        ":email" => [$email, PDO::PARAM_STR],
        ":password" => [$password, PDO::PARAM_STR],
        ":user_type" => [$user_type, PDO::PARAM_INT]
    ];
    return executeQuery($sql, $bindings);
}

/** ログイン
 * @param string $email ユーザーのメールアドレス
 * @param string $password ユーザーのパスワード
 * @return bool true:ログイン成功 false:ログイン失敗
 */
function login($email, $password)
{
    $sql =
        "SELECT * FROM users WHERE email = :email AND deleted_at IS NULL";
    $bindings = [":email" => [$email, PDO::PARAM_STR]];
    // クエリ実行
    $stmt = executeQuery($sql, $bindings, false);

    // 結果を取得
    if ($stmt && password_verify($password, $stmt["password"])) {
        session_start();
        session_regenerate_id(true);
        $_SESSION["id"] = session_id();
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = $stmt['user_type'];
        $_SESSION['building_id'] = $stmt['building_id'];
        $_SESSION['room_id'] = $stmt['room_id'];

        return true;
    } else {
        return false;
    }
}

/** ログイン状態をチェック
 * @return bool true:ログインしている false:ログインしていない
 */
function isLogin()
{
    if (!isset($_SESSION))
        session_start();
    if (// 1. $_SESSION["id"]が存在するかチェック
        // 2. $_SESSION["id"]が現在のセッションIDと一致するかチェック
        !isset($_SESSION["id"]) || $_SESSION["id"] !== session_id()
    ) {
        // ログインしてない場合
        return false;
    } else {
        // ログインしている場合
        session_regenerate_id(true);
        $_SESSION["id"] = session_id();
        return true;
    }

}
