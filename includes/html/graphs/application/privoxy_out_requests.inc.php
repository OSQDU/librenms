<?php

$unit_text = 'out_requests';
$descr = 'out_requests';
$ds = 'out_requests';

$rrd_filename = Rrd::name($device['hostname'], ['app', $app->app_type, $app->app_id]);

require 'includes/html/graphs/generic_stats.inc.php';
