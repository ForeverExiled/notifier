<?php 
class Database extends SQLite3
{
    public function __construct($name) {
        SQLite3::open($name);
    }
}

$db = new Database(__DIR__."/".DATABASE);
$db->exec("CREATE TABLE IF NOT EXISTS ".TABLE." (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text TEXT);");
