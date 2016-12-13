<div class="column large-12">
	<div class="main-carousel">
		<?php
		if ($query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="carousel-cell highlights" style="background-image: url(<?= get_thumbnail_url_full(get_the_ID()) ?>)">
					<div class="info">
						<h2>
							<a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
							<div class="line"></div>
						</h2> 						
						<div class="column large-8 no-p">
							<a href="<?= get_permalink() ?>"><p class="excerpt raleway"><?= get_the_excerpt() ?></p></a>
						</div> 
						<?php $cat_classes = 'black'; include(ROOT. 'inc/categories.php') ?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>
