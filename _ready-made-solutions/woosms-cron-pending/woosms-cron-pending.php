<?php
/*
  Plugin Name: WooSMS - Cron pending SMS
  Plugin URI: http://www.woo-sms.net/
  Description: Cron job
  Version: 1.0.0
  Author: TOPefekt s.r.o. - Lukáš Piják
  Author URI: http://www.bulkgate.com/
*/

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

/*
 * 1. To wp-config.php -> define( 'DISABLE_WP_CRON', true);
 * 2. Define WOOSMS_CRON_JON_PERIOD in minutes
 * 3. Define run() function
 * 4. Set cron job on server to script https://example.com/wp-cron.php?doing_wp_cron
 */

!defined('ABSPATH') && exit;

require_once(ABSPATH . 'wp-admin/includes/plugin.php');

define('WOOSMS_CRON_JON_PERIOD', 1);

/**
 * Check if WooSMS is installed
 */
if (is_plugin_active('woosms-sms-module-for-woocommerce/woosms-sms-module-for-woocommerce.php'))
{
    function woosms_cron_run()
    {
        /** \wpdb */
        global $wpdb;

        $config = include_once __DIR__. '/config.php';

        $wait_time = isset($config['waitTime']) ? $config['waitTime'] : 30;

        $result = $wpdb->get_results('SELECT  `ID` FROM `'.$wpdb->prefix.'posts` WHERE `post_type` = \'shop_order\' AND `post_status` = \'wc-pending\' AND (`post_date` + INTERVAL '.$wpdb->_escape($wait_time).' MINUTE) < CONVERT_TZ(NOW(),\'+02:00\',\'+03:00\') AND NOT `pinged`');

        if(is_array($result))
        {
            foreach($result as $row)
            {
                $data = woosms_cron_post_meta($row->ID);

                do_action(
                    'woosms_send_sms',
                    woosms_cron_get_from_array($data, '_billing_phone'),
                    isset($config['template']) ?  $config['template'] : '',
                    array_merge(array(
                        '_order_id'  => $row->ID
                    ), $data),
                    array(
                        'unicode' => isset($config['unicode']) ? (bool) $config['unicode'] : false,
                        'flash' => isset($config['flash']) ? (bool) $config['flash'] : false,
                        'country' => strtolower(woosms_cron_get_from_array($data, '_billing_country')),
                        'senderType' => isset($config['senderType']) ? $config['senderType'] : 'gSystem',
                        'senderValue' => isset($config['senderValue']) ? $config['senderValue'] : '',
                      )
                );

                wp_update_post(array(
                    'ID' => $row->ID,
                    'pinged' => '1',
                ));
            }
        }
    }

    add_action('init', function ()
    {
        if(wp_next_scheduled('woosms_cron_job') === false)
        {
            wp_schedule_single_event(time() + WOOSMS_CRON_JON_PERIOD * 60, 'woosms_cron_job');
        }
    }, 20, 0);

    add_action('woosms_cron_job', function()
    {
        woosms_cron_run();
        wp_clear_scheduled_hook("woosms_cron_job");
        wp_schedule_single_event(time() + WOOSMS_CRON_JON_PERIOD * 60, "woosms_cron_job");
    }, 21, 0);

    function woosms_cron_post_meta($id)
    {
        $data = (get_post_meta($id));

        foreach($data as $key => $item)
        {
            $data[$key] = reset($item);
        }
        return $data;
    }

    function woosms_cron_get_from_array(array $array, $field, $default = '')
    {
        return isset($array[$field]) ? $array[$field] : $default;
    }
}
else
{
    deactivate_plugins(plugin_basename(__FILE__));
}
