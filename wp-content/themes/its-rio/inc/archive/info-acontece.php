<div class="info">
    <h2>
        <a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
        <div class="line"></div>
    </h2>
    <div class="categories-wrapper show-for-medium">
        <?php $cat_classes = 'black'; include(ROOT. 'inc/categories.php') ?>
    </div>
    <div class="more-info show-for-small-only">
        <a href="<?= get_permalink() ?>"><?= pll__('mais sobre a publicação') ?></a>
    </div>
</div>
