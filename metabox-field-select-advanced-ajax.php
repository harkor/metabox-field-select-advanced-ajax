<?php
/*
Plugin Name:        Meta Box field - Select Advanced Ajax
Description:        Meta Box plugin compatible with ajax and select-advanced field
Version:            1.1
Author:             Harkor (Charlin)
Author URI:         https://www.charlin.be/
*/

if ( ! class_exists( 'MetaBoxFieldSelectAdvancedAjax' ) ) {
  class MetaBoxFieldSelectAdvancedAjax {
  
    public function __construct() {
      add_action( 'rwmb_enqueue_scripts', array( $this, 'enqueue' ) );
      add_action( 'init', array( $this, 'prefix_load_SelectAdvancedAjax_type' ));
    }
  
    public function prefix_load_SelectAdvancedAjax_type(){
      require 'RWMB_Select_advanced_ajax_Field.php';
    }

    public function enqueue() {
      list( , $url ) = RWMB_Loader::get_path( dirname( __FILE__ ) );
      wp_enqueue_script( 'field-select-ajax', $url . 'js/select-advanced-ajax-field.js', array( 'jquery' ), '1.1', true );
    }
  
  }
  
  new MetaBoxFieldSelectAdvancedAjax;
}
