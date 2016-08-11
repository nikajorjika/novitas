<?php

/**
* Add Custom Currency
*/
add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {
  $currencies['GEL'] = __( 'Georgian Lari', 'novitas' );
  return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

function add_my_currency_symbol( $currency_symbol, $currency ) {
  switch( $currency ) {
    case 'GEL': $currency_symbol = 'GEL'; break;
  }
  return $currency_symbol;
}

/**
* Declare WooCommerce Support
*/
add_action( 'after_setup_theme', 'woocommerce_support' );

function woocommerce_support() {
  add_theme_support( 'woocommerce' );
}

/**
* Unhook The WooCommerce Wrappers
*/
// remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
// remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
* Add Custom Wrappers
*/
// add_action('woocommerce_before_main_content', 'custom_wrapper_start', 10 );
// add_action('woocommerce_after_main_content', 'custom_wrapper_end', 10 );

// function custom_wrapper_start() {
//   echo '<section id="main-container">';
// }

// function custom_wrapper_end() {
//   echo '</section>';
// }
