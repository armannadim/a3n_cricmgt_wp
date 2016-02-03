=== Plugin Name ===
Contributors: armannadim
Donate link: http://wpplugins.armannadim.com/
Tags: cricket,pointtable, standings, standing, cricket management, cricket league, cricket result, match summary,a3n, armannadim
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==

A3N Cricket management plugin has been created to help cricket league or cricket club managers to publish there fixture, match summary and point tables.
This plugin is still in it's initial version. Very functionalities available in this version. Time to time I'm going to add more functionalities.
Till now it's free version. Any body can use, modify or share this plugin. But it will encourage me to work on this plugin if you contribute a small amount of donation.

On this initial version this plugins allows user to upload fixture in .xls/.xlst format also can input a fixture one by one on the fixture table. After each match the administrator can update results on the table easily. Also it's possible to upload the standings table and later the admin can edit manually. To publish fixture, match summary and point table on the wordpress site there are 2 shortcodes(you'll find those shortcode in the how to use section).
This plugin is in progress. More features are coming soon. Features like, adding players, statistics, personal data and stats, auto update of runrate, pointtable, complete scorebook integration etc are in the list.


== Installation ==


1. Upload a3n_cricmgt_wp to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add teams, tournaments in the configuration tab.
4. Add fixture to the fixture tab, also you can upload excel file.[You'll find the sample excel file with this package. fixture.xls]
    4.1. Fixture excel file contains various columns, TeamA_Name [Name of team a], TeamA [id of teamA], TeamB_Name[name of teamB], TeamB [id of teamB], _group, matchdate [Date and time in yyyy-mm-dd hh:mm:ss format],
         tournament_Name, tournamentId[tournament id in the application], venue. You'll get more instruction on the fixture.xls file's ReadME tab.
5. Modify match status on the results tab. Click on the cell you want to edit and write the desired information and leave the cell. This will update data to the database.
6. Add point table or standings in the Standings tab. You can upload initial data of point table using excel file.[You'll find the sample excel file with this package. dt.xls]
    6.1. Point table excel contains tournamentId, position, team. This three column are most important in this case. You've to put the tournamentID of which you're creating point table. Team will contain team id and position is when you're updating the point table what is the position of the current team.
         Point table till now is manual. Automated point table system will be available soon.
7. Use shortcodes to show fixture with result and standings in the wordpress page.
   [This version allows only two shortcodes: [a3n_pointtable tId="<>" group="<>" ] & [a3n_matches tId="<>" group="<>" ] details about this shortcodes you'll find later on this document. ]
[a3n_pointtable tId="<>" group="<>" ] -> This short codes enables standings on a menu page.
[a3n_matches tId="<>" group="<>" ] -> This short codes enables fixtures with results on a menu page.
tId = Tournament Id. It's compulsary paramatere and value of this parametre is numeric.
group is an optional parametere. If a tournament has group and you want to show fixture or standings group wise than you've to add group name as it is shown in the plugin settings.
   
== Frequently Asked Questions ==

* Can I add this shortcodes in a menu page?
=> Yes

== Screenshots ==

NO SCREENSHOTS ADDED YET

== Changelog ==
= 1.1.1 =
* resolved solution of backend standing on table update.
* Added tournament dropdown list to select standing of specific table.
* Modified standing page to show a tournament of current year.

= 1.1.0 =
* Added venue to the database and in the fixture table. Also in the fixture excel file to upload fixtures.

= 1.0.1 =
* Edit and delete team and tournament

= 1.0.0 =
* Initial version. 
* Adding team and tournament.
* Add fixture or upload fixture.
* Edit fixture and edit results.
* Upload point table and edit point table.