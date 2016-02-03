<?php
/*
 * This is a tab view page. Title of the Tab is "How to use".
 * It's an informative page only in HTMl. This page will show the instruction of how to use this plugin.
 * Author: Aseq A Arman Nadim
 * Date: 27 Fenruary 2015
 */
?>
<div id="team" class="content active">
    <div class="row">
        <h3 class="subheader">Instruction to use this plugin:</h3>
        <div class="panel callout radius">
            <ol>
                <li>After instalation add team and tournament data in the tab "Configuration". </li>
                <li>Add fixture by navigating to the "Fixture" tab. You can add matches one by one or also you can upload excel file with the all matches. You can download the excel file template from this link.
                    You can edit some fixture data by clicking on the cell.</li>
                <li>After adding fixture go to the next tab which is "Result" tab. Here you can update results of all the matches. You can add results by clicking on the cell.</li>
                <li>Adding fixture and other data in a frontend page using short codes. Short codes are bellow:
                    <ul>
                        <li><span class="info round label">i) [a3n_pointtable tId="<>" group="<>" ]</span>
                            &DoubleRightArrow;&nbsp;This short code will add standings of the specific tournament and/or group(if available).<br>                            
                        </li>
                        <li><span class="info round label">ii) [a3n_matches tId="<>" group="<>" ]</span>
                            &DoubleRightArrow;&nbsp;This shortcode is to show the fixture in the specific menu page.
                            Parameters are same as the previous one.
                        </li>
                        <li>
                            <blockquote>First parameter "tId" is tournament id, it receives numeric value. You'll get the tournament id on the "Configuration" tab under Tournaments option.
                                Second parameter is optional. If you've groupings in the tournament then you should write the group name in it. This group must be same as stated in the fixture.</blockquote>
                        </li>
                    </ul>              
                </li>            
            </ol>
        </div>            
        <blockquote>Fill free to contact with me for any kind of query, suggestion, request on the following email address.
            <span class="email"><a href="mailto:armannadim@msn.com">armannadim@msn.com</a></span><br>
            I'm working on it to improve and add more functionality to this plugin. If you think that I should add some functionality that I haven't added yet just drop me message.<br>
            And above everything, Thanks a lot for using my plugin.        
        </blockquote>
    </div>
</div>