<?php
$pglist=array("add_project.php");
$namelist=array("新增專案");
foreach ($pglist as $key => $pg) {
 $name=$namelist[$key];
echo "<tr><form method='post' action='$pg' target='middle' ><td>
            <input class='cmd1' type='submit' name='command' value='$name'>
            </td></form></tr>";
        }
?>

<?php
session_start();
date_default_timezone_set("Asia/Taipei");
$dt = new DateTime;
if (isset($_GET['year']) && isset($_GET['week'])) {
    $dt->setISODate($_GET['year'], $_GET['week']);
} else {
    $dt->setISODate($dt->format('o'), $dt->format('W'));
}
$year = $dt->format('o');
$week = $dt->format('W');
$i=0;
do {
	$date[$i] = $dt->format('Y-m-d');
    $dt->modify('+1 day');
	$i++;
} while ($week == $dt->format('W'));


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'skyeye';
$selectDB = 'test';
$conn = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
mysql_select_db("$selectDB");
mysql_query("SET NAMES 'utf8'");
?>

<?php
$result = mysql_query("SELECT * FROM project");
while($myrow = mysql_fetch_array($result) ){
	$name=$myrow["name"];
	$p_start=$myrow["p_start"];
	$p_end=$myrow["p_end"];
	echo "$name:$p_start~$p_end<br>";
	
}

echo "<br>";
?>

<a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week-1).'&year='.$year; ?>">Pre Week</a> <!--Previous week-->
<a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week+1).'&year='.$year; ?>">Next Week</a> <!--Next week-->


<?php
	echo "<table border='1px' style='width:100%;'>";
	echo "<tr>";
	echo "<td style='width:10%;'></td>";

	for($i=0;$i<=6;$i++){
	echo "<td>".$date[$i]."</td>";
	}
	echo "</tr>";

// $pc=0;
$result = mysql_query("SELECT * FROM project");
while($r = mysql_fetch_assoc($result)) {
	
	$p_id = $r['p_id'];
	$ii=0;
	$t_sql_read = mysql_query("SELECT * FROM task where `p_id` = '$p_id' and `startdate` <= '$date[6]' and `enddate` >= '$date[0]'");
	while($task = mysql_fetch_assoc($t_sql_read)) {
	$project_name[$ii] = $task['project_name'];
	$startdate[$ii] = $task['startdate'];
	$enddate[$ii] = $task['enddate'];
	$ii++;
	//print_r($r);
	}

if($r['name'] =="" && $ii==0){echo "";}
else if($r['name'] !=""){
echo "<tr>";
echo "<td>$r[name]</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
//$_SESSION['project']=$r['name'];

	$ee = 0;
	if($project_name){
	foreach($project_name as $v){
	echo "<tr>";
	echo "<td style='width:10%;word-break: break-all;text-align:right;'>$v</td>";
	for($i=0;$i<=6;$i++){
		if($startdate[$ee]<=$date[$i] && $date[$i] <= $enddate[$ee]){
		$_SESSION['date']=$date[$i];
		echo "<form action='test.php' method='post'>";
		echo " <input type='hidden' name='date' value='$date[$i]' />";
		echo " <input type='hidden' name='project' value='$r[name]' />";
		echo " <input type='hidden' name='task' value='$v' />";
		echo "<td><input class='cmd1' type='submit' name='command' value='report'></td>";
		echo "</form>";
		}
		else{echo "<td></td>";}
	}
	echo "</tr>";
	$ee++;
	}
	}
	$project_name="";
	$startdate="";
	$enddate="";
	$ii=0;

/*
$p_id[$pc] = $r['p_id'];
$p_name[$pc] = $r['name'];
$pc++;
*/

}
}
echo "</table>";


?>




