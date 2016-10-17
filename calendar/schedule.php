<?php
// 年月日を取得する
if (isset($_GET["ymd"])) {
    //スケジュールの年月日を取得する
    $ymd = basename($_GET["ymd"]);
    $cy = intval(substr($ymd, 0, 4));
    $cm = intval(substr($ymd, 4, 2));
    $cd = intval(substr($ymd, 6, 2));
    $disp_ymd = "{$cy}年{$cm}月{$cd}日のスケジュール";

    // スケジュールデータを取得する
    $sql = sprintf('SELECT contents FROM schedule WHERE date = "%d"',
       mysqli_real_escape_string($db, $_GET['ymd'])
       );
    $re =mysqli_query($db, $sql) or die(mysqli_error($db));
    $kekka =mysqli_fetch_array($re);
    if (!$kekka[0] == "") {
      $schedule = $kekka[0];
    } else {
      $schedule = "";
    }
    $sql  = 'SELECT date FROM schedule WHERE CHAR_LENGTH(contents) >=1';
    $re =mysqli_query($db, $sql) or die(mysqli_error($db));
    //$kekka =mysqli_fetch_array($re);
    while ($row = mysqli_fetch_array($re)) {
      echo '<div class="hide">';
      echo $row[0]."<br>";
      echo '</div>';
     }
    $hoge = $_GET["ymd"];
} else {
  $ymd_now = date("Ymd");
  $y = substr($ymd_now, 0, 4);
  $m = substr($ymd_now, 4, 2);
  $d = substr($ymd_now, 6, 2);
  $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

  $sql = sprintf('SELECT contents FROM schedule WHERE date = "%d"',
    mysqli_real_escape_string($db, $ymd_now)
    );
     $re =mysqli_query($db, $sql) or die(mysqli_error($db));
     $kekka =mysqli_fetch_array($re);
     if (!$kekka[0] == "") {
       $schedule = $kekka[0];
     } else {
       $schedule = "";
     }
  $hoge = $ymd_now;
}

// スケジュールを更新する
if (isset($_POST["action"]) and $_POST["action"] == "保存") {
  //テーブルに曜日が存在しているか確認する。
  $sql = sprintf('SELECT date,contents FROM schedule WHERE date IN("%d")',
     mysqli_real_escape_string($db, $hoge)
  );
  $re =mysqli_query($db, $sql) or die(mysqli_error($db));
  $kekka =mysqli_fetch_array($re);
  //曜日が存在していたら内容を更新する
  if($kekka[0]) {
    $sql = sprintf('UPDATE schedule SET contents="%s" WHERE date ="%d"',
     mysqli_real_escape_string($db, $_POST['contents']),
     mysqli_real_escape_string($db, $hoge)
    );
  }
  //曜日が存在していなかったら内容を挿入する
  else {
    $sql = sprintf('INSERT INTO schedule SET date="%d", contents="%s"',
      mysqli_real_escape_string($db, $hoge),
      mysqli_real_escape_string($db, $_POST['contents'])
    );
  }
  mysqli_query($db, $sql) or die(mysqli_error($db));
  //$scheduleに予定を代入する。
  $sql = sprintf('SELECT contents FROM schedule WHERE date = "%d"',
    mysqli_real_escape_string($db, $hoge)
  );
    $re =mysqli_query($db, $sql) or die(mysqli_error($db));
    $kekka =mysqli_fetch_array($re);
    $schedule = $kekka[0];
  $sql  = 'SELECT date FROM schedule WHERE CHAR_LENGTH(contents) >=1';
  $re =mysqli_query($db, $sql) or die(mysqli_error($db));
  //$kekka =mysqli_fetch_array($re);
  while ($row = mysqli_fetch_array($re)) {
    echo '<div class="hide">';
    echo $row[0]."<br>";
    echo '</div>';
   }
  mysqli_close($db);
}

// スケジュールをリセットする
if (isset($_POST["clear"]) and $_POST["clear"] == "クリア") {
  //カラムを削除する。
  $sql = sprintf('DELETE FROM schedule WHERE date ="%d"',
     mysqli_real_escape_string($db, $hoge)
  );
  mysqli_query($db, $sql) or die(mysqli_error($db));
  $sql  = 'SELECT date FROM schedule WHERE CHAR_LENGTH(contents) >=1';
  $re =mysqli_query($db, $sql) or die(mysqli_error($db));
  if($row = mysqli_fetch_array($re)){
    while ($row = mysqli_fetch_array($re)) {
      echo '<div class="hide2">';
      echo $row[0]."<br>";
      echo '</div>';
     }
   } else {
    echo '<div class="hide3"></div>';
   }
   mysqli_close($db);
  //$scheduleの予定を削除する。
  $schedule = "";
}
if (!isset($_GET["ymd"])) {
    echo '<div class="foo">';
} elseif (isset($_POST["target_date"])) {
    echo '<div class="foo">';
} else {
    echo '<div id="s_wrap" class="foo">';
}
?>


  <form method="POST" action="" name="sc">
    <table>
      <tr>
       <td class="memo"><?php echo $disp_ymd ?></td>
      </tr>
      <tr>
        <td>
        <textarea rows="10" cols="50" name="contents"><?php echo $schedule; ?></textarea>
        </td>
      </tr>
      <tr>
        <td class="memo">
        <input type="submit" id="act" name="action" value="保存">
        <input type="submit"  id="clear" name="clear" value="クリア">
        </td>
      </tr>
    </table>
  </form>
</div>

