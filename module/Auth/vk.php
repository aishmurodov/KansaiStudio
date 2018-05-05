<?
	foreach ($_GET as $key => $value) {
		$$key = $value;
	}

	function vk_auth_login($network,$uid) {
		$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `users` WHERE `network` = '$network' AND `identity` = '$uid'"));
		foreach ($row as $key => $value) {
			$_SESSION[$key] = $value;
		}
		echo "<script>window.location.href = '/main';</script>";
	}

	$network = "vk";

	if (!mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `users` WHERE `network` = '$network' AND `identity` = '$id'")))
	{

		if (!$screen_name || mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `users` WHERE `login` = '$screen_name'")))
			$screen_name = "vk_$id";
		if (mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `users` WHERE `email` = '$email'")))
			$email = "";

		$password = Form::genPass($uid, $screen_name);
		$hash = Form::genPass($password, $screen_name, $network);
		if ($sex == 1) 
			$gender = 2;
		else if ($sex == 2)
			$gender = 1;
		else 
			$gender = 0;

		$bdate_array = explode('.', $bdate);

		$bdate = $bdate_array[0];

		$bdate.= " ".System::dateToStr_Return($bdate_array[1]);

		$bdate.= ", $bdate_array[2]";

		mysqli_query(Mysql::connect(), "INSERT INTO `users` (`identity`,`network`,`name`,`login`,`password`,`hash`,`gender`,`birthday`,`avatar`,`about`,`email`) VALUES('$id','$network','$first_name $last_name', '$screen_name', '$password','$hash', '$gender','$bdate','$photo_max_orig','$about','$email')");

		vk_auth_login($network, $id);
	}else {
		vk_auth_login($network, $id);
	}