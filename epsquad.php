<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");

  $command=$_POST["command"];
  if ($command=="小組代碼資料" || $command=="返回") {
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
    echo "<html><head><title>小組代碼資料</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=2>小組代碼資料</td></tr>
          <tr><td class='alt1'>小組代碼</td>
          <td><input type='text' name='squad_id' /></td></tr>

          <tr><td class='alt1'>小組名稱</td>
          <td><input type='text' name='name' /></td></tr></table>

          <input class='cmd' type='submit' name='command' value='查詢'>
          <input class='cmd' type='submit' name='command' value='新增'>
          </form></center></body></html>";
  }
 
  function display_search_page($db) {
    $squad_id=trim($_POST["squad_id"]);
    $name=trim($_POST["name"]); 
    if ($squad_id=="") $squad_id="%"; 
    else $squad_id="%".$squad_id."%";
    if ($name=="") $name="%";
    else $name="%".$name."%";
    // 準備查詢命令按班級學號排序
    $sql ="SELECT * FROM test.squad WHERE squad_id LIKE '$squad_id' AND name LIKE '$name' ORDER BY squad_id ";
    $db->query($sql);
    echo "<html><head><title>小組代碼資料</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table><form method='post' action=''>
          <tr class='alt0'><td colspan=3>小組代碼資料</td></tr>
          <tr class='alt1'><td>小組代碼</td><td>小組名稱</td><td>選擇</td></tr>";
    $cnt=0;
    while ($myrow = $db->fetch_array()) {
      $squad_id=$myrow["squad_id"]; 
      $name=$myrow["name"]; 
      $bg=$cnt % 2 + 2;
      echo "<tr class='alt$bg'><td>$squad_id</td><td>$name</td>
            <td><input type='radio' name='squad_id' value='$squad_id'></td></tr>";
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
    $squad_id=trim($_POST["squad_id"]);
    $name=trim($_POST["name"]); 
    if ($squad_id=="" || $name=="") {
      display_first_page($db); exit();
    }
    $sql="INSERT INTO `test`.`squad` (`squad_id`, `name`) VALUES ('$squad_id','$name')";
    $db->query($sql);                     
  }

  function display_delete_page($db) {
    $squad_id=trim($_POST["squad_id"]); 
    if ($squad_id=="") {
      display_first_page($db); die();
    }
    $sql="delete from test.squad where squad_id='$squad_id' ";
    $db->query($sql);                     
  }

  function display_modify_page($db) {
    $squad_id=$_POST["squad_id"];
    if ($squad_id=="") {
      display_first_page($db); die();
    }
    $sql="SELECT * FROM test.squad WHERE squad_id='$squad_id' ";
    $db->query($sql); 
    $myrow = $db->fetch_array();
    $name=$myrow["name"];
    echo "<html><head><title>小組代碼資料</title>
          <link rel='stylesheet' type='text/css' href='style.css'>
          </head><body><center>
          <table> <form method='post' action=''>
          <tr class='alt0'><td colspan=4>小組代碼資料</td></tr>
          <tr><td class='alt1'>小組代碼</td>
          <td><input type='text' name='squad_id' value='$squad_id' readonly/></td>
          <tr><td class='alt1'>小組名稱</td>
          <td><input type='text' name='name' value='$name' /></td></tr>
          </table>
          <input class='cmd' type='submit' name='command' value='確認'
            onclick=\"return confirm('確定更新嗎?');\" />
          <input class='cmd' type='submit' name='command' value='返回'>
          </form></center></body></html>";
  }

  function display_confirm_page($db) {
    $squad_id=trim($_POST["squad_id"]); 
    $name=trim($_POST["name"]); 
    $sql="UPDATE test.squad SET name='$name' WHERE squad_id='$squad_id' ";
    $db->query($sql);                   
  }

?>

