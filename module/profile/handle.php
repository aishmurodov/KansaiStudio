<?
	
	$data = $_POST;

	if (isset($Param['addNewComment']) && $data['text']) {
		$text = Form::formChars($data['text']);
		$issploiler = Form::formChars($data['issploiler']);
		$anime_post = Form::formChars($data['anime_post'], 1);
		$date = date("d.m.y");

		if ($issploiler == "yes") {
			$issploiler = 1;
		}else {
			$issploiler = 0;
		}

		if ( strlen( str_replace(" ", "", $text) ) >= 5 && strlen($text) > 9 && strlen($text) < 201 && $anime_post > 0) {

			$Mysql = new Mysql();
			$connect = $Mysql->connect();
			mysqli_query($connect, "INSERT INTO `anime_comments` (`id`, `anime_post`, `by_user`, `text`, `spoiler`, `likes`, `dislikes`,`comt_date`) VALUES (NULL, '$anime_post', '$_SESSION[id]', '$text', '$issploiler', '0', '0', '$date');");

			if ($_SESSION['sortCommentByWhat'] == 'news') {
				$query = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$anime_post' ORDER BY `id` DESC");
			}else if ($_SESSION['sortCommentByWhat'] == 'olds') {
				$query = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$anime_post' ORDER BY `id`");
			}else exit;


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
					<?php endif ?>
				</p>
				<p><small>Дата добавления: <?=$row['comt_date']?></small></p>
				<?php if (User::Root(5)): ?>
					<a onclick="DeleteComment ('commentNumber<?=$row['id']?>', $(this).attr('data-comment-id'))" data-comment-id="<?=$row['id']?>" class="secondary-content"><i class="fa fa-times" aria-hidden="true"></i></a>
				<?php endif ?>
			</li>
			<?}
			?>
			<script>
				 $(document).ready(function(){
$('.collapsible').collapsible();
				 });
			</script>
			<?
		}
	}

	else if (isset($Param['UserOptions']) && $data['anime_post']) {
		$iswatching = false;
		$Option = $data['Option'];
		$anime_post = "anime_".$data['anime_post'];

		$watching = json_decode($_SESSION['watching'], true);

		foreach ($watching as $anime_watch) {
			if ($anime_watch['anime'] == $anime_post) {
				$iswatching = true;
				break;
			} 
		}

		if ($iswatching === false) {
			$watching[] = [
				"anime" => $anime_post,
				"last_serie" => 1
			];
			$_SESSION['watching'] = html_entity_decode(json_encode($watching), ENT_QUOTES, 'UTF-8');
			//exit(System::dump($_SESSION['watching']). "<br>". System::dump($watching));
		}else {
			System::toast("Это аниме уже находится в ваших избранных");
		}

		$Mysql = new Mysql();
		$connect = $Mysql->connect();

		mysqli_query($connect, "UPDATE `users` SET `watching` = '$_SESSION[watching]' WHERE `id` = $_SESSION[id]");
		System::toast("Это аниме добавлено в ваши избранные");
	}

	else if (isset($Param['deleteThis']) && $data['v']) {
		$v = $data['v'];

		$userPlayList = json_decode($_SESSION['watching'], true);
		$watching = $userPlayList;
		foreach ($userPlayList as $anime_watch_key => $anime_watch_value) {
			if ($anime_watch_value['anime'] == "anime_$v") {
				unset($watching[$anime_watch_key]);
			}
		}

		$_SESSION['watching'] = html_entity_decode(json_encode($watching), ENT_QUOTES, 'UTF-8');
		$Mysql = new Mysql();
		$connect = $Mysql->connect();

		mysqli_query($connect, "UPDATE `users` SET `watching` = '$_SESSION[watching]' WHERE `id` = $_SESSION[id]");

	}

	else if ( $Param['ChangeAvatar'] ) {
		$formats = array("jpg","png","jpeg");
		$format = @end(explode('.',$_FILES['image']['name']));
		if (in_array($format, $formats)) {
			if (is_uploaded_file($_FILES['image']['tmp_name'])) {
				$dir = "static/images/avatar/_".rand(0,9999)."_".time()."_".$_FILES['image']['name'];
				if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
					$dir = '/'.$dir;
					$_SESSION['avatar'] = $dir;
					$Mysql = new Mysql();
					$connect = $Mysql->connect();
					$img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `avatar` FROM `users` WHERE `id` = '$_SESSION[id]'"));
					mysqli_query($connect, "UPDATE `users` SET `avatar` = '$dir' WHERE `id` = '$_SESSION[id]'");
					?>
					<img src="<?=$dir?>" class="materialboxed responsive-img hoverable main_content_cardss z-depth-3" width="650">
					<script>
						$(document).ready(function() {
							$('.materialboxed').materialbox();
						});
					</script>
					<?
					mb_internal_encoding("UTF-8");
					$img = mb_substr($img['avatar'], 1);
					unlink($img);
					System::toast("Изменено");
				}else {
					System::toast("Не удалось загрузить аватар");
				}
			}
		}else {
			System::toast("Аватар не соответствует форматам jpg и png");
		}
	}

	else if ( $Param['ChangeAbout'] ) {
		$_SESSION['about'] = Form::formChars($data['text']);
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "UPDATE `users` SET `about` = '$_SESSION[about]' WHERE `id` = $_SESSION[id]");
	}




	/// ADMIN

	else if ( User::Root(5) && $Param['ChangeAvatarAdmin'] ) {
		$formats = array("jpg","png","jpeg");
		$format = @end(explode('.',$_FILES['image']['name']));
		$user = $_POST['uid'];
		if (in_array($format, $formats)) {
			if (is_uploaded_file($_FILES['image']['tmp_name'])) {
				$dir = "static/images/avatar/_".rand(0,9999)."_".time()."_".$_FILES['image']['name'];
				if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
					$dir = '/'.$dir;
					$userAvatar = $dir;
					$Mysql = new Mysql();
					$connect = $Mysql->connect();
					$img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `avatar` FROM `users` WHERE `id` = '$user'"));
					mysqli_query($connect, "UPDATE `users` SET `avatar` = '$dir' WHERE `id` = '$user'");
					?>
					<img src="<?=$dir?>" class="materialboxed responsive-img hoverable main_content_cardss z-depth-3" width="650">
					<script>
						$(document).ready(function() {
							$('.materialboxed').materialbox();
						});
					</script>
					<?
					mb_internal_encoding("UTF-8");
					$img = mb_substr($img['avatar'], 1);
					unlink($img);
					System::toast("Изменено");
				}else {
					System::toast("Не удалось загрузить аватар");
				}
			}
		}else {
			System::toast("Аватар не соответствует форматам jpg и png");
		}
	}

	else if ( User::Root(5) && $Param['ChangeAboutAdmin'] ) {
		$text = Form::formChars($data['text']);
		$user = $_POST['uid'];
		$Mysql = new Mysql();
		$connect = $Mysql->connect();
		mysqli_query($connect, "UPDATE `users` SET `about` = '$text' WHERE `id` = $user");
	}

	else if ( $Param['editMyProfileFromNewWindow'] ) {
		$Username = Form::formChars($_POST['Username']);
		$email = Form::formChars($_POST['email']);
		$old_password = Form::formChars($_POST['old_password']);
		$new_password = Form::formChars($_POST['new_password']);
		$gender = Form::formChars($_POST['gender']);
		$birthday = Form::formChars($_POST['birthday']);

		if ($Username && strlen($Username) >= 2) {
			$Username = $Username;
		}else {
			$Username = $_SESSION['name'];
		}

		if ($email && $email != $_SESSION['email'] && Form::email_valid($email)) {
				$row = mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `users` WHERE `email` = '$email'"));
				if ($row == 0) {
					$email = $email;
				}else {
					System::toast("E-mail занят");
				}

		}else {
			$email = $_SESSION['email'];
		}

		if ($gender != $_SESSION['gender']) {
			$gender = $gender;
		}else {
			$gender = $_SESSION['gender'];
		}

		if ($birthday && $birthday != $_SESSION['birthday']) {
			$birthday = $birthday;
		}else {
			$birthday = $_SESSION['birthday'];
		}

		if (strlen($new_password) >= 7) {
			
			$old_password = Form::genPass($old_password, $_SESSION['login']);
			if ($old_password == $_SESSION['password']) {
				$password = Form::genPass($new_password, $_SESSION['login']);
			}else {
				System::toast("Старый пароль введён неправильно");
			}

		}else {
			$password = $_SESSION['password'];
		}

		$mysql = new Mysql();
		$connect = $mysql->connect();

		mysqli_query($connect, "UPDATE `users` SET `name` = '$Username', `email` = '$email', `password` = '$password', `gender` = '$gender', `birthday` = '$birthday' WHERE `id` = '$_SESSION[id]'");

		$_SESSION['name'] = $Username ;
		$_SESSION['email'] = $email ;
		$_SESSION['password'] = $password ;
		$_SESSION['gender'] = $gender ;
		$_SESSION['birthday'] = $birthday ;

		System::toast("Изменено");
	}