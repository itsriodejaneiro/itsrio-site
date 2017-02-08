<its-search inline-template>
	<div class="search-box">
		<div class="row">
			<div class="column large-12">
				<form action="/<?= $lang == 'en' ? 'en/search-en/' : 'pt/search/' ?>" method="GET" id="formSearch">
					<a href="#" class="close-button" onclick="toggleBusca()"><?= pll__('fechar') ?> <span class="icon">&times;</span></a>
					<label class="search-label" for="search">
						<h2><?= pll__('buscar por:') ?></h2>
						<input type="text" id="search" name="title" v-model="title" placeholder="<?= pll__('digite sua palavra-chave') ?>">
						<button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
					</label>

					<div class="filter-options" id="cat-filter">
						<h2><?= pll__('filtragem de conteúdo:') ?></h2>

						<div class="filter">
							<h3 class="list-title">
								<?= pll__('área') ?>
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_area" class="ocultar">
							<label class="label-tab" for="search_title_area"></label>
							<div style="overflow: hidden; width: 100%;">
								<input type="checkbox" id="search_cursos" v-model="ctp" name="cpt[]" value="cursos">
								<label for="search_cursos" class="box"><?= pll__('cursos') ?></label>

								<input type="checkbox" id="search_varandas" v-model="ctp" name="cpt[]" value="varandas">
								<label for="search_varandas" class="box"><?= pll__('varandas') ?></label>

								<input type="checkbox" id="search_projetos" v-model="ctp" name="cpt[]" value="projetos">
								<label for="search_projetos" class="box"><?= pll__('projetos') ?></label>

								<input type="checkbox" id="search_publicações" v-model="ctp" name="cpt[]" value="publicacoes">
								<label for="search_publicações" class="box"><?= pll__('publicações') ?></label>
							</div>

						</div>
						<div class="filter hide" id="info_areapesquisa">
							<h3 class="list-title">
								<?= pll__('áreas de pesquisa'); ?>
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_linhas" class="ocultar">
							<label class="label-tab" for="search_title_linhas"></label>
							<div style="overflow: hidden; width: 100%;">
								<?php
								$areas = get_ctp_array('areas');
								foreach ($areas as $id => $area) {
									?>
									<input type="checkbox" id="<?= sanitize_title($area) ?>" value="<?= $id ?>" v-model="info_areapesquisa" name="info_areapesquisa[]">
									<label for="<?= sanitize_title($area) ?>" class="box"><?= $area ?></label>
									<?php
								}
								?>

							</div>
						</div>
						<div class="filter">
							<h3 class="list-title">
								<?= pll__('categorias (assuntos)') ?>
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_categorias" class="ocultar">
							<label class="label-tab" for="search_title_categorias"></label>
							<div style="overflow: hidden; width: 100%;">
								<?php
								$lang_filter = $lang == 'en' ? 'en_US' : 'pt_BR';
								$terms = get_terms('category', ['lang' => 'pt_BR']);
								foreach ( $terms as $term ) {
									if($term->taxonomy == 'category' && $term->name != 'Uncategorized'){
										?>
										<input type="checkbox" id="search_cat_<?= $term->term_id ?>" v-bind:value="<?= $term->term_id ?>" v-model="cat">
										<label for="search_cat_<?= $term->term_id ?>" class="box"><?= $term->name ?></label>
										<?php
									}
								}

								?>
							</div>
						</div>
					</div>

					<a href="#" class="button advanced-search" onclick="openBuscaAvancada()">
						<?= pll__('busca avançada') ?>
						<i class="fa fa-angle-up" aria-hidden="true"></i>
						<i class="fa fa-angle-down" aria-hidden="true"></i>
					</a>
				</form>
			</div>
		</div>
	</div>
</its-search>
