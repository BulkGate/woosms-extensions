# WooSMS Extensions plugins

## Customer & Admin SMS Variables extensions

```php
add_action("woosms_extends_variables", function(Extensions\Hook\Variables $variables, Extensions\Database\IDatabase $database)
{
    $result = $database->execute('SELECT `tracking_number` FROM `order` WHERE order_id = "'.$database->escape($variables->get('order_id')).'"');

    if($result->getNumRows())
    {
        $row = $result->getRow();
        $variables->set('tracking_number', $row->tracking_number);
    }

    /** Now you can use in Customer or Admin SMS variable <tracking_number> */

}, 20, 2);
```

## Ready made solutions

**woosms-aftership-exntesion** - Customer & Admin SMS variables extension https://wordpress.org/plugins/aftership-woocommerce-tracking/
```
<_aftership_tracking_provider>, <_aftership_tracking_provider_name>, <_aftership_tracking_required_fields>,
<_aftership_tracking_number>, <_aftership_tracking_shipdate>, <_aftership_tracking_postal>,
<_aftership_tracking_account>, <_aftership_tracking_key>, <_aftership_tracking_destination_country>
```

**woosms-wcst-shipping-tracking** - Customer & Admin SMS variables extension https://codecanyon.net/item/woocommerce-shipping-tracking/11363158
```
<_wcst_order_trackno>, <_wcst_track_without_tracking_code>, <_wcst_order_dispatch_date'>,
<_wcst_custom_text'>, <_wcst_order_trackname'>, <_wcst_order_trackurl'>, <_wcst_order_track_http_url'>
```

**woosms-eupago-multibanco** - Customer & Admin SMS variables extension https://wordpress.org/plugins/eupago-for-woocommerce/
```
<_eupago_multibanco_entidade>, <_eupago_multibanco_referencia>
```
