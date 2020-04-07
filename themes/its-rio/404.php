<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

<div class="error-404-wrapper">
    <div class="color-hover"></div>
    <div class="error-404-content">
        <h2><?= pll__('Página não encontrada') ?></h2>
        <p><?= pll__('Verifique a URL ou digite na ferramenta') ?><br><?= pll__('de busca o que deseja encontrar.') ?></p>
        <div class="seta-404 show-for-large"></div>
    </div>
</div>

<?php get_footer(); ?>