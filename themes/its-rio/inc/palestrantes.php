<p class="raleway pessoas">
	<?php if(isset($meta['its_pessoas'])): ?>
		<?= $label ?>
		<b>
			<?php
			$ids = $meta['its_pessoas'];
			$html = '';
			$htmlHide = '';
			$query_pessoas = new WP_Query(['post_type' => 'pessoas', 'post__in' => $ids, 'order' => 'ASC', 'orderby' => 'title', 'posts_per_page' => '-1' ] );
			$i = 0;
			while ($query_pessoas->have_posts()){
				$query_pessoas->the_post();
				if($i < 3)
					$html .= ' <span onclick="goToPerson('.$i.')" pessoa="'.get_the_title().'"> <a href="javascript:void(0);">'. get_the_title() . '</a></span>,';
				else
					$htmlHide .= ' <span onclick="goToPerson('.$i.')" pessoa="'.get_the_title().'" class="hide"></span>';

				$i++;
			}
			if(isset($query) && !is_null($query)) $query->reset_postdata();
			$html = rtrim($html,',');
			if($i > 3)
				$html .= ' <span> e mais '. ((int)$i - 3) .'.</span>';

			echo $html.$htmlHide;
			?>
		</b>
	</p>
	<?php
	endif;
	?>
	<script>
		function goToPerson(i){
			pessoas.pessoaActive = pessoas[i];
			scrollToElement('.component-tabs.pessoas');
			$('.pessoa').eq(i).find('input').attr('checked','true');
			setTimeout(function(){ 
				$('.pessoa').eq(i).find('input').attr('checked','true');
			},1100);
		}

		function scrollToElement(sel){
			$('html, body').animate({
				scrollTop: $(sel).offset().top - 80
			}, 1000);
		}
	</script>