<?php
/*
  Plugin Name: WooSMS - Admin & Customer SMS Variables Extension
  Plugin URI: http://www.woo-sms.net/
  Description: Skeleton
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
        /** @example PSEUDO CODE

        $result = $database->execute('SELECT `tracking_number` FROM `order` WHERE order_id = "'.$database->escape($variables->get('order_id')).'"');

        if($result->getNumRows())
        {
            $row = $result->getRow();
            $variables->set('tracking_number', $row->tracking_number);
        }

        */
        $variables->set("test_variable", "value");

        /** Now you can use in Customer or Admin SMS variable <test_variable> */

    }, 20, 2);
}
else
{
    deactivate_plugins(plugin_basename(__FILE__));
}
