<?php

/**
 * Plugin Name: Cricket Management
 * Plugin URI: http://wpplugins.armannadim.com/
 * Description: This plugin will show fixture, results, point tables of a cricket league.
 * Version: 1.1.1
 * Author: Arman Nadim
 * Author URI: http://www.armannadim.com
 * License: GPL2 
  A3N Cricket Management v1.0 is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation.

  A3N Cricket Management v1.0 is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with A3N Cricket Management v1.0. If not, see {License URI}.
 */
defined('ABSPATH') or die('No script kiddies please!');

function a3n_cricmgt_admin() {
    include('a3n_home_admin.php');
}

function a3n_admin_actions() {
    add_menu_page("A3N Cricket Management", "A3N Cricket Management", 1, "A3N_cricmgt", "a3n_cricmgt_admin");
}

add_action('admin_menu', 'a3n_admin_actions');

//SETUP
function a3n_cricmgt_activation() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $db_table_fixture = $wpdb->prefix . 'a3n_fixture';
    $attr_fixture = "CREATE TABLE " . $db_table_fixture . " ("
            . " id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, "
            . " TeamA int(10) , "
            . " TeamB int(10) , "
            . " _group varchar(5), "
            . " matchdate datetime NOT NULL, "
            . " tournamentId int, "
            . " PRIMARY KEY ( id ) ) ";
    createTable($db_table_fixture, $attr_fixture, $wpdb);


    $db_table_match_summary = $wpdb->prefix . 'a3n_match_summary';
    $attr_match_summary = "CREATE TABLE " . $db_table_match_summary . " ("
            . " id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,"
            . " fixtureId int NOT NULL,"
            . " TeamA_score varchar(20),"
            . " TeamA_wicket varchar(20),"
            . " TeamA_over varchar(20), "
            . " TeamB_score varchar(20),"
            . " TeamB_wicket varchar(20),"
            . " TeamB_over varchar(100) NOT NULL,"
            . " result varchar(500),"
            . " mom varchar(100),"
            . " PRIMARY KEY ( id ) ) ";
    createTable($db_table_match_summary, $attr_match_summary, $wpdb);


    $db_table_point_table = $wpdb->prefix . 'a3n_point_table';
    $attr_point_table = "CREATE TABLE " . $db_table_point_table . " ("
            . " id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, "
            . " tournamentID int (5),"
            . " position int (2),"
            . " _group varchar(5),"
            . " team int (3),"
            . " match_played int(2),"
            . " win int(2),"
            . " loss int(2),"
            . " tie_NR int(2),"
            . " runs_for varchar(5),"
            . " overs_for varchar(5),"
            . " runs_against varchar(5),"
            . " overs_against varchar(5),"
            . " nrr int(10),"
            . " point FLOAT,"
            . " PRIMARY KEY (id) ) ";
    createTable($db_table_point_table, $attr_point_table, $wpdb);


    $db_table_team = $wpdb->prefix . 'a3n_team';
    $attr_team = "CREATE TABLE " . $db_table_team . " ("
            . " id int(2) UNSIGNED NOT NULL AUTO_INCREMENT, "
            . " team varchar(50),"
            . " PRIMARY KEY (id) ) ";
    createTable($db_table_team, $attr_team, $wpdb);


    $db_table_tournament = $wpdb->prefix . 'a3n_tournament';
    $attr_tournament = "CREATE TABLE " . $db_table_tournament . " ("
            . " id int(5) UNSIGNED NOT NULL AUTO_INCREMENT, "
            . " tournament varchar(50), "
            . " format varchar(10), "
            . " season varchar(5), "
            . " PRIMARY KEY (id) ) ";
    createTable($db_table_tournament, $attr_tournament, $wpdb);


    //$db_table_batting_details = $wpdb->prefix . 'batting_details'; //NOT IMPLEMENTED IN THE VERSION 1
    //$db_table_bowling_details = $wpdb->prefix . 'bowling_details'; //NOT IMPLEMENTED IN THE VERSION 1
    //$db_table_players = $wpdb->prefix . 'players';//NOT IMPLEMENTED IN THE VERSION 1
}

register_activation_hook(__FILE__, 'a3n_cricmgt_activation');

function createTable($tableName, $query, $wpdb) {
    if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
        if (!empty($wpdb->charset)) {
            $charset_collate = " DEFAULT CHARACTER SET $wpdb->charset";
        }
        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE $wpdb->collate";
        }
        $sql = $query . " $charset_collate; ";
        dbDelta($sql);



        /* $sql = $attr_season . " $charset_collate; ";
          dbDelta($sql); */
        /* NOT IMPLEMENTED IN THE VERSION 1  
          $sql = create_table_sql($db_table_batting_details, '')." $charset_collate;
          ";
          dbDelta($sql);

          $sql = create_table_sql($db_table_bowling_details, '')." $charset_collate;
          ";
          dbDelta($sql);

          $sql = create_table_sql($db_table_players, '')." $charset_collate;
          ";
          dbDelta($sql); */
    }
}

function a3n_cricmgt_deactivation() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;

    $dropFixture = "Drop table " . $wpdb->prefix . 'a3n_fixture ;';
    $wpdb->query($dropFixture);
    $dropMatchSummary = "Drop table " . $wpdb->prefix . 'a3n_match_summary ;';
    $wpdb->query($dropMatchSummary);
    $dropTeam = "Drop table " . $wpdb->prefix . 'a3n_team ;';
    $wpdb->query($dropTeam);
    $dropPointTable = "Drop table " . $wpdb->prefix . 'a3n_point_table ;';
    $wpdb->query($dropPointTable);
    $dropTournament = "Drop table " . $wpdb->prefix . 'a3n_tournament ;';
    $wpdb->query($dropTournament);
}

register_deactivation_hook(__FILE__, 'a3n_cricmgt_deactivation');

function getMatchSummary() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select f.id, (SELECT team from " . $wpdb->prefix . "a3n_team where id= f.teamA) TeamA,"
            . " (SELECT team from " . $wpdb->prefix . "a3n_team where id= f.teamB) TeamB, "
            . " f._group, "
            . " f.matchdate, "
            . " (select tournament from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) Tournament,"
            . " ms.* "
            . " from wp_a3n_fixture f , "
            . " wp_a3n_match_summary ms where f.id = ms.fixtureId";


    $result = $wpdb->get_results($query);
    return $result;
}

function getFixture() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select * , "
            . "(SELECT team from " . $wpdb->prefix . "a3n_team where id= f.teamA) TeamA,"
            . " (SELECT team from " . $wpdb->prefix . "a3n_team where id= f.teamB) TeamB, "
            . " (select tournament from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) Tournament,"
            . " (select season from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) Season"
            . " from " . $wpdb->prefix . "a3n_fixture f  ";


    $results = $wpdb->get_results($wpdb->prepare($query, $id));

    return $results;
}

function getTeamsJSON() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select * "
            . " from " . $wpdb->prefix . "a3n_team t  ";


    $results = $wpdb->get_results($query);
    $teams[0] = 'Please Select';
    foreach ($results as $result) {
        $teams[$result->id] = $result->team;
    }
    $json = json_encode($teams);

    return $json;
}

function getTournamentsJSON() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select * "
            . " from " . $wpdb->prefix . "a3n_tournament t  ";


    $results = $wpdb->get_results($query);
    $tournament[0] = 'Please Select';
    foreach ($results as $result) {
        $tournament[$result->id] = $result->tournament;
    }
    $json = json_encode($tournament);

    return $json;
}

function bulkLoadFixture($FILES) {
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        //print_r($emapData);
        //exit();
        $sql = "UPDATE into " . $wpdb->prefix . "a3n_fixture (TeamA, TeamB, _group, matchdate, tournamentId) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[3]')";
        dbDelta($sql);
    }
    return "Database updated";
}

function bulkLoadResults($FILES) {
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        //print_r($emapData);
        //exit();
        $sql = "INSERT into " . $wpdb->prefix . "a3n_match_summary (fixtureId, TeamA_score, TeamA_wicket, TeamA_over, TeamB_score, TeamB_wicket, TeamB_over, result, mom) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]')";
        dbDelta($sql);
    }
    return "Database updated";
}

function getTeamsDT() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select * "
            . " from " . $wpdb->prefix . "a3n_team t  ";


    $result = $wpdb->get_results($query);
    return $result;
}

function getTournament() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select * "
            . " from " . $wpdb->prefix . "a3n_tournament t  ";


    $result = $wpdb->get_results($query);
    return $result;
}

/* FRONT END SHORT CODE */

/*
 * As attr this function will recieve few variables
 * $attr is an Array
 * Tournament ID
 * Group ID
 * Returns htmlCode [To show the point table]
 */

function Show_pointTable($atts) {
    $htmlCode = "";

    $atts = shortcode_atts(array(
        'tid' => "No",
        'group' => '0'
            ), $atts, 'a3n_matches');
    if ($atts['tid'] === 'No') {
        return "Please provide tournament Id. To get the tournament ID go to the 'A3N Cricket Management' page of the dashboard.";
    }
    $standings = getPointTablesForPage($atts['tid'], $atts['group']);
//return var_dump($standings);
    $htmlCode .=""
            . " <table>"
            . "     <thead>"
            . "         <tr>"
            . "             <td width='5%'>Pos</td>"
            . "             <td width='25%'>Team</td>"
            . "             <td width='5%'>P</td>"
            . "             <td width='5%'>W</td>"
            . "             <td width='5%'>L</td>"
            . "             <td width='5%'>N/R</td>"
            . "             <td width='5%'>Point</td>"
            . "             <td width='15%'>NRR</td>"
            . "             <td width='15%'>For</td>"
            . "             <td width='15%'>Against</td>"
            . "         </tr>"
            . "     </thead>"
            . "     <tbody>";
    foreach ($standings as $row) {

        $htmlCode .= ""
                . "         <tr>"
                . "             <td>{$row->position}</td> "
                . "             <td>{$row->team_name}</td> "
                . "             <td>{$row->match_played}</td> "
                . "             <td>{$row->win}</td> "
                . "             <td>{$row->lost}</td> "
                . "             <td>{$row->tie_NR}</td> "
                . "             <td>{$row->point}</td> "
                . "             <td>{$row->nrr}</td> "
                . "             <td>{$row->runs_for}/{$row->overs_for}</td> "
                . "             <td>{$row->runs_against}/{$row->overs_against}</td> "
                . "         </tr>";
    }

    $htmlCode .= ""
            . "     </tbody>"
            . "</table>";
    $htmlCode .="<h6 class='subheader' style='float:right'><small>Plugins created by: <a href='http://armannadim.com/'>Arman Nadim</a></small></h6>";
    return $htmlCode;
}

/* [a3n_pointtable tId="1" group="A" ] */
add_shortcode('a3n_pointtable', 'Show_pointTable');

function getPointTablesForPage($tournamentId = "", $group = "", $season = "") {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    if ($season != null) {
        $getTournamentId = $wpdb->get_var("select id from " . $wpdb->prefix . "a3n_tournament where  season = '$season' Limit 1");
    }
    
    $query = "select pt.*, "
            . " (select team from " . $wpdb->prefix . "a3n_team where  id=pt.team) team_name, "
            . " (select tournament from " . $wpdb->prefix . "a3n_tournament where  id=pt.tournamentID) tournament "
            . " from " . $wpdb->prefix . "a3n_point_table pt ";

    if ($tournamentId != "" || $group != "" || $season != "") {
        $query .= " where ";
    }
    if ($tournamentId != "") {
        $query .= " pt.tournamentID='$tournamentId' ";
    }else{
         $query .= " pt.tournamentID='$getTournamentId' ";
    }

    if ($group != "") {
        $query .= " AND pt._group='$group' ";
    }

    $query .= " Order by pt.point DESC";

    $result = $wpdb->get_results($query);
    return $result;
}

/*
 * As attr this function will recieve few variables
 * $attr is an Array
 * tID --> Tournament Id[Obligatory]
 * Group ID [Obligatory]
 * Team ID [Optional - only for the specific club information]
 * Returns htmlCode [It will contain the data of fixture + match summary in a table]
 */

function Show_FixtureWithResults($atts) {
    //return var_dump($atts);
    $htmlCode = "";
    $atts = shortcode_atts(array(
        'tid' => "No",
        'group' => '0',
        'teamid' => '0'
            ), $atts, 'a3n_matches');
    if ($atts['tid'] === 'No') {
        return "Please provide tournament Id. To get the tournament ID go to the 'A3N Cricket Management' page of the dashboard.";
    }
    $fixture = getFixtureForPage($atts['tid'], $atts['group'], $atts['teamid']);
//return var_dump($fixture);
    $htmlCode .=""
            . " <table>"
            . "     <thead>"
            . "         <tr>"
            . "             <td width='5%'>No</td>"
            . "             <td width='6%'>Pool</td>"
            . "             <td width='10%'>Date & Time</td>"
            . "             <td width='24%'>Team A Score</td>"
            . "             <td width='24%'>Team B Score</td>"
            . "             <td width='20%'>Result</td>"
            . "             <td width='11%'>MOM</td>"
            . "             <td width='11%'>Venue</td>"
            . "         </tr>"
            . "     </thead>"
            . "     <tbody>";
    foreach ($fixture as $row) {
        if (isset($row->TeamA_score) && isset($row->TeamA_wicket) && isset($row->TeamA_over)) {
            $teamA = "{$row->TeamA_Name}: {$row->TeamA_score}/{$row->TeamA_wicket} after {$row->TeamA_over} overs";
        } else {
            $teamA = "{$row->TeamA_Name}: N/A";
        }
        if (isset($row->TeamB_score) && isset($row->TeamB_wicket) && isset($row->TeamB_over)) {
            $teamB = "{$row->TeamB_Name}: {$row->TeamB_score}/{$row->TeamB_wicket} after {$row->TeamB_over} overs";
        } else {
            $teamB = "{$row->TeamB_Name}: N/A";
        }
        if (isset($row->result)) {
            $result = $row->result;
        } else {
            $result = "N/A";
        }
        if (isset($row->mom)) {
            $mom = $row->mom;
        } else {
            $mom = "N/A";
        }
        if (isset($row->venue)) {
            $venue = $row->venue;
        } else {
            $venue = "N/A";
        }

        $htmlCode .= ""
                . "         <tr>"
                . "             <td>{$row->id}</td> "
                . "             <td>{$row->_group}</td> "
                . "             <td>{$row->matchdate}</td> "
                . "             <td>{$teamA}</td> "
                . "             <td>{$teamB}</td> "
                . "             <td>{$result}</td> "
                . "             <td>{$mom}</td> "
                . "             <td>{$venue}</td> "
                . "         </tr>";
    }

    $htmlCode .= ""
            . "     </tbody>"
            . "</table>";
    $htmlCode .="<h6 class='subheader' style='float:right'><small>Plugins created by: <a href='http://armannadim.com/'>Arman Nadim</a></small></h6>";
    return $htmlCode;
}

/* [a3n_matches tId="1" group="A" ] */
add_shortcode('a3n_matches', 'Show_FixtureWithResults');

function getFixtureForPage($tournamentId, $group = "", $teamId = "") {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $query = "select f.id, f.TeamA, f.TeamB, f._group, f.matchdate, f.venue, "
            . " (select team from " . $wpdb->prefix . "a3n_team where id = f.TeamA) TeamA_Name, "
            . " (select team from " . $wpdb->prefix . "a3n_team where id = f.TeamB) TeamB_Name, "
            . " (select tournament from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) tournament, "
            . " (select season from " . $wpdb->prefix . "a3n_tournament where id = f.tournamentId) season, "
            . " ms.TeamA_score, ms.TeamA_wicket, ms.TeamA_over, "
            . " ms.TeamB_score, ms.TeamB_wicket, ms.TeamB_over, "
            . " ms.result, ms.mom "
            . " from " . $wpdb->prefix . "a3n_fixture f, " . $wpdb->prefix . "a3n_match_summary ms "
            . " where f.id = ms.fixtureId AND f.tournamentId = '$tournamentId' ";
    if ($group != "0") {
        $query .= " AND f._group='$group' ";
    }
    if ($teamId != "0") {
        $query .= " AND ( f.TeamA = '$teamId' OR f.TeamB = '$teamId') ";
    }


    $result = $wpdb->get_results($query);
    return $result;
}

/* END SHORTCODES */

function a3n_styles() {

    // Register the style like this for a plugin:
    wp_register_style('styles', plugin_dir_url(__FILE__) . "css/foundation.css", array(), '20150225', 'all');
    wp_register_style('styles', plugin_dir_url(__FILE__) . "css/dataTables.foundation.css", array(), '20150225', 'all');

    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style('styles');
}

add_action('wp_enqueue_scripts', 'a3n_styles');

function a3n_scripts() {
    // Register the script like this for a plugin:
    wp_register_script('scripts', plugin_dir_url(__FILE__) . "js/vendor/jquery.js");
    wp_register_script('scripts', plugin_dir_url(__FILE__) . "js/vendor/jquery-ui.js");
    wp_register_script('scripts', plugin_dir_url(__FILE__) . "js/vendor/jquery.dataTables.min.js");
    wp_register_script('scripts', plugin_dir_url(__FILE__) . "js/foundation/foundation.min.js");
    wp_register_script('scripts', plugin_dir_url(__FILE__) . "js/vendor/dataTables.foundation.js");


    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script('scripts');
}

add_action('wp_enqueue_scripts', 'a3n_scripts', 5);

/* END LOAD SCRIPTS AND STYLES */

/* UPDATE SCRITPS */
/*
 * Parameteres
 * $table = Name of the table
 * $column = name of the input using in the specific form
 * Returns html code to generate dropdown box
 * 
 */

function createSelect($table, $column, $selected = null) {
    $html = "<select id='$table' name='$column'>";
    $data = null;
    if ($table == "Team") {
        $data = getTeamsDT();
    } else if ($table == "Tournament") {
        $data = getTournament();
    }

    $html .="<option value=''>Select $table</option>";
    foreach ($data as $row) {
        if ($table == "Team") {
            if ($row->id === $selected) {
                $html .= "<option id='$row->id' value='$row->id' selected>$row->team</option>";
            } else {
                $html .= "<option id='$row->id' value='$row->id'>$row->team</option>";
            }
        } else if ($table == "Tournament") {
            if ($row->id === $selected) {
                $html .= "<option id='$row->id' value='$row->id' selected>$row->tournament-$row->season</option>";
            } else {
                $html .= "<option id='$row->id' value='$row->id'>$row->tournament-$row->season</option>";
            }
        }
    }

    $html .="</select>";
    return $html;
}

function insertFixture($data) {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $wpdb->insert($wpdb->prefix . "a3n_fixture", array(
        'tournamentId' => $data['tournamentId'],
        'TeamA' => $data['TeamA'],
        'TeamB' => $data['TeamB'],
        'matchdate' => $data['matchdate']
    ));
    return "Done";
}

/* VERSION 1.1.0 */
/* THIS FUNCTION RETURNS ALL FIELDS OF THE TABLE */

function get_fields($table = null, $column = null) {
    global $wpdb;

    if (!empty($table)) {
        $fullname = $table;

        if (($tablefields = $wpdb->get_results('SHOW COLUMNS FROM ' . $wpdb->prefix . $table, OBJECT)) !== false) {
            $columns = count($tablefields);
            $field_array = array();
            for ($i = 0; $i < $columns; $i++) {
                /* $fieldname = $tablefields[$i]->Field;
                  $field_array[] = $fieldname; */
                if ($tablefields[$i]->Field === $column) {
                    return true;
                }
            }

            //return $field_array;
        }
    }
    return false;
}

?>