jQuery(function($){
  'use strict';

  /**
   * Synchronize hidden field name and ID with select field
   * Ensures proper saving in Meta Box groups with unique identifiers per clone
   * 
   * @param {jQuery} $select The select element
   * @return {jQuery} The synchronized hidden field
   */
  function syncHiddenField($select) {
    var selectName    = $select.attr('name');
    var interfaceName = selectName + '-interface';
    
    var $interface = $select.closest('.rwmb-input').find('input[type="hidden"].rwmb-ajax-interface-field');
    
    if ($interface.length > 0) {
      // Update hidden field name to match select structure
      $interface.attr('name', interfaceName);
      
      // Generate unique ID: _group[1][_field] → _group_1__field-interface
      var newId = selectName.replace(/\[/g, '_').replace(/\]/g, '') + '-interface';
      $interface.attr('id', newId);
    }
    
    return $interface;
  }

  /**
   * Initialize select_advanced_ajax field
   * Sets up change handler and populates initial value from data-selected
   * 
   * @param {jQuery} $field The select field to initialize
   */
  function initSelectAjax($field) {
    var $interface = syncHiddenField($field);
    
    // Remove previous handlers to avoid duplicates
    $field.off('change.ajax-interface');
    
    // Update hidden field when select value changes
    $field.on('change.ajax-interface', function() {
      var $this = $(this);
      var value = $this.find(':selected').val();
      var text  = $this.find(':selected').text();
      var data  = '';
      
      if (value !== '') {
        data = JSON.stringify({ value: value, text: text });
      }
      
      $interface.val(data);
    });
    
    // Populate select from data-selected attribute (provided by PHP)
    var dataSelected = $field.attr('data-selected');
    
    if (dataSelected && dataSelected !== '' && dataSelected !== 'undefined') {
      try {
        var data = JSON.parse(dataSelected);
        
        // Only populate if we have both value and text
        if (data && data.value && data.text) {
          var newOption = new Option(data.text, data.value, true, true);
          $field.append(newOption);
          
          // Sync hidden field with initial value
          $interface.val(dataSelected);
        }
      } catch (e) {
        console.error('Error parsing data-selected:', e, dataSelected);
      }
    }
  }

  // Initialize all existing select_advanced_ajax fields
  $('.rwmb-select_advanced_ajax').each(function(){
    initSelectAjax($(this));
  });

  // Watch for new fields added via Meta Box group cloning
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      $(mutation.addedNodes)
        .find('.rwmb-select_advanced_ajax')
        .addBack('.rwmb-select_advanced_ajax')
        .each(function() {
          initSelectAjax($(this));
        });
    });
  });
  
  // Observe all group containers for new clones
  $('.rwmb-group-wrapper .rwmb-input').each(function() {
    observer.observe(this, { 
      childList: true, 
      subtree: true 
    });
  });
  
});
