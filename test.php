<?php
session_start();
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");

  $command=$_POST["command"];
  if ($command=="report" || $command=="返回") {
    display_first_page($db);  
  }
  elseif ($command=="查詢") {
    display_search_page($db);
  } 
      $date = $_POST[date];
	  $project = $_POST[project];
	  $task = $_POST[task];

  function display_first_page($db) {
	  $date = $_POST[date];
	  $project = $_POST[project];
	  $task = $_POST[task];
    echo "<html><head><title>專案報告</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=2>專案報告</td></tr>
          <tr><td class='alt1'>專案名稱</td>
          <td><input type='text' name='project' value=$project readonly='readonly' style='width:300px;'/></td></tr>
       
          <tr><td class='alt1'>日期</td>
          <td><input type='text' name='date' value=$date readonly='readonly' style='width:300px;'/></td></tr>

		  <tr><td class='alt1'>Task</td>
          <td><input type='text' name='task' value=$task readonly='readonly' style='width:300px;'/></td></tr>";
	/*echo "<tr><td class='alt1'>任務</td>
          <td><input type='text' name='task' /></td></tr>";
	  
	  echo "<tr><td class='alt1'>工作內容</td>
          <td><input type='text' name='work' /></td></tr>";*/
        echo  "</td></tr></tr></table><input class='cmd' type='submit' name='command' value='查詢'>
          
          </form></center></body></html>";
  }
 
  function display_search_page($db) {
	  $task =trim($_POST[task]);
	  $project =trim($_POST[project]);
	  $date =trim($_POST[date]);	  
	  /*if ($project=="") $project="%"; 
		else $project="%".$project."%";
	  if ($date=="") $date="%";
		else $date="%".$date."%";
	  if ($task=="") $task="%";
		else $task="%".$task."%";*/

		// 準備查詢命令按班級學號排序
    $sql ="SELECT * FROM `report` WHERE project = '$project' AND date = '$date' AND task = ' $task'";
    $result = mysql_query($sql);	
    echo "<html><head><title>專案報告</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=5>專案報告</td></tr>
          <tr class='alt1'><td>專案名稱 </td><td>姓名</td><td>任務</td><td>日期</td><td>工作說明</td></tr>";
    $cnt=0;
    while ($row = mysql_fetch_array($result)) {
	  $a_name=$row['a_name'];
      $project=$row['project'];
	  $task=$row['task'];
      $date=$row['date']; 
	  $work=$row['work'];
      $bg=$cnt % 2 + 2;
       echo "<tr class='alt$bg'><td><input type='text' style='background-color:#C9FFFF;' name='project' value=$project readonly='readonly'/></td>
	                            <td><input type='text' style='background-color:#C9FFFF;' name='a_name' value=$a_name readonly='readonly'></td>
	                            <td><input type='text' style='background-color:#C9FFFF;' name='task' value=$task readonly='readonly'></td>
                                <td><input type='text' style='background-color:#C9FFFF;' name='date' value=$date readonly='readonly'/></td>
			                    <td><input type='text' style='background-color:#C9FFFF;' name='work' value=$work readonly='readonly'></td>
            </tr>";
      $cnt++;
    }
    echo "</table>
          
          <input class='cmd' type='submit' name='command' value='返回'>
          </center></body></html>"; 
		  
  }


  



?>

