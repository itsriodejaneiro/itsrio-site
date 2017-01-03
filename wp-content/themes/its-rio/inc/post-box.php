<div class="column small-12 medium-6 large-4 end">
	<div <?php post_class( 'list-item' ); ?>>
		<a href="<?= get_permalink() ?>">
			<div class="info">
				<h3><?= the_title(); ?></h3>
				<div class="line"></div>
				<p class="excerpt">
					<?= limit_excerpt(get_the_excerpt(), 100); ?>
					<?php if(get_the_excerpt() != ''): ?>
						<a href="<?= get_permalink() ?>"><b>Saiba Mais</b></a>
					<?php endif; ?>
				</p>
			</div>
			<!-- <div class="img" style="background-image: url('<?= get_thumbnail_url_card( $post->ID ); ?>')"> -->
			<div class="img" <?= get_thumbnail_style($post->ID,'card'); ?> >
				<div class="color-hover"></div>
			</div>
			<?php $cat_classes = ''; include(ROOT. 'inc/categories.php') ?>
		</a>
	</div>
</div>