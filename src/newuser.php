<!DOCTYPE html>
<html>
  <head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>ユーザ追加</h2>
		<form action="newuser.php" method="post">
		  ユーザ: <input type="text" name="username" /><br/>
		  パスワード: <input type="password" name="password" /><br/>
		  <input type="submit" />
		</form>
	</body>
</html>

<?php
    require_once 'common/session.php';

    // セッション開始
    session_start_if_none();

    // 接続
    $mysqli = new mysqli('localhost', 'vagrant', '985632', 'test');    

    // 接続状況の確認
    if($mysqli->connect_error){
            echo $mysqli->connect_error;
            exit();
    }else{
            $mysqli->set_charset('utf8');
    }

    $name = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = $mysqli->prepare("INSERT INTO user(name, password) VALUES (?, ?)");
    $sql->bind_param('ss', $name, $password_hash);
    $sql->execute();

    // 切断
    $mysqli->close();
    echo "ユーザを追加しました。";
?>
