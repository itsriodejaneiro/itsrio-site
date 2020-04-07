<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
?>

<?php if ( $content->is_enabled ) : ?>
  <button data-href="#moove_gdpr_cookie_modal" id="moove_gdpr_save_popup_settings_button" style='<?php echo $content->styles; ?>' class="<?php echo $content->class; ?>">
    <span class="moove_gdpr_icon"><span class="gdpr-icon moovegdpr-advanced"></span></span>
    <span class="moove_gdpr_text"><?php echo $content->label; ?></span>
  </button>
<?php endif; ?>