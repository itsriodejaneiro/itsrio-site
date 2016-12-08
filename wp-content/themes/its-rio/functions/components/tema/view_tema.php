
<div class="content-area component-tabs tab component-tema" id="tab_<?= array_search('tema', $data['its_tabs']) ?>">
	<div class="row">
		<?php
		if(get_post_type() != 'cursos_ctp' || $closed){
			?>
			<h2 class="tab-title list-title left">tema</h2>
			<?php
		}else{
			?>
			<div class="component-tabs-title">
				<h2 class="tab-title list-title">tema</h2>
				<h5 class="tab-title list-title">valor <i class="fa fa-tag"></i></h5>
				<ul>
					<li><?= $meta['info_valor'][0]; ?></li>
				</ul>
			</div>
			<?php
		} ?>
		<div class="tab-content raleway" style="padding: 0;">
			<h3 class="raleway"><b><?= $title ?></b></h3>
			<p><?= $content ?></p>
		</div>
	</div>
</div>
