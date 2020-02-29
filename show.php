<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();
$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tweet) {
  header('Location: index.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>tweet</title>
</head>

<body>
  <h1><?php echo h($tweet['content']); ?></h1>
  <a href="index.php">戻る</a>
  [#<?php echo h($tweet['id']); ?>]
</body>

</html>