<?php
/*
 * This is a tab view page. Title of the Tab is "Configuration". This page contains 2 forms and 2 datatables.
 * Forms on this page are used to add team and tournament and datatables shows the team and tournament data.
 * Author: Aseq A Arman Nadim
 * Date: 27 February 2015
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
        $.editable.addInputType('datetimepicker', {
            /* create input element */
            element: function(settings, original) {
                var form = $(this),
                        input = $('<input />');
                input.attr('autocomplete', 'off');
                input.attr('class', 'datetimepicker');
                form.append(input);
                return input;
            },
            /* attach jquery.ui.datetimepicker to the input element */
            plugin: function(settings, original) {
                var form = this,
                        input = form.find("input");
                // Don't cancel inline editing onblur to allow clicking datetimepicker
                //settings.onblur = 'nothing';
                datetimepicker = {
                    onSelect: function() {
                        // clicking specific day in the calendar should
                        // submit the form and close the input field
                        form.submit();
                    },
                    onClose: function() {
                        setTimeout(function() {
                            if (!input.is(':focus')) {
                                // input has NO focus after 150ms which means
                                // calendar was closed due to click outside of it
                                // so let's close the input field without saving
                                original.reset(form);
                            } else {
                                // input still HAS focus after 150ms which means
                                // calendar was closed due to Enter in the input field
                                // so lets submit the form and close the input field
                                form.submit();
                            }

                            // the delay is necessary; calendar must be already
                            // closed for the above :focus checking to work properly;
                            // without a delay the form is submitted in all scenarios, which is wrong
                        }, 150);
                    }
                };
                if (settings.datetimepicker) {
                    jQuery.extend(datetimepicker, settings.datetimepicker);
                }

                input.datetimepicker(datetimepicker);
            }
        });
        $('#wp_fixture tfoot th').each(function(i)
        {

            var title = $('#wp_fixture thead th').eq($(this).index()).text();
            // or just var title = $('#sample_3 thead th').text();
            var serach = '<input type="text" placeholder="Search ' + title + '" />';
            $(this).html('');
            $(serach).appendTo(this).keyup(function() {
                table_fixture.fnFilter($(this).val(), i)
            })
        });
        var table_fixture = $('#wp_fixture').dataTable({
            "iDisplayLength": 50,
            sPaginationType: "full_numbers",
            "aoColumns": [
                {
                    sName: "id"
                },
                {
                    sName: "Tournament"
                },
                {
                    sName: "season"
                },
                {
                    sName: "_group"
                },
                {
                    sName: "matchdate",
                    sClass: "datetimepicker"
                },
                {
                    sName: "TeamA"
                },
                {
                    sName: "TeamB"
                },
                {
                    sName: "venue"
                },
                {
                    sName: "Action"
                }
            ]
        })
                .makeEditable({
                    //"sAddURL": "<?php echo plugin_dir_url(__FILE__) ?>config_plugin.php",
                    //"sDeleteURL": "DeleteData.php",
                    //"sAddDeleteToolbarSelector": ".dataTables_length",

                    "oEditableSettings"
                            : {event: 'click', onblur: 'submit'},
                    "sUpdateURL": "<?php echo plugin_dir_url(__FILE__) ?>../db/updateFixture.php",
                    "aoColumns"
                            : [
                                null,
                                {
                                    tooltip: 'Click to select Tournament',
                                    loadtext: 'loading...',
                                    type: 'select',
                                    data: '<?php echo $tournaments; ?>'
                                },
                                null, {},
                                {
                                    tooltip: 'Click to change date and time',
                                    loadtext: 'loading...',
                                    type: "datetimepicker",
                                    datetimepicker: {
                                        format: 'Y-m-d H:i:00',
                                        changeMonth: true,
                                        changeYear: true,
                                        showHour: true,
                                        showMinute: true,
                                        step: 30
                                    }
                                },
                                {
                                    tooltip: 'Click to select Team A',
                                    loadtext: 'loading...',
                                    type: 'select',
                                    data: '<?php echo $teams; ?>'
                                },
                                {
                                    tooltip: 'Click to select Team B',
                                    loadtext: 'loading...',
                                    type: 'select',
                                    data: '<?php echo $teams; ?>',
                                }, {}, null
                            ]
                });

        $('#saveFixture').click(function(e) {
            var frm = $('#addMatch');
            frm.submit(function(ev) {
                ev.preventDefault();
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    success: function(data) {
                        window.location.reload();
                    }
                });
            });
        });
        jQuery('#newFixtureDTP').datetimepicker({
            format: 'Y-m-d H:i:00',
            changeMonth: true,
            changeYear: true,
            showHour: true,
            showMinute: true,
            step: 30
        });
        $(':file').change(function() {
            var file = this.files[0];
            var name = file.name;
            var size = file.size;
            var type = file.type;
            //Your validation
        });
        $('#uploadFile').click(function(e) {
            var frm = $('#uploadFixture');

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
            <form id="uploadFixture" enctype="multipart/form-data" method="post" role="form" action="<?php echo plugin_dir_url(__FILE__) ?>../db/insertFixture.php">
                <input type="hidden" name="addFixture" value="File"/>
                <div class="large-6 columns">
                    <label for="filePT">File Upload&nbsp;&nbsp;&nbsp;<span class="success round label">Only Excel/CSV File Import.</span></label>
                    <input type="file" name="file" id="file" size="150">                    
                </div>  
                <div class="large-6 columns">
                    <button id="uploadFile" class="saveNew" role="button" tabindex="0" aria-label="Save"><i class="fi-upload"></i> Upload</button>
                </div>                      
            </form>    
        </div>
    </div>
    <div class="row" id="fixtureTable">        
        <?php //echo "<h4>" . __('Add results', 'oscimp_trdom') . "</h4>";      ?>
        <table id="wp_fixture" class="large-12 small-12 medium-12" >
            <thead>     
                <tr>
                    <th width="2%">No</th>
                    <th width="15%">Tournament</th>
                    <th width="4%">Season</th>
                    <th width="4%">Pool</th>
                    <th width="20%">Date</th>
                    <th width="25%">Team A</th>
                    <th width="25%">Team B</th>                                 
                    <th width="25%">Venue</th>                                 
                    <th width="5%">Action</th>   
                </tr>
            </thead>
            <tfoot>     
                <tr>
                    <th>No</th>
                    <th>Tournament</th>
                    <th>Season</th>
                    <th>Pool</th>
                    <th>Date</th>
                    <th>Team A</th>
                    <th>Team B</th>                                 
                    <th>Venue</th>  
                    <th>Action</th>   
                </tr>
            </tfoot>
            <?php
            $f = getFixture();
            foreach ($f as $row) {
                ?>
                <tr id="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->Tournament; ?></td>
                    <td><?php echo $row->Season; ?></td>
                    <td><?php echo $row->_group; ?></td>
                    <td><?php echo $row->matchdate; ?></td>
                    <td><?php echo $row->TeamA; ?></td>
                    <td><?php echo $row->TeamB; ?></td>
                    <td><?php echo $row->venue; ?></td>
                    <td class="buttonRow" style="text-align: center;"><a class="item" role="button" tabindex="0" aria-label="home">
                            <i class="fi-trash"></i>
                        </a></td>
                </tr>
            <?php } ?>            
        </table>
        <a href="#" data-reveal-id="newFixture">Add New match</a>
    </div>
</div>

<div id="newFixture" class="reveal-modal small" data-reveal>
    <h2>Add new match.</h2>  
    <div class="row">
        <div class="large-8 small-8 medium-8">
            <form id="addMatch" action="<?php echo plugin_dir_url(__FILE__) ?>../db/insertFixture.php" method="POST">
                <input type="hidden" name="addFixture" value="Form"/>
                <span class="label">Tournaments: </span><?php echo createSelect("Tournament", "tournamentId"); ?>    
                <span class="label">Groups/Pool</span><input name="_group" type="text" value="" placeholder="Group or Pool Name">
                <span class="label">Match date & Time: </span><input id="newFixtureDTP" type="text" name="matchdate" placeholder="Select date & time" >
                <span class="label">Team A: </span><?php echo createSelect("Team", 'TeamA'); ?>
                <span class="label">Team B:</span> <?php echo createSelect("Team", 'TeamB'); ?>
                <span class="label">Venue:</span> <input name="venue" type="text" value="" placeholder="Venue Name">
                <button id="saveFixture" class="saveNew" role="button" tabindex="0" aria-label="Save"><i class="fi-save"></i> Save</button>
            </form>
        </div>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
