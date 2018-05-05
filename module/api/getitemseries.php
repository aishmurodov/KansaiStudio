<?

	header('Content-type: text/html; charset=utf-8');
	function normJsonStr($str){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
	    return iconv('cp1251', 'utf-8', $str);
	}
	$item = Form::formChars($Param['item'], 1);
	$row_item = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT `origin_title`,`maxseries` FROM `anime_post` WHERE `id` = '$item'"));
	if (!$row_item)
		exit("Invalid item number. Please check and rewrite");


	$query = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_series` WHERE `anime_post` = '$item'");

	while ($row = mysqli_fetch_assoc($query)) {
		$arr[] = $row;
	}

	$arr = json_encode($arr);

	echo normJsonStr($arr);