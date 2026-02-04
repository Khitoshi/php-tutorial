<?php
abstract class Table {
    private string $tableName;

    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }

    protected function getTableName() : string {
        return $this->tableName;
    }
}
