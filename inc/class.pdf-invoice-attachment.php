<?php

defined('ABSPATH') or die("HEY YOU CANT ACCESS THIS FILE.");


require_once PDFINVOICEATTACHMENT__PLUGIN_DIR . 'inc/html2pdf-master/vendor/autoload.php';
require('phpqrcode/qrlib.php');

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;



class Pdf_Invoice_Attachment
{

    public static function activate()
    {
        //
    }

    private static function render($template_path, $params)
    {
        extract($params);
        ob_start();
        include $template_path;
        $content = ob_get_clean();

        return $content;
    }

    function attach_invoice($attachments, $email_id, $order)
    {
        global $wpdb;

        // Avoiding errors and problems
        if (!is_a($order, 'WC_Order') || !isset($email_id)) {
            return $attachments;
        }

        //GET EMAIL OF ACCOUNT MANAGER
        $manager = $wpdb->get_results("SELECT m.name FROM `" . $wpdb->prefix . "account_managers` as m JOIN " . $wpdb->prefix . "accountmanagers_to_woocommerce_users as a ON m.am_id = a.account_manager_id WHERE a.user_id=" . $order->get_user_id());

        $acc_mgr_name = '-';
        if (count($manager) > 0) {
            $acc_mgr_name = $manager[0]->name;
        }

        $order_link = esc_url($order->get_checkout_payment_url());
        $qr_file_path = PDFINVOICEATTACHMENT__PLUGIN_DIR . '/qr_codes_images/order-' . $order->get_id() . '.png';

        //SAVING QRCODE
        QRcode::png($order_link, $qr_file_path);

        // QUERY TO GET CUSTOMER NUMBER
        $customer_number = "SELECT customer_number FROM " . $wpdb->prefix . "customers_numbers WHERE user_id=" . $order->get_user_id();

        // GETTING BACK CUSTOMER NUMBER
        $filtered = $wpdb->get_results($customer_number);

        $data = [
            'order'                 => $order,
            'order_summary'         => [
                'customer_id'           => (count($filtered) > 0) ? $filtered[0]->customer_number : '',
                'quote'                 => get_field('quote'),
                'client_po'             => get_field('client_po'),
                'sales_order'           => get_field('sales_order'),
                'order_acknowledgment'  => get_field('order_acknowledgment'),
                'payment_terms'         => get_field('payment_terms'),
                'inco_terms'            => get_field('inco_terms'),
                'order_date'            => date('d/m/Y', strtotime($order->get_date_created())),
                'date_in_hands'         => get_field('date_in_hands'),
                'due_date'              => get_field('due_date'),
                'date_paid'             => get_field('date_paid'),
                'ship_date'             => get_field('ship_date'),
                'tracking_number'       => get_field('tracking_number')
            ],

            'billing_company'       => $order->get_billing_company(),
            'customer_name'         => $order->get_billing_first_name() . " " . $order->get_billing_last_name(),
            'account_manager_name'  => $acc_mgr_name,
            'customer_phone'        => $order->get_billing_phone(),
            'customer_email'        => $order->get_billing_email(),
            'fax'                   => get_field('fax', 'user_' . $order->get_user_id()),
            'acknowledgement_address' => get_field('acknowledgement_address'),
            'bill_to'               => $order->get_billing_first_name() . '<br>' . $order->get_billing_last_name() . '<br>' . $order->get_billing_company() . '<br>' . $order->get_billing_address_1() . '<br>' . $order->get_billing_address_2() . '<br>' . $order->get_billing_city() . '<br>' . $order->get_billing_state() . '<br>' . $order->get_billing_postcode() . '<br>' . $order->get_billing_country(),
            'ship_to_complete_addr' => $order->get_shipping_first_name() . '<br>' . $order->get_shipping_last_name() . '<br>' . $order->get_shipping_company() . '<br>' . $order->get_shipping_address_1() . '<br>' . $order->get_shipping_address_2() . '<br>' . $order->get_shipping_city() . '<br>' . $order->get_shipping_state() . '<br>' . $order->get_shipping_postcode() . '<br>' . $order->get_shipping_country(),
            'ship_to'               => $order->get_shipping_address_1(),
            'ship_from'             => get_field('ship_from'),

            'customer_note'         => $order->get_customer_note('view'),
            'qr_file_path'          => $qr_file_path,
            'order_link'            => $order_link,

        ];

        $template_path = PDFINVOICEATTACHMENT__PLUGIN_DIR . '/templates/invoice.php';
        $content = self::render($template_path, $data);

        $html2pdf = new Html2Pdf('P', 'A4', 'fr');
        $html2pdf->writeHTML($content);

        $file_path = PDFINVOICEATTACHMENT__PLUGIN_DIR . '/order_pdf_files/order-' . $order->get_id() . '.pdf';

        $html2pdf->output($file_path, 'F');

        $email_ids = array(
            'new_order',
            'customer_processing_order',
            'customer_invoice',
            'cancelled_order',
            'customer_completed_order',
            'customer_note',
            'customer_on_hold_order',
            'customer_refunded_order'
        );
        if (in_array($email_id, $email_ids)) {
            $attachments[] = $file_path;
            return $attachments;
        } else {
            return $attachments;
        }
    }
}
