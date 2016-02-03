<?php
defined('ABSPATH') or die('No script kiddies please!');
?>
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) ?>css/foundation.css" />
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) ?>css/dataTables.foundation.css" />
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) ?>css/default.css" />
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) ?>css/jquery.datetimepicker.css" />
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) ?>css/foundation-icons/foundation-icons.css" />
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/jquery.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/jquery-ui.js"></script>


<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/jquery.dataTables.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/jquery.dataTables.editable.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/jquery.jeditable.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/jquery.datetimepicker.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/fastclick.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/foundation/foundation.min.js"></script>    
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/dataTables.foundation.js"></script>    
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/vendor/dataTables.TableTools.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>js/fnReloadAjax.js"></script>    
<script type="text/javascript">
    $(document).ready(function() {
        $('#upgrade').click(function(e) {                    
            $.ajax({
                type: 'POST',
                url: "<?php echo plugin_dir_url(__FILE__) ?>db/upgrading.php",
                data: "action=alter&column=venue",
                success: function(data) {
                    alert(data);
                    window.location.reload();
                }
            });
        });
    });</script>

<div class="panel">
    <h2 class="subheader">A3N Cricket Management</h2>
    Thanks for choosing this plugin as your create club/league manager. 
    Manage your federation/association/league/club's fixture with results and point table easily by using this plugin.       


</div>
<?php if (get_fields('a3n_fixture', 'venue')) { ?>
    <div class=" panel">

        <ul class="tabs" data-tab role="tablist" data-options="deep_linking: true">
            <li class="tab-title active" role="presentational" ><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">How to use</a></li>
            <li class="tab-title" role="presentational" ><a href="#panel2-2" role="tab" tabindex="1"aria-selected="false" controls="panel2-2">Configuration</a></li>
            <li class="tab-title" role="presentational"><a href="#panel2-3" role="tab" tabindex="2" aria-selected="false" controls="panel2-3">Fixture</a></li>
            <li class="tab-title" role="presentational" ><a href="#panel2-4" role="tab" tabindex="3" aria-selected="false" controls="panel2-4">Results</a></li>
            <li class="tab-title" role="presentational" ><a href="#panel2-5" role="tab" tabindex="4" aria-selected="false" controls="panel2-5">Standings</a></li>
            <li class="tab-title" role="presentational" ><a href="#panel2-6" role="tab" tabindex="5" aria-selected="false" controls="panel2-6">Version Log</a></li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
                <?php include 'admin/use.php'; ?>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
                <?php include 'admin/configuration.php'; ?>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-3">
                <?php include 'admin/fixture.php'; ?>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-4">
                <?php include 'admin/results.php'; ?>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-5">
                <?php include 'admin/standings.php'; ?>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-6">
                <?php include 'admin/version_log.php'; ?>
            </section>
        </div>

    </div>
<?php } else { ?>
    <div>You need to upgrade database to work with this version of the plugin.</div>
    <button id="upgrade" class="saveNew" role="button" tabindex="0" aria-label="Save"><i class="fi-upload"></i> Update database</button>
<?php } ?>
<script>
    $(document).foundation();
</script>