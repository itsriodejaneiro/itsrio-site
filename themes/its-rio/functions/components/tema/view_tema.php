
<div class="content-area component-tabs tab component-tema" id="tab_<?= array_search(pll__('tema'), $data['its_tabs']) ?>">
	<div class="row">
		<?php
		if(get_post_type() != 'cursos_ctp' || $closed){
			?>
			<h2 class="tab-title list-title left">
				<?= pll__('tema') ?>
				<div class="line"></div>
			</h2>
			<?php
		}else{
			?>
			<div class="component-tabs-title">
				<h2 class="tab-title list-title">
					<?= pll__('tema') ?>
					<div class="line"></div>
				</h2>
				<?php if(isset($meta['info_valor']) && $meta['info_valor'][0] != ''): ?>
					<h5 class="tab-title list-title">
						<?= pll__('valor') ?> <i class="fa fa-tag"></i>
					</h5>
					<ul>
						<li><?= $meta['info_valor'][0]; ?></li>
					</ul>
				<?php endif; ?>
			</div>
			<?php
		} ?>
		<div class="tab-content raleway" <?php if($closed): ?> style="padding: 0;" <?php endif; ?> >
			<h3 class="raleway"><b><?= $title ?></b></h3>
			<p><?= $content ?></p>
		</div>
	</div>
</div>
