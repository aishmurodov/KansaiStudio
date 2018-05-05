<?

	$data = $_POST;

	if (isset($data)) {
		
		if ($Param['return_serie']) {
			$src = Form::formChars($data['src'], 1);
			$Mysql = new Mysql();
			$connect = $Mysql->connect();
			$query = mysqli_query($connect, "SELECT `frame` FROM `anime_series` WHERE `url` = '$src'");
			$row = mysqli_fetch_assoc($query);
			if ($row['frame'] == 1) {
				echo "frame";
			}
		}

		if ($Param['view']) {
			$item = Form::formChars($data['item'], 1);
			$src = Form::formChars($data['src'], 1);

			$Mysql = new Mysql();
			$connect = $Mysql->connect();
			$query = mysqli_query($connect, "SELECT `id`,`views_count`, `number` FROM `anime_series` WHERE `anime_post` = '$item' AND `url` = '$src'");
			$row = mysqli_fetch_assoc($query);
			if ($row) {
				if (isset($_SESSION['id']) ) {
					$userPlayList = json_decode($_SESSION['watching'], true);
					$watching = [];
					foreach ($userPlayList as $anime_watch) {
						if ($anime_watch['anime'] == "anime_$item") {
							if ( $anime_watch['last_serie'] != $row['number'] ){
								$anime_watch['last_serie'] = $row['number'];
								$iswathcing = true;
							}
						} 
						$watching[] = $anime_watch;
					}
					if ($iswathcing === true) {
						$_SESSION['watching'] = html_entity_decode(json_encode($watching), ENT_QUOTES, 'UTF-8');
						mysqli_query($connect, "UPDATE `users` SET `watching` = '$_SESSION[watching]' WHERE `id` = $_SESSION[id]");
					}
					echo "Set Session";
				}else{
					echo "No Session";
				}
				$count = 1 + $row['views_count'];
				mysqli_query($connect, "UPDATE `anime_series` SET `views_count` = '$count' WHERE `id` = '$row[id]'");
			}else echo "row error $item $src";
		}

		if ($Param['returnView']) {
			$item = Form::formChars($data['item'], 1);
			$src = Form::formChars($data['src'], 1);

			$Mysql = new Mysql();
			$connect = $Mysql->connect();
			$query = mysqli_query($connect, "SELECT SUM(`views_count`) FROM `anime_series` WHERE `anime_post` = '$item'");
			$row = mysqli_fetch_assoc($query);
			if ($row) {
				foreach ($row as $key => $value) {
					echo "$value";
				}
			}
			else {
				echo "Nothing";
			}
		}

		if ($Param['votes'] ) {
			if (isset($_SESSION['id'])) {
				$item = Form::formChars($data['item'], 1);
				$vote = Form::formChars($data['vote'], 1);

				$Mysql = new Mysql();
				$connect = $Mysql->connect();
				$query = mysqli_query($connect, "SELECT `votes`, `voters`,`voters_count` FROM `anime_post` WHERE `id` = '$item'");
				$row = mysqli_fetch_assoc($query);
				if ($row) {
					$viewer = explode(',', $row['voters']);
					if (!in_array($_SESSION['id'], $viewer) && $vote > 0 && $vote < 11) {
						$vwer = '';
						$viewer[] .= $_SESSION['id'];
						foreach ($viewer as $key => $value) {
						  if ($vwer) {
						    $vwer .= ",".$value;
						  }else {
						    $vwer = $value;
						  }
						}

						$count = 1 + $row['voters_count'];

						$voteq = $row['votes'] + $vote;
						$voteq = $voteq / $count;
						$voteq = round($voteq, 2);

						mysqli_query($connect, "UPDATE `anime_post` SET `voters_count` = '$count', `voters` = '$vwer', `votes` = '$voteq' WHERE `id` = '$item'");

						$votes = $voteq;

	?>
						<div class="ARating-container">
							<div data-total-value="<?=$votes?>" class="ARatingBackGround"></div>
							<div class="ARatingStar"></div>
						</div>
	<?

						System::toast("Вы поставили $vote из 10");
					}else {
						echo "error";
					}
				}
			}else {
				echo "Error_Auth";
			}
		}

	}