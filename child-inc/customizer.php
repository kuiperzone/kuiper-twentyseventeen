<?php

require_once 'heading-label.php';
require_once 'info-label.php';

require_once 'customize-advanced.php';
require_once 'customize-identity.php';
require_once 'customize-colors.php';
require_once 'customize-fonts.php';
require_once 'customize-page.php';
require_once 'customize-footer.php';

$CHILD_MOD_DEFAULTS = array_merge(
	$CHILD_MOD_ADVANCED_DEFAULTS,
	$CHILD_MOD_IDENTITY_DEFAULTS,
	$CHILD_MOD_COLORS_DEFAULTS,
	$CHILD_MOD_FONTS_DEFAULTS,
	$CHILD_MOD_PAGE_DEFAULTS,
	$CHILD_MOD_FOOTER_DEFAULTS
);

//-----------------------------------------------------------------------------
// REGISTER
//-----------------------------------------------------------------------------
add_action('customize_register', 'child_customize_register');
function child_customize_register($wp_customize) {

	// Get default values
	$def = child_get_theme_mods(true);

	// Sections & priorities
	// REF: https://developer.wordpress.org/themes/customize-api/customizer-objects/#sections
	child_add_advanced_controls($wp_customize, $def);
	child_add_identity_controls($wp_customize, $def);
	child_add_colors_controls($wp_customize, $def);
	child_add_fonts_controls($wp_customize, $def);
	child_add_page_controls($wp_customize, $def);
	child_add_footer_controls($wp_customize, $def);
}
//-----------------------------------------------------------------------------
// INLINE CSS
//-----------------------------------------------------------------------------
function child_get_inline_css($mods) {
	
	$css = '';
	$css .= child_get_advanced_inline_css($mods);
	$css .= child_get_identity_inline_css($mods);
	$css .= child_get_colors_inline_css($mods);
	$css .= child_get_fonts_inline_css($mods);
	$css .= child_get_page_inline_css($mods);
	$css .= child_get_footer_inline_css($mods);
	
	return $css;
}
//-----------------------------------------------------------------------------
// FUNCTIONS
//-----------------------------------------------------------------------------
function child_parse_css_size($input) {

	// Validate '5px' = array('5','px')
	// Must be positive and case sensitive
	$bk = -1;
	$input = trim($input);
	$arr = str_split($input);
	$asz = count($arr);

	$val = '';
	$units = '';
	$rslt = array('','');

	for ($n = 0; $n < $asz; ++$n) {

		if (($arr[$n] < '0' || $arr[$n] > '9') && $arr[$n] !== '.') {
			$bk = $n;
			break;
		}

		$val .= $arr[$n];
	}

	if (is_numeric($val)) {

		if ($bk > 0) {

			// Valid so far - build units
			for ($n = $bk; $n < $asz && $n < 20; ++$n) {
				if ($arr[$n] !== ' ') {
					$units .= $arr[$n];
				}
			}

			if ($units === 'px' || $units === '%' || $units === 'em' ||
				$units === 'pt' || $units === 'rem') {
				// OK
				$rslt[0] = $val;
				$rslt[1] = $units;
			}
		}
	}

	return $rslt;

}
//-----------------------------------------------------------------------------
function child_sanitize_css_size($input) {

	// Validate '5px', '1.2em', '2rem', 20%' etc
	$p = child_parse_css_size($input);
	return $p[0] . $p[1];
}
//-----------------------------------------------------------------------------
function child_sanitize_length($input) {

	// Validate 'normal', '1.2%', or '1.2' etc
	$input = trim($input);

	// Simple number
	if (is_numeric($input)) {
		
		if ($input > 0) {
			return $input;
		}
		
		return 'normal';
	}

	if ($units === 'normal' || $units === 'initial' || $units === 'inherit') {
		return $input;
	}
	
	$p = child_parse_css_size($input);
	$temp = $p[0] . $p[1];
	
	if (!empty($temp)) {
		return $temp;
	}
	
	return 'normal';
}
//-----------------------------------------------------------------------------
function child_get_select_transform() {

	return array(
		'none' => __('None', 'kuiper-twentyseventeen'),
		'uppercase' => __('Uppercase', 'kuiper-twentyseventeen'),
		'lowercase' => __('Lowercase', 'kuiper-twentyseventeen'),
		'capitalize' => __('Capitalize', 'kuiper-twentyseventeen'),
	);
}
//-----------------------------------------------------------------------------
function child_sanitize_transform($input) {

	if (key_exists($input, child_get_select_transform())) {
		return $input;
	}

	return 'none';
}
//-----------------------------------------------------------------------------
function child_get_select_halign() {

	return array(
		'left' => __('Left', 'kuiper-twentyseventeen'),
		'center' => __('Center', 'kuiper-twentyseventeen'),
		'right' => __('Right', 'kuiper-twentyseventeen'),
	);
}
//-----------------------------------------------------------------------------
function child_sanitize_halign($input) {

	if (key_exists($input, child_get_select_halign())) {
		return $input;
	}

	return 'left';
}
//-----------------------------------------------------------------------------
function child_get_select_valign() {

	return array(
		'top' => __('Top', 'kuiper-twentyseventeen'),
		'middle' => __('Middle', 'kuiper-twentyseventeen'),
		'bottom' => __('Bottom', 'kuiper-twentyseventeen'),
	);
}
//-----------------------------------------------------------------------------
function child_sanitize_valign($input) {

	if (key_exists($input, child_get_select_valign())) {
		return $input;
	}

	return 'middle';
}
//-----------------------------------------------------------------------------
function child_sanitize_text($input) {

	return wp_kses_post(force_balance_tags(trim($input)));

}
//-----------------------------------------------------------------------------
function child_sanitize_check($input) {

	if ($input) {
		return 1;
	}

	return '';
}
//-----------------------------------------------------------------------------
function child_sanitize_label($input) {

	// Dummy for labels
	return '';
}
//-----------------------------------------------------------------------------

?>