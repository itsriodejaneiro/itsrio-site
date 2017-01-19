<div class="column small-12 home-area">
	<h3 class="list-title show-for-medium">
		<?= $title ?>
		<div class="line"></div>
	</h3>
	<div class="home-area-carousel">
		<?php
		foreach ($tabs_content_home_areas as $tab) {
			?>
			<div class="carousel-cell home-area-item">
				<div class="area-left">
					<h2 class="area-title">
						<?= $tab['title'] ?>
					</h2>
					<a href="/<?= $lang.'/'.$tab['link'] ?>" class="button curved-shadow show-for-small-only"><?= $tab['link_title'] ?></a>
					<a href="/<?= $lang.'/'.$tab['link'] ?>" class="button large curved-shadow show-for-medium"><?= $tab['link_title'] ?></a>
					</div>
				<div class="area-midia">
					<img src="<?= $tab['midia'] ?>" alt="">
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<div class="color-line show-for-small-only">
		<span></span><span></span><span></span><span></span>
	</div>
</div>
