<?php
session_start();
?>
<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
 echo "<body background ='2.jpg' width=100% height=100%>";
 $command=$_POST["command"];
 if ($command=="") {
 echo "<html><head><title>小組紀錄登入頁面</title>
 <link rel='stylesheet' type='text/css' href='style.css'>
 </head><body><center>
 <form method=post action=''>
 <fieldset>
 <span style='background-color: #ccccff'>帳號:</span>
 <input type=text name=username size=8 /><br>
 <span style='background-color: #ccccff'>密碼:</span>
 <input type=password name=password size=8><br>
 <input class='cmd' type=submit name=command value='登入'>



 </form></fieldset>";
 $pglist=array("epnews.php","eplist.php");
 $namelist=array("檢視組員名單","檢視小組組長");
 foreach ($pglist as $key => $pg) {
 $name=$namelist[$key];
 echo "<tr><form metho$d='post' action='$pg' target='middle' ><td>
 <input class='cmd1' type='submit' name='command' value='$name'>
 </td></form></tr>";
 }
 echo "</table></center></body></html>";
 }
 if ($command=='登入') {
 $username=$_POST["id"];

 $account=trim($_POST["username"]);
 $password=trim($_POST["password"]);


 if ($account==$adminuser && $password==$adminpass) $ident="1"; //管理者
 else {

 $account=$_POST['username'];
 $password=$_POST['password'];

 $sql = "SELECT * FROM `test`.`data` WHERE `account` = '$account' &&`password` = '$password' ";
 
 $db->query($sql);

 $row = $db->get_num_rows();
 
 if ($row == 1) $ident="2";
 else {
   //Var_dump($row);
   echo "登入失敗，請回前頁重新登入";
   echo '<meta http-equiv=REFRESH CONTENT=1;url=eplogin.php>';
      }
 }
 
 if ($ident=="1") { // 系統管理者管理介面
    echo "<html><head><title>系統管理者燈入頁面</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>";
          $pglist=array("epsquad.php","epdata.php","project.php");
          $namelist=array("小組代碼資料","小組基本資料","全組專案紀錄");
          foreach ($pglist as $key => $pg) {
          $name=$namelist[$key];

          $_SESSION['root']=$account;
      echo "<tr><form method='post' action='$pg' target='middle' ><td>
            <input class='cmd1' type='submit' name='command' value='$name'>
            </td></form></tr>";
        }
		echo "<tr><form method='post' action='logout.php' target='_top'><td>
            <input class='cmd' type='submit' name='command' value='登出' target=''>
            </td></form></tr>";
      echo "</table></center></body></html>";
    }

    if ($ident=="2") { // 使用者管理介面
    echo "<html><head><title>使用者登入頁面</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>";      
          $pglist=array("eplook.php","user.php");
          $namelist=array("專案紀錄","使用者基本資料維護");
          foreach ($pglist as $key => $pg) {
          $name=$namelist[$key];
          $_SESSION['s_id'] = $s_id;
          $_SESSION['username'] = $account;
          $_SESSION['password'] = $password;
      echo "<tr><form method='post' action='$pg' target='middle' ><td>
            <input class='cmd1' type='submit' name='command' value='$name'>
            </td></form></tr>";
       
        }
		echo "<tr><form method='post' action='logout.php' target='_top'><td>
            <input class='cmd' type='submit' name='command' value='登出' target=''>
            </td></form></tr>";
      echo "</table></center></body></html>";
    }
	
  }
  
?>
