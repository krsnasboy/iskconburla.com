<?php
declare(strict_types=1);

function _hf_load_parts(): array {
	static $parts = null;
	if ($parts !== null) return $parts;
	$path = __DIR__ . '/../admin/headerfooter.html';
	$html = @file_get_contents($path) ?: '';
	$style = '';
	$header = '';
	$mobileMenu = '';
	$overlay = '';
	$footer = '';
	$script = '';
	if ($html !== '') {
		if (preg_match('/<style[^>]*>([\s\S]*?)<\/style>/i', $html, $m)) {
			$style = $m[0];
		}
		if (preg_match('/<header[\s\S]*?<\/header>/i', $html, $m)) {
			$header = $m[0];
		}
		if (preg_match('/<div class="mobile-menu"[\s\S]*?<\/div>\s*/i', $html, $m)) {
			$mobileMenu = $m[0];
		}
		if (preg_match('/<div class="menu-overlay"[\s\S]*?<\/div>/i', $html, $m)) {
			$overlay = $m[0];
		}
		if (preg_match('/<footer[\s\S]*?<\/footer>/i', $html, $m)) {
			$footer = $m[0];
		}
		if (preg_match('/<script[\s\S]*?<\/script>\s*<\/body>/i', $html, $m)) {
			// strip closing body from capture
			$script = preg_replace('/<\/body>$/i', '', $m[0]);
		}
	}
	$parts = [
		'style' => $style,
		'header' => $header . "\n" . $mobileMenu . $overlay,
		'footer' => $footer,
		'script' => $script,
	];
	return $parts;
}

function render_public_head_assets(): void {
	$p = _hf_load_parts();
	// Print inline style from headerfooter
	if (!empty($p['style'])) {
		echo $p['style'];
	}
}

function render_public_header(): void {
	$p = _hf_load_parts();
	echo $p['header'];
}

function render_public_footer(): void {
	$p = _hf_load_parts();
	echo $p['footer'];
	// append scripts necessary for header/footer behavior
	if (!empty($p['script'])) {
		echo $p['script'];
	}
} 
