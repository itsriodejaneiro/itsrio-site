<?php
$ar_o_que_sao = [
'cursos' => 'os cursos',
'varandas' => 'as varandas',
'projetos' => 'os projetos',
'publicacoes' => 'as publicações'
];
?>

<div class="submenu">
	<div class="submenu_info">
		<h1><?= $title ?></h1>
		<img src="http://localhost/wp-content/themes/divi3-master-52cd5a7ba82bf112c8a84aa3d9b0239e5961febc/images/logo.png" alt="">
		<p><?= $description ?></p>
	</div>
	<div class="o-que-sao">
		<p>o quê são <?= $ar_o_que_sao[$postType] ?>?</p>
		<p class="o-que-sao_description"><?= $o_que_sao ?></p>
	</div>
	<div class="submenu_filter">
		filtrar <?= str_replace(['os ','as '], ['',''], $ar_o_que_sao[$postType]); ?>
	</div>

	<div class="show-hide">
		<a href="javascript:void(0);">mostrar</a>
	</div>
</div>