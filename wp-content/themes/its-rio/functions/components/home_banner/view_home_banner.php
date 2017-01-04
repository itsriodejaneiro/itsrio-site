<div class="main-carousel-wrapper column small-12">
	<div class="main-carousel">
		<?php
		if ($query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				?>
				<div <?php post_class( 'carousel-cell highlights' ); ?> style="background-image: url(<?= get_thumbnail_url_banner(get_the_ID()) ?>)">
					<div class="color-hover"></div>
					<div class="info">
						<h2>
							<a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
							<div class="line"></div>
						</h2> 						
						<div class="categories-wrapper show-for-medium">
							<?php $cat_classes = 'black'; include(ROOT. 'inc/categories.php') ?>
						</div>
						<div class="more-info">
							<a href="<?= get_permalink() ?>">mais sobre a publicação</a>
						</div>
					</div>
					<div class="categories-wrapper show-for-small-only">
						<?php $cat_classes = 'black'; include(ROOT. 'inc/categories.php') ?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>
