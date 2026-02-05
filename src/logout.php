<?php
    require_once __DIR__ . '/common/session.php';

    // セッション開始
    session_start_if_none();

    if(isset($_SESSION['user_name'])){
        echo $_SESSION['user_name'] . "さんはログイン中です。<br>";
    }else{
        echo "ログインしていません。<br>";
        exit();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ログアウト処理
        if(isset($_SESSION['user_id'])) {
            echo "ログアウトしました。<br>";
            session_destroy();
            // リダイレクト
            header("Location: /login");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>ログアウト</h2>
		<form action="logout" method="post">
		  <button type="submit" name="logout" value="send">ログアウト</button>
		</form>
	</body>
</html>
