<?php
require 'includes/graphs/common.inc.php';
$i              = 0;
$scale_min      = 0;
$nototal        = 1;
$unit_text      = 'Per Sec.';
$rrd_filename   = rrd_name($device['hostname'], array('app', 'freeradius-queue', $app['app_id']));
$fr_queue_array = array(
    'len_internal' => 'Len Internal',
    'len_proxy' => 'Len Proxy',
    'len_auth' => 'Len Auth',
    'len_acct' => 'Len Acct',
    'len_detail' => 'Len Detail',
    'pps_in' => 'PPS In',
    'pps_out' => 'PPS Out'
);
$colours      = 'mixed';
$rrd_list     = array();
if (rrdtool_check_rrd_exists($rrd_filename)) {
    foreach ($fr_queue_array as $ds => $descr) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = $descr;
        $rrd_list[$i]['ds']       = $ds;
        $i++;
    }
} else {
    echo "file missing: $rrd_filename";
}
require 'includes/graphs/generic_multi_line.inc.php';
