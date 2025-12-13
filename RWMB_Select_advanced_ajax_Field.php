<?php
/**
 * Meta Box Select Advanced Ajax Field
 * 
 * Extends select_advanced to support AJAX data sources from external APIs.
 * Compatible with Meta Box groups and cloneable fields.
 * 
 * @since 1.0
 * @version 1.2 - Added Meta Box group support
 */

if(class_exists('RWMB_Select_Advanced_Field')):

  class RWMB_Select_advanced_ajax_Field extends RWMB_Select_Advanced_Field {

    /**
     * Render field HTML
     * 
     * @param mixed $meta  Field value
     * @param array $field Field configuration
     * @return string HTML output
     */
    public static function html( $meta, $field ) {

      $options                     = self::transform_options( $field['options'] );
      $attributes                  = self::call( 'get_attributes', $field, $meta );
      $walker                      = new RWMB_Walker_Select( $field, $meta );
      
      // Detect if field is inside a Meta Box group
      $is_in_group = isset( $field['field_name'] ) && strpos( $field['field_name'], '[' ) !== false;
      
      // Retrieve hidden field value to populate data-selected attribute
      $interface_field_id = $field['id'] . '-interface';
      $interfaceValue     = '';
      
      if ( ! $is_in_group ) {
        // Fields WITHOUT group: fetch hidden as separate meta
        $interfaceValue = rwmb_meta( $interface_field_id );
        
        // Use JSON from hidden if available, otherwise use raw value
        if ( ! empty( $interfaceValue ) ) {
          $attributes['data-selected'] = $interfaceValue;
        } else {
          $attributes['data-selected'] = $meta;
        }
      } else {
        // Fields WITH group: Meta Box already provides JSON in data-selected
        $attributes['data-selected'] = $meta;
      }
      
      $attributes['class'] .= ' rwmb-select_advanced';

      $output = sprintf(
        '<select %s>',
        self::render_attributes( $attributes )
      );
      
      if ( ! $field['multiple'] && $field['placeholder'] ) {
        $output .= '<option value="">' . esc_html( $field['placeholder'] ) . '</option>';
      }
      
      $output .= $walker->walk( $options, $field['flatten'] ? -1 : 0 );
      $output .= '</select>';
      $output .= self::get_select_all_html( $field );

      // Generate unique ID and name for hidden field
      // Converts: _group[1][_field] → _group_1__field-interface
      $hidden_id   = str_replace( array( '[', ']' ), array( '_', '' ), $attributes['name'] );
      $hidden_name = $attributes['name'];

      // Hidden field to store JSON data (value + text)
      $output .= sprintf(
        '<input type="hidden" id="%s-interface" name="%s-interface" value="%s" data-field-name="%s" class="rwmb-ajax-interface-field" />',
        esc_attr( $hidden_id ),
        esc_attr( $hidden_name ),
        esc_attr( $interfaceValue ),
        esc_attr( $field['id'] )
      );

      return $output;
      
    }

    /**
     * Save field value
     * 
     * For fields WITHOUT group: saves hidden field as separate meta.
     * For fields WITH group: parent::save() handles it via group array.
     * 
     * @param mixed $new     New value
     * @param mixed $old     Old value
     * @param int   $post_id Post ID
     * @param array $field   Field configuration
     */
    public static function save( $new, $old, $post_id, $field ) {
      
      // Force saving our hidden field for non-group fields
      if ( isset( $_POST[ $field['id'] . '-interface' ] ) ) {
        update_metadata(
          'post',
          $post_id,
          $field['id'] . '-interface',
          sanitize_text_field( $_POST[ $field['id'] . '-interface' ] )
        );
      }
      
      parent::save($new, $old, $post_id, $field);
      
    }

  }

endif;
