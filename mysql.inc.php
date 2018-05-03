<?php
//資料庫連線參數設定
$dbServer = "localhost";
$dbUser = "root";
$dbPass = "root";
$dbName = "msgBoard";

//連線資料庫
$conn = @mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);

if (mysqli_connect_errno($conn))
  die("無法連線資料庫伺服器");

//設定連線編碼為UTF8 
mysqli_set_charset($conn, "utf8");
?>
<?php
// $servername = "localhost";
// $username = "root";
// $password = "root";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=msgBoard", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
//     $conn = null;
//     }
// catch(PDOException $e)
//     {
//     echo "Connection failed: " . $e->getMessage();
//     $conn = null;
//     }
?>