(function() {
	var STANDALONE = !!window.HANZIVG_TEST_STANDALONE;

	function getErrList(svg) {
		return svg.parentNode.nextElementSibling;
	}

	function addError(svg, errorMessage, elements) {
		svg.errorCount++;
		if (STANDALONE) {
			if (elements && elements.length) {
				errorMessage = '[<span class="highlighter">' + Array.from(elements).map(function(n) {
					return '#' + n.id;
				}).join('</span>, <span class="highlighter">') + '</span>]:<br>' + errorMessage;
			}
			var li = document.createElement('li');
			
			li.innerHTML = errorMessage;

			var errList = getErrList(svg);
			errList.classList.add('error');
			errList.appendChild(li);

		} else {
			window.logEvent && window.logEvent({
				message: errorMessage,
				type: 'error',
				elements: elements,
				context: 'test'
			});
		}
	}

	function testIf(svg, assumption, errorMessage) {
		if (!assumption) {
			addError(svg, errorMessage);
		}		
	}

	function testElements(svg, selector, errorMessage) {
		var elements = typeof selector === 'function'
						? Array.from(svg.querySelectorAll('*')).filter(selector)
						: svg.querySelectorAll(selector);
		if (elements.length) {
			addError(svg, errorMessage, elements);
		}
	}

	function testNoElements(svg, selector, errorMessage) {
		var elements = typeof selector === 'function'
						? Array.from(svg.querySelectorAll('*')).filter(selector)
						: svg.querySelectorAll(selector);
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

	function testDuplicateAttribute(svg, attribute, errorMessage) {
		var elements = svg.querySelectorAll('[' + attribute + ']'),
			exists = {};
		for (var i = 0; i < elements.length; i++) {
			var el = elements[i],
				att = el.getAttribute(attribute);
			if (typeof exists[att] !== 'undefined') {
				addError(svg, errorMessage.replace('%att', att), el);
			}
			exists[att] = true;
		}
	}

	function runTests(svg, ctx) {
		svg.errorCount = 0;
		var charId = ctx ? ctx.charId : svg.parentNode.parentNode.dataset.charid;

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
			function(el) {
				return el.matches('g[id^="hvg:StrokePaths_"] > g:first-child:last-child,g[id^="kvg:StrokePaths_"] > g:first-child:last-child')
						&& el.hasAttribute('kvg:element');
			},
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

		testDuplicateAttribute(svg,
			'id',
			'Duplicate id %att'
		);
		
		testElements(svg,
			function(el) {
				var att = el.getAttribute('kvg:element');
				return att && att.indexOf('㇐') >= 0
			},
			'char "㇐" is used in <code>kvg:element</code> but should only be used as <code>kvg:type</code>. Should use "一" instead'
		);

		testElements(svg,
			function(el) {
				if (!el.hasAttribute('id')) return false;

				var allEls = Array.from(svg.querySelectorAll(el.tagName)).filter(function(e) {
					return !(e.matches('svg > g') || e.matches('svg > g > g'))
				}),
					elIdx = allEls.indexOf(el);
				if (elIdx < 0) return false;
				return !(new RegExp('-[^d]+' + (elIdx + 1) + '$')).test(el.getAttribute('id'))
			},
			'ID does not match node position!'
		);

		testElements(svg,
			function(el) {
				if (!el.hasAttribute('id')) return false;
				return !(new RegExp('^[hk]vg:(StrokePaths_|StrokeNumbers_)?' + charId)).test(el.getAttribute('id'))
			},
			'ID does not match character code!'
		);
		
		testElements(svg,
			function(el) {
				var att = el.getAttribute('kvg:type');
				return att && att.indexOf('一') >= 0
			},
			'char "一" is used in <code>kvg:type</code> but should only be used as <code>kvg:element</code>. Should use "㇐" instead'
		);

		// don't test this in format.html, as it will be fixed when making changes and exporting, anyway
		if (STANDALONE) {
			testElements(svg,
				'[id$="-' + ['VtLst', 'HyougaiKaisho', 'KaishoVt3', 'HzFst', 'Insatsu', 'MidFst', 'KaishoVtLst', 'Kaisho', 'Jinmei', 'Hyougai', 'KaishoVt4'].join('"], [id$="-') + '"]',
				'KanjiVG variant contained in ID string'
			);			
		}

		testElements(svg,
			function(el) {
				return el.tagName === 'path' && !el.getAttribute('kvg:type')
			},
			'path missing <code>kvg:type</code> attribute'
		);

		testElements(svg,
			function(el) {
				return el.hasAttribute('kvg:part')
			},
			'using deprecated <code>kvg:part</code> attribute. Should be replaced by <code>kvg:number</code>'
		);

		testElementsMatchCount(svg,
			'text',
			'path',
			'number count does not match path count'
		);

		testNoElements(svg,
			function (el) {
				return el.hasAttribute('kvg:radical')
			},
			'No radical defined'
		);
	}

	// when run in test.php
	if (STANDALONE) {
		var svgs = document.querySelectorAll('.svg svg'),
			totalErrors = 0,
			errorFiles = 0;
		for (var i = 0; i < svgs.length; i++) {
			var svg = svgs[i];

			runTests(svg);

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
			s.textContent = 'Yippee, no errors found! :-)';
			document.body.appendChild(s);
		} else {
			s.classList.add('error');
			s.textContent = 'Found ' + totalErrors + ' error' + (totalErrors === 1 ? '' : 's') + ' in ' + errorFiles + ' file' + (errorFiles === 1 ? '' : 's') + ':';
		}
		document.body.insertBefore(s, document.body.firstChild);
	}

	window.HANZIVG_runTests = runTests;
})();