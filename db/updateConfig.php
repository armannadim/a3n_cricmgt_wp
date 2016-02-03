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
    if ($_POST['action'] == "delete") {
        $sql = "DELETE FROM " . $wpdb->prefix . "a3n_" . $_POST['table'] . " where id= " . $_POST['id'];
        $wpdb->query($sql);
    }
    if (isset($_POST['columnId'])) {
        $id = preg_replace("/[^0-9]/", "", $_POST['id']);
        ;
        $columnId = $_POST['columnId'];
        $columnName = $_POST['columnName'];
        $columnPosition = $_POST['columnPosition'];
        $value = $_POST['value'];
        $table = "";
        if (strpos($_POST['id'], 'team')) {

            $table = "team";
        } else {
            $table = "tournament";
        }
        $sql = "update " . $wpdb->prefix . "a3n_$table set ";
        switch ($columnName) {
            case "Team": $sql .=" team = '$value' ";
                break;
            case "tournament": $sql .=" tournament = '$value' ";
                break;
            case "format": $sql .=" format = '$value' ";
                break;
            case "season": $sql .=" season = '$value' ";
                break;
        }

        $sql .= " where id = " . $id;
        $wpdb->query($sql);

        echo $value;
    }
}
?>