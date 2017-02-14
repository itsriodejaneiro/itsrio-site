<?php $categories = get_the_category(); ?>
<div class="categories <?= isset($cat_classes) ? $cat_classes : '' ?>">
	<?= !isset($no_label) || $no_label == false ? $titles[get_post_type()]['plural'] : ''  ?>
	<ul>
		<?php
		foreach ($categories as $category) {
			if($category->slug != 'uncategorized'){
				?>
				<li>
					<a href="/category/<?= $category->slug ?>"><?= $category->name ?></a>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
