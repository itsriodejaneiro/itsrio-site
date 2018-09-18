<div class="content-area tab content-partners" id="tab_<?= array_search($title, $data['its_tabs']) ?>">
	<div class="row">
		<h2 class="tab-title list-title left">
			<?= $title ?>
			<div class="line"></div>	
		</h2>
		<div class="tab-content">
			<?php
			foreach ($gallery as $image){
				?>
				<div class="partner">
					<a href="<?= $image['title'] ?>" target="_blank">
						<img src="<?= $image['src'] ?>" alt="">
					</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
