<?php
include $_SERVER["DOCUMENT_ROOT"]."/header.php";
$query_result = $db->query("SELECT * FROM ".TABLE." ORDER BY datetime");
$todos = [];
while ($row = $query_result->fetchArray(SQLITE3_ASSOC)) {
	[$date, $time] = explode("T", $row["datetime"]);
	$date = explode("-", $date);
	$date[1] = month_num_to_word($date[1]);
	$date[2] = intval($date[2]);
	$todos[] = [
		"id" => $row["id"],
		"text" => "$date[2] $date[1] $date[0] в $time: $row[text]",
	];
}
$count = count($todos);
?>

<?if($count > 0):?>
	<section class="list">
		<?for($i = 0; $i < $count; $i++):?>
			<div data-id="<?=$todos[$i]["id"]?>">
				<?=$todos[$i]["text"]?>
			</div>
			<?if($i < $count - 1):?>
				<hr>
			<?endif?>
		<?endfor?>
	</section>
<?else:?>
	<p class="pacifico-regular">Свободна как попуг!</p>
<?endif?>

<?php
include $_SERVER["DOCUMENT_ROOT"]."/footer.php";
