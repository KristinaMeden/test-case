<?
	require_once 'connection.php';
	$connect = mysql_connect($host, $user, $password); 
	mysql_select_db($database);

	$IP = $_SERVER['REMOTE_ADDR'];

	$data =mysql_query("SELECT * FROM `urls` WHERE `IP`='$IP' ");

	while($row = mysql_fetch_assoc($data)) {
		
		$urls[] = array($row[originURL],$row[shortURL],$row[time]);
	}

	echo  json_encode($urls);

?>