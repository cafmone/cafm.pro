<?php
/**
 * cafm.pro: CSS defaults
 *
 * @package WordPress
 * @subpackage cafm.pro
 */

/**
 * Generate the CSS for the current custom color scheme.
 */
function cafmpro_customizer_settings() {
	$data = array(
		'background' => array(
			'body' => array(
					'name'=>'body-background',
 					'section' => 'background-section-body', 
 					'label' => 'Body',
					'selector'=>'#body',
				),
			'header' => array(
					'name'=>'header-background',
					'section' => 'background-section-header',
					'label' => 'Header',
					'selector'=>'#header',
				),
			'topnav' => array(
					'name'=>'topnav-background',
					'section' => 'background-topnav',
					'label' => 'Topnav',
					'selector'=>'#topnav',
				),
			'canvas' => array(
					'name'=>'canvas-background',
					'section' => 'background-canvas', 
					'label' => 'Canvas',
					'selector'=>'#canvas',
				),
			'footer' => array(
					'name'=>'footer-background',
					'section' => 'background-footer',
					'label' => 'Footer',
					'selector'=>'#footer',
				),
		),
		'width' => array(
			'header' => array(
					'name'=>'header-width',
					'section' => 'dimensions-section-header', 
					'label' => 'Header',
					'selector'=>'.header.wrap',
				),
			'topnav' => array(
					'name'=>'topnav-width',
					'section' => 'dimensions-section-topnav', 
					'label' => 'Topnav',
					'selector'=>'.topnav.wrap',
				),
			'canvas' => array(
					'name'=>'canvas-width',
					'section' => 'dimensions-section-canvas', 
					'label' => 'Canvas',
					'default' => '1024px',
					'selector'=>'.wrap',
				),
			'footer' => array(
					'name'=>'footer-width',
					'section' => 'dimensions-section-footer', 
					'label' => 'Footer',
					'selector'=>'.footer.wrap',
				),
		),
		'height' => array(
			'header' => array(
					'name'=>'header-height',
					'section' => 'dimensions-section-header', 
					'label' => 'Header',
					'selector'=>'#header',
				),
		),
		'margin' => array(
			'header' => array(
					'name'=>'header-margin',
					'section' => 'dimensions-section-header', 
					'label' => 'Header',
					'selector'=>'.header.wrap',
				),
			'topnav' => array(
					'name'=>'topnav-margin',
					'section' => 'dimensions-section-topnav', 
					'label' => 'Topnav',
					'selector'=>'.topnav.wrap',
				),
			'canvas' => array(
					'name'=>'canvas-margin',
					'section' => 'dimensions-section-canvas', 
					'label' => 'Canvas',
					'selector'=>'.canvas.wrap',
				),
			'footer' => array(
					'name'=>'footer-margin',
					'section' => 'dimensions-section-footer',
					'label' => 'Footer',
					'selector'=>'.footer.wrap',
				),
		),
		'padding' => array(
			'body' => array(
					'name' => 'body-padding', 
					'section' => 'dimensions-section-body', 
					'label' => 'Body',
					'selector' => null,
				),
			'header' => array(
					'name' => 'header-padding',
					'section' => 'dimensions-section-header',
					'label' => 'Header',
					'selector' => null,
				),
			'logo' => array(
					'name'=>'logo-padding',
					'section' => 'dimensions-section-header',
					'label' => 'Header',
					'custom' => 'Logo',
					'selector'=>'#header .site-logo',
				),
			'topnav' => array(
					'name'=>'topnav-padding',
					'section' => 'dimensions-section-topnav', 
					'label' => 'Topnav',
					'selector'=>'#topnav .box',
				),
			'topnav-menu' => array(
					'name'=>'topnav-font',
					'section' => 'fonts-section-topnav',
					'label' => 'Topnav',
					'selector'=>'#topnav .main-navigation a',
				),
			'canvas' => array(
					'name'=>'canvas-padding',
					'section' => 'dimensions-section-canvas',
					'label' => 'Canvas',
					'selector'=>'#canvas .box',
				),
			'footer' => array(
					'name'=>'footer-padding',
					'section' => 'dimensions-section-footer', 
					'label' => 'Footer',
					'selector'=>'#footer .box',
				),
		),
		'borders' => array(
			'header' => array(
					'name' => 'header-border',
					'section' => 'border-section-header', 
					'label' => 'Header',
					'selector'=> '#header',
				),
			'topnav' => array(
					'name' => 'topnav-border',
					'section' => 'border-section-topnav', 
					'label' => 'Topnav',
					'selector'=> '#topnav',
				),
			'canvas' => array(
					'name' => 'canvas-border',
					'section' => 'border-section-canvas', 
					'label' => 'Canvas', 
					'selector'=> '#canvas',
				),
			'footer' => array(
					'name' => 'footer-border', 
					'section' => 'border-section-footer',
					'label' => 'Footer',
					'selector'=> '#footer',
				),
		),
		'fonts' => array(
			'0' => array(
					'name'=>'header-font-title',
					'section' => 'fonts-section-header',
					'label' => 'Header', 
					'custom' => 'Site Title',
					'selector'=>'#header .site-title a',
				),
			'1' => array(
					'name'=>'header-font-tagline',
					'section' => 'fonts-section-header', 
					'label' => 'Header', 
					'custom' => 'Tagline',
					'selector'=>'#header .site-description h2',
				),
			'topnav' => array(
					'name'=>'topnav-font',
					'section' => 'fonts-section-topnav',
					'label' => 'Topnav',
					'selector'=>'#topnav .main-navigation a',
				),
			'canvas' => array(
					'name'=>'canvas-font',
					'section' => 'fonts-section-canvas', 
					'label' => 'Canvas',
					'selector'=>'#canvas .box',
				),
			'footer' => array(
					'name'=>'footer-font',
					'section' => 'fonts-section-footer',
					'label' => 'Footer',
					'selector'=>'#footer .box',
				),
		),
		'links' => array(
			'canvas' => array(
					'name'=>'canvas-font-a',
					'section' => 'fonts-section-canvas',
					'label' => 'Link',
					'decoration' => 'text',
					'selector'=>'#canvas .box a',
				),
			'topnav' => array(
					'name'=>'topnav-menu-a',
					'section' => 'fonts-section-topnav',
					'label' => 'Topnav',
					'decoration' => 'text',
					'selector'=> array(
									'#topnav .main-navigation a',
									'#footer .main-navigation a'
								),
					'custom' => 'Link',
				),
			'topnav-background' => array(
					'name'=>'topnav-menu-background',
					'section' => 'fonts-section-topnav',
					'decoration' => 'background',
					'label' => 'Topnav',
					'selector'=>'#topnav .main-navigation li',
					'custom' => 'Background',
				),
			'topnav-border' => array(
					'name'=>'topnav-menu-border',
					'section' => 'fonts-section-topnav',
					'decoration' => 'border',
					'label' => 'Topnav',
					'selector'=>'#topnav .main-navigation ul ul',
					'custom' => 'Border',
				),
		),
		'defaults' => array (
			'padding' => '15px',
			'background' => '#fff',
			'body-padding' => '0px',
			'header-padding' => '0px',
			'logo-padding' => '0px',
			'border-color' => '#ccc',
			'header-border-style' => 'none solid solid solid',
			'header-border-width' => '1px',
			'topnav-border-style' => 'none solid',
			'topnav-border-width' => '1px',
			'canvas-border-style' => 'solid',
			'canvas-border-width' => '1px',
			'footer-border-style' => 'none solid solid solid',
			'footer-border-width' => '1px',
		),
	);
	return $data;
}
