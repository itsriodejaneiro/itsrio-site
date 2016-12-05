<?php global $title; ?>
<div class="categories <?= isset($cat_classes) ? $cat_classes : '' ?>">
	<?= !isset($no_label) ? $title['plural'] : '' ?>
	<ul>
		<?php
		$categories = get_the_category();
		foreach ($categories as $category) {
			?>
			<li>
				<a href="/category/<?= $category->slug ?>"><?= $category->name ?></a>
			</li>
			<?php
		}
		?>
	</ul>
</div>