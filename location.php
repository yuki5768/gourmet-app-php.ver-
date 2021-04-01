<?php
session_start();
if (!empty($_SESSION['token'])) {
	$_SESSION = array();
	setcookie(session_name(), '', time() - 1800, '/'); //30分でセッション切断
	session_destroy(); //セッション削除
}
$url = 'search.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>位置情報許可</title>
</head>
<body>
<script>
function getElement() {
	var element = document.getElementById("get")
	navigator.geolocation.getCurrentPosition(positionSuccess, positionError);

	function positionSuccess(position) { //成功時の処理
		getmap = confirm("飲食店検索時に位置情報の利用を許可しますか？"); //取得開始のアラート
		if (getmap == true) {
			var lat = position.coords.latitude; //緯度
			var lng = position.coords.longitude; //経度
			if (lat && lng) {
				location.href="search.php?lat=" + lat + "&lng=" + lng; //取得したらリダイレクト
			}
		} else {
			alert("またのご利用お待ちしています。");
		}
	}

	function positionError(error) { //失敗時の処理
		alert("位置情報を使用するためにはアクセスを許可してください。");
	}
}
</script>
<h1>飲食店検索アプリ</h1>
<button onclick="getElement()" id="get">現在地周辺の飲食店を探す</button>
</body>
</html>
