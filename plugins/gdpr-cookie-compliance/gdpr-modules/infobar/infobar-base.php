<?php 
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  } // Exit if accessed directly
?>

<?php 
if ( $content->show ) : ?>
  <div id="moove_gdpr_cookie_info_bar" class="<?php echo $content->class; ?>">
    <div class="moove-gdpr-info-bar-container">
      <div class="moove-gdpr-info-bar-content">
        <?php echo gdpr_get_module('infobar-content'); ?>
        <?php echo gdpr_get_module('infobar-buttons'); ?>
      </div>
      <!-- moove-gdpr-info-bar-content -->
    </div>
    <!-- moove-gdpr-info-bar-container -->
  </div>
  <!-- #moove_gdpr_cookie_info_bar  -->
<?php endif; ?>
