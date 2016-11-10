<div class="column large-4 end">
	<div class="list-item">
		<a href="<?= get_permalink() ?>">
			<div class="info">
				<h3><?= the_title(); ?></h3>
				<hr>
				<p class="excerpt"><?= the_excerpt(); ?></p>
			</div>
			<div class="img" style="background-image: url('<?= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ))[0]; ?>')">
				<?php $cat_classes = ''; include(ROOT. 'inc/categories.php') ?>
			</div>
		</a>
	</div>
</div>