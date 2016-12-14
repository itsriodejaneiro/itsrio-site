<its-map inline-template>	
	<div class="content-area component-tabs map" id="tab_<?= array_search('tema', jQuerydata['its_tabs']) ?>">
		<div class="row" style="padding-bottom: 25px;">
			<h2 class="tab-title list-title left">
				<?= $title ?>
				<div class="line"></div>	
			</h2>
			<div class="tab-content raleway" style="width: calc(100% - 240px);">
				<p><?= $content ?></p>
			</div>
		</div>
		<div id="map-editor">
			<img id="mapa" src="/wp-content/themes/its-rio/assets/images/map.png">
			<img
			v-for="(marker, i) in markers" 
			v-bind:style="{ left : marker.left +'px', top : marker.top +'px' }" 
			src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/map-marker-icon.png"
			@click="openMarker(marker)"
			class="markers" />
		</div>
		<div class="map-info">
			<div class="map-info-carousel pessoa-info" v-bind:class="{ 'active' : selectedMarker != false }">
				<div class="map-info-carousel-item" v-for="(info, i) in selectedMarker.infos" v-bind:style="{ 'background-image' : 'url('+ info.image +')' }">
					<div class="close" @click="selectedMarker = false">&times;</div>
					<div class="pessoa-info-content">
						<img v-if="info.image != ''" 
						v-bind:src="info.image" alt="">
						<h3>{{ info.title }}</h3> 	
						<div v-html="info.text"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</its-map>