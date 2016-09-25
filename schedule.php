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
    $file_name = "data/{$ymd}.txt";
    if (file_exists($file_name)) {
        $schedule = file_get_contents($file_name);
    } else {
        $schedule = "";
    }
} else {
  $ymd_now = date("Ymd");
  $y = substr($ymd_now, 0, 4);
  $m = substr($ymd_now, 4, 2);
  $d = substr($ymd_now, 6, 2);
  $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

  $file_name = "data/{$ymd_now}.txt";
  if (file_exists($file_name)) {
      $schedule = file_get_contents($file_name);
  } else {
      $schedule = "";
  }
}

// スケジュールを更新する
if (isset($_POST["action"]) and $_POST["action"] == "保存") {
    $schedule = htmlspecialchars($_POST["schedule"], ENT_QUOTES, "UTF-8");

    // スケジュールが入力されたか調べて処理を分岐
    if (!empty($schedule)) {
        // 入力された内容でスケジュールを更新
        file_put_contents($file_name, $schedule);
    } else {
        // スケジュールが空の場合はファイルを削除
        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
}

// スケジュールをリセットする
if (isset($_POST["clear"]) and $_POST["clear"] == "クリア") {
    $schedule = htmlspecialchars($_POST["schedule"], ENT_QUOTES, "UTF-8");

    if (!empty($schedule)) {
      $schedule = "";
        // スケジュールが空の場合はファイルを削除
      if (file_exists($file_name)) {
          unlink($file_name);
      }
    } else {
        return;
    }
}
?>

<form method="POST" action="">
  <table>
    <tr>
     <td class="memo"><?php echo $disp_ymd ?></td>
    </tr>
    <tr>
      <td>
      <textarea rows="10" cols="50" name="schedule"><?php echo $schedule; ?></textarea>
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
