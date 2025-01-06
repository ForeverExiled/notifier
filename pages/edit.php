<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/header.php";
$todo = $db->querySingle("SELECT * FROM ".TABLE." WHERE id={$_GET['id']};", true);
?>

<form id="form_update" action="/core/handler.php" method="post" onsubmit="validate(event)" novalidate>
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<textarea rows="10" cols="30" name="text" class="pacifico-regular"><?=$todo["text"]?></textarea>
	<input type="datetime-local" name="datetime" required>
	<button type="submit" class="pacifico-regular">Сохранить!</button>
</form>

<?php require_once $_SERVER["DOCUMENT_ROOT"]."/footer.php";
