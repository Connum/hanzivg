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

	echo '<section class="unit" data-file="' . $file . '">';
	echo '<strong>' . basename($file) . '</strong>';
	echo '<div class="svg">' . $svg . '</div>';
	echo '<ul class="status"></ul>';
	echo '</section>';
}
?>
<script type="text/javascript">
	function getErrList(svg) {
		return svg.parentNode.nextElementSibling;
	}

	function addError(svg, errorMessage, elements) {
		var li = document.createElement('li');
		
		if (elements && elements.length) {
			errorMessage = '[' + Array.from(elements).map(function(n) {
				return '#' + n.id;
			}).join(', ') + ']:<br>' + errorMessage;
		}
		li.innerHTML = errorMessage;

		var errList = getErrList(svg);
		errList.classList.add('error');
		errList.appendChild(li);

		svg.errorCount++;
	}

	function testIf(svg, assumption, errorMessage) {
		if (!assumption) {
			addError(svg, errorMessage);
		}		
	}

	function testElements(svg, selector, errorMessage) {
		var elements = svg.querySelectorAll(selector);
		if (elements.length) {
			addError(svg, errorMessage, elements);
		}
	}

	function testNoElements(svg, selector, errorMessage) {
		var elements = svg.querySelectorAll(selector);
		if (!elements.length) {
			addError(svg, errorMessage, elements);
		}
	}

	function testElementsMatchCount(svg, selector1, selector2, errorMessage) {
		var elements1 = svg.querySelectorAll(selector1),
		    elements2 = svg.querySelectorAll(selector2);
		if (elements1.length !== elements2.length) {
			addError(svg, errorMessage);
		}
	}

	var svgs = document.querySelectorAll('.svg svg'),
		totalErrors = 0,
		errorFiles = 0;
	for (var i = 0; i < svgs.length; i++) {
		var svg = svgs[i];
		svg.errorCount = 0;

		testIf(
			svg,
			svg.width && svg.width.baseVal.value === 109,
			'wrong or missing witdh svg attribute, expected: 109'
		);
		
		testIf(
			svg,
			svg.height && svg.height.baseVal.value === 109,
			'wrong or missing height svg attribute, expected: 109'
		);

		testIf(
			svg,
			svg.viewBox
				&& svg.viewBox.baseVal.x === 0
				&& svg.viewBox.baseVal.y === 0
				&& svg.viewBox.baseVal.width === 109
				&& svg.viewBox.baseVal.height === 109
			,
			'wrong or missing viewBox attribute on svg, expected: 0 0 109 109'
		);

		testNoElements(svg,
			'g[id^="hvg:StrokePaths_"],g[id^="kvg:StrokePaths_"]',
			'Missing StrokePaths root group'
		);

		testNoElements(svg,
			'g[id^="hvg:StrokeNumbers_"],g[id^="kvg:StrokeNumbers_"]',
			'Missing StrokePaths root group'
		);

		testNoElements(svg,
			'g[id^="hvg:StrokePaths_"] > g[kvg\\:element]:first-child:last-child,g[id^="kvg:StrokePaths_"] > g[kvg\\:element]:first-child:last-child',
			'Missing whole caracter group as only child of StrokePaths root group'
		);

		testNoElements(svg,
			'path',
			'No paths defined'
		);

		testNoElements(svg,
			'text',
			'No numbers defined'
		);
		
		testElements(svg,
			'[kvg\\:element="㇐"]',
			'char "㇐" is used in <code>kvg:element</code> but should only be used as <code>kvg:type</code>. Should use "一" instead'
		);

		testElements(svg,
			'[kvg\\:type="一"]',
			'char "一" is used in <code>kvg:type</code> but should only be used as <code>kvg:element</code>. Should use "㇐" instead'
		);

		testElements(svg,
			'[kvg\\:part]',
			'using deprecated <code>kvg:part</code> attribute. Should be replaced by <code>kvg:number</code>'
		);

		testElementsMatchCount(svg,
			'text',
			'path',
			'number count does not match path count'
		);

		testNoElements(svg,
			'[kvg\\:radical]',
			'No radical defined'
		);
		
		if(svg.errorCount === 0) {
			svg.parentNode.parentNode.remove();
		} else {
			errorFiles++;
			totalErrors += svg.errorCount;
			var hl = svg.parentNode.previousElementSibling;
			hl.innerHTML = '<a href="format.html#' +  hl.parentNode.dataset.file + '" target="_blank">' + hl.innerHTML + '</a>';
		}
	}

	var s = document.createElement('h1');
	s.classList.add('status');
	if (totalErrors === 0) {
		s.classList.add('ok');
		s.textContent = 'Yippie, no errors found! :-)';
		document.body.appendChild(s);
	} else {
		s.classList.add('error');
		s.textContent = 'Found ' + totalErrors + ' error' + (totalErrors === 1 ? '' : 's') + ' in ' + errorFiles + ' file' + (errorFiles === 1 ? '' : 's') + ':';
	}
	document.body.insertBefore(s, document.body.firstChild);
</script>
</body>
</html>