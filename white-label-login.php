<?php
/**
 * Plugin Name: White Label Login
 * Author: Cameron Jones
 * Author URI: https://cameronjonesweb.com.au
 * Description: Removes WordPress branding from the login page
 * Version: 0.1.1
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
	    	$style .= 'body.login, html[lang] {';
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
		    	$style .= 'body.login #backtoblog, body.login #nav {
		    		margin: 0;
		    		background: #fff;
		    	}

		    	body.login #backtoblog {
		    		padding-top: 16px;
		    		padding-bottom: 16px;
		    		margin-bottom: 16px;
		    	}';
		    }

		    $style .= 'body.login #login {
	    		padding-bottom: 4%;
	    	}';

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