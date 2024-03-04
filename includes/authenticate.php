<?php
$user = $_SERVER['PHP_AUTH_USER'] ?? "";
$pass = $_SERVER['PHP_AUTH_PW'] ?? "";

require_once RASPI_CONFIG.'/raspap.php';
$config = getConfig();
$validated = false;

if ($_SESSION['logout']) {
    echo "logout";
    $_SESSION['logout'] = 0;
} else {
    foreach ($config as $key => $value) {
        if (is_array($value)) {
            if ($value['admin_user'] == $user) {
                $validated = ($user == $value['admin_user']) && password_verify($pass, $value['admin_pass']);
            }  
        } else {
            $validated = ($user == $config['admin_user']) && password_verify($pass, $config['admin_pass']);
        }
    }
}

if (!$validated) {
    header('WWW-Authenticate: Basic realm="RaspAP"');
    if (function_exists('http_response_code')) {
        // http_response_code will respond with proper HTTP version back.
        http_response_code(401);
    } else {
        header('HTTP/1.0 401 Unauthorized');
    }

    exit('Not authorized'.PHP_EOL);
} else {
    $_SESSION['logout'] = 0;
}


