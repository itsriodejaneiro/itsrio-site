<?php
$colors = ['cursos_ctp' => '#9a258f',
'varandas_ctp' => '#00958a',
'publicacoes_ctp' => '#f5821f',
'projetos_ctp' => '#522e91',
'institucionais_ctp' => '#522e91'];
?>
<div class="content-area component-tabs informacoes">
	<div class="row">
		<div class="fazer-minha-inscricao tab-content">
			<div class="column medium-5 large-5 no-p">
				<h1 style="color:<?= $colors[$postType] ?>"><?= $title ?></h1>
			</div>
			<div class="column medium-7 large-7 no-p end">
				<a class="link button large orange curved-shadow" href="<?= $meta['typeform_url'][0] ?>" data-mode="<?= $meta['typeform_layout'][0] ?>" target="_blank">
					<?= $buttonText == '' ? pll__('fazer minha inscrição') : $buttonText  ?>
				</a>			
				<span><?= $subtitle ?></span>
			</div>
		</div>
	</div>
</div>
