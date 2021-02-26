<?php

if(class_exists('RWMB_Select_Advanced_Field')):

  class RWMB_Select_advanced_ajax_Field extends RWMB_Select_Advanced_Field {

    public static function html( $meta, $field ) {

      $options                     = self::transform_options( $field['options'] );
      $attributes                  = self::call( 'get_attributes', $field, $meta );
      $attributes['data-selected'] = $meta;
      $walker                      = new RWMB_Walker_Select( $field, $meta );
      
      $attributes['class'] .= ' rwmb-select_advanced';

      $output                      = sprintf(
        '<select %s>',
        self::render_attributes( $attributes )
      );
      if ( ! $field['multiple'] && $field['placeholder'] ) {
        $output .= '<option value="">' . esc_html( $field['placeholder'] ) . '</option>';
      }
      $output .= $walker->walk( $options, $field['flatten'] ? -1 : 0 );
      $output .= '</select>';
      $output .= self::get_select_all_html( $field );

      $interfaceValue = rwmb_meta($field['id'] .'-interface');

      // Hidden field for remember the content of the selector
      $output .= '<input
        type="hidden"
        id="'. $field['id'] .'-interface"
        name="'. $field['id'] .'-interface"
        value=\''. $interfaceValue .'\' />';

      return $output;
      
    }

    public static function save( $new, $old, $post_id, $field ) {
      
      // Force saving our hidden field
      update_metadata( 'post', $post_id, $field['id'].'-interface', $_POST[$field['id'].'-interface']);
      
      parent::save($new, $old, $post_id, $field);
      
    }

  }

endif;
