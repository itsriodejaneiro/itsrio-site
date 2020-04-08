<?php  global $titles; $meta = get_post_meta(get_the_ID()); ?>
<?php $class = ($post->post_type == 'projetos_ctp') ? 'area-'.$meta['info_areapesquisa'][0] : '' ?>
<?php $class .= ($post->post_type == 'publicacoes_ctp' || $post->post_type == 'comunicados_ctp') ? $post->post_type : '' ?>
<div class="list-item-wrapper column small-12 medium-4 large-4 end <?= $class; ?>">	<div <?php post_class( 'list-item' ); ?>>
		<div class="info">
			<p class="post-type">
				<?php
					$titlesCard = ['cursos_ctp' => 'cursos', 'varandas_ctp' => 'varandas', 'projetos_ctp' => 'projetos', 'publicacoes_ctp' => 'publicações', 'comunicados_ctp' => 'acontece'];
					
					echo pll__($titlesCard[get_post_type()]);
				?>
			</p>
			<h3><a href="<?= get_permalink() ?>"><?= the_title(); ?></a></h3>
			<div class="line"></div>
			<p class="excerpt">
				<?= limit_excerpt(get_the_excerpt(), 100); ?>
				<?php if(get_the_excerpt() != ''): ?>
					<a href="<?= get_permalink() ?>"><b><?= pll__('Saiba Mais') ?></b></a>
				<?php endif; ?>
			</p>
		</div>
		<!-- <div class="img" style="background-image: url('<?= get_thumbnail_url_card( $post->ID ); ?>')"> -->
		<div class="img" <?= get_thumbnail_style($post->ID,'card'); ?> >
			<div class="color-hover"></div>
		</div>
		<?php $cat_classes = ''; include(ROOT. 'inc/categories.php') ?>
		<a href="<?= get_permalink() ?>" class="post-link"></a>
	</div>
</div>
