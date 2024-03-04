<?php

function getConfig()
{
    $config = array(
        '0' => array(
        'admin_user' => 'admin',
        'admin_pass' => '$2y$10$.I8ji57GDlWHu6aWklGWZuTe57g980zelhV9VlYFyQfZ.eLd4b2/2',
        'purview' => '32767'
        ));

    if (file_exists(RASPI_ADMIN_DETAILS)) {
        if ($auth_details = fopen(RASPI_ADMIN_DETAILS, 'r')) {
            $i = 0;
            while (($line = fgets($auth_details)) !== false) {
                // echo $i.':'.$line.PHP_EOL;
                $result = explode(':', $line);
                if (count($result) == 3) {
                    $config[$i]['admin_user'] = $result[0];
                    $config[$i]['admin_pass'] = $result[1];
                    $config[$i]['purview'] = $result[2];
                }
                
                $i++;
                unset($line);
                unset($result);
            }
            fclose($auth_details);
        }
    }

    return $config;
}