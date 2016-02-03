<?php

/*
 * Database activities added on this page. This script will update standing table on database.
 * This script called when the user tries to modify data on the datatables on the tab "Standings".
 * Author: Aseq A Arman Nadim
 * Date: 02 March 2015
 */

require_once('../../../../wp-load.php');
defined('ABSPATH') or die('No script kiddies please!');
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
global $wpdb;
if (isset($_POST)) {
    $id = $_POST['id'];
    $columnId = $_POST['columnId'];
    $columnName = $_POST['columnName'];
    $columnPosition = $_POST['columnPosition'];
    $value = $_POST['value'];

    $sql = "update " . $wpdb->prefix . "a3n_fixture set ";
    switch ($columnName) {
        case "TeamA": $sql .=" TeamA = '$value' ";
            break;
        case "TeamB": $sql .=" TeamB = '$value' ";
            break;
        case "_group": $sql .=" _group = '$value' ";
            break;
        case "matchdate": $sql .=" matchdate = '$value' ";
            $date = strtotime($value);
            $value = date('Y-m-d H:i:s', $date);
            break;
        case "tournamentId": $sql .=" tournamentId = '$value' ";
            break;
        case "venue": $sql .=" venue = '$value' ";
            break;
    }

    $sql .= " where id = " . $id;
    $wpdb->query($sql);

    echo $value;
}
?>