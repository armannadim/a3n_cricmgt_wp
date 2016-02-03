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
//var_dump($_POST);
    $sql = "update " . $wpdb->prefix . "a3n_match_summary set ";
    switch ($columnName) {
        case "TeamA_score": $sql .=" TeamA_score = '$value' ";
            break;
        case "TeamA_wicket": $sql .=" TeamA_wicket = '$value' ";
            break;
        case "TeamA_over": $sql .=" TeamA_over = '$value' ";
            break;
        case "TeamB_score": $sql .=" TeamB_score = '$value' ";
            break;
        case "TeamB_wicket": $sql .=" TeamB_wicket = '$value' ";
            break;
        case "TeamB_over": $sql .=" TeamB_over = '$value' ";
            break;
        case "result": $sql .=" result = '$value' ";
            break;
        case "mom": $sql .=" mom = '$value' ";
            break;
    }

    $sql .= " where id = " . $id;
    $wpdb->query($sql);

    echo $value;
}
?>