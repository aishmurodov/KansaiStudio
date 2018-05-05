<?
	$data = $_POST;

	if ( $Param['addNewCat'] && $data['catTitle'] ) {
		$break = false;
		$title = Form::formChars($data['catTitle'], 1);
		$ttleCheck = mb_strtolower($title);
		$query = mysqli_query(Mysql::connect(), "SELECT `title` FROM `anime_cats` ORDER BY `title` ASC");
		while ($row = mysqli_fetch_assoc($query)) {
			if ($ttleCheck == mb_strtolower($row['title'])) {
				$break = true;
				break;
			}
		}
		if ( $break === false ) {
			$Mysql = new Mysql();
			$connect = $Mysql->connect();
			mysqli_query($connect, "INSERT INTO `anime_cats` (`title`) VALUES('$title')");
		}else {
			echo 'break';
		}
	}

	else if ( $Param['removeCat'] && $data['catTitle'] ) {
		$title = Form::formChars($data['catTitle'], 1);
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "DELETE FROM `anime_cats` WHERE `title` = '$title'");
	}

	else if ( isset($Param['addNewAnime']) ) {
		$tr_title = Form::formChars($data['tr_title']);
		$original_title = Form::formChars($data['original_title']);
		$yearOfCreated = Form::formChars($data['yearOfCreated']);
		$studio = Form::formChars($data['studio']);
		$director = Form::formChars($data['director']);
		$descriptions = Form::formChars($data['descriptions']);
		$type = Form::formChars($data['type']);
		$maxseries = Form::formChars($data['maxseries']);

		if (!empty($tr_title) && !empty($original_title) && !empty($yearOfCreated) && !empty($studio) && !empty($descriptions) && !empty($type)) {
			if ($_POST['cats']) {
				foreach ($_POST['cats'] as $key => $value) {
				  if ($cats) {
				    $cats .= " |-| ".$key;
				  }else {
				    $cats = $key;
				  }
				}
			}else {
				System::toast("Выберите жанры");
			}
			$formats = array("jpg","png","jpeg");
			$format = @end(explode('.',$_FILES['image']['name']));
			if (in_array($format, $formats)) {
				if (is_uploaded_file($_FILES['image']['tmp_name'])) {
					$dir = "static/images/posters/_".rand(0,9999)."_".time()."_".$_FILES['image']['name'];
					if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
						$dir = '/'.$dir;
					}else {
						System::toast("Не удалось загрузить постер");
					}
				}
			}else {
				System::toast("Постер не соответствует форматам jpg и png");
			}

			if ($type == 1) {
				$ongoing = 'Онгоинг';
			}else {
				if ($type == 2) $ongoing = 'Ова';
				else if ($type == 3) $ongoing = 'Фильм';
				else if ($type == 4) $ongoing = 'Анонс';
			}

			$mysql = new Mysql();
			$connect = $mysql->connect();
			mysqli_query($connect, "INSERT INTO `anime_post` (`id`, `poster`, `translated_title`, `origin_title`, `status`, `year`, `studio`, `director`, `cats`, `description`, `view`, `type`, `votes`, `voters`, `voters_count`, `maxseries`,`updatedIn`) VALUES (NULL, '$dir', '$tr_title', '$original_title', '$ongoing', '$yearOfCreated', '$studio', '$director', '$cats', '$descriptions', '0', '$type', '0', '', '0', '$maxseries', NOW());");
			echo "<script>Pagination(\"Главная\",\"/main\");</script>";
			System::toast("Аниме \"$tr_title\" добавлено");
		}
		else System::toast("Заполните все поля");
	}

	else if ( $Param['deletePost'] && $data['item'] ) {
		$item = Form::formChars($data['item'], 1);
		$mysql = new Mysql();
		$connect = $mysql->connect();

		$img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `poster` FROM `anime_post` WHERE `id` = '$item'"));
		mb_internal_encoding("UTF-8");
		$img = mb_substr($img['poster'], 1);
		mysqli_query($connect, "DELETE FROM `anime_post` WHERE `id` = '$item'");
		mysqli_query($connect, "DELETE FROM `anime_series` WHERE `anime_post` = '$item'");
		unlink($img);
		System::toast("Удалено");
	}

	else if ( $Param['addNewSerie'] && $data['number'] ) {
		$number = Form::formChars($data['number']);
		$frame = Form::formChars($data['frame'], 1);
		$for = Form::formChars($data['for'], 1);

		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "INSERT INTO `anime_series` (`id`,`anime_post`,`number`,`url`,`views_count`,`viewer`) VALUES(NULL,'$for','$number','$frame','0','')");
		mysqli_query($connect, "UPDATE `anime_post` SET `updatedIn` = NOW() WHERE `id` = '$for'");
		echo $number + 1;
	}

	else if ( $Param['addNewSerieIframe'] && $data['number'] ) {
		$number = Form::formChars($data['number']);
		$frame = Form::formChars($data['frame'], 1);
		$for = Form::formChars($data['for'], 1);

		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "INSERT INTO `anime_series` (`id`,`anime_post`,`number`,`url`,`views_count`,`viewer`,`frame`) VALUES(NULL,'$for','$number','$frame','0','','1')");
		mysqli_query($connect, "UPDATE `anime_post` SET `updatedIn` = NOW() WHERE `id` = '$for'");
		echo $number + 1;
	}

	else if ( $Param['removeSerie'] && $data['ser_id'] ) {
		$ser_id = Form::formChars($data['ser_id'], 1);
		$for = Form::formChars($data['for'], 1);

		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "DELETE FROM `anime_series` WHERE `anime_post` = '$for' AND `id` = '$ser_id'");
	}

	else if ( $Param['editSmt'] && $data['text'] ) {
		$item = Form::formChars($data['item'], 1);
		$what = Form::formChars($data['what'], 1);
		$text = Form::formChars($data['text'], 1);

		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		if ($what != "status" && $what != "maxseries") {
			mysqli_query($connect, "UPDATE `anime_post` SET `$what` = '$text' WHERE `id` = '$item'");
		}else if ( $what == "maxseries" ) {
			$text = ( mb_strtolower($text) == "xxx" ) ? "" : $text;
			mysqli_query($connect, "UPDATE `anime_post` SET `$what` = '$text' WHERE `id` = '$item'");
			$text = !empty($text) ? $text : "XXX";
		}else {
			if ($text == 'Онгоинг' || $text == 'Завершен') {
				$type = 1;
			}else {
				if ($text == 'Ова') $type = '2';
				else if ($text == 'Фильм') $type = '3';
				else if ($text == 'Анонс') $type = '4';
			}

			mysqli_query($connect, "UPDATE `anime_post` SET `$what` = '$text', `type` = '$type' WHERE `id` = '$item' AND `$what` <> '$text'");
		}

		echo "$text";
	}

	else if ( $Param['EditCats'] && $_POST['item'] && $_POST['cats'] ) {
		$item = Form::formChars($data['item'], 1);
		foreach ($_POST['cats'] as $key => $value) {
		  if ($cats) {
		    $cats .= " |-| ".$key;
		  }else {
		    $cats = $key;
		  }
		}
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "UPDATE `anime_post` SET `cats` = '$cats' WHERE `id` = '$item'");
	    $cats = explode(' |-| ', $cats);
	      foreach ($cats as $key => $value) {?>
	        <a onclick="if ($('#data-admin-edit').attr('data-already-editing') == 0) {PaginationSearch($(this).text(), $(this).attr('href'));}return false;" href="/search/cats/q/<?=$value?>"><div class="chip hoverable"><?=$value?></div></a>
	    <?}
	    System::toast("Изменено");
	}

	else if ( $Param['ChangePoster'] ) {
		$item = Form::formChars($data['item'], 1);
		$formats = array("jpg","png","jpeg");
		$format = @end(explode('.',$_FILES['image']['name']));
		if (in_array($format, $formats)) {
			if (is_uploaded_file($_FILES['image']['tmp_name'])) {
				$dir = "static/images/posters/_".rand(0,9999)."_".time()."_".$_FILES['image']['name'];
				if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
					$dir = '/'.$dir;
					$Mysql = new Mysql();
					$connect = $Mysql->connect();
					$img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `poster` FROM `anime_post` WHERE `id` = '$item'"));
					mysqli_query($connect, "UPDATE `anime_post` SET `poster` = '$dir' WHERE `id` = '$item'");
					?>
					<script>
						PaginationView("Kansai","/anime/view/item/<?=$item?>");
					</script><?
					mb_internal_encoding("UTF-8");
					$img = mb_substr($img['poster'], 1);
					unlink($img);

					System::toast("Изменено");
				}else {
					System::toast("Не удалось загрузить постер");
				}
			}
		}else {
			System::toast("Постер не соответствует форматам jpg и png");
		}
	}

	else if ( $Param['DeleteComment'] && $data['comt'] ) {
		$comt = Form::formChars($data['comt'], 1);
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		if ( mysqli_query($connect, "DELETE FROM `anime_comments` WHERE `id` = '$comt'")) 
			echo "true";
		else 
			echo "false";
	}

	else if ( $Param['loadUsers'] ) {
		$startFrom = $_POST['startFrom'];
		$res = mysqli_query(Mysql::connect(), "SELECT `id`, `login`, `user_group`, `avatar`, `name` FROM `users` WHERE `id` <> '$_SESSION[id]' ORDER BY `name` LIMIT {$startFrom}, 10");
		if ( mysqli_num_rows($res) > 0 ){
			while ($row = mysqli_fetch_assoc($res)) {?>
				<li id="numberOfMyAn<?=$value?>" class="collection-item avatar waves-effect" style="width: 100%">
					<?php if ($row['avatar']): ?>
					<img onclick="PaginationView('<?=$row['name']."(".$row['login'].")";?>', '/profile/<?=$row['login']?>');" src="<?=$row['avatar']?>" alt="KANSAI" class="circle">
					<?php else:?>
						<img onclick="PaginationView('<?=$row['name']."(".$row['login'].")";?>', '/profile/<?=$row['login']?>');" src="/static/images/havenotavatar.jpg" alt="KANSAI" class="circle">
					<?php endif ?>
					<span onclick="PaginationView('<?=$row['login']?>', '/profile/<?=$row['login']?>');" class="title" style="font-weight: 500;
color: #56524f;cursor: pointer;"><?=$row['name'].'('.$row['login'].')'?></span>
					<p>
						<b>
							Группа:
						</b>	
						<?

								if ($row['user_group'] == 0) {
									echo "Участник";
								}else if ($row['user_group'] == 1) {
									echo "Уважаемый анимешник";
								}else if ($row['user_group'] == 2) {
									echo "Модератор";
								}else if ($row['user_group'] == 3) {
									echo "Редактор";
								}else if ($row['user_group'] == 4) {
									echo "Админ";
								}

						?>
					</p>
				</li>
			<?}
		}else echo "error";
	}

	else if ( $Param['changeUserGroup'] ) {
		$uid = Form::formChars($data['uid'], 1);
		$gr = Form::formChars($data['gr']);
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "UPDATE `users` SET `user_group` = '$gr' WHERE `id` = '$uid'");
		if ($gr == 0) {
			echo "Участник";
		}else if ($gr == 1) {
			echo "Уважаемый анимешник";
		}else if ($gr == 2) {
			echo "Модератор";
		}else if ($gr == 3) {
			echo "Редактор";
		}else if ($gr == 4) {
			echo "Админ";
		}else "error";
	}

	else if ( $Param['doSomeWorkWithTorrent'] && $Param['px'] && $data['item'] ) {
		$item = Form::formChars($data['item'], 1);
		$responsitive = Form::formChars($Param['px']);
		
		if ($responsitive == "480") {
			$file_torrent = $_FILES['torrent480'];
		}else if ($responsitive == "720") {
			$file_torrent = $_FILES['torrent720'];
		}else if ($responsitive == "1080") {
			$file_torrent = $_FILES['torrent1080'];
		}else {
			exit("Не удалось загрузить торрент.");
		}	
		$formats = array("torrent");

		$format = @end(explode('.',$file_torrent['name']));
		if (in_array($format, $formats)) {
			if (is_uploaded_file($file_torrent['tmp_name'])) {
				$dir = "static/torrent/".$responsitive."p/_".rand(0,9999)."_".time()."_".$file_torrent['name'];
				$torrent_mysql = "tr_$responsitive"."p";

				if (move_uploaded_file($file_torrent['tmp_name'], $dir)) {
					$dir = '/'.$dir;
					$Mysql = new Mysql();
					$connect = $Mysql->connect();
					$torrent_delete = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `$torrent_mysql` FROM `anime_post` WHERE `id` = '$item'"));
					mysqli_query($connect, "UPDATE `anime_post` SET `$torrent_mysql` = '$dir', `updatedIn` = NOW() WHERE `id` = '$item'");
					?>
					<script>
						window.location.href = "/anime/view/item/<?=$item?>";
					</script>
					<?
					mb_internal_encoding("UTF-8");
					$torrent_delete = mb_substr($torrent_delete[$torrent_mysql], 1);
					unlink($torrent_delete);
					exit("Торрент успешно изменён");
				}else {
					exit("Не удалось загрузить торрент.");
				}
			}
		}else {
			exit("Файл должен быть с расширением \".torrent\". Вы выбрали файл с расширением $format");
		}
	}

	else if ( $Param['removeTorrent'] && $data['torrent'] && $data['of'] ) {
		$torrent = Form::formChars($data['torrent'], 1);
		$item = Form::formChars($data['of'], 1);
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		$del_torrent = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `$torrent` FROM `anime_post` WHERE `id` = '$item'"));
		mysqli_query($connect, "UPDATE `anime_post` SET `$torrent` = '' WHERE `id` = '$item'");
		mb_internal_encoding("UTF-8");
		$torrent_delete = mb_substr($del_torrent[$torrent], 1);
		unlink($torrent_delete);
		System::toast("Торрент успешно удалён");
	}