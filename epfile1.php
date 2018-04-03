<?php session_start();?> 
<?php
     
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
  
  $command=$_POST["command"];
  if ($command=="report" || $command=="返回") {
    display_first_page($db);  
  }
    elseif ($command=="新增") {
    display_insert_page($db);
    header('Location:eplook.php');
    exit;
  }
  elseif ($command=="上傳") {
    display_upload_page($db);
  }
  elseif ($command=="查詢") {
    display_search_page($db);
  }
  elseif ($command=="修改") {
    display_modify_page($db);
  }
  elseif ($command=="確認") {
	display_confirm_page($db);
    display_first_page($db);
  }
  
	  $date = $_POST[date];
	  $task = $_POST[task];
	  $project = $_POST[project];
  function display_first_page($db) {
	  if($_SESSION['username'] != $row)
  {

      $account = $_SESSION['username'];
      $password = $_SESSION['password'];
      $date = $_POST[date];
	  $task = $_POST[task];
	  $project = $_POST[project];
    //var_dump($account);
   // var_dump($password);
    $sql = "SELECT * FROM data WHERE `account` = '$account'";
    $db->query($sql);
    $myrow = $db->fetch_array();
   
    $account=$myrow["account"];
    $a_name=$myrow["a_name"];
    
    echo "<html><head><title>工作日誌</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=2>工作日誌</td></tr>
		  
		  <tr><td class='alt1'>名字</td>
          <td><input type='text' name='a_name' value=$a_name readonly='readonly' style='width:300px;'/></td></tr>
		  
          <tr><td class='alt1'>Project</td>
          <td><input type='text' name='project' value=$project readonly='readonly' style='width:300px;'/></td></tr>

          <tr><td class='alt1'>Task</td>
          <td><input type='text' name='task' value=$task readonly='readonly' style='width:300px;'/></td></tr>
		  
		  <tr><td class='alt1'>日期</td>
          <td><input type='text'' name='date' value=$date readonly='readonly' style='width:300px;'/></td></tr>
		  
		  <tr><td class='alt1'>工作說明:</td>
          <td><textarea style='width:300px;height:100px;' name='work'>撰寫工作內容
          </textarea></td></tr></table>

          <input class='cmd' type='submit' name='command' value='新增'>
          <input class='cmd' type='submit' name='command' value='上傳'>
		  <input class='cmd' type='submit' name='command' value='查詢'>
          </form></center></body></html>";
  }
  }
 
  function display_insert_page($db) {
	$a_name=trim($_POST["a_name"]);
    $project=trim($_POST["project"]);
    $task=trim($_POST["task"]);
    $date=trim($_POST["date"]);
    $work=trim($_POST["work"]);	
    if ($project=="" || $task=="" || $date=="" || $work=="") {
      display_first_page($db); exit();
    }
    $sql="INSERT INTO `test`.`report` (`a_name`, `project`, `task`, `date`, `work`) VALUES ('$a_name','$project',' $task','$date','$work')";
    $db->query($sql);                     
  }

function display_upload_page($db) {
	/*echo "<html>
<body>
<form action='upload2.php' method='post' enctype='multipart/form-data'>
選擇檔案:<input type='file' name='file' id='file' /><br/>
<input type='submit' name='submit' value='上傳檔案' />
</form>
</body>
</html>";*/
header('Location:upload3.php');
    exit;
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
          <tr class='alt0'><td colspan=6>專案報告</td></tr>
          <tr class='alt1'><td>專案名稱 </td><td>姓名</td><td>任務</td><td>日期</td><td>工作說明</td><td>選擇</td></tr>";
    $cnt=0;
    while ($row = mysql_fetch_array($result)) {
	  $a_name=$row['a_name'];
      $project=$row['project'];
	  $task=$row['task'];
      $date=$row['date']; 
	  $work=$row['work'];
      $bg=$cnt % 2 + 2;
       echo "<tr class='alt$bg'><td><input type='text' style='background-color:#C9FFFF;' name='project' value='$project' readonly/></td>
	                            <td><input type='text' style='background-color:#C9FFFF;' name='a_name' value='$a_name' readonly/></td>
	                            <td><input type='text' style='background-color:#C9FFFF;' name='task' value='$task' readonly/></td>
                                <td><input type='text' style='background-color:#C9FFFF;' name='date' value='$date' readonly/></td>
			                    <td><input type='text' style='background-color:#C9FFFF;' name='work' value='$work' readonly/></td>
			                    <td><input type='radio' name='project' value='$project'></td>
            </tr>";
      $cnt++;
    }
    echo "</table>
          <input class='cmd' type='submit' name='command' value='修改'>
          <input class='cmd' type='submit' name='command' value='返回'>
          </center></body></html>"; 
		  
  }
  function display_modify_page($db){
	  $date = $_POST[date];
	  $task = $_POST[task];
	  $project = $_POST[project];
    if ($project=="") {
      display_first_page($db); die();
    }
    $sql="SELECT * FROM report WHERE project='$project'";
    $db->query($sql); 
    $myrow = $db->fetch_array();
    $project=$myrow["project"];
    $a_name=$myrow["a_name"];
    $task=$myrow["task"];

    $date=$myrow["date"];
    $work=$myrow["work"];
	
    echo "<html><head><title>工作日誌更新</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table> <form method='post' action=''>
          <tr class='alt0'><td colspan=4>工作日誌更新</td></tr>
          <tr><td class='alt1'>姓名</td>
          <td><input type='text' name='a_name' value='$a_name' readonly/>
          </td></tr>
		  <tr><td class='alt1'>專案</td>
          <td><input type='text' name='project' value='$project' readonly/></td></tr>
          
		      <td class='alt1'>任務</td>
          <td><input type='text' name='task' value='$task' readonly/></td></tr>
          
          <tr><td class='alt1'>日期</td>
          <td><input type='text' name='date' value='$date' readonly/></td></tr>
		  
		  <tr><td class='alt1'>工作內容</td>
		  <td><input type='text' name='work' value='$work'/></td></tr>
          </table>
          <input class='cmd' type='submit' name='command' value='確認'
            onclick=\"return confirm('確定更新嗎?');\" />
          <input class='cmd' type='submit' name='command' value='返回'>
          </form></center></body></html>";
  }
function display_confirm_page($db) {
    $a_name=trim($_POST["a_name"]); 
    $project=trim($_POST["project"]);
    $task=trim($_POST["task"]); 

    $date=trim($_POST["date"]); 
    $work=trim($_POST["work"]);
	
	
    if ($work=="" ) {
      echo "請回前頁輸入完整資料"; exit();
    }
    $sql ="UPDATE report SET work='$work' where project='$project' AND date = '$date' AND task =' $task'";
    $db->query($sql);                   
  }
?>

