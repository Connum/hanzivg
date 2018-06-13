<?php
	/*
	 * compare SVGs from different directories
	 * and the Hanzi in Simplified / Traditonal / Japanese fonts
	 * Links to Arch Chinese, Yellow Bridge and LINE Dict to compare their representation and stroke order
	 */

	// the following two functions have been taken from
	// https://stackoverflow.com/questions/9361303/can-i-get-the-unicode-value-of-a-character-or-vise-versa-with-php#answer-27444149

	// code point to UTF-8 string
	function unichr($i) {
	    return iconv('UCS-4LE', 'UTF-8', pack('V', $i));
	}

	// UTF-8 string to code point
	function uniord($s) {
	    return unpack('V', iconv('UTF-8', 'UCS-4LE', $s))[1];
	}

	$h = $_GET['hanzi'];
	$d = substr("00000" . dechex(uniord($h)),-5);

	if (isset($_GET['movefrom'])) {+
		$moveFile = $_GET['movefrom'] . '/' . $d . '.svg';
		if (is_file($moveFile)) {
			rename($moveFile, 'hanzi/' . $d . '.svg');
		}
	}

	if (empty($h)) {
		header("Location:status.php"); exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Compare Hanzi</title>
	<style type="text/css">
		.char {
			font-size: 109px;
			line-height: 109px;
			display: block;
			overflow: hidden;
			margin: 0;
		}
		.traditional {
			font-family: "apple lisong", "Microsoft JhengHei", sans-serif;
		}
		.simplified {
			font-family: stheiti, simhei, sans-serif;
		}
		.japanese {
			font-family: "hiragino kaku gothic pro", "ms gothic", sans-serif;
		}
	</style>
</head>
<body>
<?php

// get LINE Dict data
$lineData = file_get_contents('http://dict-channelgw.naver.com/stroke.dict?entry=' . urlencode($h));
if ($lineData) {
	$lineData = json_decode( $lineData );
	if (isset($lineData->data) && count($lineData->data)) {
		$firstChar = $lineData->data[0];
		$lineID = $firstChar->a;
	}
}

// get writtenchinese data 
$url = 'https://dictionary.writtenchinese.com/ajaxsearch/simsearch.action';
$fields = array(
	'searchKey' => $h
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Accept: application/json, text/javascript, */*; q=0.01',
	'Accept-Encoding: gzip, deflate, br',
	'Accept-Language: de,en-US;q=0.7,en;q=0.3',
	'Cache-Control: no-cache',
	'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
	'Pragma: no-cache',
	'Referer: https://dictionary.writtenchinese.com/',
	'User-Agent: Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0',
	'X-Requested-With: XMLHttpRequest',
));

//execute post
$result = json_decode(curl_exec($ch));

//close connection
curl_close($ch);
if (count($result->signCh)) {
	$wcId = $result->signCh[0]->pinyinsort . '/' . $result->signCh[0]->id;
}


print '<p><a href="http://www.archchinese.com/chinese_english_dictionary.html?find=' . $h . '" target="_blank">Arch Chinese</a> | <a href="https://www.yellowbridge.com/chinese/character-stroke-order.php?word=' . $h .'" target="_blank">Yellow Bridge</a>' . (isset($lineID) ? ' | <a href="http://ce.linedict.com/#/cnen/entry/' . $lineID . '" target="_blank">LINE Dict</a>' : '') . (isset($wcId) ? ' | <a href="https://dictionary.writtenchinese.com/worddetail/' . $wcId . '/1/1" target="_blank">writtenchinese</a>' : '') . ' | <a target="_blank" href="https://www.mdbg.net/chinese/dictionary?cdqchi='. $h . '">MDBG</a></p>';

print '<p>' . $d . '</p>';

/*print '<div class="mdbg"><h2>MDBG</h2>';
echo preg_replace('@href="@', 'target="_blank" href="https://www.mdbg.net/chinese/', file_get_contents('https://www.mdbg.net/chinese/dictionary-ajax?c=cdcd&i=' . $h));
print '</div>';
*/
$filename = 'hanzi/' . $d . '.svg';
if (is_file($filename)) {
	print '<h1><a href="format.html?#' . $filename . '" target="_blank">HanziVG</a></h1>';
	print '<img src="' . $filename . '" />';
}

$filename = 'animhanzi/' . $d . '.svg';
if (is_file($filename)) {
	print '<h1><a href="format.html?#' . $filename . '" target="_blank">AnimHanzi</a></h1>';
	print '<img src="' . $filename . '" />';
}

$filename = 'kanji/' . $d . '.svg';
if (is_file($filename)) {
	print '<h1><a href="format.html?#' . $filename . '" target="_blank">KanjiVG</a></h1>';
	print '<img src="' . $filename . '" />';
	print '<br><a href="?movefrom=kanji&hanzi=' . $h . '">copy to HanziVG</a>';
}

print '<h2>Simplified</h2><p class="char simplified">' . $h . '</p>';
print '<h2>Traditional</h2><p class="char traditional">' . $h . '</p>';
print '<h2>Japanese</h2><p class="char japanese">' . $h . '</p>';

?>

</body>
</html>