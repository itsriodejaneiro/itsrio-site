<div class="home-cover"  
data-flickity='{ "freeScroll": false, "autoPlay" : true, "prevNextButtons": false,"pageDots": false 
}'>
	<?php
	foreach ($gallery as $image){
		?>
		<div class="home-cover-carousel-item" style="background-image: url(<?= $image['src'] ?>)">
			<h1>
				<?= $image['title'] ?>
				<br>
				<p class="subtitle"><?= $title ?></p>
			</h1>
		</div>
		<?php
	}
	?>
</div>
