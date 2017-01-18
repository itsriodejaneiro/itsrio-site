<?php 

$translations = [
	'menu' => [
		'cursos',
		'varandas',
		'projetos',
		'publicações',
		'institucional',
	],
	'busca' => ['busca']
];

foreach ($translations as $group => $value) {
	pll_register_string( $group .' '.$value, $value, $group);
}