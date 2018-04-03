<?php
session_start();
 ?>
 
 <?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
	$ident=$_SESSION['ident'];
$command=$_POST["command"];
$username=$_SESSION['username'];
  if($_SESSION['username'] != $row)
{
     $account = $_SESSION['username'];
     $password = $_SESSION['password'];
	//var_dump($account);
    //var_dump($password);
    $sql = "select * from data where account = '$account'";
    $db->query($sql);
    $myrow = $db->fetch_array();
    $who=$myrow["id"];
    //var_dump($who);
     if($_GET['t_id'] != 1 && $_GET['command'] == "Set" && $_GET['start'] != "" && $_GET['end'] != ""){


	$link=mysql_connect("localhost","root","skyeye");
	mysql_select_db("test");
	mysql_query("SET NAMES 'utf8'");
	date_default_timezone_set("Asia/Taipei");
 	 


	$get_max_pid = mysql_query("SELECT MAX(`t_id`)+1 as 'max_tid' FROM `task`");
	$idmax = mysql_fetch_assoc($get_max_pid);
	$te ="INSERT INTO task (`datetime`, `project_name`, `startdate`, `enddate`, `t_id`, `p_id`, `id`) 
					VALUES (now(), '$_GET[title]', '$_GET[start]', '$_GET[end]', '$idmax[max_tid]', '$_GET[p_id]', '$who')";
	mysql_query($te);
	

	
	// echo $idmax['max_pid'];
	/*

	*/
    }	
	}
else{
	
}




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
echo"<p>project:</p>";
echo"<select name='p_id'>";
echo"<option value='0'>select one</option>";
$result = mysql_query("SELECT * FROM project");
while($r = mysql_fetch_assoc($result)) {
echo"<option value='$r[p_id]'>$r[name]</option>";
}

echo"</select>";
echo"<br>";
echo"</td>";
echo"</tr>";

echo"<tr>";
echo"<td>";
echo"<p>Task:</p><input type='text' name='title' value='$_GET[title]' size='8'/><br>";
echo"</td>";
echo"</tr>";

echo"<tr>";
echo"<td>";
echo"<p>起時間:</p><input type='date' name='start' value='$_GET[start]' size='8'/><br>";
echo "<p>訖時間:</p><input type='date' name='end' value='$_GET[end]' size='8'/><br>";
echo"</td>";
echo"</tr>";
$pglist=array("eplook.php");
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
echo "<form>";
echo"</table>";
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