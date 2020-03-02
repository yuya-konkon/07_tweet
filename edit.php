<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam("id", $id);
$stmt->execute();

$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tweet) {
  header('Location: index,php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $content = $_POST['content'];
  $errors = [];

if ($content == '') {
  $errors['content'] = '本文が未入力です。';
}

if ($content == $tweet['content']) {
  $errors['content'] = "本文が変更されていません";
}

  if ($title == '') {
    $errors['title'] = 'タスク名を入力してください。';
  }

  if ($title == $plan['title']) {
    $errors['title'] = 'タスク名が変更されていません。';
  }

  if (empty($errors)) {
    $dbh = connectDb();
    $sql = "update tweets set content = :content, created_at = now() where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':content',$content);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: index.php');
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <h1>tweetの編集</h1>
  <a href="index.php">戻る</a>
  <?php if ($errors) :?>
    <ul class="error-list">
      <?php foreach ($errors as $error) :?>
      <li>
        <?php echo h($error) ; ?>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif ; ?>
  <form action="" method="post">
    <label for="body">本文</label><br>
    <textarea name="body" id="" cols="30" rows="5" placeholder=""><?php echo h($tweet['content']); ?></textarea><br>
    <input type="submit" value="編集する">
  </form>
</body>

</html>