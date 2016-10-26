<?php
$pageTitle = [
'cursos' => 'próximos cursos',
'varandas' => 'próximas varandas',
'projetos' => 'proximos projetos',
'publicacoes' => 'próximas publicações'
];
?>
<div class="row">
	<h1 class="list-title"><?= $pageTitle[$post_type] ?></h1>
	<br>
	<div class="highlights">
		<?php

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<div class="img">
					<?php the_post_thumbnail(); ?>
					<div class="categories">
						<ul>
							<?php
							$categories = get_the_category();
							foreach ($categories as $category) {
								?>
								<li>
									<a href="/category/<?= $category->slug ?>"><?= $category->name ?></a>
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>

				<div class="info">
					<h2><?= the_title(); ?></h2>
					<hr>
					<p class="excerpt"><?= the_excerpt(); ?></p>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>