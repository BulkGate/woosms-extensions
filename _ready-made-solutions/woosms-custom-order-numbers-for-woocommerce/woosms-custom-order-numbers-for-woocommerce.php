<?php
/*
  Plugin Name: WooSMS - Custom order number
  Plugin URI: http://www.woo-sms.net/
  Description: https://github.com/WPPlugins/custom-order-numbers-for-woocommerce
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
        if($variables->get('order_id'))
        {
            $data = get_post_meta($variables->get('order_id'));
            
            if(is_array($data))
            {
                foreach($data as $key => $item)
                {
                    if($key === '_alg_wc_custom_order_number')
                    {
                        $variables->set($key, (string) reset($item));
                    }
                }
            }
        }
    }, 20, 2);
}
else
{
    deactivate_plugins(plugin_basename(__FILE__));
}
