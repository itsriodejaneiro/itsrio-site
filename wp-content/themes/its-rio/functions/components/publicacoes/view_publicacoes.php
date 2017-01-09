
<div class="content-area tab content-publicacoes" id="tab_<?= array_search('publicações', $data['its_tabs']) ?>">
	<div class="row">
		<h2 class="tab-title list-title left">
			publicações
			<div class="line"></div>
		</h2>
		<div class="tab-content">
			<?php
			$ids = $meta['its_publicacoes'];
			$query_publicacoes = get_posts(['post_type' => 'publicacoes_ctp', 'post__in' => $ids ]);

			foreach ($query_publicacoes as $post){
				?>
				<div class="publicacao">
					<a href="<?= get_permalink($post->ID); ?>" target="_blank">
						<img src="<?= get_thumbnail_url_full($post->ID); ?>" alt="">
						<h3><?= get_the_title(); ?></h3>
						<p><?= get_the_excerpt(); ?></p>
					</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
