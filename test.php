<!DOCTYPE html>
<html>
<head>
	<title>Char integrity tests</title>
	<style type="text/css">
		.svg {
			display: none;
		}

		.status.error {
			color: red;
		}

		.status.ok {
			color: green;
		}
	</style>
</head>
<body>

<?php

foreach(glob('hanzi/*.svg') as $file) {
	$svg = file_get_contents($file);
	$errors = array();

	echo '<section class="unit" data-file="' . $file . '" data-charid="' . basename($file, '.svg') . '">';
	echo '<strong>' . basename($file) . '</strong>';
	echo '<div class="svg">' . $svg . '</div>';
	echo '<ul class="status"></ul>';
	echo '</section>';
}
?>
<script type="text/javascript">
window.HANZIVG_TEST_STANDALONE = true;
</script>
<script type="text/javascript" src="test.js"></script>
</body>
</html>