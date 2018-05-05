<?
		header('Content-type: text/html; charset=utf-8');
		function normJsonStr($str){
		    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
		    return iconv('cp1251', 'utf-8', $str);
		}
		$item = Form::formChars($Param['item'], 1);
		$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `anime_post` WHERE `id` = '$item'"));
		if (!$row) {
			exit("Invalid item number. Please check and rewrite");
		}
		else {
			$arr = json_encode($row);
			echo normJsonStr($arr);
		}