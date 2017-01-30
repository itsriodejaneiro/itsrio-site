<its-map inline-template>	
	<div class="content-area component-tabs map" id="tab_wp_mapas">
		<div class="row" style="padding-bottom: 25px;">
			<div id="marker-editor">
				<a 
				href="javascript:void(0);" 
				v-bind:class="{ 'lock' : editing != false }" 
				@click="editing = 'adicionar'" 
				class="button red"
				>Adicionar Marcador</a>

				<a 
				href="javascript:void(0);" 
				v-if="editing == 'editar'" 
				@click="infoEdit" 
				class="button red"
				>Editar</a>

				<a 
				href="javascript:void(0);" 
				v-bind:class="{ 'lock' : editing == false && editing != 'adicionar' }"
				@click="deleteMarker" 
				class="button red"
				>Excluir Marcador</a>

				<a 
				href="javascript:void(0);" 
				v-if="editing == 'adicionar' || editing == 'editar'" 
				@click="finishEditing" 
				class="button red"
				>Finalizar Edição</a>
			</div>
		</div>
		<div id="map-editor">
			<div v-show="markerInfoEdit" id="markerInfoBox">
				<a href="javascript:void(0);" class="close" @click="markerInfoEdit = false">&times;</a>
				<h5>Informações</h5>
				<h6>Adicionar informação</h6>
				<div class="column large-12 no-p">
					<label>Título
						<input type="text" v-model="editingMarker.newInfo.title" />
					</label>
				</div>
				<div class="column large-12 no-p">
					<label>Texto:
						<input type="text" v-model="editingMarker.newInfo.text" />
					</label>
				</div>
				<div class="column large-12 no-p">
					<label>URL da Imagem:
						<input type="text" v-model="editingMarker.newInfo.image" />
					</label>
				</div>
				<a href="javascript:void(0);" @click="addMarkerInfo" v-if="editing == 'editar' && editingEvent == true" class="button">
					Atualizar
				</a>
				<a href="javascript:void(0);" @click="addMarkerInfo" v-else class="button">
					Inserir
				</a>
				<br><br>
				<h6 v-if="editingMarker.infos.length > 0">Informações cadastradas</h6>
				<div v-for="(box, i) in editingMarker.infos" class="box-info">
					<div class="column large-6">
						<img v-bind:src="box.image" alt="">
					</div>
					<div class="column large-6 p">
						<p><b>Título:</b> {{ box.title }}</p>
						<p><b>Texto:</b> <span v-html="box.text"></span></p>
						<a class="button" href="javascript:void(0);" v-if="editing == 'editar'" @click="editingMarker.newInfo = box; editingEvent = true">Editar</a>
						<a class="button" href="javascript:void(0);" v-if="editing == 'editar'" @click="editingMarker.infos.splice(i) = box">Excluir</a>
					</div>
				</div>	
			</div>
			<img @click="positionMarker" id="mapa" src="/wp-content/themes/its-rio/functions/components/map/mapamundi_pontos.svg">
			<img v-show="editing == 'adicionar'" src="/wp-content/themes/its-rio/functions/components/map/map-pin.svg" id="marker" class="markers" />
			
			<img
			v-for="(marker, i) in markers" 
			v-bind:style="{ left : marker.left+'px', top : marker.top+'px' }" 
			src="/wp-content/themes/its-rio/functions/components/map/map-pin.svg"
			@click="editMarker(i, $event)"
			class="markers" />

		</div>
	</div>
</its-map>

<script>
	var markers = <?= file_exists(ROOT.'/functions/components/map/markers.json') ? file_get_contents(ROOT.'/functions/components/map/markers.json') : '[]' ?>;
	var $ = jQuery;

	Vue.component('its-map', {
		data(){
			return {
				editing : false,
				editingEvent : false,
				editingMarker : {
					top : '',
					left : '',
					newInfo : {image : '', title : '', text : ''},
					infos : [],
				},
				deletingMarker : '',
				markers,
				markerInfoEdit : false
			}
		},
		methods:{
			positionMarker(event){
				if(this.editing != false){
					var posx = event.pageX - jQuery('#mapa').offset().left - 20;
					var posy = event.pageY - jQuery('#mapa').offset().top - 20;

					jQuery('#marker').css('left', posx).css('top', posy).show();
					this.editingMarker.top = posy;
					this.editingMarker.left = posx;
					this.markerInfoEdit = true;
				}
			},
			addMarkerInfo(){
				if(this.editing != 'editar' && this.editingEvent == false)
					this.editingMarker.infos.push(this.editingMarker.newInfo);
				this.editingMarker.newInfo = { 'image' : '', 'title' : '', 'text' : '' };
				this.editingEvent = false;
			},
			editMarker(i, event){				
				if($(event.target).hasClass('selected')){
					this.deletingMarker = '';
					this.editing = false;
					$('.markers').removeClass('selected');
				}else{
					this.editing = 'editar';
					this.deletingMarker = i;
					$('.markers').removeClass('selected');
					$(event.target).addClass('selected');
				}
			},
			deleteMarker(){
				var editor = this;
				if(editor.editing != false){
					editor.markers.splice(editor.deletingMarker, 1);
					editor.editing = false;
					$('.markers').removeClass('selected');
					$.post('/wp-content/themes/its-rio/functions/components/map/save_markers.php', { 'markers' : JSON.stringify(editor.markers) });
				}
			},
			infoEdit(){
				this.markerInfoEdit = true;
				this.editingMarker = this.markers[this.deletingMarker];
			},
			finishEditing(){
				var editor = this;
				if(this.editing == 'adicionar')
					editor.markers.push(editor.editingMarker);
				editor.editing = false;
				editor.editingEvent = false;
				editor.markerInfoEdit = false;
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