<?php 

$translations = [
'menu' => [
'cursos',
'varandas',
'projetos',
'publicações',
'institucional',
],
'404' => [
'Página não encontrada',
'Verifique a URL ou digite na ferramenta',
'de busca o que deseja encontrar.'
],
'busca' => ['Busca','busca avançada','categorias (assuntos)','resultados da busca','Nenhum post foi encontrado','buscar por:', 'buscar','filtragem de conteúdo:','área','digite sua palavra-chave'],
'Misc' => ['categorias','categoria','contato','fechar','Saiba Mais','data','ocultar'],
'menu - Singular - ' => [
'curso',
'varanda',
'projeto',
'publicação',
'acontece',
]
];

foreach ($translations as $group => $value) {
	foreach ($value as $v) {
		$name = $group != $v ?  ucwords($group.' '.$v) : ucwords($v);
		pll_register_string($name, $v, $group);
	}	
}

pll_register_string('Título do banner', 'inscrições abertas', 'intermediária');
pll_register_string('Título dos cards', 'cursos futuros', 'intermediária - cursos');
pll_register_string('label para pessoas', 'professores', 'intermediária - cursos');


pll_register_string('Título do banner', 'inscrições abertas', 'intermediária');
pll_register_string('Título dos cards', 'varandas ITS', 'intermediária - varandas');
pll_register_string('label para pessoas', 'palestrantes', 'intermediária - varandas');


pll_register_string('Título do banner', 'publicações recentes', 'intermediária - publicações');
pll_register_string('Título dos cards', 'publicações', 'intermediária - publicações');
pll_register_string('label para pessoas', 'autores', 'intermediária - publicações');


pll_register_string('Título do banner', 'áreas de pesquisa', 'intermediária - projetos');
pll_register_string('Área de Pesquisa (singular)', 'área de pesquisa', 'intermediária - projetos');
pll_register_string('Título dos cards ativos', 'projetos ativos', 'intermediária - projetos');
pll_register_string('Título dos cards encerrados', 'projetos encerrados', 'intermediária - projetos');
pll_register_string('Áreas - mostrando tudo', 'mostrando tudo', 'intermediária - projetos');
pll_register_string('Ver projetos dessa área', 'ver projetos desta área', 'intermediária - projetos');
pll_register_string('Ver todos os projetos', 'ver todos os projetos', 'intermediária - projetos');


pll_register_string('publicado em', 'publicado em', 'interna - comunicados');
pll_register_string('inscrições até', 'inscrições até', 'interna - cursos');
pll_register_string('início do curso', 'início do curso', 'interna - cursos');
pll_register_string('Curso sem previsão de lançamento', 'Curso sem previsão de lançamento', 'interna - cursos');
pll_register_string('novas turmas', 'novas turmas', 'interna - cursos');

pll_register_string('leia o pdf', 'leia o pdf', 'interna - publicações');
pll_register_string('mais sobre a publicação', 'mais sobre a publicação', 'interna - publicações');

pll_register_string('horário', 'horário', 'interna - varandas');
pll_register_string('Varanda encerrada', 'Varanda encerrada', 'interna - varandas');
pll_register_string('sugira um tema', 'sugira um tema', 'interna - varandas');

pll_register_string('Contatos', 'contatos:', 'footer');
pll_register_string('Últimos Artigos', 'últimos artigos (Medium)', 'footer');
pll_register_string('Últimos Vídeos', 'últimos vídeos (YouTube)', 'footer');
pll_register_string('Trending tags', '#trending tags', 'footer');
pll_register_string('newsletter', 'newsletter', 'footer');
pll_register_string('escreva seu email para receber', 'escreva seu email para receber', 'footer');
pll_register_string('Desenvolvido por ', 'desenvolvido por', 'footer');
pll_register_string('ITS nas redes ', 'ITS nas redes', 'footer');
pll_register_string('Inscreva-se', 'inscreva-se', 'footer');
pll_register_string('equipe', 'equipe', 'footer');
pll_register_string('onde estivemos', 'onde estivemos', 'footer');
pll_register_string('comunicados', 'equipe', 'footer');



pll_register_string('aulas', 'aulas', 'módulos divi');
pll_register_string('agenda', 'agenda', 'módulos divi');
pll_register_string('comunicados', 'comunicados', 'módulos divi');
pll_register_string('informações', 'informações', 'módulos divi');
pll_register_string('Início das Inscrições:', 'Início das Inscrições:', 'módulos divi');
pll_register_string('Fim das Inscrições:', 'Fim das Inscrições:', 'módulos divi');
pll_register_string('publicações', 'publicações', 'módulos divi');
pll_register_string('relacionados', 'relacionados', 'módulos divi');
pll_register_string('conteúdos relacionados', 'conteúdos relacionados', 'módulos divi');
pll_register_string('tema', 'tema', 'módulos divi');
pll_register_string('valor', 'valor', 'módulos divi');

