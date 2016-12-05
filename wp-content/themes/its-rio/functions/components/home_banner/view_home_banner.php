<div class="column large-12">
	<div class="main-carousel">
		<?php
		if ($query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="carousel-cell highlights" style="background-image: url(<?= get_thumbnail_url_full(get_the_ID()) ?>)">
					<div class="info">
						<a href="<?= get_permalink() ?>">
							<div>
								<h2><?= get_the_title() ?></h2> 
							</div> 
						</a> 
						<hr> 
						<div class="column large-8 no-p">
							<a href="<?= get_permalink() ?>"><p class="excerpt raleway"><?= get_the_excerpt() ?></p></a>
						</div> 
						<?php $cat_classes = ''; include(ROOT. 'inc/categories.php') ?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>
