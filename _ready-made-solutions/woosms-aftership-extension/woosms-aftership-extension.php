<?php
/*
  Plugin Name: WooSMS - AfterShip plugin extension
  Plugin URI: http://www.woo-sms.net/
  Description: Extends Customer & Admin SMS variables <a href="https://wordpress.org/plugins/aftership-woocommerce-tracking/">https://wordpress.org/plugins/aftership-woocommerce-tracking/</a>
  Version: 1.0.0
  Author: TOPefekt s.r.o. - Lukáš Piják
  Author URI: http://www.bulkgate.com/
*/

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
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
                    if(in_array($key, array(
                        '_aftership_tracking_provider',
                        '_aftership_tracking_provider_name',
                        '_aftership_tracking_required_fields',
                        '_aftership_tracking_number',
                        '_aftership_tracking_shipdate',
                        '_aftership_tracking_postal',
                        '_aftership_tracking_account',
                        '_aftership_tracking_key',
                        '_aftership_tracking_destination_country'
                    ), true))
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
