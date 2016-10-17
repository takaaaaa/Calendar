<?php
session_start();
require('../data/config.php');

if(!isset($_SESSION['join'])){
  header('Location: index.php');
  exit();
}

  //登録処理をする
  //%s 引数を文字列と扱いセットする
  $sql = sprintf('INSERT INTO users SET name="%s", mail="%s", pass="%s"',
    mysqli_real_escape_string($db, $_SESSION['join']['name']),
    mysqli_real_escape_string($db, $_SESSION['join']['mail']),
    mysqli_real_escape_string($db, sha1($_SESSION['join']['pass']))
  );
  mysqli_query($db, $sql) or die(mysqli_error($db));
  mysqli_close($db);

  unset($_SESSION['join']);

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
				  <p>ユーザー登録が完了しました。</p>
				  <p class="btn-n"><a href="../calendar/">ログインする</a></p>
				</div>
			</div>
    </body>
  </html>