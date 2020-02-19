<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

// ツイート一覧の表示
$sql = "select * from tweets order by created_at desc";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $content = $_POST['content'];

  $error = [];

  if ($content == '') {
    $error['content'] = 'ツイート内容を入力してください';
  }

  if (empty($error)) {
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規投稿</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <h1>新規ツイート</h1>

  <!-- ここにエラー表示 -->
  <?php if ($error) : ?>
    <ul class="error-list">
      <li>
        <?php echo h($error['content']); ?>
      </li>
    </ul>
  <?php endif; ?>

  <!-- 新規ツイートフォーム -->
  <form action="" method="post">
    <label for="content">ツイート内容</label><br>
    <textarea name="content" id="" cols="30" rows="5" placeholder="いまどうしてる？"></textarea><br>
    <input type="submit" value="投稿">
  </form>

  <!-- tweet一覧表示 -->
  <h2>Tweet一覧</h2>
  <?php if (count($tweets)) : ?>
    <ul class="tweet-list">
      <?php foreach ($tweets as $tweet) : ?>
        <li>
          <a href="show.php"><?php echo h($tweet['content']); ?><br></a>
          投稿日時:<?php echo h($tweet['created_at']); ?>
          <?php if ($tweet['good'] == 0) : ?>
            <a href="good.php?id=<?php echo h($tweet['id']) ?>" class="good-list"><?php echo '☆'; ?></a>
          <?php else : ?>
            <a href="good.php?id=<?php echo h($tweet['id']) ?>" class="good-list"><?php echo '★'; ?></a>
          <?php endif; ?>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</body>

</html>