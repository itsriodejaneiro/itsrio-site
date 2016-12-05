<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); ?>
<div class="row row-menu header-single" 
	style="background: url(<?= isset($img[0]) ? $img[0] : ''; ?>)">
	<div class="row">

	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
