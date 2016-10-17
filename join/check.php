<?php
session_start();

if(!isset($_SESSION['join'])){
  header('Location: index.php');
  exit();
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
        <dl>
          <dt>ユーザー名</dt>
          <dd>
            <?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES, 'UTF-8'); ?>
          </dd>
          <dt>メールアドレス</dt>
          <dd>
            <?php echo htmlspecialchars($_SESSION['join']['mail'], ENT_QUOTES, 'UTF-8'); ?>
          </dd>
          <dt>パスワード</dt>
          <dd>
            【表示されません】
          </dd>
        </dl>
        <div class="btn-area">
          <p class="btn-n"><a href="index.php?action=rewrite">やり直し</a></p>
          <p class="btn-n"><a href="thanks.php">登録</a></p>
        </div>
      </div>
    </div>
  </body>
</html>

