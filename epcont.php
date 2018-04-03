<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
  $oid=$_GET["oid"];
  $sql="SELECT * FROM eplink WHERE oid=$oid";
  $result=mysql_query($sql);
  $myrow=mysql_fetch_array($result) ;
  $content=$myrow["content"];
  echo $content;
  echo "<body background='y.jpg' weight=100% height=100%>";     
      mysql_close($web);
?>
