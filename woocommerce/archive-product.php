<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );
	?>
	<div style="padding-left:10px;padding-right:10px;">
	<?php
	$posts_per_page =  (get_option('blank-elements-pro')['product_per_page-count'][0]==null)?5:get_option('blank-elements-pro')['product_per_page-count'][0];
	$products_limit = ($posts_per_page)?'products limit="'.$posts_per_page.'"': null;

	$shop_page_style = get_option('blank-elements-pro')['shop_page_style'][0];
	$columns = ($shop_page_style)?'columns="'.$shop_page_style.'"':null;

	$display_pagination = get_option('blank-elements-pro')['display_pagination'][0];
	$paginate = ($display_pagination=='show')?'paginate=true':'paginate=false';

	echo do_shortcode('['.$products_limit.' '.$columns.' '.$paginate.']');
	?>
	</div>
	<?php

do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
