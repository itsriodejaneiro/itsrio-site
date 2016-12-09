let Vue = require('vue');

import { map, filter } from 'lodash';

Vue.prototype.filters = {
	filterBy(list, value){
		return list.filter(function(item) {
			return item.indexOf(value) > -1;
		});
	},
	findBy(list, value){
		return list.filter(function(item) {
			return item == value
		});
	},
	reverse(value){
		return value.split('').reverse().join('');
	},
	limit(i, max){
		return i <= max;
	}
}

Vue.component('its-aulas', {
	data(){
		return { aulas };
	}
});	


Vue.component('its-comunicados', {
	data(){
		return { comunicados };
	}
});	

Vue.component('its-pessoas', {
	data(){
		return { pessoas };
	}
});

Vue.component('its-informacoes', {
	data(){
		return typeof aulas != 'undefined' ? { informacoes, aulas } : { informacoes } ;
	}
});

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
				jQuery('#marker').css('left', event.pageX - 20).css('top', event.pageY - 20).show();
				var posx = jQuery('#marker').offset().left - jQuery('#mapa').offset().left;
				var posy = jQuery('#marker').offset().top - jQuery('#mapa').offset().top;
				editor.editingMarker.top = posy;
				editor.editingMarker.left = posx;
				editor.editingMarker.coordinates = [event.pageX - 20, event.pageY - 20];
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
			$.post('/wp-content/themes/its-rio/functions/components/map/save_markers.php', { 'markers' : JSON.stringify(editor.markers) });
		}
	}
});

new Vue({
	el : '#content_all',
	data : site_data ,
	mounted(){
		$ = jQuery;

		$('.home-cover').css('height',$(window).height()+'px');

		$('.related-post .large-4:gt(2)').hide();

		$('.comunicados h2 > a').click(function(){
			if($(this).text().indexOf("ver") > -1){
				$('.content-area:not(.comunicados)').hide();
				$(this).text('voltar para institucional');

				$('.related-post .large-4').show();

				$('html, body').animate({
					scrollTop: 0
				}, 300);
			}else{
				$('.content-area').show();
				$('.related-post .large-4:gt(2)').hide();

				$(this).text('ver todos');
			}

			$('.comunicados .related-post').masonry({
				columnWidth : '.large-4',
				selector : '.large-4',
				percentPosition: true,
			});
		});

			//Fixa o menu interno no menu global ao dar scroll
		var menu = $('.header-single-menu');

		try{
			var top = menu.position().top;
			$(window).scroll(function(){
				if($(this).scrollTop() >= top - 65)
					menu.addClass('fixed');
				else
					menu.removeClass('fixed');
			});
		}catch(e){}

			//Adiciona a classe de active ao post type correspondente no menu global.
		$("a[href='/"+post_type+"']").parent().addClass('current-menu-item');


			//Smooth scroll
		$('a[href*="#"]:not([href="#"]), .single-menu ul li ').click(function() {
			var el =  $(this).is('a') ? this : $(this).find('a')[0];

			if (location.pathname.replace(/^\//,'') == el.pathname.replace(/^\//,'') && location.hostname == el.hostname) {
				var target = $(el.hash);
				target = target.length ? target : $('[name=' + el.hash.slice(1) +']');
				if (target.length) {
					$('.single-menu ul li a').removeClass('active');
					$(el).addClass('active');

					$('html, body').animate({
						scrollTop: target.offset().top - 100
					}, 300);
					return false;
				}
			}
		});

		$('.comunicados .related-post').masonry({
			columnWidth : '.large-4',
			selector : '.large-4',
			percentPosition: true,
		});
	}
});