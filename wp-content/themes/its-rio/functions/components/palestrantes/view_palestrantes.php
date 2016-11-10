<?php
if(in_array($title['singular'], ['curso','varanda'])){
	?>
	<div class="content-area tab content-palestrantes">
		<div class="row">
			<h2 class="tab-title list-title left"><?= $title['singular'] == 'curso' ? 'professores' : 'palestrantes' ?></h2>
			<div class="tab-content">
				<?php
				$ids = $meta['its_palestrantes'];
				$query_palestrantes = get_posts(['post_type' => 'palestrantes', 'post__in' => $ids ]);
				foreach ($query_palestrantes as $post){
					$a = (array)$post;
					?>
					<div class="palestrante">
						<input type="radio" name="palestrantes" <?= !isset($p_i)?'checked': ''; ?> id="chk_palestrante_<?= get_the_ID(); ?>">
						<div class="palestrante-mini">
							<label for="chk_palestrante_<?= get_the_ID(); ?>">
								<img src="<?= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ))[0]; ?>" alt="">
								<p><?= get_the_title(); ?></p>
							</label>
						</div>
						<div class="palestrante-info">
							<div class="palestrante-info-content">
								<img src="<?= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ))[0]; ?>" alt="">
								<h4><?= get_the_title(); ?></h4>
								<p><?= $a['post_content']; ?></p>
							</div>
						</div>
					</div>
					<?php
					$p_i = '';
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
?>
<div class="content-area" style="padding:0"></div>
