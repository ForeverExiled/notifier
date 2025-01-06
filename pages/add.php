<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/header.php";
?>

<form id="form_create" action="/core/handler.php" method="post">
  <input type="hidden" name="action" value="create">
  <textarea rows="10" cols="30" name="text" class="pacifico-regular"></textarea>
  <input type="datetime-local" name="datetime" required oninvalid="this.setCustomValidity('Выбери денек и время!')" oninput="this.setCustomValidity('')">
  <button type="submit" class="pacifico-regular">Добавить!</button>
</form>

<?php require_once $_SERVER["DOCUMENT_ROOT"]."/footer.php";
