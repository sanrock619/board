<?php
// 引用PHP連線MySQL設定檔
require ("mysql.inc.php");

// 選擇連線所使用的資料表並存入變數myTable
$myTable = 'msgBoard';

/*
 * 執行SQL查詢 語法:$result = mysqli_query($link, $sql);
 * $link=MSQL連線設定變數名稱;$sql="SQL陳述式"
 * 查詢資料表所有欄位,將所得到的之查詢結果存入result資料表變數
 * 依資料表裡的留言編號遞減排序, 讓最新留言顯示在最前面
 */
$result = mysqli_query($conn, "SELECT * FROM $myTable ORDER BY msg_id DESC");

// 取得留言總筆數並存入變數numRows
$numRows = mysqli_num_rows($result);
?>
<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>管理後台</title>
<!-- core css -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- template css -->
<link href="css/cover.css" rel="stylesheet">
<!-- project css -->
<link href="css/board.css" rel="stylesheet">

</head>

<body background="img/starfield-background.png">
	<div
		style="background-image: url('img/starfield-background.png'); background-repeat: repeat">
		<div class="site-wrapper">
			<div class="site-wrapper-inner">
				<div class="cover-container">
					<div class="masthead clearfix">
						<div class="inner">
							<h3 class="masthead-brand">留言板</h3>
							<nav>
								<ul class="nav masthead-nav">
									<li><a href="index.php" target="_blank"> <span
											class="glyphicon glyphicon-home">首頁</a></li>
									<li class="active"><a href="boardPage.php"> <span
											class="glyphicon glyphicon-wrench">管理後台</a></li>
									<li id="refresh"><a href="#"> <span
											class="glyphicon glyphicon-refresh">刷新頁面</a></li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="inner cover">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<font size='3'><strong>留言板（管理員模式）</strong></font>
							</div>
							<div class="panel-body" style="color: black">
								<button type="button" class="btn btn-info" id="maFlip">隱藏管理表單</button>
								<br> <br>
								<div id=maPanel>
									<div
										style='border: 5px #000 double; border-color: #2894FF; background-color: #D2E9FF;'>
										<font size="3">
											<form method="post" action="manage.php">
												<table class="table table-bordered"
													style="margin-bottom: -15px;">
													<tr>
														<td class="maClass">留言編號：</td>
														<td><input class="input" name="msgNum"
															style="color: black" required></td>
													</tr>
													<tr>
														<td class="maClass">密碼確認：</td>
														<td><input class="input" type="password" name="password"
															style="color: black" required></td>
													</tr>
													<tr>
														<td class="maClass" style="vertical-align: middle">修改設定：</td>
														<td><input type="radio" name="msgPrivate" value="public"
															id="public"> <label for="public"><font color="blue"><span
																	class="glyphicon glyphicon-ok-circle">留言公開</font></label>&nbsp;
															&nbsp; <input type="radio" name="msgPrivate"
															value="private" id="private"> <label for="private"><font
																color="red"><span class="glyphicon glyphicon-ban-circle">留言不公開</font></label>&nbsp;
															&nbsp; <input type="radio" name="msgPrivate" value="hide"
															id="hide"> <label for="hide"><font color="#666666"><span
																	class="glyphicon glyphicon-remove">刪除留言</font></label>
														</td>
													</tr>
													<tr>
														<td class="maClass" style="vertical-align: middle">回覆留言：</td>
														<td class="txtarIndex"><textarea name="msgReply"
																class="textArea" maxlength="150"></textarea></td>
													</tr>
												</table>
										
										</font>
									</div>
									<br>
									<div style="text-align: center;">
										<input name="submit" class="btn btn-success btn-md"
											type="submit" value="送出設定"> &nbsp; &nbsp; <input
											name="reset." class="btn btn-warning btn-md" type="reset"
											value="清除重填">
									</div>
									</form>
								</div>
								<br> <font size='3' color='black'>
<?php echo "<font color='black'><p align=left>共有 $numRows 筆留言</p></font>"?>
                    <form>
<?php

// 如果留言筆數大於 0, 則顯示留言的內容
if ($numRows > 0) {
    
    // 將留言以有序號的清單型式輸出並反轉序號(讓序號由大至小遞減排序)
    echo '<ol reversed>';
    
    /*
     * 以下使用mysqli_fetch_array()函數,語法:mysqli_fetch_array(result,resulttype)
     * 參數result:即mysqli_query()方法所查詢之結果(必要)
     * 參數resulttype:指定產生類型的陣列(非必要) MYSQLI_ASSOC ; MYSQLI_NUM ; MYSQLI_BOTH 三選一
     */
    while ($row = mysqli_fetch_array($result)) {
        
        // 將名稱及標題中的特殊字元轉成 HTML 碼
        $name = htmlspecialchars($row['name'], ENT_QUOTES);
        $msgTitle = htmlspecialchars($row['title'], ENT_QUOTES);
        
        // 將留言、回覆及留言設定中的特殊字元、換行字元、與空白轉成 HTML 碼
        // str_replace(find,replace,string)
        // nl2br():在字串中的每個\n之前插入<br>,nl2br(string,xhtml)
        $message = htmlspecialchars($row['msg'], ENT_QUOTES);
        $message = str_replace('  ', '&nbsp;&nbsp;', nl2br($message));
        $msgReply = htmlspecialchars($row['reply'], ENT_QUOTES);
        $mesReply = str_replace('  ', '&nbsp;&nbsp;', nl2br($msgReply));
        $msgPrivate = ($row['private']);
        
        // 若管理員已將留言設定為隱藏，則隱藏內容
        // 若管言者已將留言設定為不公開，則不公開
        $msgHide = '';
        if ($msgPrivate == 'hide') {
            $msgHide = '**此留言已設定為顯示刪除**<br>';
        } else if ($msgPrivate == 'private') {
            $msgHide = '**此留言已設定隱藏不顯示**<br>';
        }
        
        // 輸出留言者名稱、留言日期時間、標題與留言內容
        echo " 
    <li style='margin-left:-20px'>
        <div style='border:5px #000 double;border-color:#2894FF;margin-right:20px'>
            <table class='table table-bordered' style='margin-bottom:0px'>
                <tr>
                    <td class='tdclass'>名稱：</td>
                    <td class='txtBoard'>$name</td>
                </tr>
                <tr>
                    <td class='tdclass'>留言時間：</td>
                    <td class='txtBoard'>{$row['datetime']}</td>
                </tr>
                <tr>
                    <td class='tdclass'>標題：</td>
                    <td class='txtBoard'>$msgTitle</td>
                </tr>
                <tr>
                    <td class='tdclass' style='vertical-align:middle'>留言內容：</td>
                    <td class='txtclass'>$msgHide$message</td>
                </tr>
                <tr>
                    <td class='tdclass' style='vertical-align:middle'><span class='glyphicon glyphicon-comment'>回覆：</td>
                    <td class='boardReply'>$msgReply</td>
                </tr>
            </table>
        </div>
        <hr>
    </li>";
        // 預備進入下一次迴圈,檢查mysqli_fetch_array()回傳的值是否為null
    }
    
    // 結束留言內容輸出
    echo '</ol>';
}
?>
                    </form>
								</font>
							</div>
							<div class="panel-footer" style="background: #005AB5">
								<a href="#top"><span class="glyphicon glyphicon-share-alt"><font
										size='3'>回到最上頁</a></font>
							</div>
						</div>
					</div>
					<div class="mastfoot">
						<div class="inner">
							<p>
								<font color='white'>留言板管理員 <a href="mailto:sanrock619@gmail.com">Admin</a>.
								</font>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- core js -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- 驗證碼產生器js -->
<script src="js/code.js"></script>
<!-- 滑動式視窗js -->
<script src="js/toggleMa.js"></script>

</html>