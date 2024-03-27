<?php
require '../../includes/csrf.php';
require_once '../../includes/config.php';

$type = $_GET['type'];

if ($type == 'datadisplay') {
    exec('cat /tmp/webshow', $dctdata);
    if ($dctdata[0] != NULL){
        echo $dctdata[0];
    }  else {
        echo "{}";
    }
} else if ($type == 'opcua_nodes') {
    exec('cat /tmp/opcua_nodes', $dctdata);
    if ($dctdata[0] != NULL){
        echo $dctdata[0];
    }  else {
        echo "{}";
    }
} else if (strstr($type, 'download')) {
    $arr = explode("_", $type);
    exec('sudo conf_im_ex export ' . $arr[1]);
    exec('cat /tmp/config_export.csv', $data);
    echo implode(PHP_EOL, $data);
} else {
    if ($type == 'interface' || $type == 'server')
        exec("/usr/sbin/get_config dct name $type 5", $data);
    else if ($type == 'modbus' || $type == 'ascii' || $type == 's7'|| $type == 'fx' ||
             $type == 'mc' || $type == 'adc' || $type == 'di' || $type == 'do')
        exec("/usr/sbin/get_config dct type $type 1", $data);
    else if ($type == 'opcua') {
        exec("/usr/sbin/get_config dct name $type 1", $data);
        exec("/usr/sbin/get_config dct type opcuaserv 1", $data_opcua_server);
    } else
        exec("/usr/sbin/get_config dct name $type 1", $data);
    
    if ($type == 'opcua') {
        $dctdata['basic'] = json_decode($data[0]);
        $dctdata['opcuaserv'] = json_decode($data_opcua_server[0]);
    } else {
        $dctdata = json_decode($data[0]);
    }

    echo json_encode($dctdata);
}
