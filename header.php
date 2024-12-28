<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/constants.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/core/init.php";
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🦋Напоминалка🦋</title>
    <link rel="stylesheet" href="/style.css">
  </head>
  <body>
    <nav>
      <?if($_SERVER["SCRIPT_NAME"] !== "/index.php"):?>
      <a href="/" class="text no-decoration pacifico-regular">Домой</a>
      <?else:?>
      <a class="text no-decoration pacifico-regular" href="pages/create.php">Создать напоминание</a>
      <?endif?>
    </nav>
