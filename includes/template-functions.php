<?php
/**  Template functions */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.


/** Is gallery */
function easy_image_gallery_is_gallery() {

	$attachment_ids = get_post_meta( get_the_ID(), '_easy_image_gallery', true );

	if ( $attachment_ids ) {
		return true;
	}

	return false;
}


/** Setup Lightbox array */
function easy_image_gallery_lightbox() {

	$lightboxes = array(
		'fancybox' => 'fancyBox',
		'prettyphoto' => 'prettyPhoto',
		'light-gallery' => 'light-gallery',
	);

	return apply_filters( 'easy_image_gallery_lightbox', $lightboxes );

}

/** Get lightbox from settings */

if ( !function_exists( 'easy_image_gallery_get_lightbox' ) ) :
	function easy_image_gallery_get_lightbox() {

		$settings = (array) get_option( 'easy-image-gallery' );

		// set fancybox as default for when the settings page hasn't been saved
		$lightbox = isset( $settings['lightbox'] ) ? esc_attr( $settings['lightbox'] ) : 'prettyphoto';

		return $lightbox;

	}
endif;


/**  Has linked images */
function easy_image_gallery_has_linked_images() {

	$link_images = get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true );

	if ( 'on' == $link_images )
		return true;
}


/** Get list of post types for populating the checkboxes on the admin page */
function easy_image_gallery_get_post_types() {

	$args = array(
		'public' => true
	);

	$post_types = array_map( 'ucfirst', get_post_types( $args ) );

	// remove attachment
	unset( $post_types[ 'attachment' ] );

	return apply_filters( 'easy_image_gallery_get_post_types', $post_types );

}

/**  Retrieve attachment IDs */
function easy_image_gallery_get_image_ids($id = '') {
	global $post;
	if( ! isset( $post->ID) )
		return;

	$attachment_ids = get_post_meta( $id, '_easy_image_gallery', true );
	$attachment_ids = explode( ',', $attachment_ids );
	return array_filter( $attachment_ids );
}


/**  Shortcode */
function easy_image_gallery_shortcode() {
	return easy_image_gallery();
}
add_shortcode( 'easy_image_gallery', 'easy_image_gallery_shortcode' );


/**  Count number of images in array */
function easy_image_gallery_count_images() {

	$images = get_post_meta( get_the_ID(), '_easy_image_gallery', true );
	$images = explode( ',', $images );

	$number = count( $images );

	return $number;
}


/**  Output gallery */
function easy_image_gallery($id, $template ='default') {

	$attachment_ids = easy_image_gallery_get_image_ids($id);

	global $post;

	if ( $attachment_ids ) {
		
		$has_gallery_images = get_post_meta( $id, '_easy_image_gallery', true );

		if ( !$has_gallery_images )
			return;

		// convert string into array
		$has_gallery_images = explode( ',', $has_gallery_images );

		// clean the array (remove empty values)
		$has_gallery_images = array_filter( $has_gallery_images );
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'feature' );
		$image_title = esc_attr( get_the_title( get_post_thumbnail_id( $post->ID ) ) );

		// css classes array
		$classes = array();

		// thumbnail count
		$classes[] = $has_gallery_images ? 'thumbnails-' . easy_image_gallery_count_images() : '';

		// linked images
		$classes[] = easy_image_gallery_has_linked_images() ? 'linked' : '';

		$classes = implode( ' ', $classes );

		$gallery = get_ps_gallery_template($template, $classes, $attachment_ids, $id);

		return apply_filters( 'easy_image_gallery', $gallery );
	}
}



function get_ps_gallery_template($template, $classes, $attachment_ids, $id){
	ob_start();
	?>
    <?php
	    $i = 0;
	    $gallery = array();
		foreach ( $attachment_ids as $attachment_id ) {
			$classes = array( 'popup' );

			// get original image
			$image_link	= wp_get_attachment_image_src( $attachment_id, 'large' );
			$image_link	= $image_link[0];	
			
			$thumb = wp_get_attachment_image_src( $attachment_id, 'thumb' );
			$thumb = $thumb[0];
			
			$mobile = wp_get_attachment_image_src( $attachment_id, 'small' );
			$mobile = $mobile[0];
			
			$content = '.dynamicHtml'.$attachment_id;
			
			
			$gallery[$i]['src'] = $image_link;
			$gallery[$i]['thumb'] = $thumb;
			$gallery[$i]['sub-html'] = $content;
			$gallery[$i]['mobileSrc'] = $mobile;
			$i ++;
			
			} ?>
		
<!--
		<div style="display:none;" class="dynamicHtml<?=$attachment_id?>">
			<div class="custom-html">
				<h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h4>
				<p><?=$attachment_id?><a href="#">try this</a></p>
			</div>
		</div>
-->
		
	<?php $fimage = wp_get_attachment_image_src($attachment_ids[0], 'small' );?>

		
	<figure class="gall">
		<img src="<?= $fimage[0];?>"/>
		<figcaption>
			<h2><?= get_the_title($id);?></h2>
			<a href="javascript:void(0)" id="gallery_<?=$id?>" >view gallery</a>
		</figcaption>
	</figure>
	
	<script type="text/javascript">
  $(document).ready(function() {
    $('#gallery_<?=$id?>').click(function(e){
        $(this).lightGallery({
            dynamic:true,
//             html:true,
            mobileSrc:true,
            caption:true,
			captionLink:true,
            dynamicEl: <?php echo json_encode($gallery);?>,
            onSlideAfter: function() {
	            var $imgurl =  $('.lg-slide.loaded.complete.current img').prop('src');
               $('input[name="image"]').val($imgurl); 
            },
			orderOpen: function() {
               var $imgurl =  $('.lg-slide.loaded.complete.current img').prop('src');
               $('input[name="image"]').val($imgurl); 
            },

        });	
    }) 
  });
  
  </script>
	

    <?php
	return ob_get_clean();
}