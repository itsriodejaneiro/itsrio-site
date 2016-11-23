</div>
<?php global $data; global $components; global $postType; ?>
<script>
	'use strict';

	let aulas = <?= isset($components['aulas']) ? json_encode($components['aulas']) : '""' ?>;
	let informacoes =  <?= isset($components['informacoes']) ? json_encode($components['informacoes']) : '""' ?>;
	let pessoas =  <?= isset($components['pessoas']) ? json_encode($components['pessoas']) : '""' ?>;

	Vue.component('its-aulas', {
		data(){
			return { aulas };
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

	let vue = new Vue({
		el : '#content',
		data : <?= json_encode($data) ?>,
		mounted(){
			$ = jQuery;

			//Fixa o menu interno no menu global ao dar scroll
			var menu = $('.header-single-menu');
			var top = menu.position().top;
			$(window).scroll(function(){
				if($(this).scrollTop() >= top - 65)
					menu.addClass('fixed');
				else
					menu.removeClass('fixed');
			});

			//Adiciona a classe de active ao post type correspondente no menu global.
			$('a[href="/<?= $postType ?>"]').parent().addClass('current-menu-item');

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
		}
	});
</script>

</body>
</html>
