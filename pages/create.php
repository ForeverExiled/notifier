<?php include $_SERVER["DOCUMENT_ROOT"]."/header.php"?>

<form id="form_create" action="/core/handler.php" method="post">
  <input type="hidden" name="action" value="create">
  <input type="text" name="text" required oninvalid="this.setCustomValidity('Напиши что-нибудь!')" oninput="this.setCustomValidity('')">
  <input type="datetime-local" name="datetime" required oninvalid="this.setCustomValidity('Выбери денек и время!')" oninput="this.setCustomValidity('')">
  <button type="submit">Добавить!</button>
</form>

<script>
    /*document.getElementById("form_create").addEventListener("submit", function (e) {
        e.preventDefault();
        const payload = new FormData(this);
        handle(payload);
    });*/
</script>
<?php include $_SERVER["DOCUMENT_ROOT"]."/footer.php";
