<?php
//-----------------------------------------------------------------------------
// MODS
//-----------------------------------------------------------------------------

define('CHILD_MOD_PAGE_HOME_TITLE', 'page_home_title');
define('CHILD_MOD_PAGE_ENTRY_META', 'page_entry_meta');
define('CHILD_MOD_PAGE_RULES', 'page_rules');
define('CHILD_MOD_PAGE_LINK_UNDERLINE', 'page_link_underline');
define('CHILD_MOD_PAGE_AUTHOR_BIO', 'page_author_bio');
define('CHILD_MOD_PAGE_AUTHOR_IMAGE', 'page_author_image');
define('CHILD_MOD_PAGE_AUTHOR_WEBSITE', 'page_author_website');
define('CHILD_MOD_PAGE_ENTRY_CATS', 'page_entry_cats');
define('CHILD_MOD_PAGE_NAV', 'page_nav');
define('CHILD_MOD_PAGE_EXCERPT_ONLY', 'page_excerpt_only');

$CHILD_MOD_PAGE_DEFAULTS = array (
		
	CHILD_MOD_PAGE_HOME_TITLE => true,
	CHILD_MOD_PAGE_ENTRY_META => true,
	CHILD_MOD_PAGE_RULES => true,
	CHILD_MOD_PAGE_LINK_UNDERLINE => 'default',
	CHILD_MOD_PAGE_AUTHOR_BIO => true,
	CHILD_MOD_PAGE_AUTHOR_IMAGE => true,
	CHILD_MOD_PAGE_AUTHOR_WEBSITE => false,
	CHILD_MOD_PAGE_ENTRY_CATS => true,
	CHILD_MOD_PAGE_NAV => true,
	CHILD_MOD_PAGE_EXCERPT_ONLY => false,
);

//-----------------------------------------------------------------------------
// CUSTOMIZER
//-----------------------------------------------------------------------------
function child_add_page_controls($wp_customize, $def) {

	$section = 'child_page';
	$wp_customize->add_section($section, array(
		'title' => __('Page Elements', 'kuiper-twentyseventeen'),
		'priority' => 45,
	));

	$id = CHILD_MOD_PAGE_HOME_TITLE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Title on Home', 'kuiper-twentyseventeen'),
		'description' => __('Show the title on the home page. Useful to hide where a post carousel is shown.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_PAGE_ENTRY_META;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Meta', 'kuiper-twentyseventeen'),
		'description' => __('Show post meta information at top of posts.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_PAGE_RULES;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Rule Lines', 'kuiper-twentyseventeen'),
		'description' => __('Show horizontal rule lines. Uncheck for a cleaner look.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_PAGE_LINK_UNDERLINE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_link_underlines',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'select',
		'settings' => $id,
		'section' => $section,
		'label' => __('Underline Links', 'kuiper-twentyseventeen'),
		'description' => __('If changed from default, it is suggested that a link color is also specified.', 'kuiper-twentyseventeen'),
		'choices' => child_get_select_link_underlines(),
	));

	$id = CHILD_MOD_PAGE_AUTHOR_BIO;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Post Author', 'kuiper-twentyseventeen'),
		'description' => __('Show the author bio in posts.', 'kuiper-twentyseventeen'),
	));
	
	$id = CHILD_MOD_PAGE_AUTHOR_IMAGE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Author Picture', 'kuiper-twentyseventeen'),
		'description' => __('Show the author picture with bio (not shown if there is no bio description).', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_PAGE_AUTHOR_WEBSITE;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Author Website', 'kuiper-twentyseventeen'),
		'description' => __('Show the author wbsite link with bio (not shown if there is no bio description).', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_PAGE_ENTRY_CATS;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Show Categories', 'kuiper-twentyseventeen'),
		'description' => __('Show category tags at bottom of posts.', 'kuiper-twentyseventeen'),
	));

	$id = CHILD_MOD_PAGE_NAV;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Post Navigation', 'kuiper-twentyseventeen'),
		'description' => __('Show Next/Previous navigation at bottom of posts.', 'kuiper-twentyseventeen'),
	));
	
	$id = CHILD_MOD_PAGE_EXCERPT_ONLY;
	$wp_customize->add_setting($id, array(
		'default' => $def[$id],
		'sanitize_callback' => 'child_sanitize_check',
	));
	$wp_customize->add_control('tkctrl-' . $id, array(
		'type' => 'checkbox',
		'settings' => $id,
		'section' => $section,
		'label' => __('Excerpts Only', 'kuiper-twentyseventeen'),
		'description' => __('Show excerpts only in archive and blog pages.', 'kuiper-twentyseventeen'),
	));
	
}
//-----------------------------------------------------------------------------
function child_get_select_link_underlines() {

	return array(
		'default' => __('Default', 'kuiper-twentyseventeen'),
		'content' => __('Content Only', 'kuiper-twentyseventeen'),
		'none' => __('None', 'kuiper-twentyseventeen'),
	);
}
//-----------------------------------------------------------------------------
function child_sanitize_link_underlines($input) {

	if (key_exists($input, child_get_select_link_underlines())) {
		return $input;
	}

	return 'default';
}
//-----------------------------------------------------------------------------
add_action( 'the_content', 'child_insert_author_info' );
function child_insert_author_info( $content ) {
  
	global $post;
	global $CHILD_GMODS;
	
	// Detect if it is a single post with a post author
	if ( $CHILD_GMODS[CHILD_MOD_PAGE_AUTHOR_BIO] && is_single() && isset( $post->post_author ) ) {
		
		// Get author's display name 
		$display_name = get_the_author_meta( 'display_name', $post->post_author );
			
		// If display name is not available then use nickname as display name
		if ( empty( $display_name ) ) {
			$display_name = get_the_author_meta( 'nickname', $post->post_author );
		}
			
		// Get author's biographical information or description
		$user_description = get_the_author_meta( 'user_description', $post->post_author );
			
		// Get link to the author archive page
		$user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));
		 
		if ( ! empty( $display_name ) ) {
			$author_details =  '<p class="author-name">' . __('By', 'kuiper-twentyseventeen') . ' ' . $display_name . '</p>';
		}
		
		if ( ! empty( $user_description ) ) {
			// Author avatar and bio
			$author_details .= '<p class="author-details">'; 

			if ($CHILD_GMODS[CHILD_MOD_PAGE_AUTHOR_IMAGE]) {
				// Image
				$author_details .= get_avatar( get_the_author_meta('user_email') , 90 );
			}
			
			$author_details .= nl2br( $user_description );

			if ($CHILD_GMODS[CHILD_MOD_PAGE_AUTHOR_WEBSITE]) {
				// Website
				$user_website = get_the_author_meta('url', $post->post_author);

				if ( ! empty( $user_website ) ) {
					$author_details .= '<br/>Website: <a class="author-website" href="' . $user_website .'" target="_blank" rel="nofollow">' . $user_website . '</a>';
				}
			}
			
			$author_details .= '</p>';
		}
		
		$author_details .= '<p>' . __('View all posts by', 'kuiper-twentyseventeen');  
		$author_details .= ' <a class="author-link" href="'. $user_posts .'">' . $display_name . '</a>';
		$author_details .= '</p>';
		
		// Pass all this info to post content  
		$content = $content . '<footer class="author-bio" >' . $author_details . '</footer>';
	}
		
	return $content;
}
//-----------------------------------------------------------------------------
// INLINE CSS
//-----------------------------------------------------------------------------
function child_get_page_inline_css($mods) {

$css = '';

	if (!$mods[CHILD_MOD_PAGE_HOME_TITLE]) {
$css .= <<<CSS
	.home .entry-title {
		display: none;
	}
CSS;
	}

	if (!$mods[CHILD_MOD_PAGE_ENTRY_META]) {
$css .= <<<CSS
	.entry-meta {
		display: none;
	}
CSS;
	}

	if (!$mods[CHILD_MOD_PAGE_RULES]) {
$css .= <<<CSS
	.widget ul li,
	.single-featured-image-header,
	.main-navigation li,
	.entry-footer,
	#comments {
		border: none;
	}
	
	.wp-block-table.is-style-stripes {
		border-bottom: none;
	}
CSS;
	}

	$show_links = $mods[CHILD_MOD_PAGE_LINK_UNDERLINE];
	
	if ($show_links == 'none' || $show_links == 'content') {
$css .= <<<CSS
	a,
	a *,
	a:focus,
	a:hover {
		-webkit-box-shadow: none !important;
		box-shadow: none !important;
	}
CSS;

		if ($show_links == 'content') {
			// Can we just exclude entry-content from above instead?
$css .= <<<CSS
		.entry-content p a {
			text-decoration: underline;
		}
CSS;
		}
	}

	if (!$mods[CHILD_MOD_PAGE_ENTRY_CATS]) {
$css .= <<<CSS
	.entry-footer .cat-tags-links {
		display: none;
	}
CSS;
	}

	if (!$mods[CHILD_MOD_PAGE_NAV]) {
$css .= <<<CSS
	.post-navigation {
		display: none;
	}
CSS;
	}

	return $css;
}
//-----------------------------------------------------------------------------

?>