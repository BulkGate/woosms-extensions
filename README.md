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
