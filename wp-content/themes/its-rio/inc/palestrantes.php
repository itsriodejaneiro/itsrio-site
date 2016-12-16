<p class="raleway pessoas">
	<?php if(isset($meta['its_pessoas'])): ?>
		<?= $label ?>
		<b>
			<?php
			$ids = $meta['its_pessoas'];
			$html = '';
			$query_pessoas = get_posts(['post_type' => 'pessoas', 'post__in' => $ids ]);
			$i = 0;
			foreach ($query_pessoas as $post){
				$html .= ' <span onclick="goToPerson('.$i.')"> <a href="javascript:void(0);">'. get_the_title() . '</a>,</span>';
				$i++;
			}
			echo rtrim($html,',');
			?>
		</b>
	</p>
	<?php
	else:
		the_excerpt();
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