<?php if ( has_post_thumbnail() ) : ?>
	<div class="featured-thumbnail thumbnail">
              	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb_size, array('class' => 'th') ); ?></a>
      	</div>
<?php endif; ?>

<h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

<?php if ($meta=='yes'):?>
	<div class="meta-wrapper format-<?php echo get_post_format();?>">
		<?php WP_Foundation_shortcodes_plugables::entry_meta();  ?>
	</div>
<?php endif; ?>

<div class="excerpt">
	<?php echo wp_trim_words(get_the_excerpt(),$excerpt_count);?>
</div>
<footer>
	<?php $tag = get_the_tags(); if ($meta=='yes' && $tag) { ?><p><?php the_tags(); ?></p><?php } ?>
</footer>

