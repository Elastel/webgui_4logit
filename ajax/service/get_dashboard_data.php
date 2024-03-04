<?php

require '../../includes/csrf.php';
require_once '../../includes/config.php';

$local_time = date('Y-m-d H:i:s');
$dashboarddata['local_time'] = $local_time;

$uparray = explode(" ", exec("cat /proc/uptime"));
$seconds = round($uparray[0], 0);
$minutes = $seconds / 60;
$hours   = $minutes / 60;
$days    = floor($hours / 24);
$hours   = floor($hours   - ($days * 24));
$minutes = floor($minutes - ($days * 24 * 60) - ($hours * 60));
$uptime= '';
if ($days    != 0) {
    $uptime .= $days . ' day' . (($days    > 1)? 's ':' ');
}
if ($hours   != 0) {
    $uptime .= $hours . ' hour' . (($hours   > 1)? 's ':' ');
}
if ($minutes != 0) {
    $uptime .= $minutes . ' minute' . (($minutes > 1)? 's ':' ');
}
$dashboarddata['uptime'] = $uptime;

echo json_encode($dashboarddata);
