<?php

/*
 * Database activities added on this page. This script will update standing table on database.
 * This script called when the user tries to modify data on the datatables on the tab "Standings".
 * Author: Aseq A Arman Nadim
 * Date: 02 March 2015
 */

header("Content-Type: application/json", true);
require_once('../../../../wp-load.php');
defined('ABSPATH') or die('No script kiddies please!');
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
global $wpdb;
$query = "select f.id, f._group, f.matchdate , "
        . " (SELECT team from " . $wpdb->prefix . "a3n_team where id= f.teamA) TeamA, "
        . " (SELECT team from " . $wpdb->prefix . "a3n_team where id= f.teamB) TeamB, "
        . " (select tournament from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) Tournament,"
        . " (select season from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) Season"
        . " from " . $wpdb->prefix . "a3n_fixture f  ";


$results = $wpdb->get_results($wpdb->prepare($query, $id));

echo json_encode($results);
?>