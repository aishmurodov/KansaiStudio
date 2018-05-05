<?
	header('Content-type: text/html; charset=utf-8');
	$count = Form::formChars($Param['count'], 1);
	function normJsonStr($str){
	    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
	    return iconv('cp1251', 'utf-8', $str);
	}
	if (!$count)
		exit("Invalid count. Please check and rewrite");

	$query = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_post` LIMIT $count");
	$arr = [];

	while ($row = mysqli_fetch_assoc($query)) {
		$arr[] = $row;
	}

	$arr = json_encode($arr);
	echo normJsonStr($arr);
?>