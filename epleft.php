<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
  $weboid=$_GET["weboid"];
  $sql="SELECT * FROM eplink WHERE weboid=$weboid ";
  $result=mysql_query($sql);
  while ($myrow=mysql_fetch_array($result)) {
    $oid=$myrow["oid"];
    $linkname=$myrow["linkname"];
    echo "<a href='./epcont.php?oid=$oid' target='middle'>$linkname<br>";


  }
echo "<body background='s.jpg' weight=100% height=100%>";

  mysql_close($web); 
   
?>


