<?php
    require_once __DIR__ . '/common/session.php';
    require_once __DIR__ . '/common/tables/usertable.php';

    // セッション開始
    session_start_if_none();

    // POST送信でなければ処理を終了
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // すでにログインしていないかチェック
        if(isset($_SESSION['user_id'])) {
          echo "既にログインしています";
          exit();
        }

        //MySQLに接続
        require_once __DIR__ . '/common/database.php';
        $database = new Database();
        if($err = $database->connect()){
            echo $err;
            exit();
        }

        $name = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');

        $user_table = new UserTable();
        $row = $user_table->getUserByName($database, $name);
        $database->close();
        if(!$row) {
            echo "ユーザ名かパスワードが間違っています。";
            exit();
        }

        // ログイン処理
        if (password_verify($_POST['password'], $row['password'])) {
            // ログイン成功
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            echo "ログインしました。";
            //テーブルにリダイレクト
            header("Location: /table");
        }else{
            echo "ユーザ名かパスワードが間違っています。";
        }
        exit();
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>ログイン</h2>
		<form action="/login" method="post">
		  ユーザ: <input type="text" name="username" /><br/>
		  パスワード: <input type="password" name="password" /><br/>
		  <input type="submit" />
		</form>
	</body>
</html>
