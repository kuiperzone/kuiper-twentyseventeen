<?php
//-----------------------------------------------------------------------------
// MODS
//-----------------------------------------------------------------------------

define('CHILD_MOD_COL_HDR_BKGND', 'col_hdr_bkgnd');

define('CHILD_MOD_COL_MENU_OVERRIDE', 'col_menu_override');
define('CHILD_MOD_COL_MENU_BKGD', 'col_menu_bkgd');
define('CHILD_MOD_COL_MENU_TEXT', 'col_menu_text');
define('CHILD_MOD_COL_MENU_BORDER', 'col_menu_border');

define('CHILD_MOD_COL_MAIN_OVERRIDE', 'col_main_override');
define('CHILD_MOD_COL_MAIN_BKGND', 'col_main_bkgnd');

define('CHILD_MOD_COL_HEADING_OVERRIDE', 'col_heading_override');
define('CHILD_MOD_COL_H13', 'col_h13');
define('CHILD_MOD_COL_H46', 'col_h46');
define('CHILD_MOD_COL_ENTRY_TITLE', 'col_entry_title');

define('CHILD_MOD_COL_LINK_OVERRIDE', 'col_link_override');
define('CHILD_MOD_COL_LINK_TEXT', 'col_link_text');
define('CHILD_MOD_COL_LINK_HOVER', 'col_link_hover');

define('CHILD_MOD_COL_PRE_OVERRIDE', 'col_pre_override');
define('CHILD_MOD_COL_PRE_BKGD', 'col_pre_bkgd');
define('CHILD_MOD_COL_PRE_TEXT', 'col_pre_text');
define('CHILD_MOD_COL_CODE_BKGD', 'col_code_bkgd');
define('CHILD_MOD_COL_CODE_TEXT', 'col_code_text');

define('CHILD_MOD_COL_FTR_OVERRIDE', 'col_ftr_override');
define('CHILD_MOD_COL_FTR_BKGD', 'col_ftr_bkgd');
define('CHILD_MOD_COL_FTR_TEXT', 'col_ftr_text');
define('CHILD_MOD_COL_FTR_BORDER', 'col_ftr_border');

$CHILD_MOD_COLORS_DEFAULTS = array (

	CHILD_MOD_COL_HDR_BKGND => '#000000',
	
	CHILD_MOD_COL_MENU_OVERRIDE => false,
	CHILD_MOD_COL_MENU_BKGD => '#000000',
	CHILD_MOD_COL_MENU_TEXT => '#ffffff',
	CHILD_MOD_COL_MENU_BORDER => true,
	
	CHILD_MOD_COL_MAIN_OVERRIDE => false,
	CHILD_MOD_COL_MAIN_BKGND => '#eeeeee',
	
	CHILD_MOD_COL_HEADING_OVERRIDE => false,
	CHILD_MOD_COL_H13 => '#777777',
	CHILD_MOD_COL_H46 => '#999999',
	CHILD_MOD_COL_ENTRY_TITLE => '#777777',

	CHILD_MOD_COL_LINK_OVERRIDE => false,
	CHILD_MOD_COL_LINK_TEXT => '#387289',
	CHILD_MOD_COL_LINK_HOVER => '#888888',

	CHILD_MOD_COL_PRE_OVERRIDE => false,
	CHILD_MOD_COL_PRE_BKGD => '#e5e5e5',
	CHILD_MOD_COL_PRE_TEXT => '#1a1a1a',
	CHILD_MOD_COL_CODE_BKGD => '#e5e5e5',
	CHILD_MOD_COL_CODE_TEXT => '#1f377f',

	CHILD_MOD_COL_FTR_OVERRIDE => false,
	CHILD_MOD_COL_FTR_BKGD => '#000000',
	CHILD_MOD_COL_FTR_TEXT => '#ffffff',
	CHILD_MOD_COL_FTR_BORDER => true,
);

//-----------------------------------------------------------------------------
// CUSTOMIZER
//-----------------------------------------------------------------------------
function child_add_colors_controls($wp_customize, $def) {

	// Extend
	$section = 'colors';

	$id = CHILD_MOD_COL_HDR_BKGND;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Header Background', 'kuiper-twentyseventeen'),
		'description' => __('Background color of header area. This will be hidden by a header image, but is useful if no image is used.', 'kuiper-twentyseventeen'),
	)));

	// MENU
	$wp_customize->add_setting('comn-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'comn-info', array(
		'section' => $section,
		'label' => __('Primary Menu', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_MENU_OVERRIDE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Override Menu Colors', 'kuiper-twentyseventeen'),
		'description' => __('Check to override with colors below.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_COL_MENU_BKGD;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Menu Background', 'kuiper-twentyseventeen'),
		'description' => __('Primary menu background color.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_MENU_TEXT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Menu Text', 'kuiper-twentyseventeen'),
		'description' => __('Primary menu text color.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_MENU_BORDER;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Border Line', 'kuiper-twentyseventeen'),
		'description' => __('The default primary menu shows thin horizontal border lines. Its color is set by the theme.
Uncheck to hide this. Useful if setting background color explicitly.', 'kuiper-twentyseventeen'),
	));

	// CONTENT BACKGROUND
	$wp_customize->add_setting('cobk-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'cobk-info', array(
		'section' => $section,
		'label' => __('Content Background', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_MAIN_OVERRIDE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Override Background Color', 'kuiper-twentyseventeen'),
		'description' => __('Check to override content background color. The foreground color remains set by the color scheme above.
		If you wish to set a dark color, then ensure "Dark Scheme" is also set.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_COL_MAIN_BKGND;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Background Color', 'kuiper-twentyseventeen'),
		'description' => __('Background color of content area.', 'kuiper-twentyseventeen'),
	)));


	// HEADINGS
	$wp_customize->add_setting('cohs-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'cohs-info', array(
		'section' => $section,
		'label' => __('Headings', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_HEADING_OVERRIDE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Override Heading Colors', 'kuiper-twentyseventeen'),
		'description' => __('Check to override with colors below.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_COL_ENTRY_TITLE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Page &amp; Post Title', 'kuiper-twentyseventeen'),
		'description' => __('Post and page title color.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_H13;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Headings 1-3', 'kuiper-twentyseventeen'),
		'description' => __('Headings text color for h1 to h3.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_H46;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Headings 4-6', 'kuiper-twentyseventeen'),
		'description' => __('Headings text color for h4 to h6.', 'kuiper-twentyseventeen'),
	)));


	// LINKS
	$wp_customize->add_setting('colk-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'colk-info', array(
		'section' => $section,
		'label' => __('Content Links', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_LINK_OVERRIDE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Override Link Color', 'kuiper-twentyseventeen'),
		'description' => __('Check to override with colors below.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_COL_LINK_TEXT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Link Text', 'kuiper-twentyseventeen'),
		'description' => __('Color for link text. Applies in post and page content only.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_LINK_HOVER;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Link Hover', 'kuiper-twentyseventeen'),
		'description' => __('Color for link hover.', 'kuiper-twentyseventeen'),
	)));


	// PREFORMATTED
	$wp_customize->add_setting('copr-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'copr-info', array(
		'section' => $section,
		'label' => __('Preformatted Text', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_PRE_OVERRIDE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Override Preformatted Colors', 'kuiper-twentyseventeen'),
		'description' => __('Check to override with colors below.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_COL_PRE_BKGD;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Preformatted Background', 'kuiper-twentyseventeen'),
		'description' => __('Background color for preformatted blocks.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_PRE_TEXT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Preformatted Text', 'kuiper-twentyseventeen'),
		'description' => __('Text color for preformatted blocks.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_CODE_BKGD;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Code Background', 'kuiper-twentyseventeen'),
		'description' => __('Background color for code blocks.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_CODE_TEXT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Code Text', 'kuiper-twentyseventeen'),
		'description' => __('Text color for code blocks.', 'kuiper-twentyseventeen'),
	)));

	// FOOTER
	$wp_customize->add_setting('coft-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Heading($wp_customize, 'coft-info', array(
		'section' => $section,
		'label' => __('Footer', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_FTR_OVERRIDE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Override Footer Colors', 'kuiper-twentyseventeen'),
		'description' => __('Check to override with colors below.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_COL_FTR_BKGD;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Footer Background', 'kuiper-twentyseventeen'),
		'description' => __('Footer area background color.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_FTR_TEXT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tkctrl-' . $id, array(
		'settings' => $id,
		'section' => $section,
		'label' => __('Footer Text', 'kuiper-twentyseventeen'),
		'description' => __('Footer area text color.', 'kuiper-twentyseventeen'),
	)));

	$id = CHILD_MOD_COL_FTR_BORDER;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Border Line', 'kuiper-twentyseventeen'),
		'description' => __('The default footer shows a thin horizontal border line. Its color is set by the theme.
Uncheck to hide this. Useful if setting background color explicitly.', 'kuiper-twentyseventeen'),
	));
}
//-----------------------------------------------------------------------------
// INLINE CSS
//-----------------------------------------------------------------------------
function child_get_colors_inline_css($mods) {

	$css = '';

$css .= <<<CSS
	.site-header,
	.single-featured-image-header {
		background-color: {$mods[CHILD_MOD_COL_HDR_BKGND]} !important;
	}
CSS;

	if ($mods[CHILD_MOD_COL_MENU_OVERRIDE]) {
$css .= <<<CSS
	.navigation-top,
	.main-navigation,
	.main-navigation ul {
		background-color: {$mods[CHILD_MOD_COL_MENU_BKGD]} !important;
	}

	.navigation-top,
	.menu-toggle,
	.main-navigation,
	.main-navigation a	{
		color: {$mods[CHILD_MOD_COL_MENU_TEXT]} !important;
	}
CSS;
	}
	
	if (!$mods[CHILD_MOD_COL_MENU_BORDER]) {
$css .= <<<CSS
		.navigation-top {
			border: none;
		}
CSS;
	}

	if ($mods[CHILD_MOD_COL_MAIN_OVERRIDE]) {
$css .= <<<CSS
	.site-content-contain {
		background-color: {$mods[CHILD_MOD_COL_MAIN_BKGND]} !important;
	}
CSS;
	}

	if ($mods[CHILD_MOD_COL_HEADING_OVERRIDE]) {
$css .= <<<CSS
	.entry-header .entry-title {
		color: {$mods[CHILD_MOD_COL_ENTRY_TITLE]} !important;
	}

	.entry-content h1,
	.entry-content h2,
	.entry-content h3 {
		color: {$mods[CHILD_MOD_COL_H13]};
	}
	
	.entry-content h4,
	.entry-content h5,
	.entry-content h6 {
		color: {$mods[CHILD_MOD_COL_H46]};
	}
CSS;
	}
	
	if ($mods[CHILD_MOD_COL_LINK_OVERRIDE]) {
$css .= <<<CSS
	.entry-content p a:not(.author-link) {
		color: {$mods[CHILD_MOD_COL_LINK_TEXT]};
	}
	
	.site-content-contain a:focus,
	.site-content-contain a:hover,
	.site-content-contain a:focus .nav-title,
	.site-content-contain a:hover .nav-title {
		color: {$mods[CHILD_MOD_COL_LINK_HOVER]} !important;
	}
CSS;
	}

	if ($mods[CHILD_MOD_COL_PRE_OVERRIDE]) {
$css .= <<<CSS
	pre,
	.wp-block-preformatted pre {
		color: {$mods[CHILD_MOD_COL_PRE_TEXT]} !important;
		background-color: {$mods[CHILD_MOD_COL_PRE_BKGD]} !important;
	}
	
	.wp-block-code {
		color: {$mods[CHILD_MOD_COL_CODE_TEXT]} !important;
		background-color: {$mods[CHILD_MOD_COL_CODE_BKGD]} !important;
	}
CSS;
	}

	if ($mods[CHILD_MOD_COL_FTR_OVERRIDE]) {
$css .= <<<CSS
	.site-footer,
	.site-info a,
	.footer-widget-1 *,
	.footer-widget-2 * {
		background-color: {$mods[CHILD_MOD_COL_FTR_BKGD]} !important;
		color: {$mods[CHILD_MOD_COL_FTR_TEXT]} !important;
	}
CSS;
	}

	if (!$mods[CHILD_MOD_COL_FTR_BORDER]) {
$css .= <<<CSS
		.site-footer {
			border: none;
		}
CSS;
	}

	return $css;
}
//-----------------------------------------------------------------------------

?>