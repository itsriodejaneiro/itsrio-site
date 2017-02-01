<div class="content-area tab content-media" id="tab_<?= array_search($par_title, $data['its_tabs']) ?>">
	<div class="row">
		<h2 class="tab-title list-title left">
			<?= $par_title ?>
			<div class="line"></div>	
		</h2>
		<div class="tab-content">
			<div class="media-title active">
				<h3><?= $tabs_content_midias[0]['title'] ?></h3>
				<span><?= $tabs_content_midias[0]['description'] ?></span>
				<div class="line"></div>
			</div>
			<div id="media-player">
				<iframe width="600" height="380" src="https://www.youtube.com/embed/<?= $tabs_content_midias[0]['url'] ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="medias-thumbs">
				<?php 
				$i = 0;
				if(count($tabs_content_midias) > 1){
					foreach ($tabs_content_midias as $midia) {
						if(!is_null($midia['url']) && $midia['url'] != '' && $media['url'] != '&#10;'){
							?>
							<div class="thumb-wrapper">
								<div onclick="changeMidia(this, '<?= $midia['title'] ?>');"
									class="img-wrapper <?= $i == 0 ? ' active' : '' ?>">
									<div class="color-hover"></div>
									<img src="http://img.youtube.com/vi/<?= $midia['url'] ?>/hqdefault.jpg" class="midia-thumb"
									>
									<i class="fa fa-play-circle" aria-hidden="true"></i>
								</div>
								<div class="media-title">
									<div class="line"></div>
									<h3><?= $midia['title'] ?></h3>
									<span><?= $midia['description'] ?></span>
								</div>
							</div>
							<?php
							$i++;
						}
					}
				} ?>
			</div>
		</div>
	</div>
</div>