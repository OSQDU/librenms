<?php

require 'includes/html/graphs/common.inc.php';

$rrd_filename = Rrd::name($device['hostname'], ['app', 'mysql', $app->app_id]);

$array = [
    'SFJn' => 'Full Join',
    'SFRJn' => 'Full Range',
    'SRe' => 'Range',
    'SRCk' => 'Range Check',
    'SSn' => 'Scan',
];

$i = 0;
foreach ($array as $ds => $var) {
    $rrd_list[$i]['filename'] = $rrd_filename;
    if (is_array($var)) {
        $rrd_list[$i]['descr'] = $var['descr'];
    } else {
        $rrd_list[$i]['descr'] = $var;
    }

    $rrd_list[$i]['ds'] = $ds;
    $i++;
}

$colours = 'mixed';
$nototal = 0;
$unit_text = 'Queries';

require 'includes/html/graphs/generic_multi_simplex_seperated.inc.php';
