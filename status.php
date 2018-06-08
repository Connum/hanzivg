<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Current status of characters (complete CJK)</title>
	<style type="text/css">
		* {
			font-family: stheiti, simhei, "apple lisong", "Microsoft JhengHei", "hiragino kaku gothic pro", "ms gothic", sans-serif;
		}
		.hanzi {
			color: green;
		}
		.animhanzi {
			color: orange;
		}
		.kanji {
			color: red;
		}
	</style>
</head>
<body>
<?php
$codeBlocks = array(
	(object)array(
		'name' => 'CJK Unified Ideographs',
		'range_from' => '4E00',
		'range_to' => '9FFF',
		'comment' => 'Common'
	),
	(object)array(
		'name' => 'CJK Unified Ideographs Extension A',
		'range_from' => '3400',
		'range_to' => '4DBF',
		'comment' => 'Rare'
	),
	(object)array(
		'name' => 'CJK Unified Ideographs Extension B',
		'range_from' => '20000',
		'range_to' => '2A6DF',
		'comment' => 'Rare, historic'
	),
	(object)array(
		'name' => 'CJK Unified Ideographs Extension C',
		'range_from' => '2A700',
		'range_to' => '2B73F',
		'comment' => 'Rare, historic'
	),
	(object)array(
		'name' => 'CJK Unified Ideographs Extension D',
		'range_from' => '2B740',
		'range_to' => '2B81F',
		'comment' => 'Uncommon, some in current use'
	),
	(object)array(
		'name' => 'CJK Unified Ideographs Extension E',
		'range_from' => '2B820',
		'range_to' => '2CEAF',
		'comment' => 'Rare, historic'
	),
	(object)array(
		'name' => 'CJK Compatibility Ideographs',
		'range_from' => 'F900',
		'range_to' => 'FAFF',
		'comment' => 'Duplicates, unifiable variants, corporate characters'
	),
	(object)array(
		'name' => 'CJK Compatibility Ideographs Supplement',
		'range_from' => '2F800',
		'range_to' => '2FA1F',
		'comment' => 'Unifiable variants'
	),
);

foreach ($codeBlocks as $block) {
	print '<h1>' . $block->name . '</h1>' . PHP_EOL;
	$start = hexdec($block->range_from);
	$end = hexdec($block->range_to);
	for ($i=$start; $i<$end; $i++) {
		$d = substr("00000" . dechex($i),-5);

		if (is_file('hanzi/' . $d . '.svg')) {
			$class = 'hanzi';
		} else if (is_file('animhanzi/' . $d . '.svg')) {
			$class = 'animhanzi';
		} else if (is_file('kanji/' . $d . '.svg')) {
			$class = 'kanji';
		} else {
			continue;
			$class = '';
		}

		print '<span class="' . $class . '">' . mb_convert_encoding('&#' . $i . ';', 'UTF-8', 'HTML-ENTITIES') . ' (' . $d . ')' . '</span> | ';
	}
}
?>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	$('span').css({cursor: 'pointer'}).on('click', function(ev) {
		window.open('compare.php?hanzi=' + $(this).text().split(' ')[0]);
	});
</script>

</body>
</html>