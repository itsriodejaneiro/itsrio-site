<?php
get_header();
the_post();
?>
<div class="row row-menu header-single">
	<h1><?php the_title() ?></h1>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div id="post-number" class="sidebar center">
		<p><?= $title['singular'].'#'.get_post_number(get_the_ID()) ?></p>
	</div>
	<div class="single-menu">
		<ul>
			<li v-for="(tab, i) in tabs">
				<a v-bind:href="'#tab_' + i">{{ tab.title }}</a>
			</li>
		</ul>
	</div>
	<div class="sidebar">
		<a href="#" class="btn-big curved-shadow">inscreva-se</a>
	</div>
</div>
<div class="row">
	<div class="tab" v-for="(tab, i) in tabs" v-bind:id="'tab_' + i">
		<div class="tab-title list-title">{{ tab.title }}</div>
		<div class="tab-content" v-html="tab.content"></div>
	</div>
	<?php the_content();  ?>
	<?php // dd($aulas) <-- ESSA VARIAVEL CONTEM TODAS AS AULAS ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"></script>
<script>
	'use strict';
	var data = { <?= $data ?> };

	new Vue({
		el : '#content',
		data,

	})
</script>

<!--
<div class="row">
	<div class="column large-12">

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
-->	<?php get_footer(); ?>
