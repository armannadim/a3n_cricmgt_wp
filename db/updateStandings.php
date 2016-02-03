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
    
    
    $sql = "update " . $wpdb->prefix . "a3n_point_table set ";
    switch ($columnName) {
        case "Pos": $sql .=" position = '$value' ";
            break;
        case "P": $sql .=" match_played = '$value' ";
            break;
        case "W": $sql .=" win= '$value' ";
            break;
        case "L": $sql .=" lost = '$value' ";
            break;
        case "T/NR": $sql .=" tie_NR = '$value' ";
            break;
        case "NRR": $sql .=" nrr = '$value' ";
            break;
        case "Points": $sql .=" point = '$value' ";
            break;
        case "ForR": $sql .=" runs_for = '$value' ";
            break;
        case "ForO": $sql .=" overs_for = '$value' ";
            break;
        case "AgainstR": $sql .=" runs_against = '$value' ";
            break;
        case "AgainstO": $sql .=" overs_against = '$value' ";
            break;        
    }

    $sql .= " where id = " . $id;
    
    $wpdb->query($sql);

    echo $value;
}
?>