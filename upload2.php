<?php
$type=$_FILES['file']['type'];
$size=$_FILES['file']['size'];
$name=$_FILES['file']['name'];
$name=iconv("UTF-8","BIG-5",$_FILES['file']['name']);
$nameEcho=$_FILES['file']['name'];
$tmp_name=$_FILES['file']['tmp_name'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上傳結果</title>
</head>

<body>
<?php
$sizemb=round($size/1024000,2);
echo "檔案類型：".$type."</br>";
echo "檔案大小：".$sizemb."MB</br>";
echo "檔案名稱：".$nameEcho."</br>";
echo "暫存名稱：".$tmp_name."</br>";
if($type=="application/pdf" || $type=="application/vnd.ms-excel" || $type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
 if($sizemb < 3){
  if(file_exists("upload/".$name)){
   $file=explode(".",$name);
   //echo $file[0];/*主檔名*/
   //echo $file[1];/*副檔名*/
  @$new_name=$file[0]."-".date(ymdhis)."-".rand(0,10);
  $chi_name=iconv("BIG-5","UTF-8",$new_name);
   echo "</br>已修改為新檔名:".$chi_name."後上傳成功";
   move_uploaded_file($tmp_name,"uploads/".$new_name.".".$file[1]);
  }else{
   move_uploaded_file($tmp_name,"uploads/".$name);
   echo "上傳成功";
   
exit;
  }
 }else{
  echo "檔案太大，上傳失敗";
 }
}else{
 echo "檔案格式錯誤，上傳失敗";
}
?>
</body>
</html>