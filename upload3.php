<?php
    require_once(dirname(__FILE__)."/Connections/DB_config.php");
    require_once(dirname(__FILE__)."/Connections/DB_class.php");
//上傳檔案類型清單
$uptypes=array(
'image/jpg',
'image/jpeg',
'image/png',
'image/pjpeg',
'image/gif',
'image/bmp',
'application/vnd.openxmlformats-officedocument.word</a>processingml.document',
'application/pdf',
'application/msword</a>',
'image/x-png'
);


$max_file_size=2000000; //上傳檔案大小限制, 單位BYTE
$destination_folder="uploads/"; //上傳檔路徑
?>
<html>
<head>
<title>檔案上傳程式</title>
<!--<style type="text/css">
<!--
body
{
font-size: 9pt;
}
input
{
background-color: #66CCFF;
border: 1px inset #CCCCCC;
}
-->
</style>
</head>
<body>
<form enctype="multipart/form-data" method="post" name="upform">
上傳檔案:
<input name="upfile" type="file">
<input type="submit" value="上傳"><br>
<!--允許上傳的檔案類型為:<?php echo implode(',',$uptypes)?> --->
</form>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
//是否存在檔案
{
echo "您還沒有選擇檔!";
exit;
}$file = $_FILES["upfile"];
if($max_file_size < $file["size"])
//檢查檔案大小
{
echo "您選擇的檔太大了!";
exit;
}


if(!in_array($file["type"], $uptypes))
//檢查檔案類型
{
echo "檔案類型不符!".$file["type"];
exit;
}


if(!file_exists($destination_folder))
{
mkdir($destination_folder);
}


$filename=$file["tmp_name"];
$image_size = getimagesize($filename);
$pinfo=pathinfo($file["name"]);
$ftype=$pinfo['extension'];
$destination = $destination_folder.time().".".$ftype;
if (file_exists($destination) && $overwrite != true)
{
echo "同名檔已經存在了";
exit;
}


if(!move_uploaded_file ($filename, $destination))
{
echo "移動檔出錯";
exit;
}


$pinfo=pathinfo($destination);
$fname=$pinfo['basename'];
echo " <font color=red>已經成功上傳</font><br>完整位址: <font color=blue>http://localhost/book/".$destination_folder.$fname."</font><br>";
echo "<br> 大小:".$file["size"]." bytes";
echo '<br>';
//將資料插入到資料庫中
$dizhi = "http://localhost/book/"."$destination_folder"."$fname";
$name = $file['name'];
$sql = "insert into `excel`(`dizhi`,`name`) values ('$dizhi','$name')";
mysql_query($sql);
echo "資料插入成功";
}


?>
</body>