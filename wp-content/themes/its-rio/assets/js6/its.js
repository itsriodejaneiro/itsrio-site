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
		return {
			informacoes,
			aulas
		};
	}
});

new Vue({
	el : '#content',
	data : site_data ,
	mounted(){
		$ = jQuery;

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
		$("a[href=<?= $postType ?>]").parent().addClass('current-menu-item');

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

		var _this = this;
		$.ajax({
			type:"POST",
			beforeSend: function (request) {
				request.setRequestHeader("Accept","application/json");
				request.setRequestHeader("Content-Type","application/json");
			},
			url: 'https://medium.com/@ev/latest',
			success: function(data) {
				console.log(data);
				_this.footer.medium = data.payload.references.User.Collection;
			}
		});

		$('.comunicados .related-post').masonry({
			columnWidth : '.large-4',
			selector : '.large-4',
			percentPosition: true,
		});
	}
});