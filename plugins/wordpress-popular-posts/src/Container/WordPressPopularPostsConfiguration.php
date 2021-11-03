<?php
namespace WordPressPopularPosts\Container;

use WordPressPopularPosts\Settings;

class WordPressPopularPostsConfiguration implements ContainerConfigurationInterface
{
    /**
     * Modifies the given dependency injection container.
     *
     * @since   5.0.0
     * @param   Container $container
     */
    public function modify(Container $container)
    {
        $container['admin_options'] = Settings::get('admin_options');
        $container['widget_options'] = Settings::get('widget_options');

        $container['i18n'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\I18N();
        });

        $container['translate'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Translate();
        });

        $container['image'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Image($container['admin_options']);
        });

        $container['themer'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Themer();
        });

        $container['output'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Output($container['widget_options'], $container['admin_options'], $container['image'], $container['translate'], $container['themer']);
        });

        $container['widget'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Widget\Widget($container['widget_options'], $container['admin_options'], $container['output'], $container['image'], $container['translate'], $container['themer']);
        });

        $container['rest'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Rest\Controller($container['admin_options'], $container['translate'], $container['output']);
        });

        $container['admin'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Admin\Admin($container['admin_options'], $container['image']);
        });

        $container['front'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\Front\Front($container['admin_options'], $container['translate'], $container['output']);
        });

        $container['wpp'] = $container->service(function(Container $container) {
            return new \WordPressPopularPosts\WordPressPopularPosts($container['i18n'], $container['rest'], $container['admin'], $container['front'], $container['widget']);
        });
    }
}
