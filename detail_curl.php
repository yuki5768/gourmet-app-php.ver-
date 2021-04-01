<?php
if (!empty($shop_id)) { //shop_idの存在チェック
	$url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=5f60e3892fb0b479&id=" . $shop_id . "&format=json";
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
