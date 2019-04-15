<?php


//checkout com os campos bairro obrigatorio, 5 numeros no numero, e 30 no complemento
function wc_elshaddai_bfield( $fields ) {
    $fields['billing_number']['maxlength'] = 5;
    $fields['billing_address_2']['maxlength'] = 30;
    $fields['billing_address_2']['label_class'] = array('');    
    $fields['billing_neighborhood']['required'] = true;
    return $fields;}
add_filter( 'woocommerce_billing_fields', 'wc_elshaddai_bfield' );
function wc_elshaddai_sfield( $fields ) {
    $fields['shipping_number']['maxlength'] = 5;
    $fields['shipping_address_2']['maxlength'] = 30;
    $fields['shipping_address_2']['label_class'] = array('');  
    $fields['shipping_neighborhood']['required'] = true;
    return $fields;}
add_filter( 'woocommerce_shipping_fields', 'wc_elshaddai_sfield' );
function wc_elshaddai_ordernote( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;}
add_filter( 'woocommerce_checkout_fields' , 'wc_elshaddai_ordernote' );



//Bling passa a atualizar o estoque, Gereciamento do Woocommerce é desativado
//Webhooks não podem ser agendadas Asyncronamente
add_filter("woocommerce_payment_complet_reduce_order_stock", false);
add_filter("woocommerce_payment_complete_reduce_order_stock",false);
add_filter("woocommerce_can_reduce_order_stock", false);
add_filter("woocommerce_webhook_deliver_async", false);


//Helper na dash board com  os autores
add_action('wp_dashboard_setup', 'attributes_on_dashboard_widgets');
function attributes_on_dashboard_widgets() {
  global $wp_meta_boxes;
  wp_add_dashboard_widget('custom_help_widget', 'Atributos dos Livros', 'custom_dashboard_help');
}
function custom_dashboard_help() {
  echo '<p>Abrir atributos</p>';
  echo('<a href="'. get_site_url() . '/wp-admin/edit-tags.php?taxonomy=pa_autor&post_type=product" class="button button-primary">Autores</a>');
  echo('<a href="'. get_site_url() . '/wp-admin/edit-tags.php?taxonomy=pa_editora&post_type=product" class="button button-primary">Editoras</a>');
}


function shortcode_to_be_added( $arg ){
    echo do_shortcode( "[".$arg['shortcode']."]" ) ;
    return;
  
  }
  
function shortcode_to_add( $atts ) {
    add_action("especial_space_to_widgets", function() use ( $atts ) { shortcode_to_be_added( $atts ); });
  
    return ;
    
}
add_shortcode( 'before_loop', 'shortcode_to_add' );


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );