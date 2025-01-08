<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/init.php";

switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if ($_SERVER["CONTENT_TYPE"] === "application/json") {
            $json = json_decode(file_get_contents("php://input"), true);
            $action = $json["action"] ?? "";
        } else {
            $action = $_POST["action"] ?? "";
        }
        switch($action) {
            case "create":
                $db->exec("INSERT INTO ".TABLE." (text, datetime) VALUES (\"{$_POST['text']}\", \"{$_POST['datetime']}\")");
                break;
            case "update":
                $db->exec("UPDATE ".TABLE." SET (text, datetime) = (\"{$_POST['text']}\", \"{$_POST['datetime']}\") WHERE id={$_POST['id']};");
                break;
            case "delete":
                $db->exec("DELETE FROM ".TABLE." WHERE id={$json['id']};");
                break;
            default:
                break;
        }
        break;
    case "GET":
        switch ($_GET["q"]) {
            case "nearest":
                echo json_encode($db->querySingle("SELECT * FROM ".TABLE." ORDER BY datetime;", true));
                break;
            default:
                break;
        }
        break;
}

if (!empty($_POST["action"])) {
    header("Refresh: 0; url=/");
}
