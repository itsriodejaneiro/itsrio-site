<its-comunicados inline-template>
	<div class="related-content content-area comunicados" id="tab_<?= array_search(pll__('comunicados'), $data['its_tabs']) ?>">
		<div class="row">
			<h2 class="list-title">
				<?= pll__('acontece') ?> <a href="/<?= $lang ?>/comunicados"><?= pll__('ver todos') ?></a>
				<div class="line"></div>
			</h2>
			<div class="related-post list-item-wrapper">
				<div class="column small-12 medium-4 large-4 end" v-for="(item, index) in comunicados.posts ">
					<div class="list-item">
						<div class="info">
							<h3 v-html="item.title"></h3>
							<div class="line"></div>
							<p class="excerpt" v-html="item.excerpt"></p>
							<a v-bind:href="item.permalink"><b><?= pll__('Saiba Mais') ?></b></a>
						</div>
						<div class="img" v-bind:style="{ 'background-image': 'url('+item.thumb+')' }">
						<div class="color-hover"></div>
						</div>
						<a v-bind:href="item.permalink" class="post-link"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</its-comunicados>