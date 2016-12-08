<its-informacoes inline-template>
	<div class="content-area component-tabs informacoes" id="tab_<?= array_search('informações', $data['its_tabs']) ?>">
		<div class="row">
			<div class="component-tabs-title">
				<h2 class="tab-title list-title">informações</h2>
				<h5 class="label">mais informações</h5>
			</div>
			<div class="tab-content">
				<div v-for="(informacao, i) in informacoes" class="component-tabs-tab">
					<h3 class="list-title">{{ informacao.title }}</h3>
					<input type="checkbox" v-bind:id="'check_informacoes_' + i">
					<label v-bind:for="'check_informacoes_' + i"></label>
					<div
					v-if="informacao.content != '' && informacao.title != 'datas' || (informacao.title == 'datas' && informacao.content != '')"
					class="component-tabs-content"
					v-html="informacao.content"> </div>
					<div
					v-else
					class="component-tabs-content">
					<?php if(get_post_type() == 'cursos_ctp'): ?>
						<div class="columns large-6">
							<p>
								Início das Inscrições:
								<?= date('d \\d\\e F',strtotime($meta['info_inscinicio'][0]))	 ?>
							</p>
						</div>
						<div class="columns large-6">
							<p>
								Fim das Inscrições:
								<?= date('d \\d\\e F',strtotime($meta['info_inscfim'][0]))	 ?>
							</p>
						</div>
						<div v-for="(aula, i) in aulas" class="columns large-6">
							<b>{{ i + 1 }}ª aula</b>
							<p>{{ aula.date }}</p>
						</div>
						<?php
						else: ?>
						<div class="columns large-12"><?= $meta['info_datahorario'][0] ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</its-informacoes>