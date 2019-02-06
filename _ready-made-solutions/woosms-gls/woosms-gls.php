<?php
/*
  Plugin Name: WooSMS - GLS tracking number
  Plugin URI: http://www.woo-sms.net/
  Description: Extends Admin & Customer SMS -&gt; &lt;gls_info&gt; &lt;gls_client_ref&gt; &lt;gls_cod_amount&gt; &lt;gls_cod_ref&gt; &lt;gls_pickup_date&gt; variables | Gls Shipping - GLS Parcel Order Generator <a href="https://www.sprintsoft.ro/">https://www.sprintsoft.ro/</a>
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
if (is_plugin_active('woosms-sms-module-for-woocommerce/woosms-sms-module-for-woocommerce.php') && is_plugin_active('gls/gls.php'))
{
    /**
     * Extend WooSMS
     */
    add_action("woosms_extends_variables", function(Extensions\Hook\Variables $variables, Extensions\Database\IDatabase $database)
    {
        $result = $database->execute('SELECT `content` AS `gls_info`, `clientref` AS `gls_client_ref`, 	`codamount` AS `gls_cod_amount`, `codref` AS `gls_cod_ref`, `pickupdate` AS `gls_pickup_date` FROM `glscarrier` WHERE order_id = "'.$database->escape($variables->get('order_id')).'"');

        if($result->getNumRows())
        {
            $row = $result->getRow();
            $variables->set('gls_info', $row['gls_info']);
            $variables->set('gls_client_ref', $row['gls_client_ref']);
            $variables->set('gls_cod_amount', $row['gls_cod_amount']);
            $variables->set('gls_cod_ref', $row['gls_cod_ref']);
            $variables->set('gls_pickup_date', $row['gls_pickup_date']);
        }
    }, 20, 2);
}
else
{
    deactivate_plugins(plugin_basename(__FILE__));
}
