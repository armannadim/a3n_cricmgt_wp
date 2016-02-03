<?php
/*
 * This is a tab view page. Title of the Tab is "Configuration". This page contains 2 forms and 2 datatables.
 * Forms on this page are used to add team and tournament and datatables shows the team and tournament data.
 * Author: Aseq A Arman Nadim
 * Date: 27 February 2015
 */
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#team_table').dataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "aoColumns": [
                {
                    sName: "id"
                }
                ,
                {
                    sName: "Team"
                },
                {
                    sName: "Action"
                }]
        }).makeEditable({
            "oEditableSettings": {event: 'click', onblur: 'submit'},
            "sUpdateURL": "<?php echo plugin_dir_url(__FILE__) ?>../db/updateConfig.php",
            "aoColumns"
                    : [
                        null,
                        {
                            tooltip: 'Click to select Tournament',
                            loadtext: 'loading...',
                            type: 'text'
                        },
                        null
                    ]
        });


        $('#tournament_table').dataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "aoColumns": [
                {
                    sName: "id"
                }
                ,
                {
                    sName: "tournament"
                },
                {
                    sName: "season"
                },
                {
                    sName: "format"
                },
                {
                    sName: "Action"
                }]
        }).makeEditable({
            "oEditableSettings": {event: 'click', onblur: 'submit'},
            "sUpdateURL": "<?php echo plugin_dir_url(__FILE__) ?>../db/updateConfig.php",
            "aoColumns"
                    : [
                        null,
                        {},
                        {},
                        {},
                        null
                    ]
        });


        $('#addTournament').click(function(e) {
            var frm = $('#addTournamentForm');
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
        $('#addTeam').click(function(e) {
            var frm = $('#addTeamForm');
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
    });
    function deleteData(id, table) {
        $.ajax({
            type: 'POST',
            url: "<?php echo plugin_dir_url(__FILE__) ?>../db/updateConfig.php",
            data: 'id=' + id + '&action=delete&table='+table,
            success: function(data) {
                window.location.reload();
            }
        });
    }    
</script>
<ul id="accordion_config" class="accordion" data-accordion>
    <li class="accordion-navigation">
        <a href="#team_accordion">Team Config</a>
        <div id="team_accordion" class="content active">
            <div class="row">
                <div class="large-6 columns">
                    <form id="addTeamForm" name="team_form" method="post" action="<?php echo plugin_dir_url(__FILE__) ?>../db/insertTT.php">    
                        <input type="hidden" name="addTeam" value="Team"/>
                        <?php echo "<h4>" . __('Add new team', 'oscimp_trdom') . "</h4>"; ?>
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix"><?php _e("Team Name"); ?></span>
                            </div>
                            <div class="small-9 columns">                            
                                <input type="text" name="a3n_team" value="<?php echo $team; ?>" placeholder="<?php _e(" ex: ABC Cricket Club"); ?>" size="20">
                            </div>                       
                        </div>
                        <hr />
                        <button id="addTeam" class="saveNew" role="button" tabindex="0" aria-label="Save"><?php _e('Add team'); ?></button>

                    </form>
                </div>
                <div class="large-6 columns">
                    <?php echo "<h4>" . __('Team list', 'oscimp_trdom') . "</h4>"; ?>

                    <table id="team_table" class="large-12 small-12 medium-12" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Team</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $t = getTeamsDT();
                        foreach ($t as $row) {
                            ?>
                            <tr id="<?php echo $row->id; ?>team">
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->team; ?></td>                            
                                <td>
                                    <a  onclick="javascript:deleteData(<?php echo $row->id; ?>, 'team')" class="item" role="button" tabindex="0" aria-label="home">
                                        <i class="fi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

        </div>
    </li>
    <li class="accordion-navigation">
        <a href="#tournament">Tournament Config</a>
        <div id="tournament" class="content active">
            <div class="row">
                <div class="large-6 columns">
                    <form id="addTournamentForm" name="tournament_form" method="post" action="<?php echo plugin_dir_url(__FILE__) ?>../db/insertTT.php">                        
                        <input type="hidden" name="addTournament" value="Tournament"/>
                        <?php echo "<h4>" . __('Add Tournament', 'oscimp_trdom') . "</h4>"; ?>
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix"><?php _e("Tournament Name"); ?></span>
                            </div>
                            <div class="small-9 columns">                            
                                <input type="text" name="a3n_tournament" value="<?php echo $team; ?>" placeholder="<?php _e("ex: World Cup Cricket"); ?>" size="20">
                            </div>                       
                        </div>
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix"><?php _e("Season"); ?></span>
                            </div>
                            <div class="small-9 columns">                            
                                <input type="text" name="a3n_season" value="<?php echo $team; ?>" placeholder="<?php _e("ex: 2014, 2015"); ?>" size="20">
                            </div>                       
                        </div>
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix"><?php _e("Format"); ?></span>
                            </div>
                            <div class="small-9 columns">                            
                                <input type="text" name="a3n_format" value="<?php echo $team; ?>" placeholder="<?php _e("ex: T20, 50 Overs, Test"); ?>" size="20">
                            </div>                       
                        </div>                        

                        <hr />
                        <p class="submit">
                            <button id="addTournament" class="saveNew" role="button" tabindex="0" aria-label="Save"><?php _e('Add Tournament'); ?></button>                            
                        </p>
                    </form>
                </div>
                <div class="large-6 columns">
                    <?php echo "<h4>" . __('Tournament List', 'oscimp_trdom') . "</h4>"; ?>
                    <table id="tournament_table" class="tournament_table" summary="Tournament Table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tournament</th>
                                <th>Season</th>
                                <th>Format</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $tr = getTournament();
                        foreach ($tr as $row) {
                            ?>
                            <tr id="<?php echo $row->id; ?>tournament">
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->tournament; ?></td>                            
                                <td><?php echo $row->season; ?></td>         
                                <td><?php echo $row->format; ?></td>         
                                <td>
                                    <a onclick="javascript:deleteData(<?php echo $row->id; ?>, 'tournament')" class="item" role="button" tabindex="0" aria-label="home">
                                        <i class="fi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </li> 
</ul>


