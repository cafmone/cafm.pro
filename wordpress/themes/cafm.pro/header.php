<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage cafm.pro
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body id="body" <?php body_class();?> style="">

<div id="page" style="height:100%;">

<div style="">
	<div class="header wrap">
		<header id="header" class="site-header">
			<div class="box" style="position: relative;">
				<table style="height:100%; width:auto;">
					<tr>
						<?php if( has_custom_logo() ) {
								echo '<td class="site-logo" style="position: relative;">'."\n";
								the_custom_logo();
								echo '</td>';
							} else {
								echo '<td class="site-logo" style="position: relative; padding:0 30px 0 0;">'."\n";
								printf(
									'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url"><img src="%2$s" class="custom-logo" itemprop="logo" alt="%3$s"></a>',
									esc_url( home_url( '/' ) ),
									esc_url( get_theme_file_uri( '/assets/images/default-logo.png' ) ),
									get_bloginfo( 'name', 'display' )
								);
								echo '</td>';
							}
						?>
						<?php 
							if ( get_theme_mod( 'site-logo-display' ) !== false){
								if ( get_theme_mod( 'site-logo-display' ) === 'block') {
									echo '</tr><tr>';
								}
							}
						 ?>
						<td class="site-info" style="white-space:nowrap;">
							<div class="site-title">
								<h1 style="position: relative; white-space:nowrap;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							</div>
							<div class="site-description">
								<h2 style="position:relative; white-space:nowrap;">
									<?php if ( get_bloginfo( 'description' ) ) { echo get_bloginfo( 'description' ); } ?>
								</h2>
							</div>
						</td>
					</tr>
				</table>
				<span class="header-customizer" style="position: absolute; right: 0; top: 0; font-size:0px; line-height:0px;">&#160;</span>
			</div>
		</header>
	</div>
</div>
<div style="">
	<div class="topnav wrap">
		<div id="topnav" class="top-nav" style="height: auto;">
			<div class="wrap">
				<nav class="main-navigation">
				<div class="box main-navigation menu-header-container" style="position: relative;">
					<ul id="top-nav-menu" class="menu" style="position:relative; display:flex;direction:row;">
					<?php
						if ( has_nav_menu( 'top-nav-menu' ) ) {
							$nav_args = array( 
								'container' => 'ul', 
								'items_wrap' => '%3$s',
								'theme_location' => 'top-nav-menu',
							);
							wp_nav_menu( $nav_args ); 
						}
					?>
					</ul>
					<span class="topnav-customizer" style="position: absolute; right: 0; top: 0; font-size:0px; line-height:0px;">&#160;</span>
				</div>
				</nav>
			</div>
		</div>
	</div>
</div>
