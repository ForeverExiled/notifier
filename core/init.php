<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/constants.php";

$db = new SQLite3(__DIR__."/".DATABASE);
$db->exec("CREATE TABLE IF NOT EXISTS ".TABLE." (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text TEXT, datetime TEXT);");
