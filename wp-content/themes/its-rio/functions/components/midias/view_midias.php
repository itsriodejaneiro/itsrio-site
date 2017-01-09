<div class="content-area tab content-partners" id="tab_<?= array_search($par_title, $data['its_tabs']) ?>">
	<div class="row">
		<h2 class="tab-title list-title left">
			<?= $par_title ?>
			<div class="line"></div>	
		</h2>
		<div class="tab-content">
			<div id="media-player">
				<iframe width="390" height="240" src="https://www.youtube.com/embed/<?= $tabs_content[0]['url'] ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="midias-thumbs">
				<?php 
				if(count($tabs_content) > 1){
					foreach ($tabs_content as $midia) {
						?>
						<img 
						src="https://img.youtube.com/vi/<?= $midia['url'] ?>/maxresdefault.jpg" 
						onclick="$('#media-player iframe').attr('src','https://www.youtube.com/embed/<?= $midia['url'] ?>')">
						<?php
					}
				} ?>
			</div>
		</div>
	</div>
</div>