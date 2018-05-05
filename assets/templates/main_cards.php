<?

	function Give_Me_Cards($order, $sql = "", $query = "") {
		$search = false;
		if ( $order == "news" ){
			$sql = "SELECT * FROM `anime_post` ORDER BY `updatedIn` DESC, `id` DESC";
			$date_active = "sortLink-active";
			$orderBy = 'updatedIn';
		}
		else if ( $order == "views" ){
			$sql = "SELECT * FROM `anime_post` ORDER BY `view` DESC";
			$view_active = "sortLink-active";
			$orderBy = 'view';
		}
		else if ( $order == "rate" ){
			$sql = "SELECT * FROM `anime_post` WHERE `type` <> 4 ORDER BY `votes` DESC";
			$rate_active = "sortLink-active";
			$orderBy = 'votes';
		}
		else if ($order == 'search' && !empty($sql) ) {
			$search = true;
		}
		else exit("Что-то пошло не так");

		$current_url = $_SESSION['current_page'];

		$get_params = [];

		$current_page_url = explode("?", $current_url)[0];
		$gets_string = explode("?", $current_url)[1];

		$gets_array = explode("&", $gets_string);

		foreach ($gets_array as $get) {
			$get_key = explode("=", $get)[0];
			$get_val = isset(explode("=", $get)[1]) ? explode("=", $get)[1] : false;
			$get_params[$get_key] = $get_val;
		}

		if ($get_params['sortBy'] == "view" && $search) {
			$sql = str_replace('ORDER BY `view` DESC', 'ORDER BY `view` DESC', $sql);
			$view_active = "sortLink-active";
		}else if ($get_params['sortBy'] == "rate" && $search) {
			$sql = str_replace('ORDER BY `view` DESC', 'AND `type` <> 4 ORDER BY `votes` DESC', $sql);
			$rate_active = "sortLink-active";
		}else if ($search){
			$get_params['sortBy'] = "date";
			$sql = str_replace('ORDER BY `view` DESC', 'ORDER BY `updatedIn` DESC, `id` DESC', $sql);
			$date_active = "sortLink-active";
		}
		$per_page = 10;
		$current_page = isset($get_params['page']) ? (int) $get_params['page'] : 1;

		unset($get_params['page']);

		$total_count_q = mysqli_query(Mysql::connect(), $sql);
		$total_count = mysqli_num_rows($total_count_q);

		$total_pages = ceil($total_count / $per_page);

		if ( $current_page <= 1 || $current_page > $total_pages ) 
			$current_page = 1;

		$offset = ($per_page * $current_page) - $per_page;

		$sql .= " LIMIT $offset, $per_page";

		$link = Mysql::connect();
		$query_sql = mysqli_query($link, $sql);
		echo '<div class="col s12" id="AnimeContent">';

		if ($order != 'search' || empty($sql)){?>
			<div style="background: #fff;padding: 10px;text-align: left;font-size:16px;font-weight:500;color: #2fb9f8;border-radius: 5px;text-align: center;">
				<a onclick="PaginationSearch('Главная', '/main');" class="sortLink <?=$date_active?>" style="cursor: pointer;">По дате добавления</a> <span style="cursor: pointer;">|</span>
				<a onclick="PaginationSearch('Главная', '/animeTop');" class="sortLink <?=$view_active?>" style="cursor: pointer;">По количеству просмотров</a> <span style="cursor: pointer;">|</span>
				<a onclick="PaginationSearch('Главная', '/animeRating');" class="sortLink <?=$rate_active?>" style="cursor: pointer;">По рейтингу</a> 
			</div>		
		<?} else{
		?>
		<div style="background: #fff;padding: 10px;text-align: left;font-size:16px;font-weight:500;color: #2fb9f8;border-radius: 5px;text-align: center;">
			<a onclick="PaginationSearch('Главная', '<?=$current_page_url.'?sortBy=date&page='.$current_page?>');" class="sortLink <?=$date_active?>" style="cursor: pointer;">
				По дате добавления
			</a> <span style="cursor: pointer;">|</span>
			<a onclick="PaginationSearch('Главная', '<?=$current_page_url.'?sortBy=view&page='.$current_page?>');" class="sortLink <?=$view_active?>" style="cursor: pointer;">
				По количеству просмотров
			</a> <span style="cursor: pointer;">|</span>
			<a onclick="PaginationSearch('Главная', '<?=$current_page_url.'?sortBy=rate&page='.$current_page?>');" class="sortLink <?=$rate_active?>" style="cursor: pointer;">
				По рейтингу
			</a> 
		</div>		
		<?} 

			if ( mysqli_num_rows($query_sql) > 0 ){
				echo '<div style="background: #fff;padding: 10px;text-align: left;font-size:16px;font-weight:500;color: #56524f;border-radius: 5px;text-align: center;"><div style="cursor: pointer;" class="ttle">'. $query .'</div></div>';
				echo return_paginate_anime($total_pages,$current_page,$current_page_url, $get_params); 
				while ($row = mysqli_fetch_assoc($query_sql)) {
					Anime_Cards($row);
				}
				echo return_paginate_anime($total_pages,$current_page,$current_page_url, $get_params); 
			}
			else
				echo '<div style="background: #fff;padding: 10px;text-align: left;font-size:16px;font-weight:500;color: #56524f;border-radius: 5px;text-align: center;"><div style="cursor: pointer;" class="ttle">Ничего не найдено :(</div></div>';
		echo '</div>';
	}