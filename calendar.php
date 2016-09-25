<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>スケジュール帳</title>
<link rel="stylesheet" href="style.css">

<script>
	function keisan(n){
	  var target = document.getElementById("target_date").value,
	  		y = target.substr( 0, 4 ),
	  		m = target.substr( 5, 2 ),
	  		a = Number(m)+n,
	  		b = ("00"+a).slice( -2 );//0うめ
	  		if(b == 13) {
	  			b = ("00"+1).slice( -2 );
	  			y = Number(y)+n;
	  		} else if(b == 00 ) {
	  			b = 12;
	  			y = Number(y)+n;
	  		}
	  		document.getElementById("target_date").value = y+"年"+ b +"月";
	  		post01.submit();
	 };
</script>
</head>
<body>
<?php

	//年月選択リストを表示する
	echo "<form method='POST' action='' name='post01'>";
	echo "<p class='prev' onClick='keisan(-1)'>前へ</p>";
	if(isset($_GET["ymd"])) {
		$ymd = basename($_GET["ymd"]);
		$y = substr($ymd, 0, 4);
		$m = substr($ymd, 4, 2);
		if(!isset($_POST["target_date"])){
			echo "<input type='text' id='target_date' name='target_date' value='{$y}年{$m}月'>";
		} else {
			$ym_select = $_POST["target_date"];
			$y = mb_substr($ym_select, 0, 4);
		  $m = mb_substr($ym_select, 5, 2);
			echo "<input type='text' id='target_date' name='target_date' value='{$ym_select}'>";
		}
		}
	elseif (isset($_POST["target_date"])) {
		    // 選択された年月を取得する
		    // $y = intval($_POST["y"]);
		  	// $m = intval($_POST["m"]);
				$ym_select = $_POST["target_date"];
				$y = mb_substr($ym_select, 0, 4);
			  $m = mb_substr($ym_select, 5, 2);
			  echo "<input type='text' id='target_date' name='target_date' value='{$ym_select}'>";
	} else {
		    // 現在の年月を取得する
		    $ym_now = date("Ym");
		    $y = substr($ym_now, 0, 4);
		    $m = substr($ym_now, 4, 2);
		    echo "<input type='text' id='target_date' name='target_date' value='{$y}年{$m}月'>";
		}
	echo "<p class='next' onClick='keisan(1)'>次へ</p>";
	echo "</form>";
?>
<!-- カレンダーの表示 -->
<table id="cal" border="1">
<tr>
<th>日</th>
<th>月</th>
<th>火</th>
<th>水</th>
<th>木</th>
<th>金</th>
<th>土</th>
</tr>
<tr>
<?php
// 1日の曜日まで移動
$wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
for ($i = 1; $i <= $wd1; $i++) {
    echo "<td>&nbsp;</td>";
}

$d = 1;
while (checkdate($m, $d, $y)) {
    // 日付リンクの表示
    $link = "calendar.php?ymd=%04d%02d%02d";
    //引数に指定した値を指定の形式にフォーマットした文字列を取得します
    // 今日が土曜日の場合の処理
    if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
        // 週を終了
    		echo "<td><a class='blue' target='iframe' href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
        echo "</tr>";

        // 次の週がある場合は新たな行を準備
        if (checkdate($m, $d + 1, $y)) {
            echo "<tr>";
        }
    } elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0) {
    	echo "<td><a class='red' target='iframe' href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
    } else {
    	echo "<td><a target='iframe' href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
    }

    // 日付を1つ進める
    $d++;
}

// 最後の週の土曜日まで移動
$wdx = date("w", mktime(0, 0, 0, $m + 1, 0, $y));
for ($i = 1; $i < 7 - $wdx; $i++) {
    echo "<td>&nbsp;</td>";
}
?>
</tr>
</table>

	<!-- 2桁の10進数 -->
	<?php $img_num = (int)$m;
		echo "<div class='ponta'>";
		echo "<h2>{$img_num}月</h2>";
		echo "<img src='img/{$m}.jpg'>";
		echo "</div>";
	?>

<br><br>

<?php  require 'schedule.php';?>


</body>
</html>