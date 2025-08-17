<?php
/**
 * cafm.pro: customizer
 *
 * @package WordPress
 * @subpackage cafm.pro
 */

/**
 * Set customizer
 */
function cafmpro_customizer( $wp_customize ) {

	$settings = cafmpro_customizer_settings();
	$defaults = $settings['defaults'];

	$wp_customize->add_setting( 'header-align', array(
			'default' => 'left',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'header-align', array(
			'label' => __( 'Align', 'textdomain' ),
			'settings' => 'header-align',
			'priority' => 15,
			'section' => 'dimensions-section-header',
			'type' => 'select',
			'choices' => array(
				'' => '',
				'left' => 'left',
				'center' => 'center',
				'right' => 'right',
			 ),
		)
	);

	$wp_customize->add_setting( 'site-logo-valign', array(
			'default' => 'bottom',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'site-logo-valign', array(
			'label' => __( 'Logo Align', 'textdomain' ),
			'settings' => 'site-logo-valign',
			'priority' => 20,
			'section' => 'dimensions-section-header',
			'type' => 'select',
			'choices' => array(
				'' => '',
				'top' => 'top',
				'middle' => 'middle',
				'bottom' => 'bottom',
			 ),
		)
	);
	$wp_customize->add_setting( 'site-logo-display', array(
			'default' => 'inline-block',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'site-logo-display', array(
			'label' => __( 'Logo Display', 'textdomain' ),
			'settings' => 'site-logo-display',
			'priority' => 20,
			'section' => 'dimensions-section-header',
			'type' => 'select',
			'choices' => array(
				'' => '',
				'inline-block' => 'inline',
				'block' => 'block',
			 ),
		)
	);

	$wp_customize->add_setting( 'site-info-valign', array(
			'default' => 'bottom',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'site-info-valign', array(
			'label' => __( 'Site Title Align', 'textdomain' ),
			'settings' => 'site-info-valign',
			'priority' => 20,
			'section' => 'dimensions-section-header',
			'type' => 'select',
			'choices' => array(
				'' => '',
				'top' => 'top',
				'middle' => 'middle',
				'bottom' => 'bottom',
			 ),
		)
	);
	
	$wp_customize->add_setting( 'site-info-display', array(
			'default' => 'inline-block',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'site-info-display', array(
			'label' => __( 'Tagline Display', 'textdomain' ),
			'settings' => 'site-info-display',
			'priority' => 20,
			'section' => 'dimensions-section-header',
			'type' => 'select',
			'choices' => array(
				'' => '',
				'inline-block' => 'inline',
				'block' => 'block',
			 ),
		)
	);

	$wp_customize->add_setting( 'copyright', array(
			'default' => '',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'copyright', array(
			'label' => __( 'Copyright', 'textdomain' ),
			'settings' => 'copyright',
			'priority' => 11,
			'section' => 'title_tagline',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting( 'topnav-menu-border-root', array(
			'default' => '',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'topnav-menu-border-root', array(
			'label' => __( 'Root Menu has Border', 'textdomain' ),
			'settings' => 'topnav-menu-border-root',
			'priority' => 10,
			'section' => 'fonts-section-topnav',
			'type' => 'checkbox',
		)
	);

	### TODO
	$wp_customize->add_section( 'nav_menu_custom', array(
		'title' => __( 'Breadcrumps', 'nssra' ),
		'panel' => 'nav_menus',
		'priority' => 15,
	) );
	$wp_customize->add_setting( 'breadcrumps_hide', array(
			'default' => '',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'breadcrumps_hide', array(
			'label' => __( 'Hide Breadcrumps', 'textdomain' ),
			'settings' => 'breadcrumps_hide',
			'priority' => 9,
			'section' => 'nav_menu_custom',
			'type' => 'checkbox',
		)
	);
	$wp_customize->add_setting( 'breadcrumps_delimit', array(
			'default' => '&rsaquo;',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'breadcrumps_delimit', array(
			'label' => __( 'Delimiter', 'textdomain' ),
			'settings' => 'breadcrumps_delimit',
			'priority' => 9,
			'section' => 'nav_menu_custom',
			'type' => 'text',
		)
	);


	// --------------------------------
	// help
	// --------------------------------
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
	) );
	$wp_customize->selective_refresh->add_partial( 'copyright', array(
		'selector' => '#footer .copyright-customizer',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-width', array(
		'selector' => '#header .box .header-customizer',
	) );
	$wp_customize->selective_refresh->add_partial( 'topnav-width', array(
		'selector' => '#topnav .box .topnav-customizer',
	) );
	$wp_customize->selective_refresh->add_partial( 'canvas-width', array(
		'selector' => '#canvas .canvas-customizer',
	) );
	$wp_customize->selective_refresh->add_partial( 'footer-width', array(
		'selector' => '#footer .box .footer-customizer',
	) );

	// --------------------------------
	// background
	// --------------------------------

	$wp_customize->add_panel( 'background-panel' , array(
		'priority' => 30,
		'title' => __( 'Backround', 'starter' ),
		'description' => 'Background Settings',
	) );
	// background
	$colors = $settings['background'];
	foreach($colors as $color) {
	
		if(isset($defaults[$color['name']])) {
			$default = $defaults[$color['name']];
		}
		else if(isset($defaults['background'])) {
			$default = $defaults['background'];
		} else {
			$default = '#fff';
		}

		$wp_customize->add_section( $color['section'] , array(
			'title' => __( $color['label'], 'starter' ),
			'priority' => 10,
			'panel' => 'background-panel',
		) );
		$wp_customize->add_setting( $color['name'], array(
				'default' => $default,
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['name'],
				array(
					'label' => __( 'Background Color', 'textdomain' ),
					'mode'     => 'full',
					'section'  => $color['section'],
					'priority' => 10,
				)
			)
		);
		$wp_customize->add_setting( $color['name'].'-image', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( 
			new WP_Customize_Media_Control(
			$wp_customize,
			$color['name'].'-image',
			array(
				'section' => $color['section'],
				'mime_type' => 'image',
				)
			)
		);
		$wp_customize->add_setting( $color['name'].'-repeat', array(
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( $color['name'].'-repeat', array(
				'label' => __( 'Background Repeat', 'textdomain' ),
				'settings' => $color['name'].'-repeat',
				'priority' => 10,
				'section' => $color['section'],
				'type' => 'select',
				'choices' => array(
					'' => '',
					'no-repeat' => 'no-repeat',
					'repeat' => 'repeat',
					'repeat-x' => 'repeat-x',
					'repeat-y' => 'repeat-y',
				 ),
			)
		);
		$wp_customize->add_setting( $color['name'].'-position', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( $color['name'].'-position', array(
				'label' => __( 'Background Position', 'textdomain' ),
				'settings' => $color['name'].'-position',
				'priority' => 10,
				'section' => $color['section'],
				'type' => 'text',
			)
		);

	}

	// --------------------------------
	// dimensions
	// --------------------------------
	$wp_customize->add_panel( 'dimensions-panel' , array(
		'priority' => 29,
		'title' => __( 'Dimensions', 'starter' ),
		'description' => 'Dimensions Settings',
	) );

	// --------------------------------
	// dimensions - width
	// --------------------------------
	$data = $settings['width'];
	foreach($data as $d) {
		$wp_customize->add_section( $d['section'] , array(
			'title' => __( $d['label'], 'starter' ),
			'priority' => 10,
			'panel' => 'dimensions-panel',
		) );
	
		// width of page
		$default = '';
		if(isset($d['default'])) {
			$default = $d['default'];
		}
		$wp_customize->add_setting( $d['name'], array(
				'default' => $default,
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$label = 'Width';
		if(isset($d['custom'])) {
			$label = $d['custom'].' '.$label;
		}
		$wp_customize->add_control( $d['name'], array(
				'label' => __( $label, 'textdomain' ),
				'settings' => $d['name'],
				'priority' => 12,
				'section' => $d['section'],
				'type' => 'text',
			)
		);
	}
	
	
	##### TODO

	// canvas inner
	$wp_customize->add_setting( 'canvas-inner-width', array(
			'default' => '',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		),
	);
	$wp_customize->add_control( 'canvas-inner-width', array(
			'label' => __( 'Inner Width', 'textdomain' ),
			'settings' => 'canvas-inner-width',
			'priority' => 12,
			'section' => 'dimensions-section-canvas',
			'type' => 'text',
		)
	);

	// --------------------------------
	// dimensions - height
	// --------------------------------
	$data = $settings['height'];
	foreach($data as $d) {
		if( $wp_customize->get_section( $d['section']) === null) {
			$wp_customize->add_section( $d['section'] , array(
				'title' => __( $d['label'], 'starter' ),
				'priority' => 10,
				'panel' => 'dimensions-panel',
			) );
		}
		$wp_customize->add_setting( $d['name'], array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( $d['name'], array(
				'label' => __( 'Height', 'textdomain' ),
				'settings' => $d['name'],
				'priority' => 14,
				'section' => $d['section'],
				'type' => 'text',
			)
		);
	}

	// --------------------------------
	// dimensions - margin
	// --------------------------------
	$data = $settings['margin'];
	foreach($data as $d) {
		if( $wp_customize->get_section( $d['section']) === null) {
			$wp_customize->add_section( $d['section'] , array(
				'title' => __( $d['label'], 'starter' ),
				'priority' => 10,
				'panel' => 'dimensions-panel',
			) );
		}
		$wp_customize->add_setting( $d['name'], array(
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( $d['name'], array(
				'label' => __( 'Margin', 'textdomain' ),
				'settings' => $d['name'],
				'priority' => 15,
				'section' => $d['section'],
				'type' => 'text',
			)
		);
	}

	// --------------------------------
	// dimensions - padding
	// --------------------------------
	$data = $settings['padding'];
	foreach($data as $d) {
		if(isset($defaults[$d['name']])) {
			$default = $defaults[$d['name']];
		}
		else if($defaults['padding']) {
			$default = $defaults['padding'];
		} else {
			$default = '15px';
		}
		if( $wp_customize->get_section( $d['section']) === null) {
			$wp_customize->add_section( $d['section'] , array(
				'title' => __( $d['label'], 'starter' ),
				'priority' => 10,
				'panel' => 'dimensions-panel',
			) );
		}
		$wp_customize->add_setting( $d['name'], array(
				'default' => $default,
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$label = 'Padding';
		if(isset($d['custom'])) {
			$label = $d['custom'].' '.$label;
		}
		$wp_customize->add_control( $d['name'], array(
				'label' => __( $label, 'textdomain' ),
				'settings' => $d['name'],
				'priority' => 16,
				'section' => $d['section'],
				'type' => 'text',
			)
		);
	}

	// --------------------------------
	// border
	// --------------------------------
	$wp_customize->add_panel( 'border-panel' , array(
		'priority' => 30,
		'title' => __( 'Borders', 'starter' ),
		'description' => 'Border Settings',
	) );
	$data = $settings['borders'];
	foreach($data as $d) {
		if( $wp_customize->get_section( $d['section']) === null) {
			$wp_customize->add_section( $d['section'] , array(
				'title' => __( $d['label'], 'starter' ),
				'priority' => 10,
				'panel' => 'border-panel',
			) );
		}
		$pos = array('top','right','bottom','left');
		$atr = array('style','width','radius','color');
		foreach($atr as $a) {
			if($a === 'style') {
				$default = 'none';
				if(isset($defaults[$d['name'].'-'.$a])) {
					$default = $defaults[$d['name'].'-'.$a].' ';
				}
				$wp_customize->add_setting( $d['name'].'-'.$a, array(
					'default' => $default,
					'type' => 'theme_mod',
					'capability' => 'edit_theme_options'
				), );
				$wp_customize->add_control( $d['name'].'-'.$a, array(
					'label' => ucfirst($a),
					'description' => 'Supported: dotted, dashed, solid, double, groove, ridge, inset, outset',
					'default' => $default,
					'settings' => $d['name'].'-'.$a,
					'priority' => 14,
					'section' => $d['section'],
					'type' => 'text',
				), );
			}
			elseif($a === 'color') {
				foreach($pos as $p) {
					$default = '#cccccc';
					if(isset($defaults[$d['name'].'-'.$p.'-'.$a])) {
						$default = $defaults[$d['name'].'-'.$p.'-'.$a].' ';
					}
					else if(isset($defaults['border-color'])) {
						$default = $defaults['border-color'];
					}
					$wp_customize->add_setting( $d['name'].'-'.$p.'-'.$a, array(
						'default' => $default,
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options'
					), );
					$wp_customize->add_control(
						new WP_Customize_Color_Control(
							$wp_customize,
							$d['name'].'-'.$p.'-'.$a,
							array(
								'label' => ucfirst($p).' '.ucfirst($a),
								'mode'     => 'full',
								'section'  => $d['section'],
								'priority' => 14,
								'default' => $default,
							)
						)
					);
				}
			} else {
				$default = '';
				if(isset($defaults[$d['name'].'-'.$a])) {
					$default = $defaults[$d['name'].'-'.$a].' ';
				}
				$wp_customize->add_setting( $d['name'].'-'.$a, array(
					'default' => $default,
					'type' => 'theme_mod',
					'capability' => 'edit_theme_options'
				), );
				$wp_customize->add_control( $d['name'].'-'.$a, array(
					'label' => ucfirst($a),
					'settings' => $d['name'].'-'.$a,
					'priority' => 14,
					'section' => $d['section'],
					'type' => 'text',
				), );
			}
		}
	}

	// --------------------------------
	// fonts
	// --------------------------------
	$wp_customize->add_panel( 'fonts-panel' , array(
		'priority' => 30,
		'title' => __( 'Fonts', 'starter' ),
		'description' => 'Font Settings',
	) );
	$data = $settings['fonts'];
	foreach($data as $d) {
		$panel = 'fonts-panel';
		if(isset($d['panel'])) {
			$panel = $d['panel'];
		}
		$wp_customize->add_section( $d['section'] , array(
			'title' => __( $d['label'], 'starter' ),
			'priority' => 11,
			'panel' => $panel,
		) );
		$wp_customize->add_setting( $d['name'].'-color', array(
				'default' => '#000000',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$label = 'Text Color';
		if(isset($d['custom'])) {
			$label = $d['custom'].' Color';
		}
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$d['name'].'-color',
				array(
					'label' => __( $label, 'textdomain' ),
					'mode'     => 'full',
					'section'  => $d['section'],
					'priority' => 10,
				)
			)
		);
		$label = 'Text Size';
		if(isset($d['custom'])) {
			$label = $d['custom'].' Size';
		}
		$wp_customize->add_setting( $d['name'].'-size', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( $d['name'].'-size', array(
			'label' => $label,
			'settings' => $d['name'].'-size',
			'priority' => 10,
			'section' => $d['section'],
			'type' => 'text',
		), );
		$label = 'Bold Text';
		if(isset($d['custom'])) {
			$label = 'Bold '.$d['custom'];
		}
		$wp_customize->add_setting( $d['name'].'-weight', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( $d['name'].'-weight', array(
			'label' => $label,
			'settings' => $d['name'].'-weight',
			'priority' => 10,
			'section' => $d['section'],
			'type' => 'checkbox',
		), );
	}


	// --------------------------------
	// links
	// --------------------------------
	$modes = array('','hover','active');
	$data = $settings['links'];
	foreach($data as $d) {

		if( $wp_customize->get_section( $d['section']) === null) {
			$wp_customize->add_section( $d['section'] , array(
				'title' => __( $d['label'], 'starter' ),
				'priority' => 10,
				'panel' => 'fonts-panel',
			) );
		}

		foreach($modes as $m) {
			if($m !== '') {
				$m = ' '.$m;
			}
			$label = $d['label'].$m;
			if(isset($d['custom'])) {
				$label = $d['custom'].$m;
			}

			$default = '#000000';
			if(isset($d['decoration']) && $d['decoration'] === 'border') {
				$default = '#ccc';
			}
			else if(isset($d['decoration']) && $d['decoration'] === 'background') {
				$default = '#fff';
			}

			$wp_customize->add_setting( $d['name'].$m.'-color', array(
					'default' => $default,
					'type' => 'theme_mod',
					'capability' => 'edit_theme_options'
				),
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$d['name'].$m.'-color',
					array(
						'label' => __( $label, 'textdomain' ),
						'mode'     => 'full',
						'section'  => $d['section'],
						'priority' => 11,
					)
				)
			);
			if(!isset($d['decoration']) || $d['decoration'] === 'text') {
				$label = $d['label'].$m.' decoration';
				if(isset($d['custom'])) {
					$label = $d['custom'].$m.' decoration';
				}
				$wp_customize->add_setting( $d['name'].$m.'-decoration', array(
						'default' => 'underline',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options'
					),
				);
				$wp_customize->add_control(  $d['name'].$m.'-decoration', array(
					'label' => $label,
					'settings' =>  $d['name'].$m.'-decoration',
					'priority' => 11,
					'section' => $d['section'],
					'type' => 'select',
					'choices' => array(
						'' => '',
						'underline' => 'underline',
					 ),
				), );
			}
		}
	}

	// --------------------------------
	// JS
	// --------------------------------
		$wp_customize->add_setting( 'js-adjust-canvas', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( 'js-adjust-canvas', array(
			'label' => 'Adjust Canvas height to fit page',
			'settings' =>  'js-adjust-canvas',
			'priority' => 11,
			'section' => 'dimensions-section-canvas',
			'type' => 'checkbox',
		), );
		$wp_customize->add_setting( 'js-scroll-canvas', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options'
			),
		);
		$wp_customize->add_control( 'js-scroll-canvas', array(
			'label' => 'Canvas is scrollable',
			'settings' =>  'js-scroll-canvas',
			'priority' => 11,
			'section' => 'dimensions-section-canvas',
			'type' => 'checkbox',
		), );

}
