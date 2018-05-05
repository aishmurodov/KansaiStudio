<?
	// $_SESSION['__GLOBALS']['post'] = [];
	// $_SESSION['__GLOBALS']['get'] = [];
	
	$_SESSION['__POST'][] = $_POST;
	$_SESSION['__GET'][] = $_GET;

	if ( $Page == 'index' AND $Module == 'index') include 'pages/main.php';
	else if ($Page == 'pagination') include 'pagination.php';
	else if ($Page == 'handler') include 'handler.php';
	else if ($Page == 'randomAnime') include 'pages/randomAnime.php';
	else if ( (User::Root(3) || User::Root(4)) && $Page == 'admin' && $Module == "handle") include 'module/admin/handle.php';
	else if ( isset($_SESSION['id']) && $Page == 'profile' && $Module == "handle") include 'module/profile/handle.php';
	else if ( isset($_SESSION['id']) && $Page == 'profile' && $Module == "editWindow") include 'module/profile/editWindow.php';
	else if ( $Page == 'anime' && $Module == "handle") include 'module/anime/handle.php';
	else if ( $Page == 'anime' && $Module == "GiveMeta") include 'templates/giveMeta.php';
	else if ( $Page == 'api' && !$Module ) include 'module/api/home.php';
	else if ( $Page == 'api' && $Module == 'getitem' ) include 'module/api/getitem.php';
	else if ( $Page == 'api' && $Module == 'getposts' ) include 'module/api/getposts.php';
	else if ( $Page == 'api' && $Module == 'getseries' ) include 'module/api/getseries.php';
	else if ( $Page == 'api' && $Module == 'getitemseries' ) include 'module/api/getitemseries.php';
	else if ( !isset($_SESSION['id']) && $Page == 'signSites' && $Module == 'vk') include 'module/Auth/vk.php';
	else if ( !isset($_SESSION['id']) && $Page == 'signSites' && $Module == 'yandex') include 'module/Auth/yandex.php';

	else if ( $Page == "bot" && $Module == "vk" ) include 'module/bot/vk/home.php';

	else include 'pages/main.php';

?>