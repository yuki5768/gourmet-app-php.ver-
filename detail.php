<?php
session_start();
if (!empty($_SESSION['token'])) { //セッションデータチェック
	if (!empty($_GET['shop_id'])) { //shop_idが送られてきた場合の処理
		$shop_id = $_GET['shop_id'];
		require_once('detail_curl.php');
		if (!empty($json->results->shop)) { //飲食店が見つかった場合の処理
			$detail = $json->results->shop;
		} else { //飲食店が見つからなかった場合の処理
			$message = '該当する飲食店が見つかりませんでした。';
		}
	} else { //shop_idが送られてこなかった場合の処理
		header('Location: location.php');
	}
} else { //セッションデータがない場合の処理
	header('Location: location.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>検索結果</title>
<meta charset="utf-8">
</head>
<body>
<h1>飲食店詳細</h1>
<?php foreach ($detail as $shop): ?> <!-- 見つかった飲食店をテーブル表示 -->
<table border="1" id="shops">
<tr>
<th>店名</th>
<th>住所</th>
<th>営業時間</th>
<th>店舗画像</th>
</tr>
<tr>
<td><?php echo $shop->name; ?></td> <!-- 店名 -->
<td><?php echo $shop->address; ?></td> <!-- 飲食店の住所 -->
<td><?php echo $shop->open; ?></td> <!-- 営業時間 -->
<td><img src="<?php echo $shop->photo->mobile->l; ?>"></td> <!-- 飲食店画像 -->
</tr>
</table>
<?php endforeach; ?>
<p><a href="<?php echo $shop->urls->pc; ?>">ホットペッパーサイトへ</a></p> <!-- ホットペッパーサイトURL -->
<p><a href="location.php">最初に戻る</a></p>
</body>
</html>
