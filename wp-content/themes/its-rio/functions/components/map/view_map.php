<its-map inline-template>	
	<div class="content-area component-tabs map" id="tab_<?= array_search('tema', jQuerydata['its_tabs']) ?>">
		<div class="row" style="padding: 50px 0;">
			<h2 class="tab-title list-title left"><?= $title ?></h2>

			<div class="tab-content raleway">
				<p><?= $content ?></p>
			</div>

			<div id="marker-editor">
				<a 
				href="javascript:void(0);" 
				v-bind:class="{ 'lock' : editor.editing != false }" 
				@click="editor.editing = 'adicionar'" 
				class="button red"
				>Adicionar Marcador</a>

				<a 
				href="javascript:void(0);" 
				v-bind:class="{ 'lock' : editor.editing == false && editor.editing != 'adicionar' }"
				@click="deleteMarker" 
				class="button red"
				>Excluir Marcador</a>

				<a 
				href="javascript:void(0);" 
				v-if="editor.editing == 'adicionar'" 
				@click="finishEditing" 
				class="button red"
				>Finalizar Edição</a>
			</div>
		</div>
		<div id="map-editor">
			<div v-show="editor.markerInfoEdit" id="markerInfoBox">
				<a href="javascript:void(0);" class="close" @click="editor.markerInfoEdit = false">&times;</a>
				<h5>Informações</h5>
				<h6>Adicionar informação</h6>
				<div class="column large-12 no-p">
					<label>Título
						<input type="text" v-model="editor.editingMarker.newInfo.title" />
					</label>
				</div>
				<div class="column large-12 no-p">
					<label>Texto:
						<input type="text" v-model="editor.editingMarker.newInfo.text" />
					</label>
				</div>
				<div class="column large-12 no-p">
					<label>URL da Imagem:
						<input type="text" v-model="editor.editingMarker.newInfo.image" />
					</label>
				</div>
				<a href="javascript:void(0);" @click="addMarkerInfo" class="button">Inserir</a>
				<h6 v-if="editor.editingMarker.infos.length > 0">Informações cadastradas</h6>
				<div v-for="(box, i) in editor.editingMarker.infos" class="box-info">
					<div class="column large-6 no-p-l">
					<img v-bind:src="box.image" alt="">
					</div>
					<div class="column large-6 no-p">
						<b>Título:</b> {{ box.title }}
						<br>
						<b>Texto:</b> <span v-html="box.text"></span>
						<br>
					</div>
				</div>	
			</div>
			<img @click="positionMarker" id="mapa" src="/wp-content/themes/its-rio/assets/images/map.png">
			<img v-show="editor.editing == 'adicionar'" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/map-marker-icon.png" id="marker" class="markers" />
			
			<img
			v-for="(marker, i) in editor.markers" 
			v-bind:style="{ left : marker.coordinates[0]+'px', top : marker.coordinates[1]+'px' }" 
			src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/map-marker-icon.png"
			@click="editMarker(i, $event)"
			class="markers" />

		</div>
	</div>

</its-map>