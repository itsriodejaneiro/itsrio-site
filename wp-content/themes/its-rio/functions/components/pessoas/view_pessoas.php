<its-pessoas inline-template>
	<div class="content-area component-tabs informacao pessoas" id="tab_<?= array_search($moduleTitle, $data['its_tabs']) ?>">
		<div class="component-tabs-tab">
			<div class="row">
				<div class="component-tabs-title">
					<h2 class="tab-title left list-title">
						<span><?= $moduleTitle; ?></span>
						<div class="line"></div>
					</h2>
				</div>
				<div class="tab-content">
					<div v-for="(pessoa, ip, i) in pessoas" v-if="parseInt(ip) > 0 || ip == 0" class="pessoa">
						<input 
						type="radio" 
						v-bind:checked="pessoa.pessoaActive == ''" 
						v-bind:name="'<?= $moduleTitle ?>_'+ ip" 
						v-bind:id="'pessoa_'+ip+'_' + pessoa.ID"
						/>
						<div class="pessoa-mini">
							<label v-bind:for="'pessoa_'+ip+'_' + pessoa.ID" @click="pessoas.pessoaActive == '' ? pessoa : ''">
								<img v-bind:src="pessoa.thumb" alt="">
								<p><b>{{ pessoa.title }}</b></p>
							</label>
						</div>
					</div>
				</div>
			</div> 
				<div v-bind:class="{ 'active' : pessoas.pessoaActive != '' }"  class="pessoa-info" >
					<div class="close" @click="pessoas.pessoaActive = ''">&times;</div>
					<div class="pessoa-info-content">
						<div class="pessoa-thumb">
							<img v-if="pessoas.pessoaActive.thumb != ''" 
							v-bind:src="pessoas.pessoaActive.thumb" alt="">
						</div>
						<div class="pessoa-text">
							<h2 class="raleway">{{ pessoas.pessoaActive.title }}</h2> 	
							<div v-html="pessoas.pessoaActive.content"></div>
						</div>
					</div>
				</div>
		</div>
	</div>
</its-pessoas>
