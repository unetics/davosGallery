<?php
/*
Plugin Name: Davos Image Gallery
Plugin URI: http://webwebcreationcentre.com.au/
Description: An easy to use image gallery with drag & drop re-ordering
Version: 1.1.2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Easy_Image_Gallery' ) ) {

	class Easy_Image_Gallery {

		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'constants' ));
			add_action( 'plugins_loaded', array( $this, 'includes' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'easy_image_gallery_plugin_action_links' );
		}

		/** Constants */
		public function constants() {

			if ( !defined( 'EASY_IMAGE_GALLERY_DIR' ) )
				define( 'EASY_IMAGE_GALLERY_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			if ( !defined( 'EASY_IMAGE_GALLERY_URL' ) )
			    define( 'EASY_IMAGE_GALLERY_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			if ( ! defined( 'EASY_IMAGE_GALLERY_VERSION' ) )
			    define( 'EASY_IMAGE_GALLERY_VERSION', '1.1.2' );

			if ( ! defined( 'EASY_IMAGE_GALLERY_INCLUDES' ) )
			    define( 'EASY_IMAGE_GALLERY_INCLUDES', EASY_IMAGE_GALLERY_DIR . trailingslashit( 'includes' ) );

		}

		/** Loads the initial files needed by the plugin. */
		public function includes() {
			require_once( EASY_IMAGE_GALLERY_INCLUDES . 'template-functions.php' );
			require_once( EASY_IMAGE_GALLERY_INCLUDES . 'scripts.php' );
			require_once( EASY_IMAGE_GALLERY_INCLUDES . 'post-type.php' );
			require_once( EASY_IMAGE_GALLERY_INCLUDES . 'metabox.php' );
			require_once( EASY_IMAGE_GALLERY_INCLUDES . 'admin-page.php' );	
				
		}

	}
}

$Easy_Image_Gallery = new Easy_Image_Gallery();