<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

// var_dump($_SERVER);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

  $sql = "update tweets set good = :good where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':good',$good);
  $stmt->execute();
  $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);


  header('Location: index.php');
  exit;
}