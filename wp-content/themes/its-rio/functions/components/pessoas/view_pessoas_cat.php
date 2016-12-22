<its-pessoas inline-template>
	<div>
		<div class="content-area component-tabs informacao equipe" id="tab_<?= array_search($moduleTitle, $data['its_tabs']) ?>">
			<div v-for="(pessoas_, i, e) in pessoas" v-if="i != 'pessoaActive'" class="component-tabs-tab">
				<div class="row">
					<div class="component-tabs-title">
						<h2 class="tab-title left" v-bind:class="{ 'list-title':  e == 0 }">
							<span v-if="e == 0"><?= $moduleTitle; ?></span>
							<div v-if="e == 0" class="line"></div>
							<span v-else>&nbsp;</span>
						</h2>
					</div>
					<div class="tab-content">
						<h3 class="list-title">
							{{ i }}
							<div class="line"></div>
						</h3>
						<p><?= $moduleExcerpt; ?></p>
						<input type="checkbox" v-bind:id="'check_informacoes_' + i">
						<label v-bind:for="'check_informacoes_' + i" class="label-tab" ></label>
						<div class="component-tabs-content">
							<div v-for="(pessoa, ip) in pessoas_" v-if="i != 'pessoaActive' && ip != 'pessoaActive'" class="pessoa">
								<input type="radio" v-bind:checked="pessoa.pessoaActive == ''" v-bind:name="'<? $moduleTitle ?>_'+ i" v-bind:id="'pessoa_'+i+'_' + pessoa.ID">
								<div class="pessoa-mini">
									<label v-bind:for="'pessoa_'+i+'_' + pessoa.ID" @click="openPessoaCat(pessoa, i,pessoas_)">
										<img v-bind:src="pessoa.thumb" alt="">
										<div class="name">
											{{ pessoa.title }}
											<div class="line"></div>
										</div>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div> 
				<div v-bind:class="{ 'active' : pessoas_.pessoaActive != '' }"  class="pessoa-info">
					<div class="pessoa-info-content">
						<div class="pessoa-thumb">
							<img v-bind:src="pessoas_.pessoaActive.thumb" alt="">
						</div>
						<div class="pessoa-text">
							<h3>{{ pessoas_.pessoaActive.title }}</h3>
							<div v-html="pessoas_.pessoaActive.content"></div>
						</div>
						<div class="close" @click="pessoas_.pessoaActive = ''">&times;</div>
					</div>
				</div>
			</div>
		</div>
		<div class="work-with-us">
			<a href="" class="button large purple curved-shadow">trabalhe conosco</a>
		</div>
	</div>
</its-pessoas>
