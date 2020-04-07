<its-aulas inline-template>
	<div class="content-area component-tabs aulas" id="tab_<?= array_search(pll__('aulas'), $data['its_tabs']) ?>">
		<div class="row">
			<div class="component-tabs-title">
				<h2 class="tab-title list-title">
					<?= pll__('aulas') ?>
					<div class="line"></div>
				</h2>
				<?php if(!$closed): ?>
					<h5 class="tab-title"><?= pll__('agenda') ?> <i class="fa fa-calendar"></i></h5>
					<ul>
						<li v-for="(aula, i) in aulas">
							<b>{{ i + 1 }}º aula</b>
							<br>
							<p>{{ aula.date }}</p>
						</li>
					</ul>
				<?php endif; ?>
			</div>
			<div class="tab-content">
				<div v-for="(aula, i) in aulas" class="component-tabs-tab">
					<h2 class="list-title">
						{{ aula.title }}
						<div class="line"></div>
					</h2>
					<div class="tab-subtitle">
						<p class="left">{{ aula.subtitle }}</p> 
						<p class="aula-pessoas" v-if="aula.palestrante_1 != ''">
							<span @click="goToPersonName(aula.palestrante_1)"  v-if="aula.palestrante_1 != ''"> com {{ aula.palestrante_1 }}</span>
							<span v-if="aula.palestrante_3 != '' && aula.palestrante_2 != ''">,</span>
							<span v-if="aula.palestrante_3 == '' && aula.palestrante_2 != ''"> e</span>
							<span @click="goToPersonName(aula.palestrante_2)"  v-if="aula.palestrante_2 != ''"> {{ aula.palestrante_2 }} </span>
							<span @click="goToPersonName(aula.palestrante_3)"  v-if="aula.palestrante_3 != ''"> e {{ aula.palestrante_3 }} </span>
						</p>
					</div>
					<input type="checkbox" v-bind:id="'check_aula_' + i">
					<label class="label-tab" v-bind:for="'check_aula_' + i"></label>
					<div class="component-tabs-content" v-html="aula.content"> </div>
				</div>
			</div>
		</div>
	</div>
</its-aulas>