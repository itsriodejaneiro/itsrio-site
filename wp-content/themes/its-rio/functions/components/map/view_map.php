<its-map inline-template>	
	<div class="content-area component-tabs map" id="tab_<?= array_search($title, $data['its_tabs']) ?>">
		<div class="row" style="padding-bottom: 25px;">
			<h2 class="tab-title list-title left">
				<?= $title ?>
				<div class="line"></div>	
			</h2>
			<div class="tab-content raleway" style="width: calc(100% - 240px);">
				<p><?= $content ?></p>
			</div>
			<div id="map-editor">
				<img id="mapa" src="/wp-content/themes/its-rio/functions/components/map/mapamundi_pontos.svg">
				<img
				v-for="(marker, i) in markers" 
				v-bind:style="{ left : marker.left +'px', top : marker.top +'px' }" 
				src="/wp-content/themes/its-rio/functions/components/map/map-pin.svg"
				@click="openMarker(marker)"
				class="markers" />
			</div>
		</div>
		<div class="map-info">
			<div class="map-info-carousel pessoa-info" v-bind:class="{ 'active' : selectedMarker != false }">
				<div class="map-info-carousel-item carousel-cell" v-for="(info, i) in selectedMarker.infos" v-bind:style="{ 'background-image' : 'url('+ info.image +')' }">
					<div class="close" @click="closeMarker">&times;</div>
					<div class="map-info-content">
						<div class="map-thumb">
							<div class="color-hover"></div><!--  -->
							<!-- <img v-if="info.image != ''" 
							v-bind:src="info.image" alt=""> -->
							<img src="/wp-content/uploads/2016/07/site2-direitos-autorais-na-pratica-05-1.png" alt="">
						</div>
						<div class="map-text">
							<h3>Convenção XYZ Tecnologia (Recife, PE)</h3>
							<div>Estudou Economia e Administração na Fundação Getulio Vargas do Rio de Janeiro. Possui cursos de Inovação, Criptografia, Psicologia e Filosofia da Mente pela Universidade de Cambridge, Reino Unido. Atuando especialmente nas frentes de Bitcoin, tecnologia blockchain, segurança digital e educação online, é pesquisador do ITS Rio.</div>
							<!-- <h3 class="raleway">{{ info.title }}</h3> 	
							<div v-html="info.text"></div> -->
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</its-map>