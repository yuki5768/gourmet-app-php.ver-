<?php
if (!empty($_GET['lat'] && $_GET['lng'])) { //経度と緯度の存在チェック
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
} else {
	header('Location: location.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>検索範囲選択</title>
<meta charset="utf-8">
</head>
<body>
<h2>検索範囲を選択してください</h2>
<p>※最大25件まで検索できます</p>
<p>※範囲を選択しない場合3000m以内の飲食店を自動的に検索します。</p>
<form action="shops_register.php" method="POST">
<p><input type="hidden" name="lat" value=<?php echo $lat; ?>></p>
<p><input type="hidden" name="lng" value=<?php echo $lng; ?>></p>
<select name="range">
<option value="">検索範囲</option>
<option value="1">300m以内</option>
<option value="2">500m以内</option>
<option value="3">1000m以内</option>
<option value="4">2000m以内</option>
<option value="5">3000m以内</option>
</select>
<p><input type="submit" value="検索"></p>
</form>
</body>
</html>
