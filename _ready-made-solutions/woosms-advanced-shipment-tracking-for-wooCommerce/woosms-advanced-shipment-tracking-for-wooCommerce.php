<?php
/*
  Plugin Name: WooSMS - Advanced Shipment Tracking for WooCommerce
  Plugin URI: http://www.woo-sms.net/
  Description: Extends Customer & Admin SMS variables <a href="https://www.zorem.com/product/woocommerce-advanced-shipment-tracking/">https://www.zorem.com/product/woocommerce-advanced-shipment-tracking/</a>
  Version: 1.0.0
  Author: TOPefekt s.r.o. - Lukáš Piják
  Author URI: http://www.bulkgate.com/
*/

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
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
    add_action('woosms_extends_variables', function(Extensions\Hook\Variables $variables, Extensions\Database\IDatabase $database)
    {
        if ($variables->get('order_id'))
        {
            $data = get_post_meta($variables->get('order_id'));

            if (is_array($data))
            {
                foreach ($data as $key => $item)
                {
                    if ($key === '_wc_shipment_tracking_items')
                    {
                        $data = reset($item);
                        $data = unserialize((string) $data);

                        if (is_array($data))
                        {
                            $data = reset($data);

                            if (is_array($data))
                            {
                                foreach ($data as $k => $v)
                                {
                                    $variables->set($k, (string) $v);
                                }
                            }
                        }

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
