<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/constants.php";

function mpr($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function log_to_file($data, $filename) {
	$path = "$_SERVER[DOCUMENT_ROOT]/logs/";
	if (!file_exists($path)) {
		mkdir($path);
	}
	$path .= $filename;
	$date = substr((new DateTime())->format(DateTime::ATOM), 0, 16);
	$up_down = str_repeat("-", strlen($date) + 2);
	$date = $up_down.PHP_EOL."|$date|".PHP_EOL.$up_down.PHP_EOL;
	file_put_contents($path, $date.var_export($data, true), FILE_APPEND);
}

function month_num_to_word($num) : string {
    $month = [
        "01" => "января",
        "02" => "февраля",
        "03" => "марта",
        "04" => "арпеля",
        "05" => "мая",
        "06" => "июня",
        "07" => "июля",
        "08" => "августа",
        "09" => "сентября",
        "10" => "октября",
        "11" => "ноября",
        "12" => "декабря",
    ];
    return $month[$num];
}

$db = new SQLite3(__DIR__."/".DATABASE);
$db->busyTimeout(60000);
$db->exec("PRAGMA journal_mode=wal;");
$db->exec("CREATE TABLE IF NOT EXISTS ".TABLE." (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text TEXT, datetime TEXT, notified INTEGER DEFAULT 0);");
