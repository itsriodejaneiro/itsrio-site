<its-search inline-template>
	<div class="search-box">
		<div class="row">
			<div class="column large-12">
				<form action="<?= get_search_link() ?>" method="GET" id="formSearch">
					<a href="#" class="close-button" onclick="jQuery('.search-box').fadeOut();">fechar <span class="icon">&times;</span></a>
					<label class="search-label" for="search">
						<h2>buscar por:</h2>
						<input type="text" id="search" name="title" v-model="title" placeholder="digite sua palavra-chave">
						<button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
					</label>

					<div class="filter-options">
						<h2>filtragem de conteúdo:</h2>

						<div class="filter">
							<h3 class="list-title">
								área
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_area" class="ocultar">
							<label class="label-tab" for="search_title_area"></label>
							<div style="overflow: hidden; width: 100%;">
								<input type="checkbox" id="search_cursos" v-model="ctp" name="cpt[]" value="cursos_ctp">
								<label for="search_cursos" class="box">cursos</label>

								<input type="checkbox" id="search_varandas" v-model="ctp" name="cpt[]" value="varandas_ctp">
								<label for="search_varandas" class="box">varandas</label>

								<input type="checkbox" id="search_projetos" v-model="ctp" name="cpt[]" value="projetos_ctp">
								<label for="search_projetos" class="box">projetos</label>

								<input type="checkbox" id="search_publicações" v-model="ctp" name="cpt[]" value="publicacoes_ctp">
								<label for="search_publicações" class="box">publicações</label>
							</div>

						</div>
						<div class="filter hide" id="info_areapesquisa">
							<h3 class="list-title">
								áreas de pesquisa
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
								categorias (assuntos)
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_categorias" class="ocultar">
							<label class="label-tab" for="search_title_categorias"></label>
							<div style="overflow: hidden; width: 100%;">
								<?php
								$terms = get_terms();
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
						busca avançada
						<i class="fa fa-angle-up" aria-hidden="true"></i>
						<i class="fa fa-angle-down" aria-hidden="true"></i>
					</a>
				</form>
			</div>
		</div>
	</div>
</its-search>
