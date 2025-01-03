<?php
include $_SERVER["DOCUMENT_ROOT"]."/header.php";
$todo = $db->querySingle("SELECT * FROM ".TABLE." WHERE id={$_GET['id']};", true);
?>

<form id="form_create" action="/core/handler.php" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<textarea rows="10" cols="30" name="text" class="pacifico-regular"><?=$todo["text"]?></textarea>
	<input type="datetime-local" name="datetime" required oninvalid="this.setCustomValidity('Выбери денек и время!')" oninput="this.setCustomValidity('')" value="<?=$todo["datetime"]?>">
	<button type="submit" class="pacifico-regular">Сохранить!</button>
</form>

<?php include $_SERVER["DOCUMENT_ROOT"]."/footer.php";
