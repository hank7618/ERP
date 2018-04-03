<?php
    require_once(dirname(__FILE__)."/DB_class.php");
    global $_DB;	
    $_DB['host'] = "localhost";
    $_DB['username'] = "root";
    $_DB['password'] = "skyeye";
    $_DB['dbname'] = "test";
    $db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $adminuser="w301a0";   // 自行設定管理者帳號
    $adminpass="boon301ca0";  // 自行設定管理者密碼
?>
