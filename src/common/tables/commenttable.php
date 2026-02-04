<?php
require_once __DIR__ . '/table.php';

class CommentTable extends Table {
    
    public function __construct() {
        parent::__construct('comment');
    }

    // コメント一覧取得
    public function getComments(Database $db) : ?array{
        return $db->execute(function($mysqli) {
            $tableName = $this->getTableName();
            $sql = $mysqli->prepare("
                SELECT c.id, c.user_id, c.comment, u.name as user_name 
                FROM $tableName c
                JOIN user u ON c.user_id = u.id
            ");
            if (!$sql) {
                return null;
            }
            if (!$sql->execute()) {
                echo "execute error: " . $sql->error;
                return null;
            }
            $result = $sql->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            return $rows ? $rows : [];
        });
    }

    // コメント投稿
    // useridやcommentもクラスにまとめてよりわかりやすく管理したいが、面倒なので簡略化。。。
    public function postComment(Database $db, int $userId,  string $comment) {
        return $db->execute(function($mysqli) use ($userId, $comment)  {
            $tableName = $this->getTableName();
            
            $sql= $mysqli->prepare("INSERT INTO $tableName (user_id, comment) VALUES (?, ?) ");
            if (!$sql) {
                echo "prepare error: " . $mysqli->error;
                return null;
            }
            $sql->bind_param('is', $userId, $comment);
            if (!$sql->execute()) {
                echo "execute error: " . $sql->error;
                return null;
            }
            return $sql->affected_rows > 0 ? ['user_id' => $userId, 'comment' => $comment] : null;
        });
    }
}
