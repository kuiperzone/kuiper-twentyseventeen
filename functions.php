<?php
//-----------------------------------------------------------------------------
// Project:        KUIPER TWENTY SEVENTEEN CHILD
// Author:         Andy Thomas
// Author URI:     https://kuiper.zone/
// License:        GNU General Public License v3 or later
// License URI:    http://www.gnu.org/licenses/gpl-3.0.html
//-----------------------------------------------------------------------------

require __DIR__ . '/child-inc/constants.php';
require __DIR__ . '/child-inc/customizer.php';

// Global theme mods.
$CHILD_GMODS = child_get_theme_mods(false);

//-----------------------------------------------------------------------------
// CHILD SETUP
//-----------------------------------------------------------------------------
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' );
function child_enqueue_styles() {

	global $CHILD_GMODS;

	// Custom URLs
	$fsu = $CHILD_GMODS[CHILD_MOD_URLS_FONT1];
	
	if (!empty($fsu)) {
		wp_enqueue_style('child-theme-fonts1', esc_url_raw($fsu), array(), null);
	}

	$fsu = $CHILD_GMODS[CHILD_MOD_URLS_FONT2];
	
	if (!empty($fsu)) {
		wp_enqueue_style('child-theme-fonts2', esc_url_raw($fsu), array(), null);
	}

	// Enqueue parent (note that parent has multi style sheets)
	// This will replace OUR child (we need to enqueue explicitly also)
	wp_enqueue_style('twentyseventeen-style', get_template_directory_uri() . '/style.css' );
	
	load_theme_textdomain('kuiper-twentyseventeen');
}
//-----------------------------------------------------------------------------
add_action( 'wp_enqueue_scripts', 'child_enqueue_appended_styles', 99 );
function child_enqueue_appended_styles() {

	// EXPLICITLY ENQUEUE CHILD
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css' );
	
	// Remove unused
	wp_dequeue_style('twentyseventeen-fonts');
}
//-----------------------------------------------------------------------------
add_action('wp_head', 'child_inline_css', 99);
function child_inline_css() {
	global $CHILD_GMODS;
	echo '<style>' . child_get_inline_css($CHILD_GMODS) . '</style>';
}
//-----------------------------------------------------------------------------
add_action( 'admin_init', 'child_editor_style', 200 );
function child_editor_style() {
	add_editor_style( 'child-css/editor-style.css' );
}
//-----------------------------------------------------------------------------
add_action('wp_head', 'child_head');
function child_head() {

	global $CHILD_GMODS;

	if ($CHILD_GMODS[CHILD_MOD_THEME_META]) {

		echo '<meta property="og:url" content="' . esc_url( home_url() ) . '" />';
		echo '<meta property="og:type" content="website" />';
		
		$title = get_bloginfo('name');
		
		if (!empty($title)) {
			echo '<meta property="og:title" content="' . $title . '" />';
		}

		$desc = get_bloginfo( 'description', 'display' );

		if (!empty($desc)) {
			echo '<meta property="og:description" content="' . $desc . '" />';
		}

		$thumb = get_the_post_thumbnail_url(null, 'large');
		
		if ($thumb) {
			echo '<meta property="og:image" content="' . $thumb . '" />';
		}
	}
	
	if (is_customize_preview()) {
		// Need to ensure re-load on preview update
		$CHILD_GMODS = child_get_theme_mods(false);
	}

	$com = $CHILD_GMODS[CHILD_MOD_THEME_COMMENTS];

	if ($com == 'disabled-show' || $com == 'disabled-hide') {
		// Close comments on the front-end
		add_filter('comments_open', '__return_false', 20, 2);
		add_filter('pings_open', '__return_false', 20, 2);

		if ($com == 'disabled-hide') {
			// Hide existing comments
			add_filter('comments_array', '__return_empty_array', 10, 2);
		}
	}	
}
//-----------------------------------------------------------------------------
add_action( 'init', 'child_remove_parent_actions', 99 );
function child_remove_parent_actions() {

	// Parent has fixed width of 1000 and several filters
	// for image resize attributed. If different size, disable these.
	global $CHILD_GMODS;

	if ($CHILD_GMODS[CHILD_MOD_THEME_MAX_WIDTH] <= 1000) {
		remove_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr');
		remove_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr');
		remove_action( 'template_redirect', 'twentyseventeen_content_width');
	}
}
//-----------------------------------------------------------------------------
// CUSTOM FUNCTIONS
//-----------------------------------------------------------------------------
function child_get_theme_mods($defaults_only) {

	global $CHILD_MOD_DEFAULTS;

	$mods = array();

	if (!$defaults_only && !is_customize_preview()) {
		// Load from DB but only if are not in preview as changes
		// are not reflected with "get_theme_mods" (but are with "get_theme_mod").
		$mods = get_theme_mods();
	}

	$mods = wp_parse_args($mods, $CHILD_MOD_DEFAULTS);

	if (!$defaults_only) {

		// WORKAROUND FOR WP BUG
		// See: https://core.trac.wordpress.org/ticket/24844
		if (is_customize_preview()) {
			// Doing this kills advantage of using global array in
			// customizer, but advantage in normal viewing remains.
			foreach ($mods as $key => $value) {
				$mods[$key] = get_theme_mod($key, $mods[$key]);
			}
		}
	}

	return $mods;
}
//-----------------------------------------------------------------------------
function child_get_header_title() {

	if (is_customize_preview()) {
		// Use call rather than GMODS here because
		// this can be called with partial update.
		$text = get_theme_mod(CHILD_MOD_IDENT_ALT_TITLE, '');
	} else {
		global $CHILD_GMODS;
		$text = $CHILD_GMODS[CHILD_MOD_IDENT_ALT_TITLE];
	}
	
	if (!empty($text)) {
		return child_get_variable_text($text);
	}
	
	return get_bloginfo('name');
}
//-----------------------------------------------------------------------------
function child_get_header_desc() {

	if (is_customize_preview()) {
		// Use call rather than GMODS here because
		// this can be called with partial update.
		$text = get_theme_mod(CHILD_MOD_IDENT_ALT_DESC, '');
	} else {
		global $CHILD_GMODS;
		$text = $CHILD_GMODS[CHILD_MOD_IDENT_ALT_DESC];
	}
	
	if (!empty($text)) {
		return child_get_variable_text($text);
	}
	
	return get_bloginfo( 'description', 'display' );
}
//-----------------------------------------------------------------------------
function child_get_footer_text() {

	if (is_customize_preview()) {
		$text = child_get_variable_text(get_theme_mod(CHILD_MOD_FTR_TEXT_CONTENT, ''));
		$show_credit = get_theme_mod(CHILD_MOD_FTR_SHOW_CREDIT);
	} else {
		global $CHILD_GMODS;
		$text = child_get_variable_text($CHILD_GMODS[CHILD_MOD_FTR_TEXT_CONTENT]);
		$show_credit = $CHILD_GMODS[CHILD_MOD_FTR_SHOW_CREDIT];
	}

	if ($show_credit) {
		$text .= '<div style="font-size:smaller;">' . __('WordPress Theme', 'kuiper-twentyseventeen') .
			' : <a href="' . CHILD_THEME_URL . '" target="_blank">' .
			CHILD_THEME_NAME .'</a></div>';
	}

	return $text;
}
//-----------------------------------------------------------------------------
function child_get_variable_text($text, $sep = ', ') {

	// Performs variable replacement. If $text is '%VARNAMES%',
	// will output key names for use in customizer.

	// Designed this to work efficiently so it does not populate array multiple
	// times with same data if called in succession (hence use of static).
	static $varkey = null;

	if (!empty($text) && strpos($text, '%') !== false) {

		if ($varkey === null) {

			// Initialize key names
			$varkey = array(
				'%SITE-NAME%' => '',
				'%SITE-TAGLINE%' => '',
				'%SITE-URL%' => '',
				'%NOW-DAY%' => '',
				'%NOW-MONTH%' => '',
				'%NOW-YEAR%' => '',
				'%NOW-YMD%' => '',
			);
		}

		// Compare once
		$vflag = ($text === '%VARNAMES%');

		if (!$vflag) {

			// Assign once
			$date = getdate();

			$varkey['%SITE-NAME%'] = get_bloginfo('name');
			$varkey['%SITE-TAGLINE%'] = get_bloginfo('description');
			$varkey['%SITE-URL%'] = esc_url( home_url() );
			$varkey['%NOW-DAY%'] = $date['mday'];
			$varkey['%NOW-MONTH%'] = $date['mon'];
			$varkey['%NOW-YEAR%'] = $date['year'];
			$varkey['%NOW-YMD%'] = $date['year'] . '-' .$date['mon'] . '-' . $date['mday'];
		}

		if ($vflag) {

			// Key names only
			$s = '';
			$text = '';

			foreach ($varkey as $key => $x) {
				$text .= $s . $key;
				$s = $sep;
			}

		} else {

			// Replacement
			foreach ($varkey as $key => $value) {
				$text = str_replace($key, $value, $text);
			}
		}
	}

	return $text;
}
//-----------------------------------------------------------------------------
/*
Not used
function child_log($log) {
  
	if (WP_DEBUG === true) {
		if (is_array($log) || is_object($log)) {
			error_log(print_r($log, true));
		} else {
			error_log($log);
		}
	}
}
*/
//-----------------------------------------------------------------------------
?>
