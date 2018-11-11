<?php
/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

return array(
    'waitTime' => 60, // wait time for SMS in minutes
    'unicode' => true, // for diacritics
    'flash' => false,
    'senderType' => 'gSystem', // gSystem, gShort, gText, gOwn
    'senderValue' => '', // in case gText, gOwn
    'template' => <<<EOF
text of message <_order_id>
EOF
,
);

/**
 * Possible variables:
 ---------------------
    <_order_id>
    <_edit_last>
    <_order_key>
    <_customer_user>
    <_payment_method>
    <_payment_method_title>
    <_transaction_id>
    <_customer_ip_address>
    <_customer_user_agent>
    <_created_via>
    <_date_completed>
    <_completed_date>
    <_date_paid>
    <_paid_date>
    <_cart_hash>
    <_billing_first_name>
    <_billing_last_name>
    <_billing_company>
    <_billing_address_1>
    <_billing_address_2>
    <_billing_city>
    <_billing_state>
    <_billing_postcode>
    <_billing_country>
    <_billing_email>
    <_billing_phone>
    <_shipping_first_name>
    <_shipping_last_name>
    <_shipping_company>
    <_shipping_address_1>
    <_shipping_address_2>
    <_shipping_city>
    <_shipping_state>
    <_shipping_postcode>
    <_shipping_country>
    <_order_currency>
    <_cart_discount>
    <_cart_discount_tax>
    <_order_shipping>
    <_order_shipping_tax>
    <_order_tax>
    <_order_total>
    <_order_version>
    <_prices_include_tax>
    <_billing_address_index>
    <_shipping_address_index>
    etc...
 */