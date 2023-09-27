<?php

require '../../includes/csrf.php';
require_once '../../includes/config.php';

$interface = $_GET['iface'];

if (isset($interface)) {
    // fetch dnsmasq.conf settings for interface
    exec('cat '. escapeshellarg(RASPI_DNSMASQ_PREFIX.$interface.'.conf'), $return);
    $conf = ParseConfig($return);

    $dhcpdata['DHCPEnabled'] = empty($conf) ? false : true;
    if ($conf['dhcp-range'] != null) {
        $arrRange = explode(",", $conf['dhcp-range']);
        $dhcpdata['RangeStart'] = $arrRange[0];
        $dhcpdata['RangeEnd'] = $arrRange[1];
        $dhcpdata['RangeMask'] = $arrRange[2];
        $dhcpdata['leaseTime'] = $arrRange[3];
    }

    if ($conf['dhcp-host'] != null) {
        $dhcpHost = $conf['dhcp-host'];
    }
    
    $dhcpHost = empty($dhcpHost) ? [] : $dhcpHost;
    $dhcpdata['dhcpHost'] = is_array($dhcpHost) ? $dhcpHost : [ $dhcpHost ];
    $upstreamServers = is_array($conf['server']) ? $conf['server'] : [ $conf['server'] ];
    $dhcpdata['upstreamServersEnabled'] = empty($conf['server']) ? false: true;
    $dhcpdata['upstreamServers'] = array_filter($upstreamServers);

    preg_match('/([0-9]*)([a-z])/i', $dhcpdata['leaseTime'], $arrRangeLeaseTime);
    $dhcpdata['leaseTime'] = $arrRangeLeaseTime[1];
    $dhcpdata['leaseTimeInterval'] = $arrRangeLeaseTime[2];
    
    if (isset($conf['dhcp-option'])) {
        $arrDns = explode(",", $conf['dhcp-option']);
        if ($arrDns[0] == '6') {
            if (count($arrDns) > 1) {
                $dhcpdata['DNS1'] = $arrDns[1];
            }
            if (count($arrDns) > 2) {
                $dhcpdata['DNS2'] = $arrDns[2];
            }
        }
    }

    // fetch dhcpcd.conf settings for interface
    $conf = file_get_contents(RASPI_DHCPCD_CONFIG);
    preg_match('/^#\sRaspAP\s'.$interface.'\s.*?(?=\s*+$)/ms', $conf, $matched);
    // preg_match('/metric\s(\d*)/', $matched[0], $metric);
    preg_match('/static\sip_address=(.*)/', $matched[0], $static_ip);
    preg_match('/static\srouters=(.*)/', $matched[0], $static_routers);
    preg_match('/static\sdomain_name_server=(.*)/', $matched[0], $static_dns);
    preg_match('/fallback\sstatic_'.$interface.'/', $matched[0], $fallback);
    preg_match('/(?:no)?gateway/', $matched[0], $gateway);
    exec("sudo /usr/local/bin/uci get network.wan.metric", $metric);
    $dhcpdata['Metric'] = $metric[0];
    $dhcpdata['StaticIP'] = strpos($static_ip[1],'/') ?  substr($static_ip[1], 0, strpos($static_ip[1],'/')) : $static_ip[1];
    $dhcpdata['SubnetMask'] = cidr2mask($static_ip[1]);
    $dhcpdata['StaticRouters'] = $static_routers[1];
    $dhcpdata['StaticDNS'] = $static_dns[1];
    if (isset($dhcpdata['StaticDNS'])) {
        $arrStaticDns = explode(" ", $dhcpdata['StaticDNS']);
        if (count($arrStaticDns) == 1) {
            $dhcpdata['StaticDNS1'] = $arrStaticDns[0];
        } else if (count($arrStaticDns) >= 2) {
            $dhcpdata['StaticDNS1'] = $arrStaticDns[0];
            $dhcpdata['StaticDNS2'] = $arrStaticDns[1];
        }
    }

    exec("sudo /usr/local/bin/uci get network.wan.wan_multi", $wan_multi);
    $dhcpdata['wan_multi'] = $wan_multi[0];

    // fetch qmi-network.conf settings for interface
    exec("sudo /usr/local/bin/uci get network.swan.metric", $lte_metric);
    exec("sudo /usr/local/bin/uci get network.swan.apn", $apn);
    exec("sudo /usr/local/bin/uci get network.swan.pincode", $pin);
    exec("sudo /usr/local/bin/uci get network.swan.auth", $auth_type);
    exec("sudo /usr/local/bin/uci get network.swan.username", $apn_user);
    exec("sudo /usr/local/bin/uci get network.swan.password", $apn_pass);
    $dhcpdata['lte_metric'] = $lte_metric[0];
    $dhcpdata['Apn'] = $apn[0];
    $dhcpdata['Pin'] = $pin[0];
    $dhcpdata['ApnUser'] = $apn_user[0];
    $dhcpdata['ApnPass'] = $apn_pass[0];
    $dhcpdata['AuthType'] = $auth_type[0];
    
    if (!isset($dhcpdata['AuthType'])) {
        $dhcpdata['AuthType'] = 'none';
    }

    $dhcpdata['FallbackEnabled'] = empty($fallback) ? false: true;
    $dhcpdata['DefaultRoute'] = $gateway[0] == "gateway";

    echo json_encode($dhcpdata);
}
