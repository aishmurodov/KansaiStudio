<?
	
	define('HOST', 'localhost'); // Mysql HOST
	define('USER', ''); // Mysql USer
	define('PASSWORD', ''); //Mysql Password
	define('DB', ''); // Mysql Db Name

	class Config {
		static public function title () {
			return 'Kansai';
		}

		static public function VkApi() {
			return [
				"id" => '5645933',
				"secret" => 'ejqsED3b24FppBqcQLjP',
				"url" => 'https://createpro.site/Kansai/vk_login/'
			];
		}


	}

	$Menu = array(
		"User" => array(
			
		),
		"editor" => array(
			"admin" => "Добавить аниме"
		),
		"Admin" => array(
			"admin" => "Админ Панель"
		)
	);
?>