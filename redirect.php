<?
	require_once 'connection.php';
	$connect = mysql_connect($host, $user, $password); 
	mysql_select_db($database);

	$redirect = "http://".$_SERVER['HTTP_HOST']."/".$_GET['link'];
	$data = mysql_query("SELECT originURL FROM `urls` WHERE `shortURL`='$redirect'");

	while($row = mysql_fetch_assoc($data)) {
		$url = $row[originURL];
	}
    header('Location:'.$url);
 ?>