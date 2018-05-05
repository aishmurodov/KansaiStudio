<?

	define('VK_CONFIRMATION_CODE', '2cff1286');
	define('VK_SECRET_TOKEN', 'aaq213123sadacqwe12ASDAWQECXXX');
	define('VK_TOKEN', 'dcb38fd6374a2bb98c122b78f7281ec04b43b2f141f2e2093efa61e56d3a5fffa226e3f20530c0e319f79');

	define('VK_API_ENDPOINT', 'https://api.vk.com/method/');
	define('VK_API_VERSION', '5.69');

	$data = $_POST;
	$data = json_decode(file_get_contents('php://input'));

	//print_r($data);	

	if ( $data->secret !== 'VK_SECRET_TOKEN' && $data->type !== 'confirmation' ) 
		echo 'nil';

	switch ( $data->type ) {
		case 'confirmation':
			echo VK_CONFIRMATION_CODE;
			break;

		case 'message_new':

			echo 'ok';
			break;
	}