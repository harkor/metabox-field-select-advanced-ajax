jQuery(function($){

  $('.rwmb-select_advanced_ajax').each(function(){

    var $this = $(this);

    var $field = $this;
    var $interface = $("#"+ $field.attr('id') +"-interface");
    
    $field.on("change", function(){
      
      var $this = $(this);
      var value = $this.find(":selected").val();
      var text = $this.find(":selected").text();
      var data = "";
      
      if(value != ""){
        data = JSON.stringify({ value : value, text : text });
      }

      $interface.val(data);

    });

    if($interface.val() != ""){
      var data = JSON.parse($interface.val());
      var newOption = new Option(data.text, data.value, true, true);
      $field.append(newOption);
    }

  });
  
});
