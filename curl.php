<?php
if (!empty($lat) && !empty($lng) && !empty($range)) { //検索条件チェック
	$order = 4;
	$url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=api_key&lat=" . $lat . "&lng=" . $lng . "&range=" . $range . "&order=" . $order . "&count=25" . "&format=json";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$results = curl_exec($ch);
	$json = json_decode(file_get_contents($url));
	curl_close($ch);
} else {
	header('Location: location.php');
}
?>
