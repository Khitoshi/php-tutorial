<?php
require_once './common/session.php';

// セッション開始
session_start_if_none();

//CSRF対策
if (!isset($_POST['token']) || !isset($_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
    echo "Bad Request";
    exit();
}

/**
 * コメント投稿したときに呼ばれる想定
 */
if (!isset($_SESSION['user_id'])) {
  //ログインしていないときは処理されたくない
  echo "Bad Request";
  exit();
}
//MySQLに接続
require_once './common/database.php';
$database = new Database();
if($err = $database->connect()){
    echo $err;
    exit();
}

$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
var_dump($comment);

// コメント投稿処理
require_once './common/tables/commenttable.php';
$ct = new CommentTable();
$row = $ct->postComment($database, $_SESSION['user_id'], $comment);
$database->close();
if ($row === null) {
    echo "コメントの投稿に失敗しました。";
    exit();
}
echo "コメントを投稿しました。";

//リダイレクト（table.phpにリダイレクトすると自然な流れになると思います）
header('Location: table.php');
