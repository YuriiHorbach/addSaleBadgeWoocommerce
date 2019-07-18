//how to add custom sale badges and translation for them

//add cucstom field
add_action( 'woocommerce_product_options_general_product_data', 'add_custom_bubble_field' );
function add_custom_bubble_field() {
   global $product, $post;
   echo '<div class="options_group">';// Группировка полей
   
   // checkbox
   woocommerce_wp_checkbox( array(
      'id'            => '_checkbox',
      'wrapper_class' => 'show_if_simple',
      'label'         => pll__( 'On order', 'woocommerce' ),
   ) );
}	


add_action( 'woocommerce_process_product_meta', 'add_custom_bubble_field_save', 10 );
function add_custom_bubble_field_save( $post_id ) {
   // Save checkbox
   $woocommerce_checkbox = isset( $_POST['_checkbox'] ) ? 'yes' : 'no';
   update_post_meta( $post_id, '_checkbox', $woocommerce_checkbox );	
   
}

add_action( 'woocommerce_single_product_summary', 'singleProd_add_field_before_price', 9 );
function singleProd_add_field_before_price() {
   global $post, $product;
  	$custom_option = get_post_meta( $post->ID, '_checkbox', true );
	$template = pll__('on order', 'woocommerce');
   if ( $custom_option ) {
      ?>
  		  <div class="orderBadgeSingle">	
			  <?php echo $template ; ?>
		  </div>	    
   <?php }
   
}


add_action( 'woocommerce_before_shop_loop_item_title', 'archive_add_field_before_price', 9 );
function archive_add_field_before_price() {
   global $post, $product;
  	$custom_option = get_post_meta( $post->ID, '_checkbox', true );
	$template = pll__('on order', 'woocommerce');
   if ( $custom_option ) {
      ?>
      	  <div class="orderBadge ">	
			  <?php echo $template ; ?>
		  </div>
		

     
   <?php }
   
}

add_action('init', function() {
	pll_register_string('on order','woocommerce');
});


add_filter('woocommerce_bubble_text', 'my_custom_sale_flash', 10, 3);

function my_custom_sale_flash($text, $post, $_product) {
	$template = pll__('on order', 'woocommerce');
	
return '


	<div clas="box-image">
		'.$template.'
	</div>

';
}