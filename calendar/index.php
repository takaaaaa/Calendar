
<?php
session_start();

require('../data/config.php');


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/lib.js"></script>
		<title>スケジュール帳</title>
</head>

<body id="Cal">
<div class="wrap">
<div class="inner">
<h1><?php echo htmlspecialchars($_SESSION['login']['name'], ENT_QUOTES, 'UTF-8'); ?>のカレンダー</h1>

	<form method='POST' action='' name='post01'>
	<p class='prev' onClick='keisan(-1)'>前へ</p>
<?php
	//年月選択リストを表示する
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
		$ym_select = $_POST["target_date"];
		$y = mb_substr($ym_select, 0, 4);
	  $m = mb_substr($ym_select, 5, 2);
	  echo "<input type='text' id='target_date' name='target_date' value='{$ym_select}'>";
	} else {
    // 現在の年月を取得する
    $ym_now = date("Ym");//20160401
    $y = substr($ym_now, 0, 4);
    $m = substr($ym_now, 4, 2);
    echo "<input type='text' id='target_date' name='target_date' value='{$y}年{$m}月'>";
	}
?>
	<p class='next' onClick='keisan(1)'>次へ</p>
	</form>


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
    $link = "index.php?ymd=%04d%02d%02d";
    //引数に指定した値を指定の形式にフォーマットした文字列を取得します
    // 今日が土曜日の場合の処理
    if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
        // 週を終了
        echo "<td><a class='blue' href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
        echo "</tr>";

        // 次の週がある場合は新たな行を準備
        if (checkdate($m, $d + 1, $y)) {
            echo "<tr>";
        }
    } elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0) {
      echo "<td><a class='red' href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
    } else {
      echo "<td><a href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
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
		echo "<div class='img'>";
		echo "<h2>{$img_num}月</h2>";
		echo "<img src='../img/{$m}.png'>";
		echo "</div>";
	?>

<br>

<?php  require 'schedule.php';?>
<!-- #inner --></div>
<!-- #wrap --></div>
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
	 //クリアボタンを押したときかつ、クリアした予定以外の他の予定があるとき
	 if($('.hide').length && $('.hide2').length) {
	 	$(".hide2").each(function() {
	 		var txt = $(this).text();
	 		var txt_r = txt.replace( /[^\u\l\d]/g , "" ) ;

	 		$('td a').each(function() {

	 			var $href = $(this).attr('href');
	 			if ($href.indexOf(txt_r) != -1) {
	 				$(this).parent('td').addClass("yellow");
	 			}
	 		});
	 	});
	 } else if($('.hide').length > 0 && $('.hide2').length == 0 && $('.hide3').length == 0) {
	 	//保存ボタンを押したとき
	 	$(".hide").each(function() {
	 		var txt = $(this).text();
	 		var txt_r = txt.replace( /[^\u\l\d]/g , "" ) ;

	 		$('td a').each(function() {

	 			var $href = $(this).attr('href');
	 			if ($href.indexOf(txt_r) != -1) {
	 				$(this).parent('td').addClass("yellow");
	 			}
	 		});
	 	});
	 	//クリアボタンを押したときかつ、クリアした予定以外の他の予定がないとき
	  } else if ($('.hide').length && $('.hide3').length) {
	  	console.log("foo");
	  	$(".yellow").addClass("foo");
	  }

	 // var cont = $("textarea").text();
	 // $('td a').each(function() {
	 // 	var $href = $(this).attr('href');
	 // 	if ($href.indexOf(str) != -1) {
	 // 		if(!cont == "")
	 // 		$(this).parent('td').addClass("yellow");
	 // 	}
	 // });
</script>
</body>
</html>