<?php

/*
 * Database activities added on this page. This script will update standing table on database.
 * This script called when the user tries to upload excel file on the tab "Standings".
 * Author: Aseq A Arman Nadim
 * Date: 02 March 2015
 */

require_once('../../../../wp-load.php');
defined('ABSPATH') or die('No script kiddies please!');
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
global $wpdb;

$return = array();

if (isset($_POST['addPT']) && $_POST['addPT'] == "File" && isset($_FILES["filePT"])) {

    $uploadedStatus = 0;

//if there was an error uploading the file
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["filePT"]["error"] . "<br />";
    } else {

        if (!function_exists('wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        if (file_exists($_FILES["file"]["name"])) {
            unlink($_FILES["file"]["name"]);
        }
        $storagename = "standings.xlsx";

        $uploadedfile = $_FILES['filePT'];
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
                $tournamentId = trim($allDataInSheet[$i]["A"]);
                $position = trim($allDataInSheet[$i]["B"]);
                $_group = trim($allDataInSheet[$i]["C"]);
                $team = trim($allDataInSheet[$i]["D"]);
                $match_played = trim($allDataInSheet[$i]["E"]);
                $win = trim($allDataInSheet[$i]["F"]);
                $lost = trim($allDataInSheet[$i]["G"]);
                $tie_NR = trim($allDataInSheet[$i]["H"]);
                $nrr = trim($allDataInSheet[$i]["I"]);
                $runs_for = trim($allDataInSheet[$i]["J"]);
                $overs_for = trim($allDataInSheet[$i]["K"]);
                $runs_against = trim($allDataInSheet[$i]["L"]);
                $overs_against = trim($allDataInSheet[$i]["M"]);
                $points = trim($allDataInSheet[$i]["N"]);

                $wpdb->insert($wpdb->prefix . "a3n_point_table", array(
                    'tournamentId' => $tournamentId,
                    'position' => $position,
                    '_group' => $_group,
                    'team' => $team,
                    'match_played' => $match_played,
                    'win' => $win,
                    'lost' => $lost,
                    'tie_NR' => $tie_NR,
                    'nrr' => $nrr,
                    'runs_for' => $runs_for,
                    'overs_for' => $overs_for,
                    'runs_against' => $runs_against,
                    'overs_against' => $overs_against,
                    'point' => $points
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
