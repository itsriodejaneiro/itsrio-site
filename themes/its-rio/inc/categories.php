<?php 
$categories = get_the_category(); 
$titlesCard = ['cursos_ctp' => 'cursos', 'varandas_ctp' => 'varandas', 'projetos_ctp' => 'projetos', 'publicacoes_ctp' => 'publicações', 'comunicados_ctp' => 'comunicados', 'videos_ctp' => 'vídeos', 'artigos_ctp' => 'artigos'];
?>
<div class="categories <?= isset($cat_classes) ? $cat_classes : '' ?>">

	<!--<?= !isset($no_label) || $no_label == false || is_null($no_label) ? pll__($titlesCard[get_post_type()]) : ''  ?>-->
	<ul>
		<?php
		foreach ($categories as $category) {
			if($category->slug != 'uncategorized'){
				?>
				<li>
					<a href="/category/<?= $category->slug ?>"><?= $category->name ?></a>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
