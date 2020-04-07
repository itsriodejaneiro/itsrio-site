<?php

function fca_pc_upgrade_menu() {
	$page_hook = add_submenu_page(
		'fca_pc_settings_page',
		__('Upgrade to Premium', 'facebook-conversion-pixel'),
		__('Upgrade to Premium', 'facebook-conversion-pixel'),
		'manage_options',
		'pixel-cat-upgrade',
		'fca_pc_upgrade_ob_start'
	);
	add_action('load-' . $page_hook , 'fca_pc_upgrade_page');
}
add_action( 'admin_menu', 'fca_pc_upgrade_menu' );

function fca_pc_upgrade_ob_start() {
    ob_start();
}

function fca_pc_upgrade_page() {
    wp_redirect('https://fatcatapps.com/pixelcat/premium?utm_medium=plugin&utm_source=Pixel%20Cat%20Free&utm_campaign=free-plugin', 301);
    exit();
}

function fca_pc_upgrade_to_premium_menu_js() {
    ?>
    <script type="text/javascript">
    	jQuery(document).ready(function ($) {
            $('a[href="admin.php?page=pixel-cat-upgrade"]').on('click', function () {
        		$(this).attr('target', '_blank')
            })
        })
    </script>
    <style>
        a[href="admin.php?page=pixel-cat-upgrade"] {
            color: #6bbc5b !important;
        }
        a[href="admin.php?page=pixel-cat-upgrade"]:hover {
            color: #7ad368 !important;
        }
    </style>
    <?php 
}
add_action( 'admin_footer', 'fca_pc_upgrade_to_premium_menu_js');