<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>スケジュール帳</title>
</head>
<body>
<?php
	if (isset($_POST["y"])) {
	    // 選択された年月を取得する
	    $y = intval($_POST["y"]);
	    $m = intval($_POST["m"]);
	} else {
	    // 現在の年月を取得する
	    $ym_now = date("Ym");
	    //substr — 文字列の一部分を返す
	    $y = substr($ym_now, 0, 4);//0番目から4つ
	    $m = substr($ym_now, 4, 2);//4番目から2つ
	}
	?>
	<!-- 年月選択リストを表示する -->
	<form method='POST' action=''>
	<!-- 年 -->
	<select name='y'>
	<?php
		for ($i = $y - 2; $i <= $y + 2; $i++) {
		    echo "<option";
		    if ($i == $y) {
		        echo " selected ";
		    }
		    echo ">$i</option>";
		}
	?>
	</select>年

	<!-- 月 -->
	<select name='m'>
	<?php
	for ($i = 1; $i <= 12; $i++) {
	    echo "<option";
	    if ($i == $m) {
	        echo " selected ";
	    }
	    echo ">$i</option>";
	}
	?>
	</select>月
	<input type='submit' value='表示' name='sub1'>
	</form>
<table border="1">
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
		// 1日の曜日を取得
		$wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));

		// その数だけ空白を表示
		for ($i = 1; $i <= $wd1; $i++) {
		    echo "<td>&nbsp;</td>";
		}

		$d = 1;
		while (checkdate($m, $d, $y)) {
		    // 日付リンクの表示
		    $link = "schedule.php?ymd=%04d%02d%02d";
		    //引数に指定した値を指定の形式にフォーマットした文字列を取得します
		    echo "<td><a href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";

		    // 今日が土曜日の場合の処理
		    if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
		        // 週を終了
		        echo "</tr>";

		        // 次の週がある場合は新たな行を準備
		        if (checkdate($m, $d + 1, $y)) {
		            echo "<tr>";
		        }
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
<p>
	<!-- 2桁の10進数 -->
	<?php $img_num = sprintf('%02d', $m);
		echo "<img src='img/{$img_num}.jpg'>"
	?>
</p>
</body>
</html>