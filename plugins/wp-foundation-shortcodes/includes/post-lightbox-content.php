<?php if ( has_post_thumbnail() ) : 
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
?>
<a href="<?php echo $thumb['0'];?>">
	<?php the_post_thumbnail( $thumbs_val, array('class' => 'th') ); ?>
</a>
<?php endif; ?>

