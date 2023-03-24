<?php
/**
 * Plugin Name: Notification Email Changer
 * Plugin URI: https://github.com/melekin/notification-email-changer
 * Description: Adds WordPress Notification Email Address to the General Settings tab.
 * Version: 1.0.0
 * Author: Charles Peck
 * Author URI: https://g.dev/chuck
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: notification-email-changer
 */

// Add a new field to the General Settings page
add_filter('admin_init', 'custom_email_address_init');
function custom_email_address_init(){
    register_setting('general', 'custom_email_address', 'esc_attr');
    register_setting('general', 'custom_email_name', 'esc_attr');
    add_settings_field('custom_email_name', 'WordPress Notification From Email Name', 'custom_email_name_setting_callback', 'general');
    add_settings_field('custom_email_address', 'WordPress Notification Email Address', 'custom_email_address_setting_callback', 'general');
}

// Callback function to render the new email address field
function custom_email_address_setting_callback(){
    $value = get_option('custom_email_address');
    echo '<input type="email" id="custom_email_address" name="custom_email_address" value="' . esc_attr($value) . '" />';
}

// Callback function to render the new "From" name field
function custom_email_name_setting_callback(){
    $value = get_option('custom_email_name');
    echo '<input type="text" id="custom_email_name" name="custom_email_name" value="' . esc_attr($value) . '" />';
}

// Change the email address and "From" name used by WordPress to send notifications
add_filter('wp_mail_from', 'custom_email_from');
add_filter('wp_mail_from_name', 'custom_email_from_name');
function custom_email_from($original_email_address){
    if(get_option('custom_email_address')){
        return get_option('custom_email_address');
    }
    return $original_email_address;
}
function custom_email_from_name($original_email_from){
    if(get_option('custom_email_name')){
        return get_option('custom_email_name');
    }
    return $original_email_from;
}