<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
?>

<div class="moove-gdpr-button-holder">
  <button class="mgbutton moove-gdpr-infobar-allow-all"><?php echo $content->button_label; ?></button>
  <?php do_action( 'gdpr_info_bar_button_extensions' ); ?>
</div>
<!--  .button-container -->