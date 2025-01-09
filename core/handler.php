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
				$statement = $db->prepare("INSERT INTO ".TABLE." (text, datetime) VALUES (?, ?);");
                $statement->bindValue(1, $_POST["text"], SQLITE3_TEXT);
				$statement->bindValue(2, $_POST["datetime"], SQLITE3_TEXT);
				if (!$statement->execute()) {
					log_to_file(["CODE" => $db->lastErrorCode(), "MESSAGE" => $db->lastErrorMsg(), "ACTION" => "CREATE"], "database_error");
				}
                break;
            case "update":
				$statement = $db->prepare("UPDATE ".TABLE." SET (text, datetime, notified) = (?, ?, ?) WHERE id = ?;");
                $statement->bindValue(1, $_POST["text"], SQLITE3_TEXT);
				$statement->bindValue(2, $_POST["datetime"], SQLITE3_TEXT);
				$statement->bindValue(3, !empty($_POST["notified"]) ? $_POST["notified"] : 0, SQLITE3_INTEGER);
				$statement->bindValue(4, $_POST["id"], SQLITE3_INTEGER);
				if (!$statement->execute()) {
					log_to_file(["CODE" => $db->lastErrorCode(), "MESSAGE" => $db->lastErrorMsg(), "ACTION" => "UPDATE"], "database_error");
				}
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
