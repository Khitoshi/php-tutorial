<?php

require_once __DIR__ . '/table.php';

class UserTable extends Table {
    
    public function __construct() {
        parent::__construct('user');
    }

    // ユーザ取得
    // 本当は型をreadonlyにしてクラスで返したいが、vrsionの関係で使用できないので簡略化する。。。
    public function getUserByName(Database $db, string $name) : ?array {
        return $db->execute(function($mysqli) use ($name) {
            $tableName = $this->getTableName();
            $sql = $mysqli->prepare("SELECT * FROM $tableName WHERE name = ?");
            if (!$sql) {
                return null;
            }
            $sql->bind_param('s', $name);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            return $row ? $row : null;
        });
    }
}
