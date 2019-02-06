<?php
/*
  Plugin Name: WooSMS - Zitec DPD-RO Tracking number
  Plugin URI: http://www.woo-sms.net/
  Description: Extends Admin & Customer SMS -&gt; &lt;dpd_shipment_reference_number&gt; &lt;dpd_shipment_id&gt; &lt;dpd_reference_tracking_id&gt; &lt;dpd_tracking_url&gt; variables | Zitec DPD-RO <a href="https://zitec.com/">https://zitec.com/</a>
  Version: 1.0.0
  Author: BulkGate.com - Lukáš Piják
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
if (is_plugin_active('woosms-sms-module-for-woocommerce/woosms-sms-module-for-woocommerce.php') && is_plugin_active('woocommerce-zitec-dpd/woocommerce-zitec-dpd.php'))
{
    /**
     * Extend WooSMS
     */
    add_action("woosms_extends_variables", function(Extensions\Hook\Variables $variables, Extensions\Database\IDatabase $database)
    {
        $result = $database->execute('SELECT `shipment_id`, `dpd_shipment_reference_number`, `dpd_shipment_id` FROM `'.$database->table('zitec_dpd_shipments').'` WHERE `order_id` = "'.$database->escape($variables->get('order_id')).'"');

        if($result->getNumRows() > 0)
        {
            $row = $result->getRow();
            $variables->set('dpd_shipment_reference_number', $row->dpd_shipment_reference_number);
            $variables->set('dpd_shipment_id', $row->dpd_shipment_id);
            
            $tracking = $database->execute('SELECT `tracking_id`, `refference_tracking_id`, `tracking_url` FROM `'.$database->table('zitec_dpd_shipment_tracking').'` WHERE `shipment_id` = "'.$database->escape($row->shipment_id).'" ORDER BY `tracking_id` DESC LIMIT 1');
            
            if($tracking->getNumRows() > 0)
            {
                $row = $tracking->getRow();
                $variables->set('dpd_reference_tracking_id', $row->refference_tracking_id);
                $variables->set('dpd_tracking_url', $row->tracking_url);
            }
        }
    }, 20, 2);
}
else
{
    deactivate_plugins(plugin_basename(__FILE__));
}
