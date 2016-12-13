<div class="content-area tab content-partners">
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
				<?php foreach ($tabs_content as $midia) {
					?>
					<img 
					src="https://img.youtube.com/vi/<?= $midia['url'] ?>/maxresdefault.jpg" 
					onclick="$('#media-player iframe').attr('src','https://www.youtube.com/embed/<?= $midia['url'] ?>')">
					<?php
				} ?>
			</div>
		</div>
	</div>
</div>