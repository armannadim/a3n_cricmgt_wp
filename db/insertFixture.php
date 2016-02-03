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
if (isset($_POST['addFixture']) && $_POST['addFixture'] == 'Form') {
    $tournamentId = $_POST['tournamentId'];
    $group = $_POST['_group'];
    $matchdate = $_POST['matchdate'];
    $TeamA = $_POST['TeamA'];
    $TeamB = $_POST['TeamB'];
    $venue = $_POST['venue'];

    $wpdb->insert($wpdb->prefix . "a3n_fixture", array(
        'tournamentId' => $tournamentId,
        'TeamA' => $TeamA,
        'TeamB' => $TeamB,
        'matchdate' => $matchdate,
        '_group' => $group,
        'venue' => $venue
    ));

    $query = "select max(id) id "
            . " from " . $wpdb->prefix . "a3n_fixture  ";


    $results = $wpdb->get_results($query);
    $fixtureId = null;
    foreach ($results as $result) {
        $fixtureId = $result->id;
    }

    $wpdb->insert($wpdb->prefix . "a3n_match_summary", array(
        'fixtureId' => $fixtureId
    ));

    echo $value;
}

/* Add fixture from Files */
$return = array();
if (isset($_POST['addFixture']) && $_POST['addFixture'] == "File" && isset($_FILES["file"])) {

    $uploadedStatus = 0;

//if there was an error uploading the file
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {

        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        if (file_exists($_FILES["file"]["name"])) {
            unlink($_FILES["file"]["name"]);
        }
        $storagename = "fixtureFile.xlsx";

        $uploadedfile = $_FILES['file'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile) {
            //var_dump($movefile);
            set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/');
            include 'PHPExcel/IOFactory.php';

            // This is the file path to be uploaded.
            $inputFileName = $movefile['file'];

            try {
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
            //var_dump($allDataInSheet);
            for ($i = 2; $i <= $arrayCount; $i++) {
                $TeamA = trim($allDataInSheet[$i]["B"]);
                $TeamB = trim($allDataInSheet[$i]["D"]);
                $_group = trim($allDataInSheet[$i]["E"]);
                $matchdate = trim($allDataInSheet[$i]["F"]);
                $tournamentId = trim($allDataInSheet[$i]["H"]);
                $venue = trim($allDataInSheet[$i]["I"]);
                $wpdb->insert($wpdb->prefix . "a3n_fixture", array(
                    'TeamA' => $TeamA,
                    'TeamB' => $TeamB,
                    '_group' => $_group,
                    'matchdate' => $matchdate,
                    'tournamentId' => $tournamentId,
                    'venue' => $venue
                ));
            }

            $query = "SELECT id FROM " . $wpdb->prefix . "a3n_fixture WHERE id NOT IN (SELECT fixtureId FROM " . $wpdb->prefix . "a3n_match_summary)";
            $results = $wpdb->get_results($query);
            foreach ($results as $result) {
                $wpdb->insert($wpdb->prefix . "a3n_match_summary", array(
                    'fixtureId' => $result->id
                ));
            }
            array_push($return, "success", "File uploaded successfully");
            echo json_encode($return);
        } else {
            array_push($return, "error", "File Error.");
            echo json_encode($return);
        }
        $uploadedStatus = 1;
    }
} else {
    array_push($return, "error", "Cannot upload file. Please check the file and try again.");
    echo json_encode($return);
}
?>