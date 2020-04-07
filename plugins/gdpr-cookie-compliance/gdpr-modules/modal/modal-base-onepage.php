<?php 
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  } // Exit if accessed directly
?>

<!-- V2 -->
<div id="moove_gdpr_cookie_modal" class="lity-hide" role="dialog">
  <div class="moove-gdpr-modal-content moove-clearfix logo-position-<?php echo esc_attr( $content->logo_position ); ?> <?php echo esc_attr( $content->theme ); ?>">
    <a href="#" class="moove-gdpr-modal-close" rel="nofollow"><span class="gdpr-icon moovegdpr-arrow-close"></span></a>
    <div class="moove-gdpr-modal-left-content">
      <ul id="moove-gdpr-menu">
        <?php echo gdpr_get_module('tab-navigation'); ?>
      </ul>
    </div>
    <!--  .moove-gdpr-modal-left-content -->
  
    <div class="moove-gdpr-modal-right-content">
        <div class="moove-gdpr-modal-title"> 
          <div>
            <span class="tab-title"><?php echo $content->modal_title; ?></span>
          </div>
          <?php echo gdpr_get_module('company-logo'); ?>
        </div>
        <!-- .moove-gdpr-modal-ritle -->
        <div class="main-modal-content">

          <div class="moove-gdpr-tab-content">
            <?php echo gdpr_get_module( 'section-overview' ); ?>
            <?php echo gdpr_get_module( 'section-strictly' ); ?>
            <?php echo gdpr_get_module( 'section-third_party' ); ?>
            <?php echo gdpr_get_module( 'section-advanced' ); ?>
            <?php echo gdpr_get_module( 'section-cookiepolicy' ); ?>
          </div>
          <!--  .moove-gdpr-tab-content -->
        </div>
        <!--  .main-modal-content -->
        <div class="moove-gdpr-modal-footer-content">
          <?php echo gdpr_get_module( 'modal-footer-buttons' ); ?>
          <?php echo gdpr_get_module( 'gdpr-branding' ); ?>
        </div>
        <!--  .moove-gdpr-modal-footer-content -->
    </div>
    <!--  .moove-gdpr-modal-right-content -->

    <div class="moove-clearfix"></div>

  </div>
  <!--  .moove-gdpr-modal-content -->
</div>
<!-- #moove_gdpr_cookie_modal  -->