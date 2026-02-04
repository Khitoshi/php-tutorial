<?php

class Database {
    // 本当はenvで管理するが、面倒なので直書き。。。
    private string $host       = 'localhost';
    private string $user       = 'vagrant';
    private string $password   = '985632';
    private string $dbname     = 'test';
    
    private ?mysqli $mysqli = null;
    
    // MySQLに接続
    public function connect() : ?string {
        if ($this->mysqli) {
            return null;
        }
    
        $tmpMysqli = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if($tmpMysqli->connect_error){
            return $tmpMysqli->connect_error;
        }

        $this->mysqli = $tmpMysqli;
        return null;
    }

    // 切断
    public function close() : void {
        if ($this->mysqli) {
            $this->mysqli->close();
            $this->mysqli = null;
        }
    }

    // クエリ実行用のコールバック関数
    // mysqliオブジェクトをコールバック内でのみ使用可能にする
    public function execute(callable $callback) : ?array {
        if (!$this->mysqli) {
            throw new Exception("データベースに接続されていません");
        }
        return $callback($this->mysqli);
    }

}
