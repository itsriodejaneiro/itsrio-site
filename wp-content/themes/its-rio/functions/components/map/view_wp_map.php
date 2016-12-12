<its-map inline-template>	
	<div class="content-area component-tabs map" id="tab_wp_mapas">
		<div class="row" style="padding-bottom: 25px;">
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

<script>
	var markers = <?= file_get_contents(ROOT.'/functions/components/map/markers.json') ?>;
	var $ = jQuery;

	Vue.component('its-map', {
		data(){
			return {
				editor : {
					editing : false,
					editingMarker : {
						top : '',
						left : '',
						coordinates : '',
						newInfo : {
							image : '',
							title : '',
							text : ''
						},
						infos : [],
					},
					deletingMarker : '',
					markers,
					markerInfoEdit : false
				}
			}
		},
		methods:{
			positionMarker(event){
				var editor = this.editor;
				if(editor.editing != false){
					jQuery('#marker').css('left', event.pageX - 200).css('top', event.pageY - 50).show();
					var posx = jQuery('#marker').offset().left - jQuery('#mapa').offset().left;
					var posy = jQuery('#marker').offset().top - jQuery('#mapa').offset().top;
					editor.editingMarker.top = posy;
					editor.editingMarker.left = posx;
					editor.editingMarker.coordinates = [event.pageX - 200, event.pageY - 50];
					editor.markerInfoEdit = true;
				}
			},
			addMarkerInfo(){
				var editor = this.editor;
				editor.editingMarker.infos.push(editor.editingMarker.newInfo);
				editor.editingMarker.newInfo = { 'image' : '', 'title' : '', 'text' : '' };
			},
			editMarker(i, event){
				this.editor.editing = 'editar';
				this.editor.deletingMarker = i;
				$('.markers').removeClass('selected');
				$(event.target).addClass('selected');
			},
			deleteMarker(){
				var editor = this.editor;
				if(editor.editing != false){
					editor.markers.splice(editor.deletingMarker, 1);
					editor.editing = false;
					$('.markers').removeClass('selected');
					$.post('/wp-content/themes/its-rio/functions/components/map/save_markers.php', { 'markers' : JSON.stringify(editor.markers) });
				}
			},
			finishEditing(){
				var editor = this.editor;
				editor.editing = false;
				editor.markerInfoEdit = false;
				editor.markers.push(editor.editingMarker)
				editor.editingMarker = { newInfo : { image : '', title : '', text : ''}, infos : [] };
				console.log(editor.markers);
				$.post('/wp-content/themes/its-rio/functions/components/map/save_markers.php', { 'markers' : JSON.stringify(editor.markers) });
			}
		}
	});

	new Vue({
		el: '#map-vue-container'
	});
</script>