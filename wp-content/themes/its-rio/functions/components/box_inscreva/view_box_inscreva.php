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
			<div class="column large-5 no-p">
				<h1 style="color:<?= $colors[$postType] ?>"><?= $title ?></h1>
			</div>
			<div class="column large-7 no-p end">
				<a class="typeform-share link button large orange" href="<?= $meta['typeform_url'][0] ?>" data-mode="<?= $meta['typeform_layout'][0] ?>" target="_blank">
					<?= $buttonText == '' ? 'fazer minha inscrição' : $buttonText  ?>
				</a>
				<span><?= $subtitle ?></span>
			</div>
		</div>
	</div>
</div>
