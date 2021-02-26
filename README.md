# Meta Box Field Select Advanced Ajax

Plugin compatible with Meta Box with ajax and select-advanced field

[Meta Box](https://metabox.io)

[Meta Box Documentation](https://docs.metabox.io)

## Installation

1) Download zip and place it on plugins folder
2) Activate plugin

## Example usage

```php
array(
    'name' => 'Name of your field',
    'id'   => '_id_of_your_field',
    'type' => 'select_advanced_ajax',
    'sanitize_callback'   => 'none',
    'js_options' => array (
    'ajax' => array(
        'url' => '/wp-admin/admin-ajax.php',
        'dataType' => 'json',
        'type' => 'post',
            'data' => [
            'action' => 'get_my_items', // You need to create your own action
        ],
     'delay' => '250',
     ),
     'minimumInputLength' => 0,
     'allowClear' => true, 
     'placeholder' => 'Selectionner un filtre',
  ),
),
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
