<?php
$image = $gallery[rand(0,count($gallery) -1)];
?>
<div class="home-cover-carousel-item" style="background-image: url(<?= $image['src'] ?>)">
	<h1>
		<?= $image['title'] ?>
		<br>
		<p class="subtitle"><?= $title ?></p>
	</h1>
</div>
