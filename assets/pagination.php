<?
	if ( $_POST["href"] ) {
		$Page = $_POST["href"];

		$_SESSION['current_page'] = $Page;
		//$Module =  Form::formChars($_POST["module"]);

		$URL_Path = parse_url($Page, PHP_URL_PATH);
		$URL_Parts = explode('/', trim($URL_Path, ' /'));
		$Page = array_shift($URL_Parts);
		$Module = array_shift($URL_Parts);
		
		if ( !empty($Module) ) {
			$Param = array();
			for ($i=0; $i < count($URL_Parts); $i++) { 
				$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
			}
		}
		
		if ($Page == 'main') include 'pages/main_content.php';
		else if ( $Page == 'animeTop') include 'pages/animeTop.php';
		else if ( $Page == 'animeRating') include 'pages/animeRating.php';
		else if ( $Page == 'searchByWords') include 'pages/searchByWords.php';
		else if ( $Page == 'search' && !empty($Module)) include 'pages/search.php';
		// else if ( $Page == 'filter' && empty($Module)) include 'pages/filter.php';
		else if ( !isset($_SESSION['id']) && $Page == 'register') include 'pages/reg_content.php';

		// ANIME 

		else if ( $Page == 'anime' && $Module == 'view' && !empty($Param['item'])) {
			if ($_POST['view']) {
				$Param['item'] = Form::formChars($Param['item'], 1);
				$Mysql = new Mysql();
				$connect = $Mysql->connect();
				$query = mysqli_query($connect, "SELECT `id` FROM `anime_post` WHERE `id` = '$Param[item]'");
				if (mysqli_fetch_assoc($query)) {
					include 'module/anime/home.php';
				}else exit('404');
				
			}else {?>
				<script>PaginationView("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент", "<?=$_POST["href"]?>")</script>
			<?}
		}
		// END

		// ADMIN

		else if ( User::Root(4) && $Page == 'admin' && empty($Module)) include 'module/admin/home.php';

		// END

		// Profile
		else if ( isset($_SESSION['id']) && $Page == 'profile' && empty($Module)) {
			if ($_POST['view']) {
				include 'module/profile/home.php';
			}else {?>
				<script>PaginationView("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент", "<?=$_POST["href"]?>")</script>
			<?}
		}
		else if ( $Page == 'profile' && !empty($Module) && $Module != "adminView") {
			if ($_POST['view']) {
				include 'module/profile/view.php';
			}else {?>
				<script>PaginationView("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент", "<?=$_POST["href"]?>")</script>
			<?}
		}
		else if ( $Page == 'profile' && !empty($Module) && $Module == "adminView") {
			if ($_POST['view']) {
				include 'module/profile/adminView.php';
			}else {?>
				<script>PaginationView("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент", "<?=$_POST["href"]?>")</script>
			<?}
		}
		// END

		else exit('404');
	}