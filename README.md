# Meta Box Field Select Advanced Ajax

Plugin compatible with Meta Box with ajax and select-advanced field

[Meta Box](https://metabox.io)

[Meta Box Documentation](https://docs.metabox.io)

## What's New in Version 1.2

- **Full Meta Box Groups support** - Works perfectly inside groups with cloneable fields
- **Unique IDs per clone** - Each cloned field maintains independent values
- **100% Backward compatible** - All existing implementations continue to work
- **Improved code quality** - Better error handling and validation

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

### Usage with Meta Box Groups (NEW!)

```php
array(
    'id'   => 'my_group',
    'type' => 'group',
    'clone' => true,
    'fields' => array(
        array(
            'name' => 'Ajax Field',
            'id'   => '_ajax_field',
            'type' => 'select_advanced_ajax',
            'sanitize_callback' => 'none',
            'js_options' => array(
                'ajax' => array(
                    'url' => '/wp-admin/admin-ajax.php',
                    'dataType' => 'json',
                    'type' => 'post',
                    'data' => [
                        'action' => 'get_my_items',
                    ],
                    'delay' => '250',
                ),
                'minimumInputLength' => 0,
                'allowClear' => true,
                'placeholder' => 'Select an option',
            ),
        ),
    ),
),
```

## API Response Format

Your AJAX endpoint should return data in Select2 format:

```json
{
    "results": [
        {
            "id": "unique_id",
            "text": "Display Text"
        }
    ],
    "pagination": {
        "more": false
    }
}
```

## Changelog

### Version 1.2
- Added full Meta Box Groups support
- Fixed duplicate IDs when using cloneable fields
- Improved JavaScript with MutationObserver for dynamic clone detection
- Better error handling and validation
- Improved code documentation

### Version 1.1
- Tweaks to utilize current metabox logics to queue js in posts and settings pages. 
- Prevent loading this file directly and check if plugin class exists

### Version 1.0
- Initial release

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
