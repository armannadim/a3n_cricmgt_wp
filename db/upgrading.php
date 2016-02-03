<?php

/*
 * To update database when necesary for different version
 * Date: 27th March 2015.
 */
require_once('../../../../wp-load.php');
defined('ABSPATH') or die('No script kiddies please!');
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
global $wpdb;

if (isset($_POST)) {
    if ($_POST['action'] === "alter") {
        switch ($_POST['column']) {
            case 'venue': addVenue();
        }
    }
}

function addVenue() {
    global $wpdb;
    $sql = "ALTER TABLE " . $wpdb->prefix . "a3n_fixture ADD venue varchar(100)";
    $wpdb->query($sql);
}
