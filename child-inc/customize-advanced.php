<?php
//-----------------------------------------------------------------------------
// MODS
//-----------------------------------------------------------------------------

define('CHILD_MOD_THEME_MAX_WIDTH', 'adv_theme_max_width');
define('CHILD_MOD_THEME_FEATURED_POS', 'adv_theme_featured_pos');
define('CHILD_MOD_THEME_FEATURED_HIDE_HOME', 'adv_theme_featured_hide_home');
define('CHILD_MOD_THEME_META', 'adv_theme_meta');

define('CHILD_MOD_URLS_FONT1', 'adv_urls_font1');
define('CHILD_MOD_URLS_FONT2', 'adv_urls_font2');

define('CHILD_MOD_THEME_COMMENTS', 'adv_theme_comments');
define('CHILD_MOD_THEME_CLEANUP', 'adv_theme_cleanup');

$CHILD_MOD_ADVANCED_DEFAULTS = array (

	CHILD_MOD_THEME_MAX_WIDTH => 1000, // <- same as 2017 width
	CHILD_MOD_THEME_FEATURED_POS => 'default',
	CHILD_MOD_THEME_FEATURED_HIDE_HOME => false,
	CHILD_MOD_THEME_META => true,
	
	CHILD_MOD_URLS_FONT1 => '',
	CHILD_MOD_URLS_FONT2 => '',

	CHILD_MOD_THEME_COMMENTS => 'enabled',
	CHILD_MOD_THEME_CLEANUP => false,
);

//-----------------------------------------------------------------------------
// CUSTOMIZER
//-----------------------------------------------------------------------------
function child_add_advanced_controls($wp_customize, $def) {

	$section = 'child_about';
	$wp_customize->add_section($section, array(
		'title' => __('Advanced', 'kuiper-twentyseventeen'),
	));

	// About
	$wp_customize->add_setting('avix-info', array('sanitize_callback' => 'teknomatic_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Info($wp_customize, 'avix-info', array(
		'section' => $section,
		'label' => child_get_about_html(),
	)));

	// Options
	$wp_customize->add_setting('avop-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'avop-info', array(
		'section' => $section,
		'label' => __('Advanced Options', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_THEME_MAX_WIDTH;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'absint',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'number',
		'settings' => $id,
		'section' => $section,
		'label' => __('Max Width', 'kuiper-twentyseventeen'),
		'description' => __('Maximum page width in px. Suggest 1000 - 1350. Default: ', 'kuiper-twentyseventeen') . $def[$id],
		'input_attrs' => array(
			'min' => 1000,
			'max' => 5000,
			'step' => 50,
	)));

	$id = CHILD_MOD_THEME_FEATURED_POS;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_featured_pos',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'select',
		'settings' => $id,
		'section' => $section,
		'label' => __('Featured Image', 'kuiper-twentyseventeen'),
		'description' => __('Select how featured images are shown on posts and pages. This does NOT apply to the home page.', 'kuiper-twentyseventeen'),
		'choices' => child_get_select_featured_pos(),
	));

	$id = CHILD_MOD_THEME_FEATURED_HIDE_HOME;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Hide Featured on Home', 'kuiper-twentyseventeen'),
		'description' => __('If checked, the featured image will always be hidden on the home page.
Useful where the image is used to populate the "og:image" meta tag only.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_THEME_META;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Use Open Graph Meta', 'kuiper-twentyseventeen'),
		'description' => __('Includes Open Graph meta tags. If checked, the featured image is used for "og:image".', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_URLS_FONT1;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_url',
	));
	$wp_customize->add_control($id, array(
		'type' => 'text',
		'settings' => $id,
		'section' => $section,
		'label' => __('Font URL 1', 'kuiper-twentyseventeen'),
		'description' => __('Custom font style-sheet URL. Leave empty for web-safe fonts. Example:',
			'kuiper-twentyseventeen') . ' https://fonts.googleapis.com/css?family=Inconsolata',
	));

	$id = CHILD_MOD_URLS_FONT2;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_url',
	));
	$wp_customize->add_control($id, array(
		'type' => 'text',
		'settings' => $id,
		'section' => $section,
		'label' => __('Font URL 2', 'kuiper-twentyseventeen'),
		'description' => __('Example:', 'kuiper-twentyseventeen') . ' /wp-content/themes/child/fonts/font-awesome.css',
	));

	$id = CHILD_MOD_THEME_COMMENTS;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_comments',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'select',
		'settings' => $id,
		'section' => $section,
		'label' => __('Comments', 'kuiper-twentyseventeen'),
		'description' => __('Global comment section override.', 'kuiper-twentyseventeen'),
		'choices' => child_get_select_comments(),
	));

	$id = CHILD_MOD_THEME_CLEANUP;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('RESET THEME ON PUBLISH', 'kuiper-twentyseventeen'),
		'description' => __('To reset this theme\'s settings, check this option and click "Publish".
Then reload the page in the browser. Otherwise do not check this option.', 'kuiper-twentyseventeen'),
	));

}
//-----------------------------------------------------------------------------
function child_get_select_featured_pos() {

	return array(
		'default' => __('Default', 'kuiper-twentyseventeen'),
		'traditional' => __('Traditional', 'kuiper-twentyseventeen'),
		'none' => __('None', 'kuiper-twentyseventeen'),
	);
}
//-----------------------------------------------------------------------------
function child_sanitize_featured_pos($input) {

	if (key_exists($input, child_get_select_featured_pos())) {
		return $input;
	}

	return 'default';
}
//-----------------------------------------------------------------------------
add_filter( 'the_content', 'child_insert_featured_image', 10, 2 );
function child_insert_featured_image( $content ) {

	// Inserts "traditional" feature image
	$featured = '';

	global $CHILD_GMODS;

	if ($CHILD_GMODS[CHILD_MOD_THEME_FEATURED_POS] == 'traditional') {

		// This logic is same as parent header.php
		$id = get_queried_object_id();
		
		if ( ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) && has_post_thumbnail( $id ) ) {
			
			$featured .= '<div style="margin-bottom:2.5em;">';
			$featured .= get_the_post_thumbnail( $id, 'full' );
			$featured .= '</div>';
		}
	}
	
	return $featured . $content;
}
//-----------------------------------------------------------------------------
function child_get_select_comments() {

	return array(
		'enabled' => __('Enabled', 'kuiper-twentyseventeen'),
		'disabled-show' => __('Disabled (Show Existing)', 'kuiper-twentyseventeen'),
		'disabled-hide' => __('Disabled (Hide Existing)', 'kuiper-twentyseventeen'),
	);
}
//-----------------------------------------------------------------------------
function child_sanitize_comments($input) {

	if (key_exists($input, child_get_select_comments())) {
		return $input;
	}

	return 'enabled';
}
//-----------------------------------------------------------------------------
add_action('customize_save_after', 'child_reset_theme');
function child_reset_theme() {

	// An easy way to do it withou requiring javascript
	if (get_theme_mod(CHILD_MOD_THEME_CLEANUP, false)) {
		remove_theme_mods();
	}
	
}
//-----------------------------------------------------------------------------
function child_get_about_html() {
	
	$name = CHILD_THEME_NAME;
	$version = CHILD_THEME_VERSION;
	$parent = CHILD_THEME_PARENT;
	$theme_url = CHILD_THEME_URL;
	$author = CHILD_AUTHOR;
	$author_url = CHILD_AUTHOR_URL;

	$base_url = get_stylesheet_directory_uri();
	$readme_url = $base_url . '/readme.txt';
	$img_url = $base_url . '/assets/child-image.png';

$output = <<<HTML

	<p><img src="{$img_url}" width="100%" alt="{$name} Image"/></p>
	<p><b>VERSION:</b> {$version}</p>

	<p>A highly customizable child theme of {$parent}.</p>

	<p>Theme URL: <a href="{$theme_url}" target="_blank">{$name}</a></p>

	<p>By <a href="{$author_url}" target="_blank">{$author}</a>.
See also the <a href="{$readme_url}" target="_blank">readme file</a> for copyright,
licensing and credit information.</p>
HTML;

	return $output;
}
//-----------------------------------------------------------------------------
// INLINE CSS
//-----------------------------------------------------------------------------
function child_get_advanced_inline_css($mods) {

	$css = '';
	
$css .= <<<CSS
	.wrap,
	body:not(.home) .content-area {
		max-width: {$mods[CHILD_MOD_THEME_MAX_WIDTH]}px !important;
	}
CSS;

	if ($mods[CHILD_MOD_THEME_FEATURED_POS] != 'default') {
		// We override feature image here by hiding
		// parent image in CSS, and using add_filter() above.
$css .= <<<CSS
	.single-featured-image-header {
		display: none;
	}
CSS;
	}

	if ($mods[CHILD_MOD_THEME_FEATURED_HIDE_HOME]) {
		// Strange - parent display header image in different way on home page.
$css .= <<<CSS
	.home .panel-image {
		display: none;
	}
CSS;
	}
	
	return $css;
}
//-----------------------------------------------------------------------------

?>