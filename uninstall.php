<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('woo_title');
delete_option('woo_pause');
delete_option('woo_transduration');
delete_option('woo_random');
delete_option('woo_type');
 
// for site options in Multisite
delete_site_option('woo_title');
delete_site_option('woo_pause');
delete_site_option('woo_transduration');
delete_site_option('woo_random');
delete_site_option('woo_type');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}woo_transition");