<?php
/**
 * solo Customizer functionality
 *
 * @package solo
 * @subpackage inc/solo
 * @since 1.0
 * 
 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
 */

/** TODO 
 * main width (max)
 * font-size
 * .section-content .page-header .nav-container bk-color
 * site-logo max-height nav links & base-footer background/text color
 */ 

add_action( 'customize_register', 'solo_register_theme_customizer_setup' );

/**
 * Remove parts of the Options menu we don't use.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @since 1.0.2
*/

function solo_register_theme_customizer_setup($wp_customize)
{
	$transport = 'postMessage'; 
    // Theme font choice section
    $wp_customize->add_section( 'title_tagline', array(
        'title'       => __( 'Theme Headings', 'solo' ),
        'capability'  => 'edit_theme_options',
		'priority'    => 15
    ) );
	// Add declare section
    $wp_customize->add_section( 'solo_declare', array(
		'title' => 'Declaration and Top Section',
		'priority' => 20
	  ));
	// Add layout section
    $wp_customize->add_section( 'solo_layout', array(
		'title' => 'Blog and Page Settings',
		'priority' => 25
	  ));

    //-----------------Settings and Controls ------------------
	/* Add setting & control for declaration section 
	*/
	// Lead in text
    $wp_customize->add_setting( 
		'solo_declare_title', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'transport'  => $transport
	));
	$wp_customize->add_control( 
		'solo_declare_title', array(
		'label'   => 'Lead In Title',
		'section'  => 'solo_declare',
		'settings'  => 'solo_declare_title',
		'type'       => 'text',
		'description' => __( 'Enter tag line or lead in text or other. ".declare-title"', 'solo')
	));
	// Text
	$wp_customize->add_setting( 
		'solo_declare_heading', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'transport'  => $transport
	));
	// declare heading control
	$wp_customize->add_control( new WP_Customize_Control( 
		$wp_customize, 'solo_declare_heading',
		array('label' => __( 'Declare Heading', 'solo' ),
			'section'  => 'solo_declare',
			'settings'  => 'solo_declare_heading',
			'type'       => 'text',
			'description' => __( 'Comes after Lead in. can be phone or email maybe.', 'solo')
		) ) 
    );  
	  // Add setting & control for declare image
	  /*
	  $wp_customize->add_setting( 'solo_declare_image', array(
		'default'    => '', //get_template_directory_uri() . '/imgs/default-declare.jpg',
		'capability' => 'edit_theme_options',
		'transport'  => 'refresh'
	  ));
  
	$wp_customize->add_control(	new WP_Customize_Cropped_Image_Control( 
		$wp_customize, 'solo_declare_image', array(
		  'label'   => 'Image',
		  'section'  => 'solo_declare',
		  'context'   => 'declare-image',
		  'flex_width' => false,
		  'flex_height' => true,
		  'width'       => 320,
		  'height'      => 280
		) )
	);
	$wp_customize->add_setting( 
		'solo_declare_bkgheight', array(
		'default'    => '520',
		'capability' => 'edit_theme_options',
		'transport'  => 'refresh'
	));
	$wp_customize->add_control( 'solo_declare_bkgheight', array(
		'label'   => 'declare Section Height',
		'section'  => 'solo_declare',
		'settings'  => 'solo_declare_bkgheight',
		'type'       => 'number',
		'description' => __( 'Sets height of declare section height to include background image. (px)', 'solo')
	));
	*/
	$wp_customize->add_setting( 
		'solo_declare_calltotext', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'transport'  => 'refresh'
	));
	$wp_customize->add_control( 
		'solo_declare_calltotext', array(
		'label'   => __( 'Call To Action Button Text', 'solo' ),
		'section'  => 'solo_declare',
		'settings'  => 'solo_declare_calltotext',
		'type'       => 'text',
		'description' => __( 'Leave blank to remove/not show button.', 'solo')
	));
	$wp_customize->add_setting( 
		'solo_declare_calltourl', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'transport'  => $transport
	));
	$wp_customize->add_control( 
		'solo_declare_calltourl', array(
		'label'   => 'Call To Action Button URL',
		'section'  => 'solo_declare',
		'settings'  => 'solo_declare_calltourl',
		'type'       => 'url',
		'description' => __( 'Styles for button are using ".cta-tinyd"', 'solo')
	));
	$wp_customize->add_setting( 
		'solo_declare_callposition', array(
		'default'    => '4',
		'capability' => 'edit_theme_options',
		'transport'  => 'refresh'
	));
	$wp_customize->add_control( 
		'solo_declare_callposition', array(
		'label'   => 'Call To Action Position',
		'section'  => 'solo_declare',
		'settings'  => 'solo_declare_callposition',
		'type'       => 'number',
		'description' => __( 'Vertical positioning only. Uses em not px. Decimals OK.', 'solo')
	));
	/* ********************** Colors ***************************************
	 */
	// Font color
	$wp_customize->add_setting(
		'solo-font-color',
		array(
			'default'         => '#444444',
			'capability'       => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'solo-font-color',
			array(
				'label'  => 'Font Color',
				'section' => 'colors',
				'settings' => 'solo-font-color'
			)
		)
	);
	// Anchor link color
	$wp_customize->add_setting(
		'solo-link-color',
		array(
			'default'         => '#19299f',
			'capability'       => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'solo-link-color',
			array(
				'label'  => 'Links Color',
				'section' => 'colors',
				'settings' => 'solo-link-color'
			)
		)
	);
	// secondary background color
	$wp_customize->add_setting(
		'solo-second-background',
		array(
			'default'         => '#fafdfd',
			'capability'       => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'solo-second-background',
			array(
				'label' => __( 'Links Background Color', 'solo' ),
				'section' => 'colors',
				'settings' => 'solo-second-background'
			)
		)
	);
	/* ****************** Top Section Declaration **************************
	 */
	// Add setting & control for
	/*
    $wp_customize->add_setting( 
		'solo_blog_layout', array(
		'default'    => 'column',
		'capability' => 'edit_theme_options',
		'transport'  => $transport
	));
	$wp_customize->add_control( 'solo_blog_layout', array(
		'label'       => __( 'Display Blog Posts', 'solo'),
		'section'     => 'solo_layout',
		'settings'    => 'solo_blog_layout',
		'description' => __( 'Choose how to set posts on blog page. Column or Row?', 'solo'),
		'type'        => 'select',
    	'choices'     => array(
        	'default' => 'Select Layout',
        	'row'     => 'Row',
        	'column'  => 'Column'
    		)
	)); */
	// Add setting & control for content alignment
    $wp_customize->add_setting( 'solo_content_align', array(
		'default' => 'justify',
		'capability' => 'edit_theme_options',
		'transport' => 'refresh'
	));
	$wp_customize->add_control( 'solo_content_align', array(
		'label'       => __( 'Text Align Style for Content', 'solo' ),
		'section'     => 'solo_layout',
		'settings'    => 'solo_content_align',
		'description' => __( 'Choose the text alignment for central content.', 'solo'),
		'type'        => 'select',
    	'choices'     => array(
        	'default' => 'Default/Justify',
        	'left'    => 'Left',
			'right'   => 'Right',
        	'justify' => 'Justify',
			'center'  => 'Center'
    		)
	));
	$wp_customize->add_setting( 
		'solo_padding_content', array(
		'default'    => '0',
		'capability' => 'edit_theme_options',
		'transport'  => $transport
	));
	$wp_customize->add_control( 'solo_padding_content', array(
		'label'   => __( 'Content Padding', 'solo' ),
		'section'  => 'solo_layout',
		'settings'  => 'solo_padding_content',
		'type'       => 'number',
		'description' => __( 'Change padding space of Content sections. Mobile not effected.', 'solo')
	));

	// checkbox for page comments
	$wp_customize->add_setting( 
		'solo_pagecomment', array(
			'default'    => false,
			'capability' => 'edit_theme_options'
	) );
	$wp_customize->add_control( 
		'solo_pagecomment', array(
			'label'      => __( 'Allow comments on PAGES', 'solo' ),
			
			'section'     => 'solo_layout',
			'settings'    => 'solo_pagecomment',
			'type'        => 'checkbox',
			'description' => __( 'Display Comments on Pages', 'solo' )
	) ); 
} 