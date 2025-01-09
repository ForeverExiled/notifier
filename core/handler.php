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
				// TODO: make query prettier and simpler (BIND and/or ternary to set value)
				$query = "UPDATE ".TABLE." SET (text, datetime";
				if (!empty($_POST["notified"])) {
					$query .= ", notified";
				}
				$query .= ") = (\"{$_POST['text']}\", \"{$_POST['datetime']}\"";
				if (!empty($_POST["notified"])) {
					$query .= " \"{$_POST['notified']}\"";
				}
				$query .= ") WHERE id={$_POST['id']};";
                $db->exec($query);
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
                echo json_encode($db->querySingle("SELECT * FROM ".TABLE." WHERE notified = 0 ORDER BY datetime;", true));
                break;
            default:
                break;
        }
        break;
}

if (!empty($_POST["action"])) {
    header("Refresh: 0; url=/");
}
