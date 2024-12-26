<?php
/**
 * This file contains all functions related to shortcodes that couldn't fit anywhere else.
 *
 * @since   2.0.4
 * @package SMP\Shortcodes
 */

defined( 'ABSPATH' ) or exit;

add_action( 'admin_footer', 'make_smpro_support_blank' );    
function make_smpro_support_blank()
{
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
       jQuery('#sm-support-db').parent().attr('target','_blank');
    });
    </script>
    <?php
}