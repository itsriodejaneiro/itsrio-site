<its-map inline-template>	
	<div class="content-area component-tabs map" id="tab_<?= array_search($title, $data['its_tabs']) ?>">
		<div class="row">
			<h2 class="tab-title list-title left">
				<?= $title ?>
				<div class="line"></div>	
			</h2>
			<div class="tab-content raleway">
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
		<div class="map-info main-carousel">
			<div class="map-info-carousel pessoa-info" v-bind:class="{ 'active' : selectedMarker != false }">
				<div class="seta-mapa"></div>
				<a class="flickity-prev-next-button previous" type="button" disabled="" aria-label="previous"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg></a>
				<a class="flickity-prev-next-button next" type="button" disabled="" aria-label="next"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></a>
				<div 
				class="map-info-carousel-item carousel-cell" 
				v-for="(info, i) in selectedMarker.infos"
				v-bind:class="{ 'active' : i == 0 }"
				>
					<div class="map-info-content">
						<div class="map-thumb">
							<div class="color-hover"></div>
							<img v-if="info.image != ''" v-bind:src="info.image" alt="">
						</div>
						<div class="map-text">
							<h3 class="raleway">{{ info.title }}</h3> 	
							<div v-html="info.text"></div>
						</div>
						<div class="close" @click="closeMarker">&times;</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</its-map>