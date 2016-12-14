<div class="column large-4 end">
	<div class="list-item">
		<a href="<?= get_permalink() ?>">
			<div class="info">
				<h3><?= the_title(); ?></h3>
				<hr>
				<p class="excerpt">
					<?= limit_excerpt(get_the_excerpt(), 100); ?>
					<?php if(get_the_excerpt() != ''): ?>
						<a href="<?= get_permalink() ?>"><b>Saiba Mais</b></a>
					<?php endif; ?>
				</p>
			</div>
			<div class="img" style="background-image: url('<?= get_thumbnail_url_full( $post->ID ); ?>')">
				<?php $cat_classes = ''; include(ROOT. 'inc/categories.php') ?>
			</div>
		</a>
	</div>
</div>