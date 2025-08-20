<?php
// add navigation
function my_theme_setup() {
	register_nav_menus(
		array(
			'top-nav-menu' => __( 'Top Menu', 'cafm.pro' ),
			'footer-nav-menu' => __( 'Footer Menu', 'cafm.pro' ),
		)
	);
	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo',
		array(
			'default-image' => 'test.jpg',
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		)
	);
	add_theme_support( 'title-tag' );
	
		/*
	 * Enable support for Post Formats.
	 *
	 * See: https://developer.wordpress.org/advanced-administration/wordpress/post-formats/
	 */
	add_theme_support(
		'post-formats',
		array(
			'image',
		)
	);
}
add_action( 'after_setup_theme', 'my_theme_setup' );

// add scripts and styles
function my_theme_enqueue_styles() {
	wp_enqueue_style( 
		'cafmpro-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// put styles to upload dir
	$wp_upload = wp_upload_dir();
	$uri = $wp_upload['baseurl'].'/cafm.pro';
	$dir = $wp_upload['basedir'].'/cafm.pro';
	if(! is_dir($dir) ) {
		wp_mkdir_p( $dir );
	}
	if(! file_exists($dir . '/custom.css')) {
		touch($dir . '/custom.css');
	}
	if(! file_exists($dir . '/custom.js')) {
		touch($dir . '/custom.js');
	}
	wp_enqueue_style(
		'custom',
		$uri . '/custom.css',
		array('cafmpro-style'),
		filemtime($dir.'/custom.css')
	);
	wp_enqueue_script(
		'custom-script',
		$uri . '/custom.js',
		array( 'jquery' ),
		filemtime($dir.'/custom.js')
	);
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// add to customizer
function my_theme_customizer_settings( $wp_customize ) {
	require_once get_parent_theme_file_path( '/inc/cafmpro-customizer-settings.php' );
	require_once get_parent_theme_file_path( '/inc/cafmpro-customizer.php' );
	cafmpro_customizer( $wp_customize );
}
add_action( 'customize_register', 'my_theme_customizer_settings' );

/**
 * Display custom CSS.
 */
function cafmpro_css_wrap() {
	require_once get_parent_theme_file_path( '/inc/cafmpro-customizer-settings.php' );
	require_once get_parent_theme_file_path( '/inc/cafmpro-customizer-css.php' );
	echo cafmpro_customizer_css();
}
add_action( 'wp_head', 'cafmpro_css_wrap' );


// remove emojis
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		// This filter is documented in wp-includes/formatting.php 
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function nav_breadcrumb($delimiter) {

	$homeLink = get_bloginfo('url');	
	$before = '<span class="current-page">'; 
	$after = '</span>'; 
	$str = '';
	if ( !is_home() && !is_front_page() || is_paged() ) {
		global $post;
		if ( is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0) $str .= (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
				$str .= $before . single_cat_title('', false) . $after;
		}
		elseif ( is_day() ) {
			$str .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			$str .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			$str .= $before . get_the_time('d') . $after;
		}
		 elseif ( is_month() ) {
			$str .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			$str .= $before . get_the_time('F') . $after;
		}
		 elseif ( is_year() ) {
			$str .= $before . get_the_time('Y') . $after;
		}
		 elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$str .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$str .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			}
		}
		elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			$str .= $before . $post_type->labels->singular_name . $after;
		} 
		elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$str .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			$str .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
		}
		elseif ( is_page() && !$post->post_parent ) {
			#echo $before . get_the_title() . $after;
		}
		elseif ( is_page() && $post->post_parent ) {
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) {
				$str .= ' ' . $delimiter . ' '.$crumb;
			}
		}
		elseif ( is_search() ) {
			$str .= $before . 'Ergebnisse für Ihre Suche nach "' . get_search_query() . '"' . $after;
		} 
		elseif ( is_tag() ) {
			$str .= $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;
		} 
		elseif ( is_404() ) {
			$str .= $before . 'Fehler 404' . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo ': ' . __('Seite') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
	}

	$return = '';
	if($str !== '') {
		$return  = '<a href="'.$homeLink.'" class="icon icon-home"></a>';
		$return .= '<nav>'.$str.'</nav>';
	}
	return $return;
}


### TODO why
// remove svg
#function remove_parent_svg_icons() {
#	remove_action('wp_footer', 'twentyseventeen_include_svg_icons', 9999);
#}
#add_action('after_setup_theme', 'remove_parent_svg_icons');


// remove google fonts call
#function remove_google_fonts() {
#	wp_dequeue_style( 'twentyseventeen-fonts' );
#}
#add_action( 'wp_print_styles', 'remove_google_fonts', 1);

#function remove_google_fonts_preconnect() {
#	remove_filter('wp_resource_hints', 'twentyseventeen_resource_hints');
#}
#add_filter('init', 'remove_google_fonts_preconnect');

/*
remove_action( 'wp_head', 'wp_resource_hints', 2 );

// remove svg
function remove_parent_svg_icons() {
	remove_action('wp_footer', 'twentyseventeen_include_svg_icons', 9999);
}
add_action('after_setup_theme', 'remove_parent_svg_icons');




// remove block library
function smartwp_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// add json parse function
function my_json_method($filename, $raw = false) {
	$path = ABSPATH.'wp-content/themes/twentyseventeen_child/';
	if(file_exists($path.$filename)) {
		$data = file_get_contents($path.$filename);
		if(isset($raw) && $raw === true) {
			return $data;
		}
		$data = json_decode($data, true);
		if($filename === 'cafm-one-taetigkeitsgruppen.json' || $filename === 'cafm-one-gewerk.json') {
			foreach($data as $k => $d) {
				if(isset($d['bezeichner']) && is_array($d['bezeichner'])) {
					$data[$k]['bezeichner'] = implode(',', $d['bezeichner']);
				}
			}
		}
		return $data;
	}
}
*/
?>
