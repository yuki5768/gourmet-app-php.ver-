<?php
session_start();
if (!empty($_SESSION['token'])) {
	if (!empty($_GET['page'])) { //SQL用のページ数取得
		$page = ($_GET['page'] - 1) * 5;
	} else {
		$page = 0;
	}
	require_once('connect.php'); //DB接続

	//検索条件にヒットした飲食店をDBから5件ずつ呼び出す
	$sql1 = 'SELECT * FROM shops_data WHERE token = :token LIMIT 5 OFFSET :page';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':token', $_SESSION['token']);
	$stmt1->bindValue(':page', $page, PDO::PARAM_INT);
	$stmt1->execute();
	$result = $stmt1->fetchAll();

	//検索で見つかった飲食店の数をDBから呼び出す
	$sql2 = 'SELECT * FROM shops_data WHERE token = :token';
	$stmt2 = $dbh->prepare($sql2);
	$stmt2->bindValue(':token', $_SESSION['token']);
	$stmt2->execute();
	$count = $stmt2->rowCount();

	define('MAX', '5'); //1ページに表示する飲食店の数
	$max_page = ceil($count / MAX); //全体のページ数
	if (!empty($_GET['page'])) { //ページング用のページ数取得
		$now = $_GET['page'];
	} else {
		$now = 1;
	}
} else {
	header('Location: location.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>店舗一覧</title>
<meta charset="utf-8">
</head>
<body>
<h1>店舗一覧</h1>
<table border="1">
<tr>
<th>店舗名</th>
<th>アクセス</th>
<th>画像</th>
</tr>
<?php foreach ($result as $shop): ?> <!-- 取得した飲食店データをループ処理で表示 -->
<tr>
<td><a href="detail.php?shop_id=<?php echo $shop['shop_id']; ?>"><?php echo $shop['name']; ?></a></td> <!-- 店名 -->
<td>
<p>住所：<?php echo $shop['address']; ?></p>
<p>最寄駅：<?php echo $shop['station_name']; ?></p>
</td>
<td><img src="<?php echo $shop['logo_image']; ?>"></td> <!-- 店舗画像 -->
</tr>
<?php endforeach; ?>
</table>
<?php if ($now > 1): ?> <!-- 現在のページが1より大きい場合に「前へ」にリンクを付ける -->
<a href="result.php?page=<?php $now - 1; ?>">前へ</a>
<?php else: ?> <!-- 現在のページが1以下の場合「前へ」にリンクを付けない -->
<?php echo '前へ'; ?>
<?php endif; ?>
<?php for ($i = 1; $i <= $max_page; $i++): ?> <!-- ページ数を表示するためのループ処理 -->
<?php if ($i == $now): ?> <!-- 現在のページ数にはリンクを付けない -->
<?php echo $now; ?>
<?php else: ?> <!-- 現在以外のページ数にはリンクを付ける -->
<a href="result.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php endif; ?>
<?php endfor; ?>
<?php if ($now < $max_page):?> <!-- 現在のページが最大ページ数より小さい場合に「次へ」にリンクを付ける -->

<a href="result.php?page=<?php echo $now + 1; ?>">次へ</a>
<?php else: ?> <!-- 最終ページの場合「次へ」にリンクを付けない -->

<?php echo '次へ'; ?>
<?php endif; ?>
<p><a href="location.php">最初に戻る</a></p>
</body>
</html>
