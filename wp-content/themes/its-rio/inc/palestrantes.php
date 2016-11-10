<p class="raleway">
	<?php if(isset($meta['its_palestrantes'])): ?>
		<?= $label ?>
		<b>
			<?php
			$ids = $meta['its_palestrantes'];
			$html = '';
			$query_palestrantes = get_posts(['post_type' => 'palestrantes', 'post__in' => $ids ]);
			foreach ($query_palestrantes as $post)
				$html .= ' '. get_the_title() . ',';
			echo rtrim($html,',');
			?>
		</b>
	</p>
	<?php
	else:
		the_excerpt();
	endif;
	?>