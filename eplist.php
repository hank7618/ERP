<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
    $spaces="&nbsp;&nbsp;&nbsp;&nbsp;";

    $db = new DB(); 

    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

    $sql = "SELECT * FROM squad ORDER BY squad_id DESC";

    $db->query($sql);
    echo "<html><head><title>檢視小組組長</title>
            
            </head><body><center>
            <table width=30% border=1 align=center>
                <tr>
                    <td><div align=center>組長<div></td>
                </tr>";

    while($myrow = $db->fetch_array())
    {
        $squad_id=$myrow["squad_id"];
        $name=$myrow["name"];
        echo "<tr>
                    <td><div align=center>$name<div></td>
                </tr>";
    } 
  echo"	</table></center>
        </body>
        </html>";
?>
