<?php 
if (function_exists('nav_breadcrumb')) {
	if (get_theme_mod('breadcrumps_hide') === false) {

		$delimiter = '&rsaquo;';
		if(get_theme_mod('breadcrumps_delimit')) {
			$delimiter = get_theme_mod('breadcrumps_delimit');
		}
		$nav = nav_breadcrumb($delimiter);
		if($nav !== '') {
			if(get_theme_mod('breadcrumbs-font-color')) {
				echo '<div class="breadcrumbs" style="color:'.get_theme_mod('breadcrumbs-font-color').'">';
			} else {
				echo '<div class="breadcrumbs">';
			}
			echo $nav;
			echo '</div>';
		}
		if ( !is_home() && !is_front_page() || is_paged() ) {
			$list = wp_list_pages( array(
				'child_of' => get_the_ID(),
				'depth' => 1,
				'title_li' => null,
				'echo' => false,
				'link_before' => '<span style="text-decoration: none;">'.$delimiter.' </span>',
				)
			);
			if($list !== '') {
				echo '<div class="sidebar">';
				#echo _e('Next Page');
				#echo _e('Next');
				echo '<ul>';
				echo $list;
				echo '</ul>';
				echo '</div>';
			}
		}
	}
}
?>
