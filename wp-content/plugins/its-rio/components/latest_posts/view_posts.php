<?php
$pageTitle = [
'cursos' => 'próximos cursos',
'varandas' => 'próximas varandas',
'projetos' => 'proximos projetos',
'publicações' => 'próximas publicações'
];
?>
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
			</div>

			<div class="info">
				<h2><?= the_title(); ?></h2>
			</div>
			<?php
		}

	}
	?>

</div>