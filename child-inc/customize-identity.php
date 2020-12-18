<?php
//-----------------------------------------------------------------------------
// MODS
//-----------------------------------------------------------------------------

define('CHILD_MOD_IDENT_LOGO_ABOVE', 'ident_logo_above');
define('CHILD_MOD_IDENT_ALT_TITLE', 'ident_alt_title');
define('CHILD_MOD_IDENT_ALT_DESC', 'ident_alt_desc');

$CHILD_MOD_IDENTITY_DEFAULTS = array (
	CHILD_MOD_IDENT_LOGO_ABOVE => false,
	CHILD_MOD_IDENT_ALT_TITLE => '',
	CHILD_MOD_IDENT_ALT_DESC => '',
);

//-----------------------------------------------------------------------------
// CUSTOMIZER
//-----------------------------------------------------------------------------
function child_add_identity_controls($wp_customize, $def) {

	// Extend
	$section = 'title_tagline';

	$priority = 45;

	$id = CHILD_MOD_IDENT_LOGO_ABOVE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'priority' => $priority++,
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Logo Above Title', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_IDENT_ALT_TITLE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_text',
	));
	$wp_customize->add_control($id, array(
		'priority' => $priority++,
		'type' => 'textarea',
		'settings' => $id,
		'section' => $section,
		'label' => __('Display Title', 'kuiper-twentyseventeen'),
		'description' => __('Alternate site title for display purposes.
Unlike the identity setting, you can use basic HTML here to customize appearance.
Leave empty for default.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_IDENT_ALT_DESC;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_text',
	));
	$wp_customize->add_control($id, array(
		'priority' => $priority++,
		'type' => 'textarea',
		'settings' => $id,
		'section' => $section,
		'label' => __('Display Tagline', 'kuiper-twentyseventeen'),
		'description' => __('Alternate tagline for display purposes.
Unlike the identity setting, you can use basic HTML here to customize appearance.
Leave empty for default.', 'kuiper-twentyseventeen'),
	));

	$wp_customize->add_setting('idtx-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Info($wp_customize, 'idtx-info', array(
		'priority' => $priority++,
		'section' => $section,
		'label' => '<i><b>' . __('Notes.', 'teknomatic') . '</b> ' . __('The following variables may be used above to represent dynamic values:',
		'kuiper-twentyseventeen') . '</i><br/><br/>' .
		child_get_variable_text('%VARNAMES%'),
	)));

	// PARTIAL REFRESH
	if (isset($wp_customize->selective_refresh)) {

		// Partial refresh where possible
		$id = CHILD_MOD_IDENT_ALT_TITLE;
		$wp_customize->get_setting($id)->transport = 'postMessage';
		$wp_customize->selective_refresh->add_partial($id, array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'child_get_header_title',
		));

		$id = CHILD_MOD_IDENT_ALT_DESC;
		$wp_customize->get_setting($id)->transport = 'postMessage';
		$wp_customize->selective_refresh->add_partial($id, array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'child_get_header_desc',
		));
	}

}
//-----------------------------------------------------------------------------
// INLINE CSS
//-----------------------------------------------------------------------------
function child_get_identity_inline_css($mods) {

	$css = '';

	if ($mods[CHILD_MOD_IDENT_LOGO_ABOVE]) {
$css .= <<<CSS
	.custom-logo-link	{
		display: block;
	}
CSS;
	}
	
	return $css;
}
//-----------------------------------------------------------------------------

?>