<div class="main-carousel-wrapper column small-12">
	<div class="main-carousel">
		<?php
        global $titles;
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
				$meta = get_post_meta(get_the_ID());
				$postType = get_post_type(); ?>
				<div <?php post_class('carousel-cell highlights'); ?> style="background-image: url(<?= get_thumbnail_url_banner(get_the_ID()) ?>)">
					<div class="color-hover"></div>
					<div class="info">
						<a href="<?= get_post_permalink() ?>">
							<div class="header">
								<?php
                                if (in_array($postType, ['cursos_ctp','varandas_ctp'])) {
                                    include ROOT.'inc/archive/info-curso-varanda.php';
                                } elseif(in_array($postType, ['projetos_ctp','publicacoes_ctp'])){
                                    include ROOT.'inc/archive/info-projeto-publi.php';
                                } ?>
							</div>
						</a>
						<div class="line show-for-medium"></div>
						<div class="column large-12 no-p show-for-medium">
							<?php $cat_classes = 'black';
                include(ROOT.'inc/categories.php'); ?>
						</div>
					</div>
					<div class="categories-wrapper show-for-small-only">
						<?php $cat_classes = 'black';
                include(ROOT. 'inc/categories.php'); ?>
					</div>
					<a href="<?= get_permalink() ?>" class="post-link"></a>
				</div>
				<?php

            }
        }
        ?>
	</div>
</div>
