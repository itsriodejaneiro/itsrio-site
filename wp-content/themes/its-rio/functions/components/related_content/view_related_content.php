<div class="related-content content-area" id="tab_<?= array_search(pll__('relacionados'), $data['its_tabs']) ?>">
	<div class="row">
		<h2 class="list-title">
			<?= pll__('conteúdos relacionados') ?>
			<div class="line"></div>
		</h2>
		<div class="related-post">
			<?php
			if ($query->have_posts() ) {
				while( $query->have_posts() ) {
					$query->the_post();
					include(ROOT . 'inc/post-box.php');
				}
			}
			?>
		</div>
	</div>
</div>