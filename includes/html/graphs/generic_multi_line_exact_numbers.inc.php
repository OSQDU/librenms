<?php

use App\Facades\LibrenmsConfig;
use App\Facades\Rrd;

require 'includes/html/graphs/common.inc.php';

$multiplier ??= null;
$divider ??= null;
$dostack ??= null;
$printtotal ??= 0;
$total_units ??= '';

if ($width > '500') {
    $descr_len = $bigdescrlen;
} else {
    $descr_len = $smalldescrlen;
}

if ($printtotal === 1) {
    $descr_len += '2';
    $unitlen += '2';
}

$unit_text = Rrd::fixedSafeDescr($unit_text, $unitlen);

if ($width > '500') {
    $rrd_options .= " COMMENT:'" . substr(str_pad($unit_text, $descr_len + 10), 0, $descr_len + 10) . "Now         Min         Max        Avg\l'";
    if ($printtotal === 1) {
        $rrd_options .= " COMMENT:'Total      '";
    }
    $rrd_options .= " COMMENT:'\l'";
} else {
    $rrd_options .= " COMMENT:'" . substr(str_pad($unit_text, $descr_len + 10), 0, $descr_len + 10) . "Now         Min         Max        Avg\l'";
}

$colour_iter = 0;
$i = 0;

foreach ($rrd_list as $rrd) {
    if (! empty($rrd['colour'])) {
        $colour = $rrd['colour'];
    } else {
        if (! LibrenmsConfig::get("graph_colours.$colours.$colour_iter")) {
            $colour_iter = 0;
        }

        $colour = LibrenmsConfig::get("graph_colours.$colours.$colour_iter");
        $colour_iter++;
    }
    $i++;
    $ds = $rrd['ds'];
    $filename = $rrd['filename'];

    $descr = Rrd::fixedSafeDescr($rrd['descr'], $descr_len);
    $id = 'ds' . $i;

    $rrd_options .= ' DEF:' . $rrd['ds'] . $i . '=' . $rrd['filename'] . ':' . $rrd['ds'] . ':AVERAGE ';

    if (! empty($simple_rrd)) {
        $rrd_options .= ' CDEF:' . $rrd['ds'] . $i . 'min=' . $rrd['ds'] . $i . ' ';
        $rrd_options .= ' CDEF:' . $rrd['ds'] . $i . 'max=' . $rrd['ds'] . $i . ' ';
    } else {
        $rrd_options .= ' DEF:' . $rrd['ds'] . $i . 'min=' . $rrd['filename'] . ':' . $rrd['ds'] . ':MIN ';
        $rrd_options .= ' DEF:' . $rrd['ds'] . $i . 'max=' . $rrd['filename'] . ':' . $rrd['ds'] . ':MAX ';
    }

    if ($graph_params->visible('previous')) {
        $rrd_options .= ' DEF:' . $i . 'X=' . $rrd['filename'] . ':' . $rrd['ds'] . ':AVERAGE:start=' . $prev_from . ':end=' . $from;
        $rrd_options .= ' SHIFT:' . $i . "X:$period";
        $thingX .= $seperatorX . $i . 'X,UN,0,' . $i . 'X,IF';
        $plusesX .= $plusX;
        $seperatorX = ',';
        $plusX = ',+';
    }

    if ($printtotal === 1) {
        $rrd_options .= ' VDEF:tot' . $rrd['ds'] . $i . '=' . $rrd['ds'] . $i . ',TOTAL';
    }

    $g_defname = $rrd['ds'];
    if (is_numeric($multiplier)) {
        $g_defname = $rrd['ds'] . '_cdef';
        $rrd_options .= ' CDEF:' . $g_defname . $i . '=' . $rrd['ds'] . $i . ',' . $multiplier . ',*';
        $rrd_options .= ' CDEF:' . $g_defname . $i . 'min=' . $rrd['ds'] . $i . 'min,' . $multiplier . ',*';
        $rrd_options .= ' CDEF:' . $g_defname . $i . 'max=' . $rrd['ds'] . $i . 'max,' . $multiplier . ',*';
    } elseif (is_numeric($divider)) {
        $g_defname = $rrd['ds'] . '_cdef';
        $rrd_options .= ' CDEF:' . $g_defname . $i . '=' . $rrd['ds'] . $i . ',' . $divider . ',/';
        $rrd_options .= ' CDEF:' . $g_defname . $i . 'min=' . $rrd['ds'] . $i . 'min,' . $divider . ',/';
        $rrd_options .= ' CDEF:' . $g_defname . $i . 'max=' . $rrd['ds'] . $i . 'max,' . $divider . ',/';
    }

    if (isset($text_orig) && $text_orig) {
        $t_defname = $rrd['ds'];
    } else {
        $t_defname = $g_defname;
    }

    $stack = $i && ($dostack === 1) ? ':STACK' : '';

    $rrd_options .= ' LINE2:' . $g_defname . $i . '#' . $colour . ":'" . $descr . "'$stack";
    $rrd_options .= ' GPRINT:' . $t_defname . $i . ':LAST:%8.0lf%s GPRINT:' . $t_defname . $i . 'min:MIN:%8.0lf%s';
    $rrd_options .= ' GPRINT:' . $t_defname . $i . 'max:MAX:%8.0lf%s GPRINT:' . $t_defname . $i . ":AVERAGE:'%8.0lf%s\\n'";

    if ($printtotal === 1) {
        $rrd_options .= ' GPRINT:tot' . $rrd['ds'] . $i . ":%6.2lf%s'" . Rrd::safeDescr($total_units) . "'";
    }

    $rrd_options .= " COMMENT:'\\n'";
}//end foreach

if ($graph_params->visible('previous')) {
    if (is_numeric($multiplier)) {
        $rrd_options .= ' CDEF:X=' . $thingX . $plusesX . ',' . $multiplier . ',*';
    } elseif (is_numeric($divider)) {
        $rrd_options .= ' CDEF:X=' . $thingX . $plusesX . ',' . $divider . ',/';
    } else {
        $rrd_options .= ' CDEF:X=' . $thingX . $plusesX;
    }
    $rrd_options .= ' HRULE:0#555555';
}
