<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");


    $sql = "SELECT * FROM data ORDER BY id ";
    $db->query($sql);
	echo "<html><head>
		  </head><body><center>
           <table width=30% border=1 align=center>
				<tr>
					<td><div align=center>序號<div></td>
					<td><div align=center>姓名<div></td>
					<td><div align=center>日期<div></td>
				</tr>";
    while($myrow = $db->fetch_array())
    {
        $id=$myrow["id"];
    	$a_name=$myrow["a_name"];
    	$dtime=$myrow["dtime"];
	echo"
				<tr>
					<td><div align=center>$id<div></td>
					<td><div align=center>$a_name<div></td>
					<td><div align=center>$dtime<div></td>
				</tr>";
  } 
  echo"	</table></center>
	        </body>
        </html>";

?>
