<its-pessoas inline-template>
	<div>
		<div class="content-area component-tabs informacao equipe" id="tab_<?= array_search($moduleTitle, $data['its_tabs']) ?>">
			<div v-for="(pessoas_, i, e) in pessoas" v-if="i != 'pessoaActive' && pessoas_ != null" class="component-tabs-tab">
				<div class="row">
					<div class="component-tabs-title">
						<h2 class="tab-title left" v-bind:class="{ 'list-title':  i == '<?= $firstCat ?>' }">
							<span v-if="i == '<?= $firstCat ?>'"><?= $moduleTitle; ?></span>
							<div v-if="i == '<?= $firstCat ?>'" class="line"></div>
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
										<div class="img" v-bind:style="{ 'background-image': 'url('+pessoa.thumb+')' }"></div>
										<div class="name">
											<span v-html="pessoa.title.replace(' ','<br />')"></span>
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
						<div class="img" v-bind:style="{ 'background-image': 'url('+(pessoas_.pessoaActive.thumb || '/wp-content/themes/its-rio/assets/images/pessoa-default.svg')+')' }"></div>
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
		<div class="content-area work-with-us">
			<a href="https://itsrio2.typeform.com/to/jAK7xw" class="typeform-share link button large purple curved-shadow" data-mode="1">trabalhe conosco</a>
			<script>(function(){var qs,js,q,s,d=document,gi=d.getElementById,ce=d.createElement,gt=d.getElementsByTagName,id='typef_orm',b='https://s3-eu-west-1.amazonaws.com/share.typeform.com/';if(!gi.call(d,id)){js=ce.call(d,'script');js.id=id;js.src=b+'share.js';q=gt.call(d,'script')[0];q.parentNode.insertBefore(js,q)}})()</script>
		</div>
	</div>
</its-pessoas>
