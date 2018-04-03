<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");

  $command=$_POST["command"];
  if ($command=="小組基本資料" || $command=="返回") {
    display_first_page($db);  
  }
  elseif ($command=="查詢") {
    display_search_page($db);
  }
  elseif ($command=="新增") {
    display_insert_page($db);
    display_first_page($db);
  }
  elseif ($command=="更新") {
    display_modify_page($db);
  }
  elseif ($command=="刪除") {
    display_delete_page($db);
    display_first_page($db);
  }
  elseif ($command=="確認") {
    display_confirm_page($db);
    display_first_page($db);
  }


  function display_first_page($db) {
    echo "<html><head><title>小組基本資料</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=4>小組基本資料</td></tr>
          <tr><td class='alt1'>小組</td>
          <td><select name='s_id'>
          <option value='%'>選擇小組</option>";
    
    $sql = "SELECT * FROM test.squad ORDER BY squad_id DESC";
         
    $db->query($sql);
        while ($myrow = $db->fetch_array())
    {
      $squad_id=$myrow["squad_id"];
      $name=$myrow["name"];
      echo "<option value='$squad_id'>$name</option>";
    }

    echo "</select></td><td class='alt1'>帳號</td>
          <td><input type='text' name='account' /></td></tr>

          <tr><td class='alt1'>密碼</td>
          <td><input type='text' name='password' /></td>

		      <td class='alt1'>姓名</td>
          <td><input type='text' name='a_name' /></td>

		  <tr><td class='alt1'>權限</td>
          <td><input type='text' name='authority' /></td></tr></tr></table>
          
          <input class='cmd' type='submit' name='command' value='查詢'>
          <input class='cmd' type='submit' name='command' value='新增'>
          </form></center></body></html>";

  }
 
  function display_search_page($db) {
    $s_id=trim($_POST["s_id"]);
    $account=trim($_POST["account"]);
    $password=trim($_POST["password"]);
    $a_name=trim($_POST["a_name"]);  
    $dtime=trim($_POST["dtime"]);
	$authority=trim($_POST["authority"]);
    if ($s_id=="") $s_id="%"; 
    else $s_id="%".$s_id."%";
    if ($account=="") $account="%";
    else $account="%".$account."%";
    if ($a_name=="") $a_name="%";
    else $a_name="%".$a_name."%";
    if ($dtime=="") $dtime="%";
    else $dtime="%".$dtime."%";
	if ($authority=="") $authority="%";
    else $authority="%".$authority."%";
    // 準備查詢命令按班級學號排序
    
    $sql ="SELECT data.*,squad.* FROM test.data,test.squad WHERE s_id LIKE '$s_id' AND s_id = squad.squad_id ORDER BY s_id,account";
    $db->query($sql);

    echo "<html><head><title>小組基本資料</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=7>小組本資料</td></tr>
          <tr class='alt1'><td>小組</td><td>帳號</td><td>密碼</td>
          <td>姓名</td><td>日期</td><td>權限</td><td>選擇</td></tr>";
    $cnt=0;
    while ($myrow = $db->fetch_array())
    {
      $s_id=$myrow["s_id"];
      $name=$myrow["name"];
      $account=$myrow["account"];
      $password=$myrow["password"];
      $a_name=$myrow["a_name"];   
      $dtime=$myrow["dtime"];
      $authority=$myrow["authority"];
      $bg=$cnt % 2 + 2;
      
      echo "<tr class='alt$bg'><td>$name</td><td>$account</td>
            <td>$password</td><td>$a_name</td><td>$dtime</td><td>$authority</td>
            <td><input type='radio' name='account' value='$account'></td></tr>";
      $cnt++;
    }
    echo "</table>
          <input class='cmd' type='submit' name='command' value='更新'>
          <input class='cmd' type='submit' name='command' value='刪除'
            onclick=\"return confirm('確定要刪除嗎?');\" >
          <input class='cmd' type='submit' name='command' value='返回'>
          </center></body></html>"; 
  }

  function display_insert_page($db) {
    
    $s_id=trim($_POST["s_id"]);
    $a_name=trim($_POST["a_name"]); 
    $dtime=trim($_POST["dtime"]);
    $account=trim($_POST["account"]); 
    $password=trim($_POST["password"]);
	$authority=trim($_POST["authority"]);

    if ($s_id=="%" || $account=="") {
      echo "請回前頁輸入完整資料"; exit();
    }
    $sql="INSERT INTO `test`.`data` (`s_id`, `a_name`, `account`, `password`, `authority`) VALUES ('$s_id','$a_name','$account','$password','$authority')";
    $db->query($sql);                    
  }

  function display_delete_page($db) {
    $account=trim($_POST["account"]); 
    if ($account=="") {
      display_first_page($db); die();
    }
    $sql="DELETE FROM data WHERE account='$account' ";
    $db->query($sql);                    
  }
  function display_modify_page($db) {
    $account=$_POST["account"];
    if ($account=="") {
      display_first_page($db); die();
    }
    $sql="SELECT * FROM data WHERE account='$account' ";
    $db->query($sql); 
    $myrow = $db->fetch_array();
    $s_id=$myrow["s_id"];
    $account=$myrow["account"];
    $password=$myrow["password"];

    $a_name=$myrow["a_name"];
    $dtime=$myrow["dtime"];
	$authority=$myrow["authority"];
    echo "<html><head><title>小組基本資料更新</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table> <form method='post' action=''>
          <tr class='alt0'><td colspan=4>小組基本資料更新</td></tr>
          <tr><td class='alt1'>小組</td>
          <td><select name='s_id' size=1>
          <option value='%'>選擇小組</option>";
    $sql="select * from squad order by squad_id";
    $db->query($sql);
    while ($myrow = $db->fetch_array()) {
      $squad_id=$myrow["squad_id"];
      $name=$myrow["name"];
      if ($s_id==$squad_id) 
        echo "<option value='$squad_id' >$name</option>";
      else
        echo "<option value='$squad_id' >$name</option>";
    }
    echo "</select></td><td class='alt1'>帳號</td>
          <td><input type='text' name='account' value='$account'/>
          </td></tr>

          <tr><td class='alt1'>密碼</td>
          <td><input type='password' name='password' value='$password'/></td>
          
		      <td class='alt1'>姓名</td>
          <td><input type='text' name='a_name' value='$a_name'/></td></tr>
          
          <tr><td class='alt1'>日期</td>
          <td><input type='text' name='dtime' value='$dtime'/></td></tr>
		  
		  <tr><td class='alt1'>權限</td>
          <td><input type='text' name='authority' value='$authority'/></td></tr></table>
          <input class='cmd' type='submit' name='command' value='確認'
            onclick=\"return confirm('確定更新嗎?');\" />
          <input class='cmd' type='submit' name='command' value='返回'>
          </form></center></body></html>";
  }

  function display_confirm_page($db) {
    $squad_id=trim($_POST["squad_id"]); 
    $s_id=trim($_POST["s_id"]);
    $password=trim($_POST["password"]); 

    $a_name=trim($_POST["a_name"]); 
    $account=trim($_POST["account"]);
	$authority=trim($_POST["authority"]);
	$dtime=trim($_POST["dtime"]);
    if ($s_id=="%" || $account=="") {
      echo "請回前頁輸入完整資料"; exit();
    } 
    $sql ="UPDATE data SET s_id='$s_id',password='$password',a_name='$a_name',authority='$authority' where account='$account'";
    $db->query($sql);                   
  }
?>
