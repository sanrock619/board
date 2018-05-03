<?php
header("Content-Type:text/html; charset=utf-8");
$account =$_POST['account'];      // 存放管理員帳號的變數
$password =$_POST['password'];    // 存放管理員密碼的變數

if ($account=='admin' && $password=='123456' ){
    echo "<script>alert('登入成功!'); location.href = 'boardPage.php';</script>";
    exit;
}

else {
    echo "<script>alert('帳號或密碼有誤!'); location.href = 'signin.html';</script>";
    exit;;
}
?>