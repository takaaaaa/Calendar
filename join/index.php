<?php
session_start();

if(!empty($_POST)){
  //エラー項目の確認
  if($_POST['name'] == ''){
    $error['name'] = 'blank';
  }
  if($_POST['mail'] == ''){
    $error['mail'] = 'blank';
  }
  if(strlen($_POST['pass']) < 4){
    $error['pass'] = 'length';
  }
  if($_POST['pass'] == ''){
    $error['pass'] = 'blank';
  }

  if(empty($error)){
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }

}

if(!empty($_GET)) {
	if ($_GET['action'] == 'rewrite'){
	  $_POST = $_SESSION['join'];
	}
}



?>

<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <link rel="stylesheet" href="../css/style.css">
    <title>新規会員登録</title>
  </head>
  <body id="Form">
    <div class="wrap">
      <div class="inner">
        <p class="img"><img src="../img/login.png" width="80"></p>
        <h1>新規会員登録</h1>
        <form action="" method="post">
        <dl>
          <dt>ユーザー名<font color="red">*</font></dt>
          <dd>
            <input type="text" name="name" size="35" maxlength="255"
                value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'): "";?>">
            <?php if(!empty($error['name']) && $error['name'] == 'blank'): ?>
            <p><font color="red">* ユーザー名を入力してください</font></p>
            <?php endif; ?>
          </dd>
          <dt>メールアドレス<font color="red">*</font></dt>
          <dd>
            <input type="text" name="mail" size="35" maxlength="255"
                value="<?php echo isset($_POST['mail'])?htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8'): "";?>">
            <?php if(!empty($error['mail']) && $error['mail'] == 'blank'): ?>
              <p><font color="red">* メールアドレスを入力してください</font></p>
            <?php endif; ?>
            <?php if(!empty($error['mail']) && $error['mail'] == 'duplicate'): ?>
              <p><font color="red">* 指定されたメールアドレスは既に登録されています</font></p>
            <?php endif; ?>
          </dd>
          <dt>パスワード<font color="red">*</font><span style="font-size: 1.2rem"> (4文字以上)</span></dt>
          <dd>
            <input type="password" name="pass" size="10" maxlength="20"
                value="<?php echo isset($_POST['pass'])?htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8'): "";?>">
            <?php if(!empty($error['pass']) && $error['pass'] == 'blank'): ?>
              <p><font color="red">* パスワードを入力してください</font></p>
            <?php endif; ?>
            <?php if(!empty($error['pass']) && $error['pass'] == 'length'): ?>
              <p><font color="red">* パスワードは４文字以上で入力してください。</font></p>
            <?php endif; ?>
          </dd>
        </dl>
        <div class="btn"><input type="submit" value="入力内容を確認"></div>
        </form>
      </div>
    </div>
  </body>
</html>