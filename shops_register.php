<?php
if (empty($_SESSION['token'])) {
	session_start();
}
if (!empty($_POST['lat']) && !empty($_POST['lng']) && !empty($_POST['range'])) { //検索条件チェック
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$range = $_POST['range'];
	require_once('curl.php'); //curl呼び出し
	$token = rand(0, 100) . uniqid();
	require_once('connect.php'); //DB接続
	if (!empty($json->results->shop)) { //飲食店が見つかった場合の処理
		$shops = $json->results->shop;
		foreach ($shops as $shop) {
			// 値を文字列に変換↓
			$shop_id = strval($shop->id);
			$name = strval($shop->name);
			$address = strval($shop->address);
			$station_name = strval($shop->station_name);
			$logo_image = strval($shop->logo_image);

			// 飲食店情報をDBへ登録↓
			$sql = 'INSERT INTO shops_data(shop_id, name, address, station_name, logo_image, token, created_at) VALUES(:shop_id, :name, :address, :station_name, :logo_image, :token, now())';
			$stmt = $dbh->prepare($sql);
			$stmt->bindValue(':shop_id', $shop_id);
			$stmt->bindValue(':name', $name);
			$stmt->bindValue(':address', $address);
			$stmt->bindValue(':station_name', $station_name);
			$stmt->bindValue(':logo_image', $logo_image);
			$stmt->bindValue(':token', $token);
			$stmt->execute();
		}
		$_SESSION['token'] = $token;
		$count = count($shops);
		$message = '飲食店が' . $count . '件見つかりました。';
	} else { //飲食店が見つからなかった場合の処理
		$message = '飲食店が見つかりませんでした。';
	}
} else { //検索条件が送られてこなかった場合の処理
	$message = '検索条件が不十分です。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>検索結果</title>
<meta charset="utf-8">
</head>
<body>
<h1>検索結果</h1>
<?php if (!empty($_POST['lat']) && !empty($_POST['lng']) && !empty($_POST['range'])): ?> <!-- 検索条件が全て送られてきた場合 -->
<?php if (!empty($json->results->shop)): ?> <!-- 飲食店が見つかった場合 -->
<?php echo $message; ?>
<p><a href="result.php">店舗一覧へ</a></p>
<?php else: ?> <!-- 飲食店が見つからなかった場合 -->
<?php echo $message; ?>
<?php endif; ?>
<?php else: ?> <!-- 検索条件が不十分だった場合 -->
<?php echo $message; ?>
<?php endif; ?>
<p><a href="location.php">最初に戻る</a></p>
</body>
</html>
