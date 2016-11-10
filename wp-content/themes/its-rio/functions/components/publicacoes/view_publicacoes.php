
<div class="content-area tab content-publicacoes">
	<div class="row">
		<h2 class="tab-title list-title left">
			publicações
		</h2>
		<div class="tab-content">
			<?php
			$ids = $meta['its_publicacoes'];
			$query_publicacoes = get_posts(['post_type' => 'publicacoes_ctp', 'post__in' => $ids ]);

			foreach ($query_publicacoes as $post){
				?>
				<div class="publicacao">
					<a href="javascript:void(0);">
						<img src="<?= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ))[0]; ?>" alt="">
						<h4><?= get_the_title(); ?></h4>
						<p><?= get_the_excerpt(); ?></p>
					</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
