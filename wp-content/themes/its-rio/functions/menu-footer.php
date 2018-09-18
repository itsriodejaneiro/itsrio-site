<?php 
add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {
	add_menu_page('Informações do Footer', 'Footer', 'administrator', __FILE__, 'footer_settings', '' );
	add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}

function register_my_cool_plugin_settings() {
	register_setting( 'footer_settings', 'footer_contacts' );
	register_setting( 'footer_settings', 'footer_adress' );
	register_setting( 'footer_settings', 'footer_description' );
	register_setting( 'footer_settings', 'footer_description_en' );
}

function footer_settings() {
	?>
	<div class="wrap">
		<h1>Informações do Footer</h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'footer_settings' ); ?>
			<?php do_settings_sections( 'footer_settings' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Contatos (emails):</th>
					<td><input type="text" name="footer_contacts" value="<?php echo esc_attr( get_option('footer_contacts') ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Endereço: </th>
					<td><input type="text" name="footer_adress" value="<?php echo esc_attr( get_option('footer_adress') ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Descrição do ITS</th>
					<td> <?php wp_editor(get_option('footer_description'), 'footer_description') ?> </td>
				</tr>
				<tr valign="top">
					<th scope="row">Descrição do ITS (inglês)</th>
					<td> <?php wp_editor(get_option('footer_description_en'), 'footer_description_en') ?> </td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php 
}

	


