<?php
/**
 * Plugin Name: Beaverlodge Transparent Header
 * Plugin URI: https://beaverlodgehq.com
 * Description: The easiest way to add a transparent header to the Beaver Builder theme.
 * Author: Beaverlodge HQ
 * Author URI: https://beaverlodgehq.com
 * Version: 1.0.1
 */

function bb_transp_scripts() {

	wp_enqueue_script( 'jquery' );	
	wp_enqueue_script( 'bb-theme-transparent', plugins_url( '/bb-theme-transparent.js' , __FILE__ ), array( 'jquery' ) );	
	wp_enqueue_style( 'bb-theme-transparent', plugins_url( '/bb-theme-transparent.css' , __FILE__ ) );

}
add_action( 'wp_enqueue_scripts', 'bb_transp_scripts' );

function bb_transp_customizer( $wp_customize ) {
		
	$wp_customize->add_setting(
		'transp_header'
	);
    
    $wp_customize->add_control(
        'transp_header',
        array(
            'type' => 'checkbox',
            'label' => 'Make transparent header global',
            'section' => 'fl-header-style',
        )
    );

}
add_action( 'customize_register', 'bb_transp_customizer' );


function bb_transp_styles_method() {
	
		$global = get_theme_mod( 'transp_header' );
		$background = get_theme_mod( 'fl-header-bg-color' );
		$opacity = (get_theme_mod( 'fl-header-bg-opacity' ) / 100 );
		$rgb = hextorgb($background);
		$rgba = $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity;
		if ($global == true) {
            $custom_css = "

                    .navbar-transparent {
                      padding-top: 25px !important;
                    }

                    .navbar-transparent {
                        padding-top: 10px !important;
                        border-radius: 0 !important;
                      }

                    .navbar-absolute {
                      position: absolute !important;
                      width: 100% !important;
                      padding-top: 10px !important;
                      z-index: 1029 !important;
                    }

                    .fl-page-header-wrap,
                    .fl-page-nav-right .fl-page-header-wrap {
                        border-bottom: none !important;
                    }

                    .fl-page-nav-wrap,
                    .navbar-default .navbar-collapse, .navbar-default .navbar-form {
                        border: none !important;
                    }
                    .home .navbar-transparent {
                    background-color: rgba({$rgba}) !important;
                    }

            ";
		} else { 
            $custom_css = ""; 
        }
        wp_add_inline_style( 'bb-theme-transparent', $custom_css );
		
}
add_action( 'wp_enqueue_scripts', 'bb_transp_styles_method' );

function hextorgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}
