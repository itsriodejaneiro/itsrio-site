<?php
get_header();
?>
<div class="row row-menu">
	<div class="column large-12 submenu">
			<div class="submenu_info">
				<h1>cursos</h1>
				<img src="http://localhost/wp-content/themes/divi3-master-52cd5a7ba82bf112c8a84aa3d9b0239e5961febc/images/logo.png" alt="">
				<p>Lorem ipsum dolor sit amet</p>
			</div>
			<div class="submenu_description">
				<p>o quê são os cursos?</p>
				<!-- <p class="o-que-sao_description"><?= $o_que_sao ?></p> -->
			</div>
			<div class="submenu_filter">
				filtrar cursos
			</div>

			<div class="show-hide">
				<a href="javascript:void(0);">mostrar</a>
			</div>
		</div>
</div>
<div class="row">
	<div class="column large-12">
		<h1 class="list-title"><?= "próxim{$title['gender']}s {$title['plural']}" ?></h1>
		<?php
		query_posts([
			'post_type' => $post_type,
			]);
			?>
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
	</div>
	<?php get_footer(); ?>
