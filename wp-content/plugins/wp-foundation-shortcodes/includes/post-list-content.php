<?php
$cell1_class = '';
$cell2_class = 'medium-12';
?>
<article class="post-wrapper">
<header class="post-header">
	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>
<?php if ($meta=='yes'):?>
	<div class="row">
		<div class="column small-12">
			<div class="meta-wrapper format-<?php echo get_post_format();?>">
                                <?php WP_Foundation_shortcodes_plugables::entry_meta();  ?>
                        </div>		
		</div>
	</div>
<?php endif; ?>
<div class="row">	

	<?php if ( has_post_thumbnail() ) : 
		switch($thumbs){
			case "thumbnail":
				$cell1_class = 'medium-3';
				$cell2_class = 'medium-9';
			break;
			case "medium":
				$cell1_class = 'medium-4';
                                $cell2_class = 'medium-8';
			break;
			default:
				$cell1_class = 'medium-12';
                                $cell2_class = 'medium-12';
			break;
		}
	?>
		<div class="columns <?php echo $cell1_class;?>">
			<div class="featured-thumbnail thumbnail">
		              	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumbs, array('class' => 'th') ); ?></a>
      			</div>
		</div>
        <?php endif; ?>

	<div class="columns <?php echo $cell2_class;?>">	
        <div class="post_content">
		<?php 
		if ($post_content == 'excerpt'):
			the_excerpt();
		else:
			the_content( __( 'Continue reading...', 'wp-foundation-shortcodes') );
		endif; ?>
        </div>
        <footer>
                <?php $tag = get_the_tags(); if ($meta=='yes' && $tag) { ?><p><?php the_tags(); ?></p><?php } ?>
        </footer>

	</div><!-- /.columns -->

</div><!-- /.row -->
</article>


