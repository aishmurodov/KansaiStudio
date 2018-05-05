<?
	$item = Form::formChars($Param['item'], 1);

	$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `anime_post` WHERE `id` = '$item'"));

 	function MetaOgInfo ($title, $description, $poster, $url) {?>
		<meta property="og:title" content="<?=$title?> - <?=Config::title();?>">
		<meta property="og:description" content="<?=$description?>">
		<meta property="og:image" content="<?=$poster?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content= "<?=$url?>">
	<?}

	if ($row) 
		MetaOgInfo($row['translated_title'], $row['description'], "$_SERVER[HTTP_X_FORWARDED_PROTO]://$_SERVER[SERVER_NAME]".$row['poster'], "$_SERVER[HTTP_X_FORWARDED_PROTO]://$_SERVER[SERVER_NAME]/anime/view/item/$row[id]");
?>