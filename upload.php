
﻿<?php
require_once(dirname(__FILE__)."/Connections/DB_config.php");
require_once(dirname(__FILE__)."/Connections/upload_class.php");

function getFiles() {
    $i = 0;  // 遞增 array 數量

    foreach ($_FILES as $file) {
        // string 型態，表示上傳單一檔案
        if (is_string($file['name'])) {
            $files[$i] = $file;
            $i++;
        }
        // array 型態，表示上傳多個檔案
        elseif (is_array($file['name'])) {
            foreach ($file['name'] as $key => $value) {
                $files[$i]['name'] = $file['name'][$key];
                $files[$i]['type'] = $file['type'][$key];
                $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                $files[$i]['error'] = $file['error'][$key];
                $files[$i]['size'] = $file['size'][$key];
                $i++;
            }
        }
    }

    return $files;
}

/**
 * string uploadFile(array $files, array $allowExt, number $maxSize, boolean $flag, string $uploadPath) 單一及多檔案上傳
 *
 * @param files 透過 $_FILES 取得的 HTTP 檔案上傳的項目陣列
 * @param allowExt 允許上傳檔案的擴展名，預設 'jpeg', 'jpg', 'gif', 'png'
 * @param maxSize 上傳檔案容量大小限制，預設 2097152（2M * 1024 * 1024 = 2097152byte）
 * @param flag 檢查是否為真實的圖片類型（只允許上傳圖片的話），true（預設）檢查；false 不檢查
 * @param uploadPath 存放檔案的目錄，預設 uploads
 *
 * @return 回傳存放目錄 + md5 產生的檔案名稱 + 擴展名
 */
function uploadFile($fileInfo, $allowExt = array('jpeg', 'jpg', 'gif', 'png', 'rar', 'docx', 'doc', 'pptx', 'ppt', 'zip'), $maxSize = 31457280, $flag = false, $uploadPath = '/var/www/html/book/uploads') {
    // 存放錯誤訊息
    $res = array();

    // 取得上傳檔案的擴展名
    $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION); 
    
    /* 確保檔案名稱唯一，防止重覆名稱產生覆蓋
    $uniName = md5(uniqid(microtime(true), true)) . '.' . $ext;
    */
    if($_SESSION['username'] != $row)
      {
 
        $account = $_SESSION['username'];
        $password = $_SESSION['password'];

        date_default_timezone_set("Asia/Taipei");
        $today=date("Y-m-d");

        $sql = "SELECT * FROM data WHERE `account` = '$account'";
        $result1 = mysql_query($sql);
        while($myrow = mysql_fetch_assoc($result1)) {
        $ida=$myrow["id"];
        $s_id=$myrow["s_id"];
        $account=$myrow["account"];
        $password=$myrow["password"];
        $a_name=$myrow["a_name"];
        $dtime=$myrow["dtime"];
        }

        $result = mysql_query("SELECT * FROM data, task, project where '$ida' = `task`.`id` and `project`.p_id = `task`.`p_id`");
        while($r = mysql_fetch_assoc($result)) {
        $p_ids = $r['p_id'];
        $ids = $r['id'];
        $ii=0;
        }

        $t_sql_read = mysql_query("SELECT * FROM task where `id` = '$ids' and `p_id` = '$p_ids'");
        while($task = mysql_fetch_assoc($t_sql_read)) {
        $id = $task['id'];
        $p_id = $task['p_id'];
        $ii=0;
        }

        $name = $id . '_' . $p_id . '_' . $today . '_' . $fileInfo['name'];
        $destination = iconv('utf-8', 'big5', $uploadPath . '/' . $name);

    // 判斷是否有錯誤
    if ($fileInfo['error'] > 0) {
        // 匹配的錯誤代碼
        switch ($fileInfo['error']) {
            case 1:
                $res['mes'] = $fileInfo['name'] . ' 上傳的檔案超過了 php.ini 中 upload_max_filesize 允許上傳檔案容量的最大值';
                break;
            case 2:
                $res['mes'] = $fileInfo['name'] . ' 上傳檔案的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
                break;
            case 3:
                $res['mes'] = $fileInfo['name'] . ' 檔案只有部分被上傳';
                break;
            case 4:
                $res['mes'] = $fileInfo['name'] . ' 沒有檔案被上傳（沒有選擇上傳檔案就送出表單）';
                break;
            case 6:
                $res['mes'] = $fileInfo['name'] . ' 找不到臨時目錄';
                break;
            case 7:
                $res['mes'] = $fileInfo['name'] . ' 檔案寫入失敗';
                break;
            case 8:
                $res['mes'] = $fileInfo['name'] . ' 上傳的文件被 PHP 擴展程式中斷';
                break;
        }

        // 直接 return 無需在往下執行
        return $res;
    }

    // 檢查檔案是否是通過 HTTP POST 上傳的
    if (!is_uploaded_file($fileInfo['tmp_name']))
        $res['mes'] = $fileInfo['name'] . ' 檔案不是通過 HTTP POST 方式上傳的';
    
    // 檢查上傳檔案是否為允許的擴展名
    if (!is_array($allowExt))  // 判斷參數是否為陣列
        $res['mes'] = $fileInfo['name'] . ' 檔案類型型態必須為 array';
    else {
        if (!in_array($ext, $allowExt))  // 檢查陣列中是否有允許的擴展名
            $res['mes'] = $fileInfo['name'] . ' 非法檔案類型';
    }

    // 檢查上傳檔案的容量大小是否符合規範
    if ($fileInfo['size'] > $maxSize)
        $res['mes'] = $fileInfo['name'] . ' 上傳檔案容量超過限制';

    // 檢查是否為真實的圖片類型
    if ($flag && !@getimagesize($fileInfo['tmp_name']))
        $res['mes'] = $fileInfo['name'] . ' 不是真正的圖片類型';

    // array 有值表示上述其中一項檢查有誤，直接 return 無需在往下執行
    if (!empty($res))
        return $res;
    else {
        // 檢查指定目錄是否存在，不存在就建立目錄
        if (!file_exists($uploadPath))
            mkdir($uploadPath, 0777, true);
        
        // 將檔案從臨時目錄移至指定目錄
        if (!@move_uploaded_file($fileInfo['tmp_name'], $destination))  // 如果移動檔案失敗
            $res['mes'] = $fileInfo['name'] . ' 檔案移動失敗';

        $res['mes'] = $fileInfo['name'] . ' 上傳成功';
        $res['dest'] = $destination;

        return $res;
        }
    }
}


echo "<html><head><meta charset='UTF-8'>
    <title>檔案上傳</title>
</head>
<body>";

echo "<form action='epfile.php' method='post' enctype='multipart/form-data'>
    <!-- 限制上傳檔案的最大值 -->
    <input type='hidden' name='MAX_FILE_SIZE' value='31457280'>

    <!-- accept 限制上傳檔案類型。多檔案上傳 name 的屬性值須定義為 array -->
    <input type='file' name='myFile[]' accept='image/jpeg,image/jpg,image/gif,image/png,file/rar,file/docx,file/doc,file/pptx,file/ppt,file/zip' style='display:block; margin-bottom: 5px;'>

   <input type='file' name='myFile[]' accept='image/jpeg,image/jpg,image/gif,image/png,file/rar,file/docx,file/doc,file/pptx,file/ppt,file/zip' style='display: block;margin-bottom: 5px;'>

   
    <!-- 使用 html 5 實現單一上傳框可多選檔案方式，須新增 multiple 元素 -->
    <!-- <input type='file' name='myFile[]'' id='' accept='image/jpeg,image/jpg,image/gif,image/png,file/rar,file/docx,file/pptx,file/zip' multiple> -->

    <input type='submit' value='上傳檔案'>
</form>";

echo "</body>
    </html>";

?>
