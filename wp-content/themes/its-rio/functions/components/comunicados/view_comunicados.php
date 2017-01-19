<its-comunicados inline-template>
	<div class="related-content content-area comunicados" id="tab_<?= array_search(pll__('comunicados'), $data['its_tabs']) ?>">
		<div class="row">
			<h2 class="list-title">
				acontece <a href="javascript:void(0);">ver todos</a>
				<div class="line"></div>
			</h2>
			<div class="related-post list-item-wrapper">
				<div class="column medium-4 large-4" v-for="(item, index) in comunicados.posts ">
					<div class="list-item">
						<a v-bind:href="item.permalink">
							<div class="info">
								<h3 v-html="item.title"></h3>
								<div class="line"></div>
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