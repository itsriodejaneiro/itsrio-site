<div class="related-content content-area">
	<div class="row">
		<h1 class="list-title">conteúdo relacionado</h1>
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