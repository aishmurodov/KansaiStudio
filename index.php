<?
	//if ( $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https' )
		//header("Location: https://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]");

	header('Content-type: text/html; charset=utf-8');

	session_start();

	include('setting.php');

	if ( $_SERVER['REQUEST_URI'] == '/' ) {
		$Page = 'index';
		$Module = 'index';
	} else {
		$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$URL_Parts = explode('/', trim($URL_Path, ' /'));
		$Page = array_shift($URL_Parts);
		$Module = array_shift($URL_Parts);
		
		if ( !empty($Module) ) {
			$Param = array();
			for ($i=0; $i < count($URL_Parts); $i++) { 
				$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
			}
		}
	}

	date_default_timezone_set('UTC+3');
	include("assets/functions.php");

	if (!$_SESSION['sortCommentByWhat']) {
		$_SESSION['sortCommentByWhat'] = "news";
	}
	if (!$_SESSION['sortBY']) {
		$_SESSION['sortBY'] = "news";
	}

	// if ( !isset($_SESSION['id']) AND isset($_COOKIE['uid']) AND !empty($_COOKIE['uhash']) ){
	// 	$link = Mysql::connect();
	// 	$query = mysqli_query($link, "SELECT * FROM `users` WHERE `id` = $_COOKIE[uid] AND `hash` = '$_COOKIE[uhash]'");
	// 	$row = mysqli_fetch_assoc($query);
	// 	foreach ($row as $key => $value) {
	// 		$_SESSION[$key] = $value;
	// 	}
	// 	Mysql::close($link);
	// }
	include("assets/templates/anime_cards.php");
	include("assets/templates/main_cards.php");
	include("assets/engine.php");