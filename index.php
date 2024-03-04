<?php
require_once 'includes/includes.php';
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?php echo CSRFMetaTag() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php echo _("4Logit Configuration Portal"); ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- SB-Admin-2 CSS -->
    <link href="dist/sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="dist/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Huebee CSS -->
    <link href="dist/huebee/huebee.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="dist/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="<?php echo $theme_url; ?>" title="main" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="app/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="app/icons/favicon-16x16.png">
    <link rel="icon" type="image/png" href="app/icons/favicon.png" />
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#ffffff">
  </head>
  <body id="page-top" style="font-family:'Arial','Microsoft YaHei','黑体','宋体',sans-serif">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav sidebar sidebar-light d-none d-md-block accordion <?php echo (isset($toggleState)) ? $toggleState : null ; ?>" id="accordionSidebar">
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <div class="col-xs ml-3 sidebar-brand-icon">
          <img src="app/img/elastel.php" style="width:100%;height:100%;">
        </div>
        <li class="nav-item">
          <a class="nav-link" href="dashboard"><i class="fas fa-tachometer-alt fa-fw mr-2"></i><span class="nav-label"><?php echo _("Dashboard"); ?></span></a>
        </li>
        <li class="nav-item" id="page_network">
          <a class="nav-link navbar-toggle collapsed" id="network" href="#" data-toggle="collapse" data-target="#navbar-collapse-network">
              <i class="fas fa-network-wired fa-fw mr-2"></i>
              <span class="nav-label"><?php echo _("Network"); ?></a>
          </a>
          <div class="collapse navbar-collapse" id="navbar-collapse-network">
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item" name="wan" id="wan" ><a class="nav-link" href="network_conf"><?php echo _("WAN"); ?></a></li>
              <li class="nav-item" name="lan" id="lan" ><a class="nav-link" href="dhcpd_conf"><?php echo _("LAN"); ?></a></li>
              <li class="nav-item" name="wifi" id="wifi" ><a class="nav-link" href="hostapd_conf"><?php echo _("WiFi"); ?></a></li>
              <li class="nav-item" name="wifi_client" id="wifi_client" ><a class="nav-link" href="wpa_conf"><?php echo _("WiFi client"); ?></a></li>
              <li class="nav-item" name="online_detection" id="online_detection" ><a class="nav-link" href="detection_conf"><?php echo _("Online Detection"); ?></a></li>
              <?php if ($model == "EG500" || $model == "EG410" || $model == "ElastBox400") : ?>
              <li class="nav-item" name="lorawan" id="lorawan" ><a class="nav-link" href="lorawan_conf"><?php echo _("LoRaWan"); ?></a></li>
              <?php endif; ?>
              <?php if ($model == "EG500" || $model == "EG410" || $model == "ElastBox400") : ?>
              <li class="nav-item" name="firewall" id="firewall" ><a class="nav-link" href="firewall_conf"><?php echo _("Firewall"); ?></a></li>
              <?php endif; ?>
            </ul>
          </div>
        </li>
        <li class="nav-item" id="page_dct">
          <a class="nav-link navbar-toggle collapsed" id="dct" href="#" data-toggle="collapse" data-target="#navbar-collapse-dct">
              <i class="fas fa-exchange-alt fa-fw mr-2"></i>
              <span class="nav-label"><?php echo _("Data Collect"); ?></a>
          </a>
          <div class="collapse navbar-collapse" id="navbar-collapse-dct">
            <ul class="nav navbar-nav navbar-right">
              <?php
                menuPurviewMatch($purview, 'dct_basic', 'dct_basic', 'basic_conf', _('Basic'));
                menuPurviewMatch($purview, 'interfaces', 'interfaces', 'interfaces_conf', _('Interfaces'));
                menuPurviewMatch($purview, 'modbus', 'modbus', 'modbus_conf', _('Modbus Rules'));
                menuPurviewMatch($purview, 'ascii', 'ascii', 'ascii_conf', _('ASCII Rules'));
                menuPurviewMatch($purview, 's7', 's7', 's7_conf', _('S7 Rules'));
                menuPurviewMatch($purview, 'fx', 'fx', 'fx_conf', _('FX Rules'));
                menuPurviewMatch($purview, 'mc', 'mc', 'mc_conf', _('MC Rules'));
                if ($model == "EG500" || $model == "EG410") : 
                  menuPurviewMatch($purview, 'io', 'io', 'io_conf', _('IO'));
                endif;
                
                menuPurviewMatch($purview, 'bacnet_client', 'bacnet_client', 'bacnet_client', _('BACnet Client'));
                menuPurviewMatch($purview, 'server', 'server', 'server_conf', _('Server'));
                menuPurviewMatch($purview, 'opcua', 'opcua', 'opcua', _('OPC UA'));
                menuPurviewMatch($purview, 'bacnet', 'bacnet', 'bacnet', _('BACnet Server'));
                menuPurviewMatch($purview, 'datadisplay', 'datadisplay', 'datadisplay', _('Data Display'));
              ?>
            </ul>
          </div>
        </li>
        <li class="nav-item" id="page_remote">
          <a class="nav-link navbar-toggle collapsed" id="remote" href="#" data-toggle="collapse" data-target="#navbar-collapse-remote">
              <i class="fas fa-server fa-fw mr-2"></i>
              <span class="nav-label"><?php echo _("Remote Manage"); ?></a>
          </a>
          <div class="collapse navbar-collapse" id="navbar-collapse-remote">
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item" name="ddns" id="ddns"> <a class="nav-link" href="ddns"><?php echo _("DDNS"); ?></a></li>
              <li class="nav-item" name="macchina" id="macchina"> <a class="nav-link" href="macchina"><?php echo _("Macchina"); ?></a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item" id="page_vpn">
          <a class="nav-link navbar-toggle collapsed" id="vpn" href="#" data-toggle="collapse" data-target="#navbar-collapse-vpn">
              <i class="fas fa-key fa-fw mr-2"></i>
              <span class="nav-label"><?php echo _("VPN"); ?></a>
          </a>
          <div class="collapse navbar-collapse" id="navbar-collapse-vpn">
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item" name="openvpn" id="openvpn"> <a class="nav-link" href="openvpn"><?php echo _("OpenVPN"); ?></a></li>
	            <?php if ($model != "EG324" && $model != "EG324L") : ?>
              <li class="nav-item" name="wireguard" id="wireguard"> <a class="nav-link" href="wireguard"><?php echo _("WireGuard"); ?></a></li>
	            <?php endif; ?>
            </ul>
          </div>
        </li>
        <li class="nav-item" id="page_services">
          <a class="nav-link navbar-toggle collapsed" id="services" href="#" data-toggle="collapse" data-target="#navbar-collapse-services">
              <i class="fas fa-cube fa-fw mr-2"></i>
              <span class="nav-label"><?php echo _("Services"); ?></a>
          </a>
          <div class="collapse navbar-collapse" id="navbar-collapse-services">
            <ul class="nav navbar-nav navbar-right">
              <?php
                menuPurviewMatch($purview, 'terminal', 'terminal', 'terminal', _('Terminal'));
                if ($model == "EG500" || $model == "EG410") : 
                  menuPurviewMatch($purview, 'gps', 'gps', 'gps', _('GPS Location'));
                endif;
                
                if(isBinExists("node-red")) : 
                  menuPurviewMatch($purview, 'nodered', 'nodered', 'nodered', _('Node Red'));
                endif;

                if(isBinExists("dockerd")) : 
                  menuPurviewMatch($purview, 'docker', 'docker', 'docker', _('Docker'));
                endif; 
              ?>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="auth_conf"><i class="fas fa-user-lock fa-fw mr-2"></i><span class="nav-label"><?php echo _("Authentication"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="system_info"><i class="fas fa-cube fa-fw mr-2"></i><span class="nav-label"><?php echo _("System"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about"><i class="fas fa-info-circle fa-fw mr-2"></i><span class="nav-label"><?php echo _("About 4Logit"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" name="logout" href="logout"><i class="fas fa-sign-out-alt fa-fw mr-2"></i><span class="nav-label"><?php echo _("Logout"); ?></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="load" id="loading" name="loading"></div>
          <?php
            $extraFooterScripts = array();
            handlePageActions($extraFooterScripts, $page);
          ?>
        </div><!-- /.container-fluid -->
      </div><!-- End of Main Content -->
    </div><!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top" style="display: inline;">
      <i class="fas fa-angle-up"></i>
    </a> 

    <!-- jQuery -->
    <script src="dist/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="dist/jquery-easing/jquery.easing.min.js"></script>

    <!-- Chart.js JavaScript -->
    <script src="dist/chart.js/Chart.min.js"></script>

    <!-- SB-Admin-2 JavaScript -->
    <script src="dist/sb-admin-2/js/sb-admin-2.js"></script>

    <!-- Custom JS -->
    <script src="app/js/custom.js"></script>

    <?php
    // Load non default JS/ECMAScript in footer.
    foreach ($extraFooterScripts as $script) {
        echo '<script type="text/javascript" src="' , $script['src'] , '"';
        if ($script['defer']) {
            echo ' defer="defer"';
        }
        echo '></script>' , PHP_EOL;
    }
    ?>
  </body>
</html>
