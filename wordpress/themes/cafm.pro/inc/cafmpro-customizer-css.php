<?php
/**
 * cafm.pro: CSS Patterns
 *
 * @package WordPress
 * @subpackage cafm.pro
 */

/**
 * Generate the CSS for the current custom color scheme.
 */
function cafmpro_customizer_css() {

	$settings = cafmpro_customizer_settings();
	$defaults = $settings['defaults'];
	$css = '';

#echo '<pre>';
#print_r($settings['links']);
#echo '</pre>';
#echo '<pre>';
#print_r(get_theme_mods());
#echo '</pre>';

	if (get_theme_mod('site-logo-valign')) {
		$css .= '#header .site-logo { vertical-align:'.get_theme_mod('site-logo-valign').'; }'."\n";
	} else {
		$css .= '#header .site-logo { vertical-align:bottom; }'."\n";
	}

	if (get_theme_mod('site-info-valign')) {
		$css .= '#header .site-info { vertical-align:'.get_theme_mod('site-info-valign').'; }'."\n";
	} else {
		$css .= '#header .site-info { vertical-align:bottom; }'."\n";
	}
	if (get_theme_mod('site-info-display')) {
		$css .= '#header .site-info .site-title { display:'.get_theme_mod('site-info-display').'; margin-right: 15px; } '."\n";
		$css .= '#header .site-info .site-description { display:'.get_theme_mod('site-info-display').'; }'."\n";
	} else {
		$css .= '#header .site-info .site-title { display:inline-block; margin-right: 15px; } '."\n";
		$css .= '#header .site-info .site-description { display:inline-block; }'."\n";
	}

	### TODO
	if (get_theme_mod('canvas-inner-width')) {
		if(get_theme_mod('canvas-margin')) {
			$css .= '.canvas.wrap { width:'.get_theme_mod('canvas-inner-width').'; }'."\n";
			$css .= '.canvas.wrap { margin: '.get_theme_mod('canvas-margin').'; }'."\n";
		} else {
			$css .= '#canvas .box { width:'.get_theme_mod('canvas-inner-width').'; }'."\n";
			$css .= '#canvas .box { margin: 0 auto; }'."\n";
		}
	} else {
		if(get_theme_mod('canvas-margin')) {
			$css .= '#canvas { margin: '.get_theme_mod('canvas-margin').'; }'."\n";
		}
	}

	if(get_theme_mod('topnav-menu-border-color') !== false) {
		$selector = '#topnav .main-navigation ul ul li';
		if (get_theme_mod('topnav-menu-border-root') !== false) {
			$css .= '#topnav .main-navigation ul li:not(ul ul li) { z-index: 10; margin: -1px 0 -1px -1px; border: 1px solid '.get_theme_mod('topnav-menu-border-color').'; }'."\n";
		}
	}

	if(get_theme_mod('topnav-menu-border-hover-color') !== false) {
		if (get_theme_mod('topnav-menu-border-root') !== false) {
			$css .= '#topnav .main-navigation ul li:hover:not(ul ul li) {z-index: 11; border-color: '.get_theme_mod('topnav-menu-border-hover-color').'; }'."\n";
		}
	}
	if(get_theme_mod('topnav-menu-border-active-color') !== false) {
		if (get_theme_mod('topnav-menu-border-root') !== false) {
			$css .= '#topnav .main-navigation ul li:active:not(ul ul li) {z-index: 11; border-color: '.get_theme_mod('topnav-menu-border-active-color').'; }'."\n";
		}
	}

	// --------------------------------
	// background
	// --------------------------------
	$modes = array('hover','active');
	$data = $settings['background'];
	foreach ($data as $d) {
	
		$default = '#fff';
		if(isset($defaults[$d['name']])) {
			$default = $defaults[$d['name']];
		}
		else if(isset($defaults['background'])) {
			$default = $defaults['background'];
		}

		if (get_theme_mod($d['name'].'-image')) {
			$css .= $d['selector'].' { background-image: url('.wp_get_attachment_url(get_theme_mod($d['name'].'-image')).'); }'."\n";
			if (get_theme_mod($d['name'].'-repeat')) {
				$css .= $d['selector'].' { background-repeat: '.get_theme_mod($d['name'].'-repeat').'; }'."\n";
			}
			if (get_theme_mod($d['name'].'-position')) {
				$css .= $d['selector'].' { background-position: '.get_theme_mod($d['name'].'-position').'; }'."\n";
			}
		} else {
			if (get_theme_mod($d['name'])) {
				$css .= $d['selector'].' { background-color:'.get_theme_mod($d['name']).'; }'."\n";
			} else {
				$css .= $d['selector'].' { background-color:'.$default.'; }'."\n";
			}
			foreach($modes as $m) {
				if(isset($d[$m])) {
				
				}
			
			}
		}
	}

	// --------------------------------
	// fonts
	// --------------------------------
	$data = $settings['fonts'];
	foreach ($data as $d) {
		$tmp = '';
		if (get_theme_mod($d['name'].'-size')) {
			$tmp .= 'font-size:'.get_theme_mod($d['name'].'-size').'; ';
		}
		if (get_theme_mod($d['name'].'-color')) {
			$tmp .= 'color:'.get_theme_mod($d['name'].'-color').'; ';
		} else {
			$tmp .= 'color:#000000; ';
		}
		if (get_theme_mod($d['name'].'-weight')) {
			$tmp .= 'font-weight:bold; ';
		}
		if($tmp !== '') {
			$css .= $d['selector'].' { '.$tmp.' }'."\n";
		}
	}

	// --------------------------------
	// links
	// --------------------------------
	$modes = array('','hover','active');
	$data = $settings['links'];
	foreach ($data as $d) {
		foreach($modes as $m) {
			$pseudo = '';
			if($m !== '') {
				$pseudo = ':'.$m;
				$m = '-'.$m;
			}
			$tmp = '';
			if (get_theme_mod($d['name'])) {
				$tmp .= 'color:'.get_theme_mod($d['name']).$m.'; ';
			}
			if (get_theme_mod($d['name'].$m.'-decoration')) {
				$tmp .= 'text-decoration:'.get_theme_mod($d['name'].$m.'-decoration').'; ';
			} else {
				if(isset($d['decoration']) && $d['decoration'] === 'background') {
					if(get_theme_mod($d['name'].$m.'-color') !== false) {
						$tmp .= 'background:'.get_theme_mod($d['name'].$m.'-color').'; ';
					} else {
						$tmp .= 'background:#fff; ';
					}
				}
				else if(isset($d['decoration']) && $d['decoration'] === 'border') {
					if(get_theme_mod($d['name'].$m.'-color') !== false) {
						$tmp .= 'border-color:'.get_theme_mod($d['name'].$m.'-color').'; ';
					} else {
						$tmp .= 'border-color:#ccc; ';
					}
				} else {
					if(get_theme_mod($d['name'].$m.'-decoration') === '') {
						$tmp .= 'text-decoration:none; ';
					} else {
						$tmp .= 'text-decoration:underline; ';
					}
				}
			}
			if(!isset($d['decoration']) || $d['decoration'] === 'text') {
				if (get_theme_mod($d['name'].$m.'-color')) {
					$tmp .= 'color:'.get_theme_mod($d['name'].$m.'-color').'; ';
				} else {
					$tmp .= 'color: #000; ';
				}
			}
			if($tmp !== '') {
				$selector = '';
				if(is_array($d['selector'])) {
					$i = 1;
					$m = count($d['selector']);
					foreach($d['selector'] as $s) {
						$selector .= $s.$pseudo;
						if($i < $m) {
							$selector .= ', ';
						}
						$i++;
					}
				} else {
					$selector = $d['selector'].$pseudo;
				}
				$css .= $selector.' { '.$tmp.' }'."\n";
			}
		}
	}

	// --------------------------------
	// width
	// --------------------------------
	$data = $settings['width'];
	foreach ($data as $d) {
		if (get_theme_mod($d['name'])) {
			$type = 'width';
			if(isset($d['type'])) {
				$type = $d['type'];
			}
			$css .= $d['selector'].' { '.$type.':'.get_theme_mod($d['name']).'; }'."\n";
		}
	}

	// --------------------------------
	// height
	// --------------------------------
	$data = $settings['height'];
	foreach ($data as $d) {
		if (get_theme_mod($d['name'])) {
			$css .= $d['selector'].' { height:'.get_theme_mod($d['name']).'; }'."\n";
		}
	}

	// --------------------------------
	// margin
	// --------------------------------
	$data = $settings['margin'];
	foreach ($data as $d) {
		if (get_theme_mod($d['name']) !== false) {
			$css .= $d['selector'].' { margin:'.get_theme_mod($d['name']).'; }'."\n";
		}
	}

	// --------------------------------
	// padding
	// --------------------------------
	$data = $settings['padding'];	
	foreach ($data as $d) {
		if (get_theme_mod($d['name']) !== false) {
			if(isset($d['selector']) && get_theme_mod($d['name']) !== '') {
				$css .= $d['selector'].' { padding:'.get_theme_mod($d['name']).'; }'."\n";
			}
		} else {
			if(isset($d['selector'])) {
				if(isset($defaults[$d['name']])) {
					$css .= $d['selector'].' { padding:'.$defaults[$d['name']].'; }'."\n";
				}
				else if($defaults['padding']) {
					$css .= $d['selector'].' { padding:'.$defaults['padding'].'; }'."\n";
				} else {
					$css .= $d['selector'].' { padding:15px; }'."\n";
				}
			}
		}
	}

	// --------------------------------
	// padding +
	// --------------------------------
	$data = array();
	$data[] = array('name'=>'body-padding','selector'=>'body');
	$data[] = array('name'=>'header-padding','selector'=>'#header .box');
	foreach ($data as $d) {
		if (get_theme_mod($d['name']) !== false) {
			$split = get_theme_mod($d['name']);
			$split = explode(' ', $split );
			if(isset($split[0]) && $split[0] !== '') {
				$css .= $d['selector'].' { ';
				if($split[0] === '0') { $split[0] = '0px'; }
				if(isset($split[2])) {
					if($split[1] === '0') { $split[1] = '0px'; }
					if($split[2] === '0') { $split[2] = '0px'; }
					$css .= 'padding-top:'.$split[0].';';
					$css .= 'padding-right:'.$split[1].';';
					$css .= 'padding-bottom:'.$split[2].';';
					if(isset($split[3])) {
						if($split[3] === '0') { $split[3] = '0px'; }
						$css .= 'padding-left:'.$split[3].';';
					}
					$css .= '--diff: calc('.$split[0].' + '.$split[2].');';
					$css .= 'height: calc(100% - var(--diff));';
				} else {
					if(isset($split[1])) {
						if($split[1] === '0') { $split[1] = '0px'; }
						$css .= 'padding:'.$split[0].' '.$split[1].';';
					} else {
						$css .= 'padding:'.$split[0].';';
					}
					if($split[0] !== 0) {
						$css .= '--'.$d['name'].': calc('.$split[0].' * 2);';
						$css .= 'height: calc(100% - var(--'.$d['name'].'));';
					} else {
						$css .= 'height: 100%;';
					}
				}
				$css .= ' }'."\n";
			} else {
				$css .= $d['selector'].' { padding: 0px; }'."\n";
			}
		} else {
			if(isset($defaults[$d['name']])) {
				$css .= $d['selector'].' { padding:'.$defaults[$d['name']].'; }'."\n";
			}
			else if($defaults['padding']) {
				$css .= $d['selector'].' { ';
				$css .= 'padding:'.$defaults['padding'].';';
				$css .= '--'.$d['name'].': calc('.$defaults['padding'].' * 2);';
				$css .= 'height: calc(100% - var(--'.$d['name'].'));';
				$css .= ' }'."\n";
			} else {
				$css .= $d['selector'].' { padding:15px; }'."\n";
				$css .= $d['selector'].' { height: calc(100% - 30px); }'."\n";
			}
		}
	}

	// --------------------------------
	// borders
	// --------------------------------
	$pos = array('top','right','bottom','left');
	$atr = array('style','width','color');
	$data = $settings['borders'];
	foreach($data as $d) {
		$style = '';
		$width = '';
		$radius = '';
		$color = '';
		if (get_theme_mod($d['name'].'-style')) {
			$style .= get_theme_mod($d['name'].'-style').' ';
		} else {
			if(isset($defaults[$d['name'].'-style'])) {
				$style .= $defaults[$d['name'].'-style'].' ';
			} else {
				$style .= 'none ';
			}
		}
		if (get_theme_mod($d['name'].'-width')) {
			$width .= get_theme_mod($d['name'].'-width').' ';
		} else {
			if(isset($defaults[$d['name'].'-width'])) {
				$width .= $defaults[$d['name'].'-width'].' ';
			} else {
				$width .= '0 ';
			}
		}
		if (get_theme_mod($d['name'].'-radius')) {
			$radius = get_theme_mod($d['name'].'-radius').' ';
		}
		foreach($pos as $p) {
			if (get_theme_mod($d['name'].'-'.$p.'-color')) {
				$color .= get_theme_mod($d['name'].'-'.$p.'-color').' ';
			}
			else if (isset($defaults[$d['name'].'-'.$p.'-color'])) {
				$color .= $defaults[$d['name'].'-'.$p.'-color'].' ';
			} else {
				if(isset($defaults['border-color'])) {
					$color .= $defaults['border-color'].' ';
				} else {
					$color .= '#ccc ';
				}
			}
		}
		if($style !== '') {
			$css .= $d['selector'].' { ';
			$css .= 'border-style: '.$style.'; ';
			$css .= 'border-width: '.$width.'; ';
			if($radius !== '') { $css .= 'border-radius: '.$radius.'; '; }
			$css .= 'border-color: '.$color.'; ';
			$css .= '}'."\n";
		}
	}
	if($css !== '') {
		$tmp  = '<style type="text/css" id="custom-theme-css">'."\n";
		$tmp .= $css;
		$tmp .= '</style>'."\n";
		$css = $tmp;
	}
	return apply_filters( 'cafmpro_custom_css', $css );
}
