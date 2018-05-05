<?

	$gets = json_decode($_SESSION['__GLOBALS']['get'], true);
	$now_get_count = count($_SESSION['__GET']) - 2;
	$get = $_SESSION['__GET'][$now_get_count];
	$_SESSION['__GET'] = [];


	foreach ($get['selected_type'] as $key => $value) {
		if ( $value == 1 )
			$type = "`type` LIKE 'Онгоинг' OR `type` LIKE 'Завершен' OR `status` LIKE 'Завершен' OR `status` LIKE 'Онгоинг'";
		else if ( $value == 3 )
			$type = "`type` LIKE 'Фильм' OR `status` LIKE 'Фильм'";
		else if ( $value == 2 )
			$type = "`type` LIKE 'Ова' OR `status` LIKE 'Ова'";
	}

	foreach ($get['selected_category'] as $key => $value) {
		$cats .= "`cats` LIKE '%%$value%%' OR ";
	}
	$cats = mb_substr($cats, 0, -3);


	if ( $get['selected_status'][0] != 1 ) {
		$status = "`status` = '".$get['selected_status'][0]."'";
	}

	$year = "`year` > ".($get['selected_year']['min']-1)." AND `year` < ".($get['selected_year']['max']+1);


	if ($get['selected_order'][0] == 1)
		$order = "ORDER BY `rate` DESC";
	else if ($get['selected_order'][0] == 2)
		$order = "ORDER BY `translated_title` ASC,`origin_title` ASC";
	else if ($get['selected_order'][0] == 3)
		$order = "ORDER BY `translated_title` DESC,`origin_title` DESC";
	else if ($get['selected_order'][0] == 4)
		$order = "ORDER BY `view` DESC";
	else if ($get['selected_order'][0] == 5)
		$order = "ORDER BY `year` DESC";
	else 
		$order = "ORDER BY `year` ASC";

	$strict = "AND";

	echo "SELECT * FROM `anime_post` WHERE ($type) $strict ($cats) $strict ($status) $strict ($year) $order";
	Give_Me_Cards ("search", "SELECT * FROM `anime_post` WHERE ($type) $strict ($cats) $strict ($status) $strict ($year) $order", $query, true);