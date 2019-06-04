<?php
/*
  Plugin Name: WooSMS - WooCommerce License Keys
  Plugin URI: http://www.woo-sms.net/
  Description: Licence code for https://www.10quality.com/
  Version: 1.0.0
  Author: TOPefekt s.r.o. - Lukáš Piják
  Author URI: http://www.bulkgate.com/
*/

/**
 * @author Lukáš Piják 2019 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Extensions;

!defined('ABSPATH') && exit;

require_once(ABSPATH . 'wp-admin/includes/plugin.php');

/**
 * Check if WooSMS is installed
 */
if (is_plugin_active('woosms-sms-module-for-woocommerce/woosms-sms-module-for-woocommerce.php'))
{
    /**
     * Extend WooSMS
     */
    add_action("woosms_extends_variables", function(Extensions\Hook\Variables $variables, Extensions\Database\IDatabase $database)
    {
        $result = $database->execute('SELECT `order_item_id`, `order_item_name` FROM `'.$database->table('woocommerce_order_items').'` WHERE order_id = "'.$database->escape($variables->get('order_id')).'"');

        $items = array();

        if($result->getNumRows())
        {
            foreach($result as $row)
            {
                $items[$database->escape((int) $row->order_item_id)] = $database->escape($row->order_item_name);
            }

            $codes = $database->execute('SELECT `order_item_id`, `meta_value` FROM `'.$database->table('woocommerce_order_itemmeta').'` WHERE `order_item_id` IN ('.implode(',', array_keys($items)).') AND `meta_key` = "_license_key"');

            if($codes->getNumRows())
            {
                $output = array();

                foreach($codes as $code)
                {
                    $data = unserialize($code->meta_value);

                    if(is_array($data) && isset($data['code']) && isset($items[(int) $code->order_item_id]))
                    {
                        $output[] = $items[(int) $code->order_item_id].': '.$data['code'] . '-' . (string) $code->order_item_id;
                    }
                }
                $variables->set('license_code', implode("\n", $output));
            }
        }
    }, 20, 2);
}
else
{
    deactivate_plugins(plugin_basename(__FILE__));
}
