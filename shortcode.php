<?php

function zm_usa_bmx_stats(){
    $east_event_count = zm_event_by_region( 'east' );
    $west_event_count = zm_event_by_region( 'west' );
    $central_event_count = zm_event_by_region( 'central' );

    $east_national_count = zm_event_by_region( 'east', 'national' );
    $west_national_count = zm_event_by_region( 'west', 'national' );
    $central_national_count = zm_event_by_region( 'central', 'national' );

    // Still not showing up?
    // Great Salt Lake
    // Showing up as 32 but theres only 31 nationals
    ?>
    <script type="text/javascript" src='https://www.google.com/jsapi'></script>
    <script type="text/javascript">google.setOnLoadCallback( drawVisualization );</script>
    <script type="text/javascript">

        google.load("visualization", "1", {packages:["corechart"]});

        google.setOnLoadCallback( drawChartNationalsByRegion );
        google.setOnLoadCallback( drawChartEventsByRegion );
        google.setOnLoadCallback( drawChartNationalsVsEvents );

        function drawChartNationalsByRegion() {
            var data = google.visualization.arrayToDataTable([
                ['Nationals', 'Nationals by Region'],
                ['East',    <?php print $east_national_count['count']; ?>],
                ['Central', <?php print $central_national_count['count']; ?>],
                ['West',    <?php print $west_national_count['count']; ?>],
            ]);

            var options = {
                title: 'Nationals By Region',
                height: 240,
                width: 500
            };

            var chart = new google.visualization.PieChart( document.getElementById( 'chart_div_nationals_by_region' ) );
            chart.draw( data, options );
        }

        function drawChartEventsByRegion() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['East',    <?php print $east_event_count; ?>],
                ['Central', <?php print $central_event_count; ?>],
                ['West',    <?php print $west_event_count; ?>],
            ]);

            var options = {
                title: 'Events By Region',
                height: 240,
                width: 400
            };

            var chart = new google.visualization.PieChart( document.getElementById( 'chart_div_venues_by_region' ) );
            chart.draw( data, options );
        }

        function drawChartNationalsVsEvents (){

            var data = google.visualization.arrayToDataTable([
                ['Region',  'Events', 'Nationals'],
                ['East',    <?php print $east_event_count; ?>,    <?php print $east_national_count['count']; ?>],
                ['Central', <?php print $central_event_count; ?>, <?php print $central_national_count['count']; ?>],
                ['West',    <?php print $west_event_count; ?>,    <?php print $west_national_count['count']; ?>]
            ]);

            var chart = new google.visualization.ColumnChart( document.getElementById( 'chart_div' ) );

            var options = {
                title: 'National Events vs. All Events',
                hAxis: {
                    title: 'Region',
                    titleTextStyle: {
                        color: 'red'
                    }
                },
                width: 952,
                height: 266,
                colors: ['#c7cfc7', '#b2c8b2', '#d9e0de', '#cdded1'],
                chartArea: {
                    left:38,
                    top:30,
                    width:"75%",
                    height:"70%"
                },
                legendTextStyle: {
                    color:'#666666'
                },
                hAxis: {
                    title: 'Region',
                    titleTextStyle: {
                        color: '#5c5c5c'
                    },
                    titlePosition: 'out'
                }
            };

            chart.draw( data, options );
        }
    </script>
    <style type="text/css">
    .item-tmp {
        border: solid 1px #DFDFDF;
        background-color: white;
        text-align: center;
        padding: 13px;
        height: 230px;
        float: left;
        overflow: hidden;
        margin: 0 20px 20px 0;
        }
    </style>
    <?php
    return '<table>
        <tr>
            <td>
                <div class="item-tmp"><div id="chart_div_nationals_by_region"></div></div>
            </td>
            <td>
                <div class="item-tmp"><div id="chart_div_venues_by_region"></div></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div class="item-tmp"><div id="chart_div"></div></div></td>
        </tr>
    </table>'; ?>
<?php }
add_shortcode( 'usa_bmx_stats', 'zm_usa_bmx_stats' );