<?php

/*
 * Database activities added on this page. This script will update standing table on database.
 * This script called when the user tries to modify data on the datatables on the tab "Standings".
 * Author: Aseq A Arman Nadim
 * Date: 02 March 2015
 */

// DataTables PHP library and database connection
//require_once( '../../../../wp-admin/includes/upgrade.php' );
require_once('../../../../wp-config.php');
global $wpdb;



$query = "select f.id, (SELECT team from wp_a3n_team where id= f.teamA) TeamA,"
        . " (SELECT team from wp_a3n_team where id= f.teamB) TeamB, "
        . " f._group, "
        . " f.matchdate, "
        . " (select tournament from wp_a3n_tournament where id = f.tournamentId) Tournament,"
        . " ms.* "
        . " from wp_a3n_fixture f , "
        . " wp_a3n_match_summary ms where f.id = ms.fixtureId";


$result = $wpdb->get_results($query);
$json = json_encode($result);

header('Content-type: application/json');
echo $json;

