<?php include $_SERVER["DOCUMENT_ROOT"]."/header.php"?>

<form id="form_create" action="" method="post">
    <input type="text" name="text">
    <button type="submit">Добавить!</button>
</form>

<script>
    document.getElementById("form_create").addEventListener("submit", function (e) {
        e.preventDefault();
        const payload = new FormData(this).values();
        console.log(foo(payload));
    });
</script>
<?php include $_SERVER["DOCUMENT_ROOT"]."/footer.php";
