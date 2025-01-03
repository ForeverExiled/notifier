<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/core/init.php";
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>🦋Напоминалка🦋</title>
		<link rel="stylesheet" href="/style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<nav>
			<?if($_SERVER["SCRIPT_NAME"] !== "/index.php"):?>
				<a href="/" class="text no-decoration pacifico-regular btn-default">Домой</a>
			<?else:?>
				<a class="text no-decoration pacifico-regular btn-default" href="pages/add.php">Добавить напоминание</a>
			<?endif?>
		</nav>
		<hr class="hr__bold">
