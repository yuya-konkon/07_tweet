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
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <h1><?php echo h($tweet['content']); ?></h1>
  <a href="index.php">戻る</a><br>
  <ul class="show-list">
    <li>
      [#<?php echo h($tweet['id']); ?>]
      <?php echo h($tweet['content']); ?><br>
      投稿日時:<?php echo h($tweet['created_at']); ?>
      <?php if ($tweet['good'] == 0) : ?>
        <a href="good.php?id=<?php echo h($tweet['id']) . " &good=0"; ?>" class="good-list"><?php echo '☆'; ?></a>
      <?php else : ?>
        <a href="good.php?id=<?php echo h($tweet['id']) . " &good=1"; ?>" class="good-list"><?php echo '★'; ?></a>
      <?php endif; ?>
      <a href="edit.php?id=<?php echo h($tweet['id']); ?>">[編集]</a>
      <hr>
    </li>
  </ul>
</body>

</html>