<?php
/**
 * Plugin Name: White Label Login
 * Author: Cameron Jones
 * Author URI: https://cameronjonesweb.com.au
 * Description: Removes WordPress branding from the login page
 * Version: 0.1.0
 * License: GPLv2
 */

class cameronjonesweb_white_label_login {

	function __construct() {

		define( 'CJW_WLL_PLUGIN_VER', '0.1.0' );

		// Actions
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'login_styles' ) );

		// Filters
		add_filter( 'login_headertitle', array( $this, 'login_logo_title' ) );
		add_filter( 'login_headerurl', array( $this, 'login_logo_url' ) );
	}

	function theme_support() {
		if( !get_theme_support( 'custom-logo' ) ) {
			add_theme_support( 'custom-logo' );
		}
	}

	function login_styles() {

		$style = '';
		$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		$background['color'] = get_theme_mod( 'background_color' );
		$background['image'] = get_theme_mod( 'background_image' );
		$background['position'] = array( 'x' => get_theme_mod( 'background_position_x' ) );
		$background['repeat'] = get_theme_mod( 'background_repeat' );
		$background['attachment'] = get_theme_mod( 'background_attachment' );

		if ( isset( $logo ) && !empty( $logo ) ) {
		    $style .= '
		    #login h1 a, .login h1 a {
	            background-image: url(' . $logo[0] . ');
	            background-size: contain;
	            max-width: 100%;
	            width: ' . $logo[1] . 'px;
	            height: 0;
	            padding-bottom: ' . ( $logo[1] <= 320 ? $logo[2] / 320 * 100 : $logo[2] * ( 320 / $logo[1] ) / 320 * 100 ) . '%;
	        }';
	    }

	    if( isset( $background ) && !empty( $background ) ) {
	    	$style .= 'body.login, html[lang] {';
	    	foreach( $background as $key => $val ) {
	    		if( !empty( $val ) ) {
		    		if( $key == 'color' ) {
		    			$style .= 'background-' . $key . ': #' . $val . ';';
		    		} else if( $key == 'image' ) {
		    			$style .= 'background-' . $key . ': url(' . $val . ');';
		    		} else if( $key == 'position' ) {
		    			$style .= 'background-' . $key . ': top ' . $val['x'] . ';';
		    		} else {
			    		$style .= 'background-' . $key . ': ' . $val . ';';
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
	
}

$cameronjonesweb_white_label_login = new cameronjonesweb_white_label_login;