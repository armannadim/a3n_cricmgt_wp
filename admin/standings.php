<?php
/*
 * This is a tab view page. Title of the Tab is "Standings".
 * On this tab view admin can upload point tables to the database table or update standings of a tournament.
 * Author: Aseq A Arman Nadim
 * Date: 02 March 2015
 */

$teams = getTeamsJSON();
$tournaments = getTournamentsJSON();
?>

<?php
if (isset($_POST["Import"])) {
    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        bulkLoadFixture($file);
        echo 'File has been successfully Imported';
    } else
        echo 'Invalid File:Please Upload CSV File';
}
?>

<script>
    $(document).ready(function() {

        $('#wp_pointtable tfoot th').each(function(i)
        {
            var title = $('#wp_pointtable thead th').eq($(this).index()).text();
            // or just var title = $('#sample_3 thead th').text();
            var serach = '<input type="text" placeholder="Search ' + title + '" />';
            $(this).html('');
            $(serach).appendTo(this).keyup(function() {
                table_point.fnFilter($(this).val(), i)
            })
        });

        var table_point = $('#wp_pointtable').dataTable({
            sPaginationType: "full_numbers",
            "aoColumns": [
                {
                    sName: "Tournament"
                },
                {
                    sName: "group"
                },
                {
                    sName: "Pos"
                },
                {
                    sName: "Team"
                },
                {
                    sName: "P"
                },
                {
                    sName: "W"
                },
                {
                    sName: "L"
                },
                {
                    sName: "T/NR"
                },
                {
                    sName: "Points"
                },
                {
                    sName: "NRR"
                },
                {
                    sName: "ForR"
                },
                {
                    sName: "ForO"
                },
                {
                    sName: "AgainstR"
                },
                {
                    sName: "AgainstO"
                }
            ]
        })
                .makeEditable({
                    "oEditableSettings": {event: 'click', onblur: 'submit'},
                    "sUpdateURL": "<?php echo plugin_dir_url(__FILE__) ?>../db/updateStandings.php",
                    "aoColumns": [null, null, {}, null, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}]
                });

        $(':file').change(function() {
            var file = this.files[0];
            var name = file.name;
            var size = file.size;
            var type = file.type;
            //Your validation
        });
        $('#uploadPTFile').click(function(e) {
            var frm = $('#uploadPT');

            frm.submit(function(ev) {
                ev.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: formData,
                    enctype: 'multipart/form-data',
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert(data);
                        window.location.reload();
                    }
                });
            });
        });

    });
</script>
<div id="team" class="content active">
    <div class="panel">
        <div class="row">
            <form id="uploadPT" enctype="multipart/form-data" method="post" role="form" action="<?php echo plugin_dir_url(__FILE__) ?>../db/insertStandings.php">
                <input type="hidden" name="addPT" value="File"/>
                <div class="large-6 columns">
                    <label for="file">File Upload&nbsp;&nbsp;&nbsp;<span class="success round label">Only Excel/CSV File Import.</span></label>
                    <input type="file" name="filePT" id="filePT" size="100">

                </div>  
                <div class="large-6 columns">
                    <button id="uploadPTFile" class="saveNew" role="button" tabindex="0" aria-label="Save"><i class="fi-upload"></i> Upload</button>

                </div>                      
            </form>      
        </div>
    </div>
    <?php //Added in - Version 1.1.1 ?>    
    <div class="panel">
        <div class="row">
            <form id="selectTournament" method="post" role="form" action="">                
                <div class="large-6 columns">
                    <label for="tournament">Select tournament</label>
                    <?php
                    $selected = isset($_POST['tId']) ? $_POST['tId'] : null;
                    $t = createSelect('Tournament', 'tId', $selected);
                    echo $t;
                    ?>
                </div>  
                <div class="large-6 columns">
                    <button id="uploadPTFile" class="saveNew" role="button" tabindex="0" aria-label="Save"><i class="fi-upload"></i> Submit</button>
                </div>                      
            </form>      
        </div>
    </div>
    <div class="row">        
        <?php //echo "<h4>" . __('Add results', 'oscimp_trdom') . "</h4>";       ?>
        <table id="wp_pointtable" class="large-12 small-12 medium-12" >
            <thead>    
                <tr>
                    <th rowspan="2" width="10%">Tournament</th>
                    <th rowspan="2" width="10%">Pool</th>
                    <th rowspan="2" width="4%">Pos</th>
                    <th rowspan="2" width="16%">Team</th>
                    <th rowspan="2" width="4%">P</th>
                    <th rowspan="2" width="4%">W</th>
                    <th rowspan="2" width="4%">L</th>
                    <th rowspan="2" width="6%">T/NR</th>
                    <th rowspan="2" width="6%">Points</th>
                    <th rowspan="2" width="6%">NRR</th>                                 
                    <th colspan="2" >For</th>
                    <th colspan="2" >Against</th>
                </tr>
                <tr>                                                    
                    <th width="10%">For Runs</th>
                    <th width="10%">For Overs</th>
                    <th width="10%">Against Runs</th> 
                    <th width="10%">Against Overs</th> 
                </tr>
            </thead>
            <tfoot>     
                <tr>
                    <th>Tournament</th>
                    <th>Pool</th>
                    <th>Pos</th>
                    <th>Team</th>
                    <th>P</th>
                    <th>W</th>
                    <th>L</th>
                    <th>T/NR</th>
                    <th>Points</th>
                    <th>NRR</th>
                    <th>For Runs</th>
                    <th>For Overs</th>
                    <th>Against Runs</th> 
                    <th>Against Overs</th> 
                </tr>
            </tfoot>
            <?php
            //Modified in - Version 1.1.1
            if (isset($_POST['tId'])) {
                $pt = getPointTablesForPage($_POST['tId']);
            } else {
                $pt = getPointTablesForPage(null,null,date("Y"));
            }

            foreach ($pt as $row) {
                ?>
                <tr id="<?php echo $row->id; ?>">
                    <td><?php echo $row->tournament; ?></td>
                    <td><?php echo $row->_group; ?></td>
                    <td><?php echo $row->position; ?></td>
                    <td><?php echo $row->team_name; ?></td>
                    <td><?php echo $row->match_played; ?></td>
                    <td><?php echo $row->win; ?></td>
                    <td><?php echo $row->lost; ?></td>
                    <td><?php echo $row->tie_NR; ?></td>
                    <td><?php echo $row->point; ?></td>
                    <td><?php echo $row->nrr; ?></td>
                    <td><?php echo $row->runs_for; ?></td> 
                    <td><?php echo $row->overs_for; ?></td>
                    <td><?php echo $row->runs_against; ?></td>
                    <td><?php echo $row->overs_against; ?></td>
                </tr>
            <?php } ?>            
        </table>

    </div>
</div>


