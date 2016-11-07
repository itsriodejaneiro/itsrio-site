<div class="row related-content">
	<h1 class="list-title">conteúdo relacionado</h1>
	<br>
	<div class="related-post">
		<?php
		if ($query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				the_title();
				?>
				<br>
				<?php
			}
		}
		?>
	</div>
</div>