<?php 
class Database extends SQLite3
{
    public function __construct() {
        $this->SQLite3::open(__DIR__."/".DATABASE);
        $this->exec("CREATE TABLE IF NOT EXISTS ".TABLE." (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text TEXT, datetime TEXT);");        
    }

    public function add($values) {
        $this->exec("INSERT INTO ".TABLE." (text, datetime) VALUES ({$values[text]}, {$values[datetime]})");
    }
}
