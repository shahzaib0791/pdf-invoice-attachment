<?php
/**
 * Plugin Name: PDF Invoice Attachment
 * Author: Shahzaib
 * Description: This plugin will attach a pdf invoice to woocommerce selected emails
 * Version: 1.0.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pdfinvoiceattachment
 */

defined('ABSPATH') or die("HEY YOU CANT ACCESS THIS FILE.");
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
define( 'PDFINVOICEATTACHMENT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( PDFINVOICEATTACHMENT__PLUGIN_DIR . '/inc/class.pdf-invoice-attachment.php' );


if (!class_exists("Pdf_Invoice_Attachment")) {
    die("'Pdf_Invoice_Attachment' class not found!");
}


// CREATE INSTANCE OF CLASS 'Customer_Number_Generator'
$pdf_Invoice_Attachment = new Pdf_Invoice_Attachment();

// HOOKING A FUNCTION WHEN THIS PLUGIN IS FIRST ACTIVE
register_activation_hook(__FILE__,[$pdf_Invoice_Attachment,"activate"]);


add_action( 'woocommerce_email_attachments', [$pdf_Invoice_Attachment,'attach_invoice'], 10, 3 );