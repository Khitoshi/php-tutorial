<section>
    <form action="" method="post">
        <br>
        名前:<br>
        <input type="text" name="name" value=""><br>
        <br>
        パスワード:<br>
        <input type="text" name="password" value=""><br>
        <input type="submit" value="登録">
    </form>
</section>

<?php
// 接続
$mysqli = new mysqli('localhost', 'vagrant', '985632', 'test');

//接続状況の確認
if($mysqli->connect_error){
        echo $mysqli->connect_error;
        exit();
}else{
        $mysqli->set_charset('utf8');
}

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

$pass = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

$sql = $mysqli->prepare("INSERT INTO user(name, password) VALUES (?, ?)");
$sql->bind_param('ss', $name, $pass);
$sql->execute();

// 切断
$mysqli->close();
?>
