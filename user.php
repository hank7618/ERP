<?php
session_start();
?>
<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
  $command=$_POST["command"];
  
  if ($command=="使用者基本資料維護" || $command=="返回") {
   // display_first_page($db);
    display_first_page($db);
  }
  elseif ($command=="編輯") {
    display_modify_page($db);
  }
  elseif ($command=="確認") {
    display_confirm_page($db);
    display_first_page($db);
  }
 
  function display_first_page($db) {

  if($_SESSION['username'] != $row)
  {

      $account = $_SESSION['username'];
      $password = $_SESSION['password'];

    //var_dump($account);
   // var_dump($password);
    $sql = "SELECT * FROM data WHERE `account` = '$account'";
    $db->query($sql);
    $myrow = $db->fetch_array();
    $id=$myrow["id"];
    $s_id=$myrow["s_id"];
    $account=$myrow["account"];
    $password=$myrow["password"];
    $a_name=$myrow["a_name"];
    $dtime=$myrow["dtime"];
//var_dump($s_id);
    echo "<html><head><title>使用者基本資料維護</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt3'><td colspan=2>使用者基本資料維護</td></tr>";
        
      echo "    
          <tr><td class='alt1'>小組代碼</td>
          <td>$s_id</td></tr>

          <tr><td class='alt1'>帳號</td>
          <td>$account</td></tr>

          

          <tr><td class='alt1'>姓名</td>
          <td>$a_name</td></tr>

          <tr><td class='alt1'>日期</td>
          <td>$dtime</td></tr></table>
          
          <input class='cmd' type='submit' name='command' value='編輯'>
          </form></center></body></html>";
    }
    else
    {
      echo '您無權限觀看此頁面';
    }  
}
  function display_modify_page($db) {
   /* if($_SESSION['username'] != $row)
    {*/

    $account = $_SESSION['username'];
    $password = $_SESSION['password'];

    date_default_timezone_set("Asia/Taipei");
    $today=date("Y-m-d h:i:s A");

    $sql = "SELECT * FROM data WHERE `account` = '$account'";
    $db->query($sql);
    $myrow = $db->fetch_array();
    $id=$myrow["id"];
    $s_id=$myrow["s_id"];
    $account=$myrow["account"];
    $password=$myrow["password"];
    $a_name=$myrow["a_name"];
    $dtime=$myrow["dtime"];
    
    echo "<html><head><title>使用者基本資料維護</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt3'><td colspan=2>使用者基本資料維護</td></tr>";
        
      echo "    
          <tr><td class='alt1'>小組代碼</td>
          <td><input type='text' name='account' value='$s_id' readonly='readonly'/></td></tr>

          <tr><td class='alt1'>帳號</td>
          <td><input type='text' name='account' value='$account' readonly='readonly'/></td></tr>

          <tr><td class='alt1'>密碼</td>
          <td><input type='password' name='password' value='$password' /></td></tr>

          <tr><td class='alt1'>姓名</td>
          <td>$a_name</td></tr>

          
          </table>
          
          <input class='cmd' type='submit' name='command' value='確認'
            onclick=\"return confirm('確定更新嗎?');\" />
          <input class='cmd' type='submit' name='command' value='返回'>
          </form></center></body></html>";
    /*}*/
  } 

 function display_confirm_page($db) {
    $s_id=trim($_POST["s_id"]);
    $account=trim($_POST["account"]);
    $password=trim($_POST["password"]); 
    $a_name=trim($_POST["a_name"]); 
     

    /*if($_SESSION['account'] != $row && $s_id=="%")
    {

    //$account = $_SESSION['username'];
    

        echo "請回前頁輸入完整資料"; exit();

    
    }*/
	$sql ="UPDATE data SET password='$password' where account='$account'";
     $db->query($sql);
  }
?>
