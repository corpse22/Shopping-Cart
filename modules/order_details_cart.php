<?php
/*
#####################################
#  OSC-CMS: Shopping Cart Software.
#  Copyright (c) 2011-2012
#  http://osc-cms.com
#  http://osc-cms.com/forum
#  Ver. 1.0.0
#####################################
*/

$module = new osTemplate;

$module_content = array ();
$any_out_of_stock = '';
$mark_stock = '';

for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {

	if (STOCK_CHECK == 'true') {
		$mark_stock = os_check_stock($products[$i]['id'], $products[$i]['quantity']);
		if ($mark_stock)
			$_SESSION['any_out_of_stock'] = 1;
	}

	$image = '';
	if ($products[$i]['image'] != '') {
		$image = dir_path('images_thumbnail').$products[$i]['image'];
	}
	
	if (!is_file($image)) $image = http_path('images_thumbnail').'../noimage.gif';
	else  $image = http_path('images_thumbnail').$products[$i]['image'];

	//Bundle
	$products_bundle = '';
	if ($products[$i]['bundle'] == 1)
	{
		$bundle_query = getBundleProducts($products[$i]['id']);
		
		if (os_db_num_rows($bundle_query) > 0)
		{
			while($bundle_data = os_db_fetch_array($bundle_query))
			{
				$products_bundle_data .= ' - <a href="'.os_href_link(FILENAME_PRODUCT_INFO, os_product_link($bundle_data['products_id'], $bundle_data['products_name'])).'">'.$bundle_data['products_name'].'</a><br />';
			}
		}
		$products_bundle = (!empty($products_bundle_data)) ? $products_bundle_data : '';
	}
	//End of Bundle

	$module_content[$i] = array ('PRODUCTS_NAME' => $products[$i]['name'].$mark_stock, 
	                             'PRODUCTS_QTY' => os_draw_input_field('cart_quantity[]', 
								 $products[$i]['quantity'], 'size="2"').os_draw_hidden_field('products_id[]', 
								 $products[$i]['id']).os_draw_hidden_field('old_qty[]', 
								 $products[$i]['quantity']), 
								 'PRODUCTS_MODEL' => $products[$i]['model'],
								 'PRODUCTS_SHIPPING_TIME'=>$products[$i]['shipping_time'], 
								 'PRODUCTS_TAX' => @number_format($products[$i]['tax'], TAX_DECIMAL_PLACES), 
								 'PRODUCTS_IMAGE' => $image, 
								 'IMAGE_ALT' => $products[$i]['name'], 
								 'BOX_DELETE' => os_draw_checkbox_field('cart_delete[]', $products[$i]['id']), 
								 'PRODUCTS_LINK' => os_href_link(FILENAME_PRODUCT_INFO, os_product_link($products[$i]['id'], $products[$i]['name'])), 
								 'PRODUCTS_PRICE' => $osPrice->Format($products[$i]['price'] * $products[$i]['quantity'], true), 
								 'PRODUCTS_SINGLE_PRICE' =>$osPrice->Format($products[$i]['price'], true), 
								 'PRODUCTS_SHORT_DESCRIPTION' => get_short_description_cache($products[$i]['id']), 
								 'PRODUCTS_BUNDLE' => $products_bundle,
								 'ATTRIBUTES' => '',);
	$attributes_exist = ((isset ($products[$i]['attributes'])) ? 1 : 0);

	if ($attributes_exist == 1) 
	{
	  if (is_array($products[$i]['attributes'])) 
	  {
	  reset($products[$i]['attributes']);

		while (list ($option, $value) = each($products[$i]['attributes'])) {

			if (ATTRIBUTE_STOCK_CHECK == 'true' && STOCK_CHECK == 'true') {
				$attribute_stock_check = os_check_stock_attributes($products[$i][$option]['products_attributes_id'], $products[$i]['quantity']);
				if ($attribute_stock_check)
					$_SESSION['any_out_of_stock'] = 1;
			}

			$module_content[$i]['ATTRIBUTES'][] = array ('ID' => $products[$i][$option]['products_attributes_id'], 'MODEL' => os_get_attributes_model(os_get_prid($products[$i]['id']), $products[$i][$option]['products_options_values_name'],$products[$i][$option]['products_options_name']), 'NAME' => $products[$i][$option]['products_options_name'], 'VALUE_NAME' => $products[$i][$option]['products_options_values_name'].$attribute_stock_check);

		}
	   }
	}

}

$total_content = '';
$total =$_SESSION['cart']->show_total();
if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$price = $total-$_SESSION['cart']->show_tax(false);
	} else {
		$price = $total;
	}
	$discount = $osPrice->GetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	$total_content = $_SESSION['customers_status']['customers_status_ot_discount'].' % '.SUB_TITLE_OT_DISCOUNT.' -'.os_format_price($discount, $price_special = 1, $calculate_currencies = false).'<br />';
}

if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) @$total-=$discount;
	$total_content .= SUB_TITLE_SUB_TOTAL.' ' .$osPrice->Format($total, true).'<br />';
} else {
	$total_content .= TEXT_INFO_SHOW_PRICE_NO.'<br />';
}
if (@$customer_status_value['customers_status_ot_discount'] != 0) {
	$total_content .= TEXT_CART_OT_DISCOUNT.$customer_status_value['customers_status_ot_discount'].'%';
}
if (SHOW_SHIPPING == 'true') {
	$module->assign('SHIPPING_INFO', $main->getShippingLink());
}

$module->assign('UST_CONTENT', $_SESSION['cart']->show_tax());
$module->assign('TOTAL_CONTENT', $total_content);
$module->assign('language', $_SESSION['language']);
$module->assign('module_content', $module_content);

$module->caching = 0;
$module = $module->fetch(CURRENT_TEMPLATE.'/module/order_details.html');

$osTemplate->assign('MODULE_order_details', $module);
?>