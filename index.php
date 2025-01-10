<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/header.php";
$query_result = $db->query("SELECT * FROM ".TABLE." ORDER BY datetime");
$todos = [];
while ($row = $query_result->fetchArray(SQLITE3_ASSOC)) {
	[$date, $time] = explode("T", $row["datetime"]);
	$date = explode("-", $date);
	$date[1] = month_num_to_word($date[1]);
	$date[2] = intval($date[2]);
	$todos[] = [
		"id" => $row["id"],
		"datetime" => $row["datetime"],
		"text" => "$date[2] $date[1] $date[0] в $time: $row[text]",
		"notified" => $row["notified"],
	];
}
$count = count($todos);
?>

<section class="list<?if($count) echo " show"?>">
	<?for($i = 0; $i < $count; $i++):?>
		<div class="todo-item<?if($todos[$i]["notified"]) echo " notified"?>" data-id="<?=$todos[$i]["id"]?>" data-datetime="<?=$todos[$i]["datetime"]?>" onclick="show_context_menu(event)">
			<?=$todos[$i]["text"]?>
		</div>
		<?if($i < $count - 1):?>
			<hr>
		<?endif?>
	<?endfor?>
</section>
<p class="empty-list pacifico-regular<?if(!$count) echo " show"?>">Свободна как попуг!</p>
<div id="ctx__wrapper" onclick="hide_context_menu()">
	<div id="ctx__menu" class="context-menu">
		<a id="ctx__btn-edit" href="#">Изменить</a>
		<hr>
		<div id="ctx__btn-delete" onclick="confirm_delete(event)">Удалить</div>
	</div>
</div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/footer.php";
