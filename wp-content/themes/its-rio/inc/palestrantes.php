<p class="raleway pessoas">
	<?php if(isset($meta['its_pessoas'])): ?>
		<?= $label ?>
		<b>
			<?php
			$ids = $meta['its_pessoas'];
			$html = '';
			$query_pessoas = get_posts(['post_type' => 'pessoas', 'post__in' => $ids ]);
			foreach ($query_pessoas as $post)
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