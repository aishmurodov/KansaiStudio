<?

	$data = $_POST;


	if ( !isset($_SESSION['id']) && $Module == "signWithWidjet") {
        $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $user = json_decode($s, true);
		
		$first_name = $user['first_name'];
		$uid = $user['uid'];
		$network = $user['network'];

		$login = "$network"."_"."$uid";
		$password = Form::genPass($uid, $login);
		$hash = Form::genPass($password, $login, $network);

		if (!mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `users` WHERE `network` = '$network' AND `identity` = '$uid'"))) {
			mysqli_query(Mysql::connect(), "INSERT INTO `users` (`id`, `email`, `login`, `name`, `password`, `hash`, `gender`, `birthday`, `watching`, `willWatch`, `alreadyWatched`, `dropedWatching`, `favorites`, `user_group`, `avatar`, `about`, `blocked`, `blocked_time`, `network`, `identity`) VALUES (NULL, '', '$login', '$first_name', '$password', '$hash', '0', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '$network', '$uid');");
			echo "<script>window.location.href = '/handler/signWWidjet/network/$network/uid/$uid';</script>";
		}else if (!empty($user)) {
			$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `users` WHERE `network` = '$network' AND `identity` = '$uid'"));
			foreach ($row as $key => $value) {
				$_SESSION[$key] = $value;
			}
			echo "<script>window.location.href = '/main';</script>";
		}else {
			echo "<script>window.location.href = '/main';</script>";
		}
	}

	else if ( !isset($_SESSION['id']) && $Module == "signWWidjet" && $Param['network'] && $Param['uid']) {
		$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `users` WHERE `network` = '$Param[network]' AND `identity` = '$Param[uid]'"));
		foreach ($row as $key => $value) {
			$_SESSION[$key] = $value;
		}
		echo "<script>window.location.href = '/main';</script>";
	}

	else if ( !isset($_SESSION['id']) && $data['login'] && $Module == "register" ) {
		$login = Form::formChars($data['login']);
		$Username = Form::formChars($data['Username']);
		$email = Form::formChars($data['email']);
		$password = Form::formChars($data['password']);
		$gender = Form::formChars($data['gender']);
		$birthday = Form::formChars($data['birthday']);

		if ($login != "editWindow") {
			if (strlen($login) >= 4) {
				if (strlen($Username) >= 2) {
					if (Form::email_valid($email)) {
						if (strlen($password) >= 7) {
							$password = Form::genPass($password, $login);
							$hash = Form::genPass($password, $login, $email);
							$mysql = new Mysql();
							$connect = $mysql->connect();
							if (!mysqli_num_rows(mysqli_query($connect, "SELECT `id` FROM `users` WHERE `login` = '$login' OR `email` = '$email'"))) {
								mysqli_query($connect, "INSERT INTO `users` (`id`, `email`, `login`, `name`, `password`, `hash`, `gender`, `birthday`, `watching`, `willWatch`, `alreadyWatched`, `dropedWatching`, `favorites`, `user_group`, `avatar`,`about`, `blocked`) VALUES (NULL, '$email', '$login', '$Username', '$password', '$hash', '$gender', '$birthday', '', '', '', '', '', '0', '', '', '0')");

								echo "<script>Pagination(\"Главная\",\"/main\");$('#modalOfLogin').modal('open');</script>";
								System::toast("Вы успешно зарегистрировались");
							}else {
								System::toast("E-mail или никнейм занят");
							}
						}else {
							System::toast("Длина пароля не может быть меньше 7");
						}
					}else {
						System::toast("Напишите правильный E-mail");
					}
				}else {
					System::toast("Длина имени не может быть меньше 2");
				}
			}else {
				System::toast("Длина никнейма не может быть меньше 4");
			}
		}else {
			System::toast("Никнейм занят");
		}

	}

	else if ( !isset($_SESSION['id']) && $data['login'] && $Module == "signIn" ){
		$login = Form::formChars($data['login'], 1);
		$password = Form::formChars($data['password'], 1);
		$password = Form::genPass($password, $login);
		$saveme = Form::formChars($_REQUEST['saveme']);

		$mysql = new Mysql();
		$connect = $mysql->connect();
		$row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'"));

		if ($row) {
			if ($saveme == "true"){
				setcookie('uid',$row['id'], strtotime('+30 days'), '/');
				setcookie('uhash',$row['hash'], strtotime('+30 days'), '/');
			}
			foreach ($row as $key => $value) {
				$_SESSION[$key] = $value;
			}

			echo "<script>window.location.href = '/main';</script>";

			exit();
		}else {
			System::toast("Такой пользователь не найден");
		}
	}

	else if ( isset($_SESSION['id']) && $Module == "logout" ){
		if ( isset($_COOKIE['uid']) AND !empty($_COOKIE['uhash']) ) {
			unset($_COOKIE['uid']);
			unset($_COOKIE['uhash']);
			setcookie('uid', null, -1, '/');
			setcookie('uhash', null, -1, '/');
		}
		session_destroy();
		$Page = "main";
		echo "<script>window.location.href = '/main';</script>";
	}

	else if ( $Module == "loadComments" && $_POST['event']){
		$Mysql = new Mysql();
		$connect = $Mysql->connect();

		$anime_post = Form::formChars($_POST['anime_post'], 1);

		if ($_POST['event'] == 'news') {
			$query = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$anime_post' ORDER BY `id` DESC LIMIT 10");
		}else if ($_POST['event'] == 'olds') {
			$query = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$anime_post' ORDER BY `id` LIMIT 10");
		}else exit;

		$_SESSION['sortCommentByWhat'] = $_POST['event'];

		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
				$row_c_user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `login`,`name`,`avatar` FROM `users` WHERE `id` = '$row[by_user]'"));

				?>
				<li id="commentNumber<?=$row['id']?>" class="collection-item avatar">
					<img onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" src="<?=$row_c_user['avatar']?>" alt="KANSAI" class="circle">
					
					<a onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" class="title" style="cursor: pointer;"><?=$row_c_user['name']."(".$row_c_user['login'].")";?></a>
					<p>
						<?php if ($row['spoiler'] == 1): ?>
						  <ul class="collapsible" data-collapsible="accordion">
						    <li>
						      <div class="collapsible-header"><i class="material-icons">error</i>Спойлер</div>
						      <div class="collapsible-body"><span><?=nl2br($row['text'])?></span></div>
						    </li>
						  </ul>
						<?php else: ?>
							<?=nl2br($row['text'])?>
						<?php endif ?></p>
					<p><small>Дата добавления: <?=$row_c['comt_date']?></small></p>
					<?php if (User::Root(3)): ?>
						<a onclick="DeleteComment ('commentNumber<?=$row['id']?>', $(this).attr('data-comment-id'))" data-comment-id="<?=$row['id']?>" class="secondary-content"><i class="fa fa-times" aria-hidden="true"></i></a>
					<?php endif ?>
				</li>
			<?}
		}else {?>
			<li class="collection-item">
				
				<span class="title">Комментариев нет</span>
			</li>
		<?}?>
		<script>
			 $(document).ready(function(){
$('.collapsible').collapsible();
			 });
		</script>
		<?

	}

  else if ($Module == "search" && $_POST['queryString'] && !isset($Param['mobile'])) {
		$queryStr = Form::formChars(htmlspecialchars(trim($_POST['queryString'], " "), ENT_QUOTES), 1);
		$queryStr_user = htmlspecialchars(trim($_POST['queryString'], " "), ENT_QUOTES);
      	$row = User::search($queryStr);
      
      if (count($row) && strlen($row[0]['translated_title']) > 0 ) {
        ?>
        <ul class="collection">
        <?
        for ( $i = 0; $i < count($row); $i++ ) {?>
		    <?php if ($row[$i] != "searchByWordOnSite"): ?>
			    <li onclick="PaginationView('<?=$row[$i]['translated_title']?>', '/anime/view/item/<?=$row[$i]['id']?>/');" class="collection-item avatar" style="cursor: pointer;width: 100%;">
			      <img src="<?=$row[$i]['poster']?>" alt="" class="circle">
			      <span class="title"><?=$row[$i]['translated_title']?></span>
			      <p class="truncate"><?=$row[$i]['description']?></p>
			    </li>
			<?php else: ?>
			    <li onclick="PaginationSearch('<?=$queryStr_user?>', '/searchByWords/<?=urlencode($queryStr)?>/');" class="collection-item" style="cursor: pointer;width: 100%;text-align: center;">
			      <span class="title">Посмотреть все результаты</</span>
			    </li>
		    <?php endif ?>
        <?}?>
    	</ul>
        <?
      }else {?>
        <ul class="collection">
		    <li class="collection-item" style="cursor: pointer;width: 100%;">
		      <span class="title">По запросу "<?=$queryStr?>" ничего не найдено</span>
		    </li>
    	</ul>
      <?}
  }

  else if ($Module == "search" && $_POST['queryString'] && isset($Param['mobile'])) {
		$queryStr = Form::formChars(htmlspecialchars(trim($_POST['queryString'], " "), ENT_QUOTES), 1);
		$queryStr_user = htmlspecialchars(trim($_POST['queryString'], " "), ENT_QUOTES);
		$row = User::search($queryStr);
      
      if (count($row)) {
        ?>
        <ul class="collection">
        <?
        for ( $i = 0; $i < count($row); $i++ ) {?>
		    <?php if ($row[$i] != "searchByWordOnSite"): ?>
			    <li onclick="PaginationView('<?=$row[$i]['translated_title']?>', '/anime/view/item/<?=$row[$i]['id']?>');" class="collection-item avatar" style="cursor: pointer;width: 100%;background-color: #32b5f8;color: #fff">
			      <img src="<?=$row[$i]['poster']?>" alt="" class="circle">
			      <span class="title"><?=$row[$i]['translated_title']?></span>
			      <p class="truncate"><?=$row[$i]['description']?></p>
			    </li>
			<?php else: ?>
			    <li onclick="PaginationSearch('<?=$queryStr_user?>', '/searchByWords/<?=urlencode($queryStr)?>');" class="collection-item" style="cursor: pointer;width: 100%;background-color: #32b5f8;color: #fff;text-align: center;">
			      <span class="title">Посмотреть все результаты</</span>
			    </li>
		    <?php endif ?>
        <?}?>
    	</ul>
        <?}else {?>
        <ul class="collection">
		    <li class="collection-item" style="cursor: pointer;width: 100%;background-color: #32b5f8;color: #fff">
		      <span class="title">По запросу "<?=$queryStr_user?>" ничего не найдено</span>
		    </li>
    	</ul>
      <?}
  }

  else if ($Module == "loadAnime") {
  		$startFrom = $_POST['startFrom'];
	$link = Mysql::connect();
	if ($_SESSION['sortBY'] == "news") {
		$res = mysqli_query($link, "SELECT * FROM `anime_post` ORDER BY `updatedIn` DESC, `id` DESC LIMIT {$startFrom}, 10");
	}else if ($_SESSION['sortBY'] == "views") {
		$res = mysqli_query($link, "SELECT * FROM `anime_post` ORDER BY `view` DESC LIMIT {$startFrom}, 10");
	}else if ($_SESSION['sortBY'] == "rate") {
		$res = mysqli_query($link, "SELECT * FROM `anime_post` WHERE `type` <> 4 ORDER BY `votes` DESC LIMIT {$startFrom}, 10");
	}

	if ( mysqli_num_rows($res) > 0 ){
    while ( $row = mysqli_fetch_assoc( $res ) ) {
    	Anime_Cards($row);
    }
}else echo "error";
  }

  else if ($Module == "LoaderOfComments") {
  		$startFrom = $_POST['startFrom'];
  		$anime_post = Form::formChars($_POST['anime_post'], 1);
	$Mysql = new Mysql();
	$connect = $Mysql->connect();
	if ($_SESSION['sortCommentByWhat'] == 'news') {
		$res = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$anime_post' ORDER BY `id` DESC LIMIT {$startFrom}, 10");
	}else if ($_SESSION['sortCommentByWhat'] == 'olds') {
		$res = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$anime_post' ORDER BY `id` LIMIT {$startFrom}, 10");
	}else exit;

	if ( mysqli_num_rows($res) > 0 ){
    while ( $row = mysqli_fetch_assoc( $res ) ) {
			$row_c_user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `login`,`name`,`avatar` FROM `users` WHERE `id` = '$row[by_user]'"));

				?>
				<li id="commentNumber<?=$row['id']?>" class="collection-item avatar">
					<?php if ($row_c_user['avatar']): ?>
					<img onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" src="<?=$row_c_user['avatar']?>" alt="KANSAI" class="circle">
					<?php else:?>
						<img onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" src="/static/images/havenotavatar.jpg" alt="KANSAI" class="circle">
					<?php endif ?>

					
					<a onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" class="title" style="cursor: pointer;"><?=$row_c_user['name']."(".$row_c_user['login'].")";?></a>
					<p>
						<?php if ($row['spoiler'] == 1): ?>
						  <ul class="collapsible" data-collapsible="accordion">
						    <li>
						      <div class="collapsible-header"><i class="material-icons">error</i>Спойлер</div>
						      <div class="collapsible-body"><span><?=nl2br($row['text'])?></span></div>
						    </li>
						  </ul>
						<?php else: ?>
							<?=nl2br($row['text'])?>
						<?php endif ?>
					</p>
					<?php if (User::Root(3)): ?>
						<a onclick="DeleteComment ('commentNumber<?=$row['id']?>', $(this).attr('data-comment-id'))" data-comment-id="<?=$row['id']?>" class="secondary-content"><i class="fa fa-times" aria-hidden="true"></i></a>
					<?php endif ?>
				</li>
<?}?>
		<script>
			 $(document).ready(function(){
$('.collapsible').collapsible();
			 });
		</script>
<?
}else echo "error";
  }