<?php
//-----------------------------------------------------------------------------
// MODS
//-----------------------------------------------------------------------------

define('CHILD_MOD_FTR_TEXT_CONTENT', 'ftr_text_content');
define('CHILD_MOD_FTR_TEXT_ALIGN', 'ftr_text_align');
define('CHILD_MOD_FTR_SHOW_CREDIT', 'ftr_show_credit');

$CHILD_MOD_FOOTER_DEFAULTS = array (
	CHILD_MOD_FTR_TEXT_CONTENT => '<b>Copyright %SITE-NAME% %NOW-YEAR%</b>. All rights reserved.',
	CHILD_MOD_FTR_TEXT_ALIGN => 'center',
	CHILD_MOD_FTR_SHOW_CREDIT => true,
);

//-----------------------------------------------------------------------------
// CUSTOMIZER
//-----------------------------------------------------------------------------
function child_add_footer_controls($wp_customize, $def) {

	$section = 'child_footer';
	$wp_customize->add_section($section, array(
		'title' => __('Footer', 'kuiper-twentyseventeen'),
		'priority' => 61,
	));

	$id = CHILD_MOD_FTR_TEXT_CONTENT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_text',
	));
	$wp_customize->add_control($id, array(
		'type' => 'textarea',
		'settings' => $id,
		'section' => $section,
		'label' => __('Custom Text', 'kuiper-twentyseventeen'),
		'description' => __('Custom footer text. You can use basic HTML here to finely customize appearance.', 'kuiper-twentyseventeen'),
	));

	$wp_customize->add_setting('frtx-info', array('sanitize_callback' => 'child_sanitize_label'));
	$wp_customize->add_control(new Child_Customize_Info($wp_customize, 'frtx-info', array(
		'section' => $section,
		'label' => '<i><b>' . __('Notes.', 'teknomatic') . '</b> ' . __('The following variables may also be used to represent dynamic values:',
		'kuiper-twentyseventeen') . '</i><br/><br/>' .
		child_get_variable_text('%VARNAMES%'),
	)));

	$id = CHILD_MOD_FTR_TEXT_ALIGN;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_halign',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'select',
		'settings' => $id,
		'section' => $section,
		'label' => __('Alignment', 'Alignment'),
		'description' => __('Horizontal alignment of text. Default: ', 'Alignment') . $def[$id],
		'choices' => child_get_select_halign(),
	));

	$id = CHILD_MOD_FTR_SHOW_CREDIT;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Theme Credit', 'kuiper-twentyseventeen'),
	));

	// PARTIAL REFRESH
	if (isset($wp_customize->selective_refresh)) {

		// Partial refresh where possible
		$id = CHILD_MOD_FTR_TEXT_CONTENT;
		$wp_customize->get_setting($id)->transport = 'postMessage';
		$wp_customize->selective_refresh->add_partial($id, array(
			'selector' => '.site-info',
			'container_inclusive' => false,
			'render_callback' => 'child_get_footer_text',
		));
	}

}
//-----------------------------------------------------------------------------
// INLINE CSS
//-----------------------------------------------------------------------------
function child_get_footer_inline_css($mods) {

	$css = '';

$css .= <<<CSS
	.site-info {
		text-align: {$mods[CHILD_MOD_FTR_TEXT_ALIGN]};
	}
CSS;

	return $css;
}
//-----------------------------------------------------------------------------

?>