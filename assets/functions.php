<?
	class Mysql {

		function connect() {
	        $link = mysqli_connect(HOST, USER, PASSWORD, DB);
	        if (!$link) {
			    echo "Ошибка: Невозможно установить соединение с MySQL.<br>" . PHP_EOL;
			    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
			    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
			    exit;
	        }
	        return $link;
		}

	    function close($link) {
	        mysqli_close($link);
	    }

	}



	class System {


		function mb_strtoupper_first($str, $encoding = 'UTF8')
		{
		    return
		        mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
		        mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
		}

		static public function normJsonStr($str){
		    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
		    return iconv('cp1251', 'utf-8', $str);
		}

		static public function in_multiarray( $e, $a ) {
			$t = sizeof( $a ) - 1;
			$b = 0;
			while($b <= $t) {
				if( isset( $a[ $b ] ) ) {
					if( $a[ $b ] == $e )
						return true;
					else
						if( is_array( $a[ $b ] ) )
							if( in_multiarray( $e, ( $a[ $b ] ) ) )
								return true;
				}
				$b++;
			}
			return false;
		}

		function dateToStr ( $date ) {
			switch ($date) {
				case 1:
					echo "Январь";
					break;
				case 2:
					echo "Февраль";
					break;
				case 3:
					echo "Март";
					break;
				case 4:
					echo "Апрель";
					break;
				case 5:
					echo "Май";
					break;
				case 6:
					echo "Июнь";
					break;
				case 7:
					echo "Июль";
					break;
				case 8:
					echo "Август";
					break;
				case 9:
					echo "Сентябрь";
					break;
				case 10:
					echo "Октябрь";
					break;
				case 11:
					echo "Ноябрь";
					break;
				case 12:
					echo "Декабрь";
					break;
			}
		}

		function dateToStr_Return ( $date ) {
			switch ($date) {
				case 1:
					return "Январь";
					break;
				case 2:
					return "Февраль";
					break;
				case 3:
					return "Март";
					break;
				case 4:
					return "Апрель";
					break;
				case 5:
					return "Май";
					break;
				case 6:
					return "Июнь";
					break;
				case 7:
					return "Июль";
					break;
				case 8:
					return "Август";
					break;
				case 9:
					return "Сентябрь";
					break;
				case 10:
					return "Октябрь";
					break;
				case 11:
					return "Ноябрь";
					break;
				case 12:
					return "Декабрь";
					break;
			}
		}

		function go ( $url ) {
			exit ( "<script>window.location.href = \"$url\";</script>	" );
		}

		function toast ( $message ) {
			echo "<script>toast(\"$message\");</script>";
			exit;
		}

		function Location ( $url ) {
			echo "<script>window.location.href = \"$url\"</script>";
			exit;
		}

		function dump ( $array ) {
			echo "<pre>";print_r( $array );echo "</pre>";
		}

		static public function curl_get ($url, $referer = "http://www.google.com") {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0");
			curl_setopt($ch, CURLOPT_REFERER, $referer);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}

	}
	
	class Form {

		function formChars ( $p1, $p2 = 0 ) {
			if ($p2) return mysqli_real_escape_string(Mysql::connect(), $p1);
			else return htmlspecialchars(trim($p1), ENT_QUOTES);
		}

		function genPass ( $p1,$p2 ) {
			return md5('Murd'.md5('321'.$p1.'123').md5('678'.$p2.'890'));
		}

		function genHash ( $p1, $p2, $p3 ) {
			return md5('Murd'.md5('321'.$p1.'123').md5($p2).md5('678'.$p3.'890'));
		}

		function email_valid( $email ) {
			if ( !filter_var( $email, FILTER_VALIDATE_EMAIL))
				return false;
			else return true;
		}

		function password_valid( $password ) {
			if ( strlen($password) < 8 OR strlen($password) > 30 )
				System::toast(1,'Пароль может содеражть 8 - 30 символов');
		}

	}

	class User {
	  // function search($words) {
	  //   $words = Form::formChars($words);
	  //   if ( $words === "" ) return false;
	  //   $query_search = "";
	  //   $arraywords = explode(" ", $words);
	  //   foreach ($arraywords as $key => $value) {
	  //     	if ( isset($arraywords[$key - 1]) )
		 //        $query_search .= ' OR ';
		 //  	if ($value != "") {
		 //      $query_search .= '`translated_title` LIKE "%'.$value.'%" OR `origin_title` LIKE "%'.$value.'%" OR `studio` LIKE "%'.$value.'%" OR `cats` LIKE "%'.$value.'%" OR `description` LIKE "%'.$value.'%"';
		 //  	}else {
		 //  		$query_search = "`translated_title` = 'asdxasdwqe'";
		 //  	}
	  //   }
	  //   $query = "SELECT `id`,`poster`,`translated_title`, `description` FROM `anime_post` WHERE $query_search ORDER BY `view` DESC, `votes` DESC, `id` DESC";
	  //   $result_set = mysqli_query(Mysql::connect(), $query);
	  //   $i = 0;
	  //   while ( $row = mysqli_fetch_assoc($result_set) ) {
	  //     $results[$i] = $row;
	  //     $i++;
	  //   }
	  //   return $results;
	  // }

	  function search($words) {
	    $words = Form::formChars($words, 1);
	    if ( $words === "" ) return false;
	    else {
		    $query = "SELECT `id`,`poster`,`translated_title`, `description` FROM `anime_post` WHERE `translated_title` LIKE '%%$words%%' OR `origin_title` LIKE '%%$words%%' OR `studio` LIKE '%%$words%%' OR `cats` LIKE '%%$words%%' OR `description` LIKE '%%$words%%' ORDER BY `view` DESC, `votes` DESC, `id` DESC";
		    $result_set = mysqli_query(Mysql::connect(), $query);
		    $i = 0;
			while ( $row = mysqli_fetch_assoc($result_set) ) {
				$results[$i] = $row;
				$i++;
				if ($i > 3) {
					$results[$i] = 'searchByWordOnSite';
					break;
				}
			}
	    	return $results;
	    }
	  }

		function Root ($p) {
			if ($p == 1) {
				if ($_SESSION['user_group'] >= 0) {
					// Just viwer
					return true;
				}
			}
			else if ($p == 2) {
				if ($_SESSION['user_group'] >= 1) {
					// Uvajaemiy animeshnik
					return true;
				}
			}
			else if ($p == 3) {
				if (($_SESSION['user_group'] == 2) || ($_SESSION['user_group'] == 4)) {
					// Moderator
					return true;
				}
			}
			else if ($p == 4) {
				if ($_SESSION['user_group'] >= 3 ) {
					// Redaktor
					return true;
				}
			}
			else if ($p == 5) {
				if ($_SESSION['user_group'] == 4 ) {
					// ADmin
					return true;
				}
			}

			return false;
		}
	}