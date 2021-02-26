<?php
/*
Plugin Name:        Meta Box field - Select Advanced Ajax
Description:        Meta Box plugin compatible with ajax and select-advanced field
Version:            1.0
Author:             Harkor (Charlin)
Author URI:         https://www.charlin.be/
*/

class MetaBoxFieldSelectAdvancedAjax {

  function __construct(){
    add_action('init', array(&$this, 'prefix_load_SelectAdvancedAjax_type'));
    add_action('admin_enqueue_scripts', array(&$this, 'my_enqueue'));
  }

  public function prefix_load_SelectAdvancedAjax_type(){
    require 'RWMB_Select_advanced_ajax_Field.php';
  }

  public function my_enqueue($hook){

    if('post.php' !== $hook):
      return;
    endif;

    wp_enqueue_script('metabox-select-advancec-ajax-field', plugin_dir_url(__FILE__) . '/select-advanced-ajax-field.js');

  }

}

new MetaBoxFieldSelectAdvancedAjax;
