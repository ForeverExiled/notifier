<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/constants.php";

function mpr($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
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
$db->exec("CREATE TABLE IF NOT EXISTS ".TABLE." (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text TEXT, datetime TEXT);");
