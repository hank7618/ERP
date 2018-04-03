<?php
session_start();
$ident=$_SESSION['ident'];
$account=$_SESSION['username'];

$s_id=$_SESSION['s_id'];
$password=$_SESSION['password'];
if ($ident=="1") { // 系統管理者管理介面
    echo "<html><head><title>系統管理者登入頁面</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>";
          $pglist=array("epsquad.php","epdata.php","project.php");
          $namelist=array("小組代碼資料","小組基本資料","全組專案紀錄");
          foreach ($pglist as $key => $pg) {
          $name=$namelist[$key];

          /*$_SESSION['root']=$account;*/
      echo "<tr><form method='post' action='$pg' target='middle' ><td>
            <input class='cmd1' type='submit' name='command' value='$name'>
            </td></form></tr>";
        }
		echo "<tr><form method='post' action='logout.php' target='_top'><td>
            <input class='cmd' type='submit' name='command' value='登出'>
            </td></form></tr>";
      echo "</table></center></body></html>";
    }

    if ($ident=="2") { // 使用者管理介面
    echo "<html><head><title>使用者登入頁面</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body>";      
          $pglist=array("eplook.php","user.php");
          $namelist=array("專案紀錄","使用者基本資料維護");
          foreach ($pglist as $key => $pg) {
          $name=$namelist[$key];
          /*$_SESSION['s_id'] = $s_id;
          $_SESSION['username'] = $account;
          $_SESSION['password'] = $password;*/
		  
      echo "<tr><form method='post' action='$pg' target='middle' ><td>
            <input class='cmd1' type='submit' name='command' value='$name'>
            </td></form></tr>";
       
        }
		echo "<tr><form method='post' action='logout.php' target='_top'><td>
            <input class='cmd' type='submit' name='command' value='登出'>
            </td></form></tr>";
      echo "</table></body></html>";
    }
	
	 if ($ident=="3") { // 使用者管理介面
    echo "<html><head><title>使用者登入頁面</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body>";      
          $pglist=array("eplook.php","user.php");
          $namelist=array("專案紀錄","使用者基本資料維護");
          foreach ($pglist as $key => $pg) {
          $name=$namelist[$key];
          /*$_SESSION['s_id'] = $s_id;
          $_SESSION['username'] = $account;
          $_SESSION['password'] = $password;*/
		  
      echo "<tr><form method='post' action='$pg' target='middle' ><td>
            <input class='cmd1' type='submit' name='command' value='$name'>
            </td></form></tr>";
       
        }
		echo "<tr><form method='post' action='logout.php' target='_top'><td>
            <input class='cmd' type='submit' name='command' value='登出'>
            </td></form></tr>";
      echo "</table></body></html>";
    }
  ?>