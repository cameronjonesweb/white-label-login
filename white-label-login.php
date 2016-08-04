<?php
/**
 * Plugin Name: White Label Login
 * Author: Cameron Jones
 * Author URI: https://cameronjonesweb.com.au
 * Description: Removes WordPress branding from the login page
 * Version: 0.1.2
 * License: GPLv2
 */

class cameronjonesweb_white_label_login {

	private $logo_max_width;

	function __construct() {

		define( 'CJW_WLL_PLUGIN_VER', '0.1.1' );

		// Variables
		$this->logo_max_width = apply_filters( 'white_label_login_logo_max_width', '75' );

		// Actions
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'login_styles' ) );

		// Filters
		add_filter( 'login_headertitle', array( $this, 'login_logo_title' ) );
		add_filter( 'login_headerurl', array( $this, 'login_logo_url' ) );
		add_filter( 'login_body_class', array( $this, 'login_body_class' ) );
	}

	function theme_support() {
		if( !get_theme_support( 'custom-logo' ) ) {
			add_theme_support( 'custom-logo' );
		}
	}

	function login_styles() {

		$style = '';
		$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		$logo_src = apply_filters( 'white_label_login_logo_src', $logo[0] );
		if( !empty( $logo_src ) ) {
			$logo_width = apply_filters( 'white_label_login_logo_width', getimagesize( $logo_src )[0] );
			$logo_height = apply_filters( 'white_label_login_logo_height', getimagesize( $logo_src )[1] );
		}
		$background['color'] = apply_filters( 'white_label_login_background_color', get_theme_mod( 'background_color' ) );
		$background['image'] = apply_filters( 'white_label_login_background_image', get_theme_mod( 'background_image' ) );
		$background['position'] = array( 
			'x' => apply_filters( 'white_label_login_background_position_x', get_theme_mod( 'background_position_x' ) ), 
			'y' => apply_filters( 'white_label_login_background_position_y', 'top' ) 
		);
		$background['repeat'] = apply_filters( 'white_label_login_background_repeat', get_theme_mod( 'background_repeat' ) );
		$background['attachment'] = apply_filters( 'white_label_login_background_attachment', get_theme_mod( 'background_attachment' ) );
		$button['static']['background'] = apply_filters( 'white_label_login_button_background', $background['color'] );
		$button['static']['color'] = apply_filters( 'white_label_login_button_color', $button['static']['background'] !== false ? $this->getContrastYIQ( $button['static']['background'] ) : false );
		$button['static']['border'] = apply_filters( 'white_label_login_button_border', $button['static']['background'] !== false ? 'none' : false );
		$button['static']['text-shadow'] = apply_filters( 'white_label_login_button_text_shadow', $button['static']['background'] !== false ? 'none' : false );
		$button['static']['box-shadow'] = apply_filters( 'white_label_login_button_box_shadow', $button['static']['background'] !== false ? 'none' : false );
		$button['hover']['background'] = apply_filters( 'white_label_login_button_background_hover', $button['static']['background'] !== false ? $this->shadeColor2( $button['static']['background'], 0.1 ) : false );
		$button['hover']['color'] = apply_filters( 'white_label_login_button_color_hover', $button['hover']['background'] !== false ? $this->getContrastYIQ( $button['hover']['background'] ) : false );

		if ( isset( $logo_src ) && !empty( $logo_src ) ) {

			// Logo styles
		    $style .= '
		    #login h1 a, .login h1 a {
	            background-image: url(' . $logo_src . ');
	            background-size: contain;
	            max-width: ' . $this->logo_max_width . '%;
	            width: ' . $logo_width . 'px;
	            height: 0;
	            padding-bottom: ' . ( $logo_width <= 320 ? $logo_height / 320 * 100 : $logo_height * ( 320 / $logo_width ) / 320 * $this->logo_max_width ) . '%;
	        }';
	    }

	    if( isset( $background ) && !empty( $background ) ) {

	    	// Background styles
	    	$style .= 'body.cameronjonesweb_white_label_login, html[lang] {';
	    	foreach( $background as $key => $val ) {
	    		if( !empty( $val ) ) {
		    		if( $key == 'color' ) {
		    			$style .= 'background-' . $key . ': #' . $val . ';';
		    		} else if( $key == 'image' ) {
		    			$style .= 'background-' . $key . ': url(' . $val . ');';
		    		} else if( $key == 'position' ) {
		    			$style .= 'background-' . $key . ': ' . $val['y'] . ' ' . $val['x'] . ';';
		    		} else {
			    		$style .= 'background-' . $key . ': ' . $val . ';';
			    	}
			    }
	    	}
	    	$style .= '}';

	    	// Sub form links
	    	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	    	// Minimal Login by Aaron Rutley removes these links so don't bother including these styles if it's active
	    	if( !is_plugin_active( 'minimal-login/minimal_login.php' ) ) {
		    	$style .= 'body.cameronjonesweb_white_label_login #backtoblog, body.cameronjonesweb_white_label_login #nav {
		    		margin: 0;
		    		background: #fff;
		    		background: rgba( 255, 255, 255, 0.9 );
		    	}

		    	body.cameronjonesweb_white_label_login #backtoblog {
		    		padding-top: 16px;
		    		padding-bottom: 16px;
		    		margin-bottom: 16px;
		    	}

		    	body.cameronjonesweb_white_label_login form {
		    		padding-bottom: 26px;
		    	}

		    	body.cameronjonesweb_white_label_login #nav {
		    		padding-top: 20px;
		    	}';
		    }

		    $style .= 'body.cameronjonesweb_white_label_login #login {
	    		padding-bottom: 4%;
	    	}';

	    }

	    if( isset( $button ) && !empty( $button ) ) {

	    	// Button styles
	    	$style .= 'body.cameronjonesweb_white_label_login.wp-core-ui .button-primary {';
    		foreach( $button['static'] as $key => $val ) {
    			if( !empty( $val ) ) {
	    			if( $key == 'background' || $key == 'color' ) {
	    				$style .= $key . ': #' . $val . ';';
	    			} else {
	    				$style .= $key . ': ' . $val . ';';
	    			}
	    		}
    		}
	    	$style .= '}';

	    	// Hover styles
	    	$style .= 'body.cameronjonesweb_white_label_login.wp-core-ui .button-primary:hover {';
	    	foreach( $button['hover'] as $key => $val ) {
	    		if( !empty( $val ) ) {
		    		if( $key == 'background' || $key == 'color' ) {
	    				$style .= $key . ': #' . $val . ';';
	    			} else {
	    				$style .= $key . ': ' . $val . ';';
	    			}
	    		}
	    	}
	    	$style .= '}';

	    }

	    if( isset( $style ) && !empty( $style ) ) {
	    	echo '<style type="text/css">' . $style . '</style>';
	    }

	}

	function login_logo_url() {
	    return home_url();
	}

	function login_logo_title() {
	    return get_bloginfo( 'title' ) . ' - ' . get_bloginfo( 'description' );
	}

	// @link 24ways.org/2010/calculating-color-contrast/
	function getContrastYIQ( $hexcolor ){
		$r = hexdec( substr( $hexcolor, 0, 2 ) );
		$g = hexdec( substr( $hexcolor, 2, 2 ) );
		$b = hexdec( substr( $hexcolor, 4, 2 ) );
		$yiq = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;
		return ( $yiq >= 128 ) ? 'black' : 'white';
	}

	// @link stackoverflow.com/questions/5560248/programmatically-lighten-or-darken-a-hex-color-or-rgb-and-blend-colors#comment47516018_13542669
	function shadeColor2( $color, $percent ) {
	    $t = $percent < 0 ? 0 : 255;
	    $p = $percent < 0 ? $percent * -1 : $percent;
	    $RGB = str_split( $color, 2 );
	    $R = hexdec( $RGB[0] );
	    $G = hexdec( $RGB[1] );
	    $B = hexdec( $RGB[2] );
	    return substr( dechex( 0x1000000 + ( round( ( $t - $R ) * $p ) + $R ) * 0x10000 + ( round( ( $t - $G ) * $p ) + $G ) * 0x100 + ( round( ( $t - $B ) * $p ) + $B ) ), 1 );
	}

	function login_body_class( $classes ) {
		$classes[] = 'cameronjonesweb_white_label_login';
		return $classes;
	}
	
}

$cameronjonesweb_white_label_login = new cameronjonesweb_white_label_login;