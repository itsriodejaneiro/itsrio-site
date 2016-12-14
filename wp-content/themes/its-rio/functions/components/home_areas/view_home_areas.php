<div class="column large-12 home-area">
	<h3 class="list-title">
		<?= $title ?>
		<div class="line"></div>	
	</h3>
	<div class="home-area-carousel">
		<?php 
		foreach ($tabs_content as $tab) {
			?>
			<div class="carousel-cell home-area-item">
				<div class="area-left">
					<h2 class="area-title">
						<?= $tab['title'] ?>
					</h2>
					<a href="<?= $tab['link'] ?>" class="button large curved-shadow"><?= $tab['link_title'] ?></a>
					</div>
				<div class="area-midia">
					<img src="<?= $tab['midia'] ?>" alt="">
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>