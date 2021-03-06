<?php
/*
*---------------------------------------------------------
*
*	OSC-CMS - Open Source Shopping Cart Software
*	http://osc-cms.com
*
*---------------------------------------------------------
*/

@ini_set("max_execution_time", 0);//Увеличение время загрузки

require('includes/top.php');

if (!isset($_SESSION['language']) )
{
   $_SESSION['language'] = 'ru';
}   
if (isset($_POST['LANGUAGE']))
{
   $_SESSION['language'] = $_POST['LANGUAGE'];
}
include('lang/'.$_SESSION['language'].'/lang.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" lang="ru-ru" dir="ltr" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TEXT_SETUP_INDEX; ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<style type='text/css' media='all'>@import url('includes/install.css');</style>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<script src="bootstrap/jquery.js"></script>
<script src="bootstrap/js/bootstrap-transition.js"></script>
<script src="bootstrap/js/bootstrap-alert.js"></script>
<script src="bootstrap/js/bootstrap-modal.js"></script>
<script src="bootstrap/js/bootstrap-dropdown.js"></script>
<script src="bootstrap/js/bootstrap-scrollspy.js"></script>
<script src="bootstrap/js/bootstrap-tab.js"></script>
<script src="bootstrap/js/bootstrap-tooltip.js"></script>
<script src="bootstrap/js/bootstrap-popover.js"></script>
<script src="bootstrap/js/bootstrap-button.js"></script>
<script src="bootstrap/js/bootstrap-collapse.js"></script>
<script src="bootstrap/js/bootstrap-carousel.js"></script>
<script src="bootstrap/js/bootstrap-typeahead.js"></script>
</head>
<body>
<form action="" method="post" name="language">
<input type="hidden" name="LANGUAGE" id="lang_a" value="" />
</form>

<div class="container">
	<p></p>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href=""><?php echo TEXT_SETUP_INDEX; ?></a>

				<?php echo lang_menu(); ?>
			</div>
		</div>
	</div>





		<div class="page-header">

			<span class="pull-right">
				<a class="btn" href="index.php" title="<?php echo IMAGE_BACK;?>"><?php echo IMAGE_BACK;?></a>
				<a class="btn btn-success" onclick="document.install.submit();" title="<?php echo IMAGE_CONTINUE; ?>"><?php echo IMAGE_CONTINUE;?></a>
			</span>

			<h1><?php echo STEPS ;?> <?php echo STEP3; ?></h1>
		</div>

		<div class="progress progress-striped active">
			<div class="bar" style="width:50%;"></div>
		</div>
















<?php
define('_LIB', dirname(dirname(__FILE__)).'/includes/lib/');

if (isset($_SESSION['DB_PREFIX'])) define('DB_PREFIX', $_SESSION['DB_PREFIX']);

require_once(_CATALOG.'includes/database.php');

if (os_in_array('database', $_POST['install']))
{
	$_db_server = trim(stripslashes($_POST['DB_SERVER']));
	$_db_username = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
	$_db_password = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
	$_db_select_db = trim(stripslashes($_POST['DB_DATABASE']));
	
    os_db_connect_installer($_db_server, $_db_username, $_db_password) ;
	os_db_select_db($_db_select_db);
	
    //Удаление всех таблиц
    os_db_query("drop table if exists ".DB_PREFIX."address_book,".
	DB_PREFIX."address_format, ".
	DB_PREFIX."admin_access, ".
	DB_PREFIX."affiliate_affiliate, ".
	DB_PREFIX."affiliate_banners, ".
	DB_PREFIX."affiliate_banners_history, ".
	DB_PREFIX."affiliate_clickthroughs, ".
	DB_PREFIX."affiliate_payment, ".
	DB_PREFIX."affiliate_payment_status, ".
	DB_PREFIX."affiliate_payment_status_history, ".
	DB_PREFIX."affiliate_sales, ".
	DB_PREFIX."articles, ".
	DB_PREFIX."articles_description, ".
	DB_PREFIX."articles_to_topics, ".
	DB_PREFIX."articles_xsell, ".
	DB_PREFIX."authors, ".
	DB_PREFIX."authors_info, ".
	DB_PREFIX."banktransfer, ".
	DB_PREFIX."campaigns, ".
	DB_PREFIX."campaigns_ip, ".
	DB_PREFIX."cm_file_flags, ".
	DB_PREFIX."companies, ".
	DB_PREFIX."content_manager, ".
	DB_PREFIX."coupon_email_track, ".
	DB_PREFIX."coupon_gv_customer, ".
	DB_PREFIX."coupon_gv_queue, ".
	DB_PREFIX."coupon_redeem_track, ".
	DB_PREFIX."coupons, ".
	DB_PREFIX."coupons_description, ".
	DB_PREFIX."customers_ip, ".
	DB_PREFIX."customers_memo, ".
	DB_PREFIX."customers_status, ".
	DB_PREFIX."customers_status_history, ".
	DB_PREFIX."customers_status_orders_status, ".
	DB_PREFIX."customers_to_extra_fields, ".
	DB_PREFIX."extra_fields, ".
	DB_PREFIX."extra_fields_info, ".
	DB_PREFIX."faq, ".
	DB_PREFIX."featured, ".
	DB_PREFIX."languages, ".
	DB_PREFIX."latest_news, ".
	DB_PREFIX."media_content, ".
	DB_PREFIX."module_newsletter, ".
	DB_PREFIX."module_newsletter_temp_1, ".
	DB_PREFIX."module_newsletter_temp_2, ".
	DB_PREFIX."newsletter_recipients, ".
	DB_PREFIX."newsletters, ".
	DB_PREFIX."newsletters_history, ".
	DB_PREFIX."orders_recalculate, ".
	DB_PREFIX."orders_total, ".
	DB_PREFIX."payment_moneybookers, ".
	DB_PREFIX."payment_moneybookers_countries, ".
	DB_PREFIX."payment_moneybookers_currencies, ".
	DB_PREFIX."payment_qenta, ".
	DB_PREFIX."personal_offers_by_customers_status_0, ".
	DB_PREFIX."personal_offers_by_customers_status_1, ".
	DB_PREFIX."personal_offers_by_customers_status_2, ".
	DB_PREFIX."personal_offers_by_customers_status_3, ".
	DB_PREFIX."persons, ".
	DB_PREFIX."post_index, ".
	DB_PREFIX."products_content, ".
	DB_PREFIX."products_description, ".
	DB_PREFIX."products_bundles, ".
	DB_PREFIX."products_extra_fields, ".
	DB_PREFIX."products_graduated_prices, ".
	DB_PREFIX."products_images, ".
	DB_PREFIX."products_notifications, ".
	DB_PREFIX."products_to_products_extra_fields, ".
	DB_PREFIX."products_vpe, ".
	DB_PREFIX."products_xsell, ".
	DB_PREFIX."products_xsell_grp_name, ".
	DB_PREFIX."scart, ".
	DB_PREFIX."ship2pay, ".
	DB_PREFIX."shipping_status, ".
	DB_PREFIX."special_category, ".
	DB_PREFIX."special_product, ".
	DB_PREFIX."topics, ".
	DB_PREFIX."topics_description, ".
	DB_PREFIX."banners, ".
	DB_PREFIX."banners_history, ".
	DB_PREFIX."categories, ".
	DB_PREFIX."categories_description, ".
	DB_PREFIX."configuration, ".
	DB_PREFIX."configuration_group, ".
	DB_PREFIX."counter, ".
	DB_PREFIX."counter_history, ".
    DB_PREFIX."countries, ".
	DB_PREFIX."currencies, ".
	DB_PREFIX."customers, ".
	DB_PREFIX."customers_profile, ".
	DB_PREFIX."customers_basket, ".
	DB_PREFIX."customers_basket_attributes, ".
	DB_PREFIX."customers_info, ".
	DB_PREFIX."manufacturers, ".
	DB_PREFIX."manufacturers_info, ".
	DB_PREFIX."orders, ".
	DB_PREFIX."orders_products, ".
	DB_PREFIX."orders_status, ".
	DB_PREFIX."orders_status_history, ".
	DB_PREFIX."orders_products_attributes, ".
	DB_PREFIX."orders_products_download, ".
	DB_PREFIX."products, ".
	DB_PREFIX."products_attributes, ".
	DB_PREFIX."products_options_images, ".
	DB_PREFIX."products_attributes_download, ".
	DB_PREFIX."products_options, ".
	DB_PREFIX."products_options_values, ".
	DB_PREFIX."products_options_values_to_products_options, ".
	DB_PREFIX."products_to_categories, ".
	DB_PREFIX."reviews, ".
	DB_PREFIX."reviews_description, ".
	DB_PREFIX."sessions, ".
	DB_PREFIX."specials, ".
	DB_PREFIX."tax_class, ".
	DB_PREFIX."tax_rates, ".
	DB_PREFIX."geo_zones, ".
	DB_PREFIX."whos_online, ".
	DB_PREFIX."zones, ".
	DB_PREFIX."modules, ".
	DB_PREFIX."plugins, ".
	DB_PREFIX."zones_to_geo_zones");
    $db_error = false;
	
	if (!function_exists('dir_path') )
    {
       include( dirname(dirname(__FILE__) ) . '/includes/paths.php' );
    }

	include( dirname(dirname(__FILE__) ) . '/includes/classes/db.php' );
	include(dirname(__FILE__).'/sql/db_struct.php');
	include(dirname(__FILE__).'/sql/db_default.php');
	include(dirname(__FILE__).'/sql/db_full.php');
	include(_CLASS.'plugins.php');
    include(_FUNC.'plugins.php');
    include(_FUNC.'general.php');
	
    $p =  new plugins();

	include(dirname(__FILE__).'/sql/db_plugins.php');

	if (@filesize( dirname(dirname(__FILE__)).'/media/mail/ru/order_mail.html' ) == 0 or @filesize( dirname(dirname(__FILE__)).'/send_order.php' ) == 0)
	{
		@ os_db_query('delete from '.DB_PREFIX.'configuration where configuration_group_id=12');
	}

    if ($db_error) 
	{
?>

<p>
<?php echo TEXT_TITLE_ERROR; ?>
</p>

<div class="contacterror">
<b><?php echo $db_error; ?></b>
</div>

<form name="install" action="3.php" method="post">

<?php
reset($_POST);
while (list($key, $value) = each($_POST)) 
{
   if ($key != 'x' && $key != 'y') 
   {
      if (is_array($value)) 
	  {
         for ($i=0; $i<sizeof($value); $i++) 
		 {
            echo os_draw_hidden_field_installer($key . '[]', $value[$i]);
         }
      } 
	  else 
	  {
         echo os_draw_hidden_field_installer($key, $value);
       }
    }
}
?>


<input type="image" src="images/button_retry.gif" alt="<?php echo IMAGE_RETRY; ?>" />
</form>

<?php
    } else {
?>


<div class="alert alert-success"><?php echo TEXT_TITLE_SUCCESS; ?></div>


<form name="install" action="4.php" method="post">
<?php
reset($_POST);
while (list($key, $value) = each($_POST)) 
{
    if ($key != 'x' && $key != 'y') 
	{
       if (is_array($value)) 
	   {
          for ($i=0; $i<sizeof($value); $i++) 
		  {
             echo os_draw_hidden_field_installer($key . '[]', $value[$i]);
          }
       } 
	   else 
	   {
            echo os_draw_hidden_field_installer($key, $value);
          }
       }
    }
?>
<input type="hidden" name="task" value="" />
</form>
<?php
  }
}

//demo база
if (isset($_POST['OS_TEST_BASE']) && $_POST['OS_TEST_BASE'] == 'on')
{
   include(dirname(__FILE__).'/sql/db_shop.php');
   @copy_folder('sql/product_images', '../images/product_images');
}
?>


















		<span class="pull-right">
			<a class="btn" href="index.php" title="<?php echo IMAGE_BACK;?>"><?php echo IMAGE_BACK;?></a>
			<a class="btn btn-success" onclick="document.install.submit();" title="<?php echo IMAGE_CONTINUE; ?>"><?php echo IMAGE_CONTINUE;?></a>
		</span>
		<div class="clear"></div>



	<hr>

	<footer>
		<p><?php echo _copy(); ?></p>
	</footer>
</div>



</body>
</html>