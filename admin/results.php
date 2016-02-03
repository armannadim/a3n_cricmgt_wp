<?php
/*
 * This is a tab view page. Title of the Tab is "Configuration". This page contains 2 forms and 2 datatables.
 * Forms on this page are used to add team and tournament and datatables shows the team and tournament data.
 * Author: Aseq A Arman Nadim
 * Date: 27 February 2015
 */
?>
<script>
    $(document).ready(function() {
        $('#wp_match_summary').dataTable({
            sPaginationType: "full_numbers",
            aoColumns: [
                {
                    sName: "id"
                },
                {
                    sName: "Tournament"
                },
                {
                    sName: "_group"
                },
                {
                    sName: "matchdate"
                },
                {
                    sName: "TeamA"
                },
                {
                    sName: "TeamA_score"
                },
                {
                    sName: "TeamA_wicket"
                },
                {
                    sName: "TeamA_over"
                },
                {
                    sName: "TeamB"
                },
                {
                    sName: "TeamB_score"
                },
                {
                    sName: "TeamB_wicket"
                },
                {
                    sName: "TeamB_over"
                },
                {
                    sName: "result"
                },
                {
                    sName: "mom"
                }
            ]
        }).makeEditable({
            "sUpdateURL": "<?php echo plugin_dir_url(__FILE__) ?>../db/updateResults.php",
            "oEditableSettings": {event: 'click', onblur: 'submit'},
            "aoColumns": [null, null, null, null, null, {}, {}, {}, null, {}, {}, {}, {}, {}, null]
        });
    });
</script>
<div id="team" class="content active">
    <div class="row">        

        <?php echo "<h4>" . __('Add results', 'oscimp_trdom') . "</h4>"; ?>
        <table id="wp_match_summary" class="large-12 small-12 medium-12" >
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tournament</th>
                    <th rowspan="2">Group</th>
                    <th rowspan="2">Date</th>
                    <th colspan="4">Team A</th>
                    <th colspan="4">Team B</th>
                    <th rowspan="2">Winner</th>
                    <th rowspan="2">Man of the Match</th>

                </tr>
                <tr>
                    <th>Name</th>
                    <th>Runs</th>
                    <th>Wicket</th>
                    <th>Overs</th>
                    <th>Name</th>
                    <th>Runs</th>
                    <th>Wicket</th>
                    <th>Overs</th>
                </tr>                
            </thead>
            <?php
            $ms = getMatchSummary();
            foreach ($ms as $row) {
                ?>
                <tr id="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->Tournament; ?></td>
                    <td><?php echo $row->_group; ?></td>
                    <td><?php echo $row->matchdate; ?></td>
                    <td><?php echo $row->TeamA; ?></td>
                    <td><?php echo $row->TeamA_score; ?></td>
                    <td><?php echo $row->TeamA_wicket; ?></td>
                    <td><?php echo $row->TeamA_over; ?></td>
                    <td><?php echo $row->TeamB; ?></td>
                    <td><?php echo $row->TeamB_score; ?></td>
                    <td><?php echo $row->TeamB_wicket; ?></td>
                    <td><?php echo $row->TeamB_over; ?></td>
                    <td><?php echo $row->result; ?></td>
                    <td><?php echo $row->mom; ?></td>                                    

                </tr>
            <?php } ?>            
        </table>
    </div>
</div>