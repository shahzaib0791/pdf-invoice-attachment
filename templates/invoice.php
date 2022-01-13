<html>

<head>

  <style type="text/css">
    body {
      font-family: Arial, Helvetica, sans-serif;
    }

    td {
      /* border: 1px solid black; */
      font-size: 14px;
      /* padding: 0px;
      margin: 0; */
    }

    .header_col2 {
      width: 150px;
    }

    * {
      box-sizing: border-box;
    }
  </style>

</head>

<body>
  <img style="width:250px; position: absolute;" src="https://alphapromed.com/wp-content/uploads/2020/12/OPTION-2_PNG-1-400x76.png" alt="">


  <table style="position: absolute;">
    <tr>
      <td style="width: 250px; ">
        <table>

          <!-- LINE BREAK -->
          <?php for ($i = 0; $i < 5; $i++) { ?>
            <tr>
              <td style="width: 250px;">&nbsp;</td>
            </tr>
          <?php } ?>

          <tr>
            <td style="width: 250px;"><b>Contact Us at</b></td>
          </tr>
          <tr>
            <td style="width: 250px;">+1-855-444-4085</td>
          </tr>
          <tr>
            <td style="width: 250px;">customercare@alphapromed.com</td>
          </tr>
          <tr>
            <td style="width: 250px;"><a style="color:#0070c0; text-decoration: none;" href="http://www.alphapromed.com/">www.alphapromed.com</a></td>
          </tr>

          <!-- LINE BREAK -->
          <?php for ($i = 0; $i < 5; $i++) { ?>
            <tr>
              <td style="width: 250px;">&nbsp;</td>
            </tr>
          <?php } ?>

        </table>
      </td>
      <td class="header_col2">
        <table>
          <tr>
            <td style="width: 150px;"><b>AlphaProMed LLC</b></td>
          </tr>
          <tr>
            <td class="width: 150px;">6201 Johns Road, Suite 9,</td>
          </tr>
          <tr>
            <td style="width: 150px;">Tampa, Florida 33634</td>
          </tr>
          <tr>
            <td style="width: 150px;">United States</td>
          </tr>
          <!-- LINE BREAK -->
          <?php for ($i = 0; $i < 10; $i++) { ?>
            <tr>
              <td style="width: 150px;">&nbsp;</td>
            </tr>
          <?php } ?>

        </table>
      </td>
      <td style="width: 142px; background-color: #d9d9d9; ">
        <table>
          <?php foreach ($order_summary as $key => $value) {
            if ($value) {
          ?>
              <tr>
                <td style="width: 142px;"><b><?php echo ucwords(str_replace('_', ' ', $key)); ?></b></td>
                <td style="width: 142px;"><?php echo $value; ?></td>
              </tr>
          <?php }
          } ?>
        </table>
      </td>
    </tr>

    <tr>
      <td colspan="3" style="text-align: center;padding: 10px; color:red">&nbsp;</td>
    </tr>

    <tr>
      <td colspan="3" style="text-align: center;padding: 10px; color:red"><b><?php echo (strtolower($order->get_status()) == 'pending') ?  ucwords($order->get_status()) .' Payment' : ucwords($order->get_status()); ?></b></td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;padding: 10px; background-color: #0070c0; color:white"><b>INVOICE (#<?php printf(esc_html($order->get_order_number())); ?>)</b></td>
    </tr>
  </table>


  <table>
    <tr style="text-align: center;">
      <td style="width: 243px;"><b>Company Name</b></td>
      <td style="width: 243px;"><b>Customer Contact</b></td>
      <td style="width: 243px;"><b>Sales Person</b></td>
    </tr>

    <tr style="text-align: center;">
      <td style="width: 243px;"><?php echo ($billing_company) ? $billing_company : '--'; ?></td>
      <td style="width: 243px;"><?php echo ($customer_name) ? $customer_name : '--'; ?></td>
      <td style="width: 243px;"><?php echo ($account_manager_name) ? $account_manager_name : '--'; ?></td>
    </tr>

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>

    <tr style="text-align: center;">
      <td style="width: 243px;"><b>Phone Number</b></td>
      <td style="width: 243px;"><b>Email</b></td>
      <td style="width: 243px;"><b>FAX</b></td>
    </tr>

    <tr style="text-align: center;">
      <td style="width: 243px;"><?php echo ($customer_phone) ? $customer_phone : '--'; ?></td>
      <td style="width: 243px;"><?php echo ($customer_email) ? $customer_email : '--'; ?></td>
      <td style="width: 243px;"><?php echo ($fax) ? $fax : '--'; ?></td>
    </tr>

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" style="border-bottom: 1px solid black;">&nbsp;</td>
    </tr>

    <tr style="text-align: center; ">
      <td style="width: 243px;"><b>Bill To</b></td>
      <td style="width: 243px;"><b>Ship To</b></td>
      <td style="width: 243px;"><b>Acknowledgement Address</b></td>
    </tr>

    <tr style="text-align: center;">
      <td style="width: 243px;"><?php echo ($bill_to) ? $bill_to : '--'; ?></td>
      <td style="width: 243px;"><?php echo ($ship_to_complete_addr) ? $ship_to_complete_addr : '--'; ?></td>
      <td style="width: 243px;"><?php echo ($acknowledgement_address) ? $acknowledgement_address : '--'; ?></td>
    </tr>

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>

  </table>


  <?php
  $index = 0;
  $total_quantity = 0;
  foreach ($order->get_items() as $key => $item) {
    $index++;
    $product = wc_get_product($item['product_id']);
    $item_image = $product->get_image();
    //$item_ref_id = $item['product_id'];

    $product_title = explode("(", $item['name']);
    $packing =  str_replace(")", "", $product_title[1]);

    $item_name = $product_title[0];
    $item_total = $item['total'];
    $item_quantity = $item['quantity'];
    $total_quantity += $item_quantity;
    $variation_id = $item->get_variation_id();
    $variation = new WC_Product_Variation($variation_id);

    $backorder = 0;
    $_remaining_stock = $variation->get_stock_quantity() - $item_quantity;

    if ($variation->get_stock_quantity() > 0) {
      if ($_remaining_stock < 0) {
        $backorder = $_remaining_stock * -1;
      }
    } else {
      $backorder = $item_quantity;
    }


    $pv = wc_get_product($variation_id);
    if($pv){
      $item_ref_id = $pv->get_sku();
      $sku_value = get_field('sku_2', $variation_id);
      $variationName = $variation->get_variation_attributes();
  
      //GET PRODUCT ATTRIBUTES
      $material = $product->get_attribute('pa_material');
    }
   

  ?>


    <table style="background-color: #E5E5E5;">
      <tr>
        <td style="width: 375px; "><b><?php printf($index . ' - '  . esc_html($item_name)); ?></b></td>
        <td style="width: 345px; text-align: right; color:#3c7eca;padding-right: 10px;">SKU <?php printf(esc_html($sku_value)); ?></td>
      </tr>

    </table>

    <table>
      <tr>
        <td>
          <img width="100" style="padding: 0px;" src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt="">
        </td>
        <td style="width: 300px; line-height: 1.3;">
          <br><br>
          <b>Packing </b> <?php echo $packing; ?> <br>
          <b>Material</b> <?php echo $material; ?> <br>
          <!-- <b>Color</b> Blue <br>
        <b>Size</b> S <br> -->
          <?php

          $uom = '';
          foreach ($variationName as $key => $value) {

            // Get attribute taxonomy name
            $taxonomy   = str_replace('attribute_', '', $key);
            // Get attribute label name
            $label_name = wc_attribute_label($taxonomy);

            if ($label_name == 'Packing Level') {
              //$label_name = 'Unit of measure';
              $uom = get_term_by('slug', $value, $taxonomy)->name;
            }

            // Get attribute term name value
            $term_name  = get_term_by('slug', $value, $taxonomy)->name;
          ?>
            <?php if ($label_name != 'Packing Level') { ?>
              <b><?php echo $label_name; ?></b> <?php echo $term_name; ?> <br>
            <?php } ?>
          <?php } ?>
          <b>Dimensions</b> 24â€•x24â€• <br>
          <b>Special Characteristics</b> <?php print_r(strip_tags($product->get_short_description())); ?>
        </td>
        <td style="width: 330px;">
          <table>
            <tr style="text-align: right;">
              <td colspan="4" style="color:#3c7eca;">REF NUMBER <?php printf(esc_html($item_ref_id)); ?></td>
            </tr>
            <tr style="text-align: center;">
              <td style=""><b>UOM</b></td>
              <td style=""><b>QUANTITY</b></td>
              <td style=""><b>PRICE</b></td>
              <td style=""><b>TOTAL PRICE</b></td>
            </tr>
            <tr style="text-align: center;">
              <td style=""><?php echo $uom; ?></td>
              <td style=""><?php echo $item_quantity; ?></td>
              <td style=""><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($item_total / $item_quantity, 2))); ?></td>
              <td style=""><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($item_total, 2))); ?></td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>

            <tr>
              <td colspan="4"><b>Special Notes</b></td>
            </tr>
            <tr>
              <td colspan="4" style="width: 300px;"><?php printf($order->get_customer_note()); ?></td>
            </tr>
          </table>
        </td>
      </tr>

    </table>


    <table>
      <tr>
        <td style="width: 300px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 300px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 300px;"><b>Decoration Details</b></td>
      </tr>
      <tr>
        <td style="width: 300px;">AlphaProMed</td>
      </tr>
      <tr>
        <td style="width: 300px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 300px;"><b>Shipping Detail</b></td>
      </tr>
      <tr>
        <td style="width: 300px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 300px;"><b>Ship From</b></td>
        <td style="width: 100px;">&nbsp;</td>
        <td style="width: 300px;"><b>Ship To</b></td>
      </tr>
      <tr>
        <td style="width: 300px;"><?php echo $ship_from; ?></td>
        <td style="width: 100px;">&nbsp;</td>
        <td style="width: 300px;"><?php echo $ship_to; ?></td>
      </tr>
    </table>
    <br>
    <br>

  <?php } ?>

  <table>
    <tr>
      <td style="width: 580px; text-align: right; ">&nbsp;</td>
      <td style="width: 100px; text-align: right; ">&nbsp;</td>
    </tr>
  </table>

  <table style="background-color: #E5E5E5;">
    <tr>
      <td style="width: 580px; text-align: right; "><b>Quantity Ordered:</b></td>
      <td style="width: 100px; text-align: right; padding-right:5px"><b><?php printf(esc_html($total_quantity)); ?></b></td>
    </tr>

    <!-- <tr>
      <td style="width: 580px; text-align: right; "><b>Quantity Delivered:</b></td>
      <td style="width: 100px; text-align: right; padding-right:5px"><b>35</b></td>
    </tr> -->
    <!-- 
    <tr>
      <td style="width: 720px;">&nbsp;</td>
    </tr> -->

    <tr>
      <td style="width: 600px; text-align: right; ">&nbsp;</td>
      <td style="width: 130px; text-align: right; ">&nbsp;</td>
    </tr>

    <tr>
      <td style="width: 600px; text-align: right; "><b>SubTotal:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_subtotal(), 2))); ?></b></td>
    </tr>
    <tr>
      <td style="width: 600px; text-align: right; "><b>Sales Tax:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_total_tax(), 2))); ?></b></td>
    </tr>
    <tr>
      <td style="width: 600px; text-align: right; "><b>Extra Cost:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_total_fees(), 2))); ?></b></td>
    </tr>
    <tr>
      <td style="width: 600px; text-align: right; "><b>Shipping Cost:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_shipping_total(), 2))); ?></b></td>
    </tr>
    <!-- <tr>
      <td style="width: 600px; text-align: right; "><b>Quantity Delivered:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b></b></td>
    </tr> -->
    <tr>
      <td style="width: 600px; text-align: right; "><b>Total Amount:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_total(), 2))); ?></b></td>
    </tr>
    <tr>
      <td style="width: 600px; text-align: right; "><b>Amount Paid:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b>0</b></td>
    </tr>
    <tr style="background-color: black; color: white;">
      <td style="width: 600px; text-align: right; "><b>Amount Due:</b></td>
      <td style="width: 130px; text-align: right; padding-right:5px"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_total(), 2))); ?></b></td>
    </tr>
  </table>

  <br>
  <br>

  <table style="background-color: #E5E5E5;">
    <tr>
      <td style="width: 240px;">
        <table>
          <tr>
            <td style="width: 240px;"><b>Scan to Pay your Invoice.</b></td>
          </tr>
          <tr>
            <td style="width: 240px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px;text-align: right;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px; font-size: 10px;text-align: right;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px;text-align: right;">&nbsp;</td>
          </tr>
        </table>
      </td>
      <td style="width: 240px;text-align: center;"><img src="<?php echo $qr_file_path; ?>" alt=""></td>
      <td style="width: 240px;">

        <table>
          <tr>
            <td style="width: 240px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px;text-align: right;"><b><?php printf(esc_html(get_woocommerce_currency_symbol() . number_format($order->get_total(), 2))); ?></b></td>
          </tr>
          <tr>
            <td style="width: 240px;">&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 240px; font-size: 10px;text-align: right;">To review or pay your Invoice online, click here!</td>
          </tr>
          <tr>
            <td style="width: 240px;text-align: right;"><a href="<?php echo $order_link; ?>">Pay Invoice</a></td>
          </tr>
          <tr>
            <td style="width: 240px;">&nbsp;</td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

  <table>
    <tr>
      <td style="width: 720px;">&nbsp;</td>
    </tr>
    <tr style="background-color: black; color:white;">
      <td style="width: 730px; padding:5px;"><b>By approving this invoice and/or completing this purchase you agree to comply with all the terms and conditions listed here: <?php echo site_url() . '/terms-and-conditions'; ?></b></td>
    </tr>
    <tr>
      <td style="width: 730px; padding:5px;">Copyright © <a href="<?php echo site_url(); ?>">AlphaProMed</a>. All rights reserved. <a href="<?php echo site_url() . '/terms-and-conditions'; ?>"> Terms & conditions</a> | <a href="<?php echo site_url() . '/return-refund-policy'; ?>">Return and Refund Policy</a> | <a href="<?php echo site_url() . '/shipping-policy'; ?>">Shipping Policy</a></td>
    </tr>
  </table>

  <table>
    <tr>
      <td style="width: 720px;">&nbsp;</td>
    </tr>
    <tr>
      <td style="width: 720px;">&nbsp;</td>
    </tr>
    <tr>
      <td><b>Contact Us at</b></td>
    </tr>
    <tr>
      <td>+1-855-444-4085</td>
    </tr>
    <tr>
      <td>customercare@alphapromed.com</td>
    </tr>
    <tr>
      <td><a style="color:#0070c0; text-decoration: none;" href="http://www.alphapromed.com/">www.alphapromed.com</a></td>
    </tr>
  </table>


</body>

</html>