<?php
header("Content-Type:text/html; charset=utf-8");
require('mysql.inc.php');
$myTable='msgBoard';   // 設定本程式所使用的資料表
$errMsg='';            // 存放錯誤訊息的變數
$name ='';             // 存放留言者名稱的變數
$msgTitle ='';         // 存放留言標題的變數
$message ='';          // 存放留言內容的變數
$msgPrivate ='';       // 存放留言是否公開的變數

/*檢查是否已輸入名稱、標題、留言和留言設定
 將透過post方法傳遞過來的值放入相對應的變數:$var=myStripslashes($_POST['var'])*/
if ( !empty($_POST['name']) && !empty($_POST['msgTitle'] ) && !empty($_POST['message']) && !empty($_POST['msgPrivate'] )) {
    
    $name = $_POST['name'];
    $msgTitle = $_POST['msgTitle'];
    $message = $_POST['message'];
    $msgPrivate = $_POST['msgPrivate'];
    
}else {
    $errMsg='有資料未輸入<br>';
}

//如$errMsg 是空字串,表示沒有錯誤,將名稱, 標題, 留言, 日期時間, 留言設定寫入資料庫
if ($errMsg ==''){
    //設定時區
    date_default_timezone_set('Asia/Taipei');
    $now = date("Y-m-d H:i:s");
    $sql="INSERT INTO msgBoard (name, title, msg, datetime, private ) VALUES ('$name', '$msgTitle' , '$message', '$now' , '$msgPrivate')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('已成功新增一筆留言，感謝您的留言！'); location.href = 'index.php';</script>";
    }else {
        echo "<script>alert('$errMsg'); location.href = 'index.php';</script>";
    }
}
?>