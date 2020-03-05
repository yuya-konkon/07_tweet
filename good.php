<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $id = $_GET['id'];
  $good = $_GET['good'];
  if ($good == "1") {
    $good_value = 1;
    $sql = "update tweets set good = 0 where id = :id";
  } else {
    $good_value = 0;
    $sql = "update tweets set good = 1 where id = :id";
  }

  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $moto = $_SERVER[HTTP_REFERER];
  $moto_str = array(
    'yahoo.co.jp',
    'yahoo.com'
  );
  $count = count($moto_str);
  for ($i = 0; $i < $count; $i++) {
    if (stristr($moto, $moto_str[$i])) {
      $yes = 1;
    }
    if ($yes) {
      break;
    }
  }
  if ($yes) {
    header("Location: http://あなたのURL/1.html");
  } else {
    header("Location: http://あなたのURL/2.html");
  }

  if ($url == 'index.php') {
    header('Location: index.php');
    exit;
  } else {
    header('Location: show.php');
    exit;
  }
}
