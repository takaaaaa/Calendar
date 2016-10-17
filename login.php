<?php
session_start();

require('data/config.php');

if(!empty($_POST)){
  //ログインの処理
  if($_POST['mail'] != '' && $_POST['pass'] != ''){
    $sql = sprintf('SELECT * FROM users WHERE mail="%s" AND pass="%s"',
      mysqli_real_escape_string($db, $_POST['mail']),
      mysqli_real_escape_string($db, sha1($_POST['pass']))//sha1 暗号化
    );
    $re = mysqli_query($db, $sql) or die(mysqli_error($db));
    if($table = mysqli_fetch_assoc($re)){
      //ログイン成功
      //nameをカレンダーに表示
      mysqli_close($db);
      $_SESSION['login']['name']= $table['name'];
      header('Location: calendar/index.php');
      exit();
    }else{
      $error['login'] = 'failed';
    }
    mysqli_close($db);
  }else{
    $error['login'] = 'blank';
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <link rel="stylesheet" href="css/style.css">
    <title>ログイン</title>
  </head>
  <body id="Form">
    <div class="wrap">
      <div class="inner">
        <p class="img"><img src="img/login.png" width="80"></p>
        	<h1>ログイン</h1>
        	<p>入会手続きがまだの方は<a href="join/" class="line">こちら</a>からどうぞ。</p>
        	<form action="login.php" method="post">
        		<dl>
              <dt>メールアドレス</dt>
              <dd>
                <input type="text" name="mail" size="35" maxlength="255"
                    value="<?php echo isset($_POST['mail'])?htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8'): "";?>">
                <?php if(!empty($error['login']) && $error['login'] == 'blank'): ?>
                  <p><font color="red">* メールアドレスとパスワードを<br>ご記入ください</font></p>
                <?php endif; ?>
                <?php if(!empty($error['login']) && $error['login'] == 'failed'): ?>
                  <p><font color="red">* ログインに失敗しました。正しくご記入ください。</font></p>
                <?php endif; ?>
              </dd>
              <dt>パスワード</dt>
              <dd>
                <input type="password" name="pass" size="35" maxlength="255"
                    value="<?php echo isset($_POST['pass'])?htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8'): "";?>">
              </dd>
            </dl>
        		<div class="btn"><input type="submit" value="ログイン"></div>
        	</form>
      </div>
    </div>
  </body>
</html>