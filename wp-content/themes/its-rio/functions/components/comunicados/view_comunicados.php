<its-comunicados inline-template>
	<div class="related-content content-area comunicados" id="tab_<?= array_search('relacionados', $data['its_tabs']) ?>">
		<div class="row">
			<h2 class="list-title">comunicados <a href="javascript:void(0);">ver todos</a></h2>
			<div class="related-post">
				<div class="column large-4" v-for="(item, index) in comunicados.posts ">
					<div class="list-item">
						<a v-bind:href="item.permalink">
							<div class="info">
								<h3 v-html="item.title"></h3>
								<hr>
								<p class="excerpt" v-html="item.excerpt"></p>
								<a v-bind:href="item.permalink"><b>Saiba Mais</b></a>

							</div>
							<div class="img" v-bind:style="{ 'background-image': 'url('+item.thumb+')' }">
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</its-comunicados>