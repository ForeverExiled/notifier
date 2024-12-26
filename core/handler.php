<?php
function add($values) {
    
}

switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        switch($_POST["action"]) {
            case "create":
                add($_POST);
                break;
        }
        break;
}
