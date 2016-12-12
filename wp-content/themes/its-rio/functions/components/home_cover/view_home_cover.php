<?php
$image = $gallery[rand(0,count($gallery) -1)];
?>
<div class="home-cover-carousel-item" style="background-image: url(<?= $image['src'] ?>)">
	<img src="<?= get_template_directory_uri() ?>/assets/images/logo-black.svg" alt="ITS - Instituto de Tecnologia e Sociedade do Rio" class="logo-cover">
    <div class="button-english curved-shadow">
        <a class="button large" href="">english</a>
    </div>
    <h1>
		<?= $image['title'] ?>
		<br>
		<p class="subtitle"><?= $title ?></p>
	</h1>
    <div class="arrow">
        <img src="<?= get_template_directory_uri() ?>/assets/images/cover-arrow.svg" aria-hidden="true">
        <img src="<?= get_template_directory_uri() ?>/assets/images/cover-arrow.svg" aria-hidden="true">
        <img src="<?= get_template_directory_uri() ?>/assets/images/cover-arrow.svg" aria-hidden="true">
    </div>
</div>
