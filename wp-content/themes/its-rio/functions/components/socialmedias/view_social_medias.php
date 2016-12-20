<div class="content-area component-tabs tab component-social-medias" id="tab_<?= array_search($title, $data['its_tabs']) ?>">
	<div class="row">
		<div class="component-tabs-title">
			<h2 class="tab-title list-title">
				<?= $title ?>
				<div class="line"></div>
			</h2>
		</div>
		<div class="tab-content raleway">
			<ul>
				<?php 
				foreach ($this->sociais as $social) {
					?>
					<li><a href="<?= $this->shortcode_atts[$social] ?>"><i class="fa fa-<?= $social ?>"></i></a></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>
