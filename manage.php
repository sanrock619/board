<?php
header("Content-Type:text/html; charset=utf-8");
require("mysql.inc.php");
$myTable='msgBoard';              // 設定本程式所使用的資料表
$errMsg='';                       // 存放錯誤訊息的變數
$password =$_POST['password'];    // 存放管理員密碼的變數
$msgNum =$_POST['msgNum'];        // 存放欲修改留言編號的變數
$msgReply =$_POST['msgReply'];    // 存放管理員回覆的變數
$msgPrivate =$_POST['msgPrivate'];// 存放留言是否公開的變數

//登入密碼
if ( $password=='123456' ){
    if(!empty($_POST['msgNum']) && !empty($_POST['msgPrivate'] )){
        $sql= "UPDATE msgBoard SET private='$msgPrivate' WHERE msg_id='$msgNum'";
        mysqli_query($conn, $sql);
        
        if (mysqli_query($conn, $sql)) {
            if($msgPrivate=='hide'){
                echo "<script>alert('留言已刪除!'); location.href = 'boardPage.php';</script>";
                
            }
            if($msgPrivate=='private') {
                echo "<script>alert('留言已設定不公開!'); location.href = 'boardPage.php';</script>";
                
            }
            else if($msgPrivate=='public'){
                echo "<script>alert('留言已設定公開!'); location.href = 'boardPage.php';</script>";
                
            }
        }
    }
    
    if(!empty($_POST['msgNum']) && !empty($_POST['msgReply'] )){
        $sql= "UPDATE msgBoard SET reply='$msgReply' WHERE msg_id='$msgNum'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('留言已回覆!'); location.href = 'boardPage.php';</script>";
            exit;
        }
    }
}

else {
    echo "<script>alert('密碼錯誤，請重新檢查!'); location.href = 'boardPage.php';</script>";
    exit;
}
?>