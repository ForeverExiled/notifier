<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/init.php";

switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        switch($_POST["action"]) {
            case "create":
                $db->exec("INSERT INTO ".TABLE." (text, datetime) VALUES (\"{$_POST['text']}\", \"{$_POST['datetime']}\")");
                header("Refresh: 1; url=/");
        }
        break;
}
