<?php
session_start();
$who = $_SESSION['root'];
//echo $_SESSION['root'];
$link=mysql_connect("localhost","root","skyeye");
mysql_select_db("test");
mysql_query("SET NAMES 'utf8'");
date_default_timezone_set("Asia/Taipei");

//$pid = mysql_query("SELECT * FROM `project`");

//while($r = mysql_fetch_assoc($pid)) {
	
//	$p_id = $r['p_id'];
//}
//Var_dump($p_id);
if($_GET['p_id'] != 1 && $_GET['command'] == "Set" && $_GET['start'] != "" && $_GET['end'] != ""){

	$get_max_pid = mysql_query("SELECT MAX(`p_id`)+1 as 'max_tid' FROM `project`");
	$idmax = mysql_fetch_assoc($get_max_pid);
	$te ="INSERT INTO project (`p_id`, `name`, `p_start`, `p_end`) 
					VALUES ('$idmax[max_tid]', '$_GET[title]', '$_GET[start]', '$_GET[end]')";
	mysql_query($te);
		
	// echo $idmax['max_pid'];
	/*

	*/
}
//Var_dump($idmax[max_tid]);
//Var_dump($_GET[title]);
//Var_dump($_GET[start]);
//Var_dump($_GET[end]);

echo "<html>";
echo "<head>";

echo "</head>";
echo "<body>";
echo "<form method='GET' action=''>";
echo "<div class='bg'></div>
<div class='bg-d'>";
echo "<center style='color:white;'>";
echo "<div style='margin:80px;'>";
echo"<table border='1' style='text-align:center;'>";

echo"<tr>";
echo"<td>";
echo"專案:<input type='text' name='title' value='$_GET[title]' size='8'/><br>";
echo"</td>";
echo"</tr>";

echo"<tr>";
echo"<td>";
echo"起時間:<input type='date' name='start' value='$_GET[start]' size='8'/><br>";
echo "訖時間:<input type='date' name='end' value='$_GET[end]' size='8'/><br>";
echo"</td>";
echo"</tr>";
$pglist=array("perject.php",);
$namelist=array("Set");
 foreach ($pglist as $key => $pg) {
 $name=$namelist[$key];
echo"<tr><form method='post' action='$pg' target='middle' >";
echo"<td>";
echo "<input style='margin:5px;' type='submit' name='command' value='$name' size='4' />";
echo"<br>";
echo"</td></form>";
echo"</tr>";
}
echo "</form>";
echo "</table>";
echo "</div>";
echo "</div>";
echo "<input type='hidden' name='useid' value='$_GET[useid]'>";
echo "</form>";
echo "</center>";
echo "</body>";
echo "</html>";

/*

$result2 = mysql_query("SELECT MAX(`id`)+1 as 'mid' FROM `$tea_nr`");
$r = mysql_fetch_assoc($result2);
$te ="INSERT INTO `$tea_nr` (id, title, start, end, url, info) VALUES ('$mid', '$_GET[title]', '$_GET[start]', '$in_end', 'http://www.aisky.com.tw/tea/event_info.php?id=', '$allin')";
mysql_query($te);
}
*/


?>
