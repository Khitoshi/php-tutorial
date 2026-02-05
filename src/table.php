<?php
require_once __DIR__ . '/common/session.php';

// セッション開始
session_start_if_none();
    
if (isset($_SESSION['user_id'])) {
    $token = bin2hex(random_bytes(32));
    $_SESSION["token"] = $token;
    /**
    * コメント投稿フォーム
    */
    echo '現在のユーザ名: ' . htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') . '<br/>';
    echo '<form action="comment.php" method="post">';
	echo 'コメント: <input type="text" name="comment" /><br/>';
	echo '<input type="hidden" name="token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
	echo '<input type="submit" /> </form>';
}else{
    echo 'コメントを投稿するにはログインしてください。';
    //header('Location: login.php');
    exit();
}

/**
 * 結合したテーブルをSELECTして$result変数に格納する処理（前の課題の部分なので中略している）
 */

//MySQLに接続
require_once __DIR__ . '/common/database.php';
$database = new Database();
if($err = $database->connect()){
    echo $err;
    exit();
}

// コメント取得処理
require_once __DIR__ . '/common/tables/commenttable.php';
$ct = new CommentTable();
$rows = $ct->getComments($database);
$database->close();

echo "<table>\n";
echo "<tr><th>ID</th><th>ユーザ名</th><th>コメント</th></tr>\n";
foreach($rows as $row){
    echo "<tr>\n";
    echo "<td>{$row['id']}</td>\n";
    echo "<td>{$row['user_name']}</td>\n";
    echo "<td>{$row['comment']}</td>\n";
    echo "</tr>\n";
}
echo "</table>";
