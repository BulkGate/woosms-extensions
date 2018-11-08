# WooSMS Extensions plugins

## Customer & Admin SMS Variables extensions

```php
add_action("woosms_extends_variables", function(Extensions\Hook\Variables $variables, Extensions\Database\IDatabase $database)
{
    $result = $database->execute('SELECT `tracking_number` FROM `order` WHERE order_id = "'.$database->escape($variables->get('order_id')).'"');

    if($result->getNumRows())
    {
        $row = $result->getRow();
        $variables->set('tracking_number', $row['tracking_number']);
    }

    /** Now you can use in Customer or Admin SMS variable <tracking_number> */

}, 20, 2);
```

## Ready made solutions

**woosms-aftership-exntesion** - Customer & Admin SMS variables extension
```
<_aftership_tracking_provider>,
<_aftership_tracking_provider_name>,
<_aftership_tracking_required_fields>,
<_aftership_tracking_number>,
<_aftership_tracking_shipdate>,
<_aftership_tracking_postal>,
<_aftership_tracking_account>,
<_aftership_tracking_key>,
<_aftership_tracking_destination_country>
```
