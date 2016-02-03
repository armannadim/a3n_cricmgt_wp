<?php

/*
 * This page inserts team and tournament in the database. 
 * Author: Aseq A Arman Nadim
 * Date: 03 March 2015
 */

require_once('../../../../wp-load.php');
defined('ABSPATH') or die('No script kiddies please!');
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
global $wpdb;
if (isset($_POST['addTournament']) && $_POST['addTournament'] == 'Tournament') {
    $a3n_tournament = $_POST['a3n_tournament'];
    $a3n_season = $_POST['a3n_season'];
    $a3n_format = $_POST['a3n_format'];

    $wpdb->insert($wpdb->prefix . "a3n_tournament", array(
        'tournament' => $a3n_tournament,
        'format' => $a3n_format,
        'season' => $a3n_season
    ));
}
if (isset($_POST['addTeam']) && $_POST['addTeam'] == 'Team') {

    $team = $_POST['a3n_team'];

    $wpdb->insert($wpdb->prefix . "a3n_team", array(
        'team' => $team
    ));
}