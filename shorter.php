<?
	function generateUrl($length) {

		require_once 'connection.php';
		$connect = mysql_connect($host, $user, $password); 
		mysql_select_db($database);

		$data =("SELECT shortURL FROM `urls` WHERE `originURL`='".$_POST['url']."' ");
		$sql = mysql_query($data);

		if (mysql_num_rows($sql) > 0){
			while($row = mysql_fetch_assoc($sql)) {
				$url = $row[shortURL];
			}
			$result[] = "Такая ссылка уже существует";
			$result[] = $url;
			echo json_encode($result);

		} else {

		  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
		  $numChars = strlen($chars);

		  $newUrl ="http://".$_SERVER['HTTP_HOST']."/";
		  
		  for ($i = 0; $i < $length; $i++) {

		    $newUrl .= substr($chars, rand(1, $numChars) - 1, 1);

		  }

			$data =("SELECT shortURL FROM `urls` WHERE `shortURL`='$newUrl' ");
			$sql = mysql_query($data);
			if (mysql_num_rows($sql) > 0){
				generateUrl(4);
			} else {
		    	$data = mysql_query("INSERT INTO `urls` (`originURL`, `shortURL`, `IP`) VALUES ( '".mysql_real_escape_string($_POST['url'])."', '$newUrl', '".$_SERVER['REMOTE_ADDR']."')");
		    	if ($data) {
		    		$result [] = "Ваша ссылка создана";
		    		$result [] = $newUrl;
		    		echo json_encode($result);
		    	} else {
		    		echo "Ошибка создания ссылки";
		    	}
		    }	    
		    mysql_close($connect);
		}
	}
	if (!empty($_POST['url']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)) {

	    generateUrl(4);

	} else {
		echo "Ошибка! Возможно, некорректный URL?";
	}

?>