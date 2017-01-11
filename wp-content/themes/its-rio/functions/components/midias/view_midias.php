<div class="content-area tab content-media" id="tab_<?= array_search($par_title, $data['its_tabs']) ?>">
	<div class="row">
		<h2 class="tab-title list-title left">
			<?= $par_title ?>
			<div class="line"></div>	
		</h2>
		<div class="tab-content">
			<div class="media-title">
				<h3>Lorem Ipsum Dolor Sit Amet</h3>
				<span>com Black Kamen Rider phD.</span>
				<div class="line"></div>
			</div>
			<div id="media-player">
				<iframe width="600" height="380" src="https://www.youtube.com/embed/<?= $tabs_content[0]['url'] ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="medias-thumbs">
				<?php 
				$i = 0;
				if(count($tabs_content) > 1){
					foreach ($tabs_content as $midia) {
						?>
						<div class="thumb-wrapper">
							<div class="img-wrapper">
								<img 
								src="https://img.youtube.com/vi/<?= $midia['url'] ?>/maxresdefault.jpg" 
								onclick="$('#media-player iframe').attr('src','https://www.youtube.com/embed/<?= $midia['url'] ?>');$('.midia-thumb').removeClass('active');$(this).addClass('active');"
								class="midia-thumb <?= $i == 0 ? ' active' : '' ?>"
								>
								<i class="fa fa-play-circle" aria-hidden="true"></i>
							</div>
							<div class="media-title">
								<div class="line"></div>
								<h3>Lorem Ipsum Dolor Sit Amet</h3>
								<span>com Black Kamen Rider phD.</span>
							</div>
						</div>
						<?php
						$i++;
					}
				} ?>
			</div>
		</div>
	</div>
</div>