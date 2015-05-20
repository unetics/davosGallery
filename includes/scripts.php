<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**  Scripts  */
function easy_image_gallery_scripts() {

	global $post;
	// return if post object is not set
	if ( !isset( $post->ID ) )
		return;

	// JS
	wp_register_script( 'pretty-photo', EASY_IMAGE_GALLERY_URL . 'includes/lib/prettyphoto/jquery.prettyPhoto.js', array( 'jquery' ), EASY_IMAGE_GALLERY_VERSION, true );
	wp_register_script( 'fancybox', EASY_IMAGE_GALLERY_URL . 'includes/lib/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), EASY_IMAGE_GALLERY_VERSION, true );
	wp_register_script( 'light-gallery', EASY_IMAGE_GALLERY_URL . 'includes/lib/light-gallery/js/lightGallery.js', array( 'jquery' ), EASY_IMAGE_GALLERY_VERSION, true );

	// CSS
	wp_register_style( 'pretty-photo', EASY_IMAGE_GALLERY_URL . 'includes/lib/prettyphoto/prettyPhoto.css', '', EASY_IMAGE_GALLERY_VERSION, 'screen' );
	wp_register_style( 'fancybox', EASY_IMAGE_GALLERY_URL . 'includes/lib/fancybox/jquery.fancybox-1.3.4.css', '', EASY_IMAGE_GALLERY_VERSION, 'screen' );
	wp_register_style( 'light-gallery', EASY_IMAGE_GALLERY_URL . 'includes/lib/light-gallery/css/lightGallery.css', '', EASY_IMAGE_GALLERY_VERSION, 'screen' );

	$linked_images = easy_image_gallery_has_linked_images();
	// only load the JS if gallery images are linked or the featured image is linked
	if ( $linked_images ) {

		$lightbox = easy_image_gallery_get_lightbox();

		switch ( $lightbox ) {
				
				case 'prettyphoto':			
					wp_enqueue_style( 'pretty-photo' ); // CSS
					wp_enqueue_script( 'pretty-photo' ); // JS
				break;
				
				case 'fancybox':
					wp_enqueue_style( 'fancybox' ); // CSS
					wp_enqueue_script( 'fancybox' ); // JS
				break;
				
				case 'light-gallery':
					wp_enqueue_style( 'light-gallery' ); // CSS
					wp_enqueue_script( 'light-gallery' ); // JS
				break;

				default:break;
			}

		// allow developers to load their own scripts here
		do_action( 'easy_image_gallery_scripts' );

	}

}
add_action( 'wp_enqueue_scripts', 'easy_image_gallery_scripts', 20 );
