<?php ob_start() ?>
  <?php if (!RASPI_MONITOR_ENABLED) : ?>
    <div class="cbi-page-actions">
      <input type="submit" class="btn btn-outline btn-primary" name="UpdateAdminPassword" value="<?php echo _("Save settings"); ?>" />
      <input type="submit" class="btn btn-warning" name="logout" value="<?php echo _("Logout") ?>" onclick="disableValidation(this.form)"/>
    </div>
  <?php endif ?>
<?php $buttons = ob_get_clean(); ob_end_clean() ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
	        <div class="col">
						<?php echo _("Authentication"); ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /.card-header -->
      <div class="card-body">
        <?php $status->showMessages(); ?>
        <h4><?php echo _("Authentication settings for $username") ;?></h4>
        <form role="form" action="auth_conf" method="POST">
          <?php echo \ElastPro\Tokens\CSRF::hiddenField(); ?>
          <div class="row">
            <div class="mb-3 col-md-6">
              <div class="mb-2"><?php echo _("Old password"); ?></div>
              <div class="input-group has-validation">
                <input type="password" class="form-control" name="oldpass" />
                <div class="input-group-text js-toggle-password" data-bs-target="[name=oldpass]" data-toggle-with="fas fa-eye-slash"><i class="fas fa-eye mx-2"></i></div>
                <div class="invalid-feedback">
                  <?php echo _("Please enter your old password."); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
              <div class="mb-2"><?php echo _("New password"); ?></div>
              <div class="input-group has-validation">
                <input type="password" class="form-control" name="newpass" />
                <div class="input-group-text js-toggle-password" data-bs-target="[name=newpass]" data-toggle-with="fas fa-eye-slash"><i class="fas fa-eye mx-2"></i></div>
                <div class="invalid-feedback">
                  <?php echo _("Please enter a new password."); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
              <div class="mb-2"><?php echo _("Repeat new password"); ?></div>
              <div class="input-group has-validation">
                <input type="password" class="form-control" name="newpassagain" />
                <div class="input-group-text js-toggle-password" data-bs-target="[name=newpassagain]" data-toggle-with="fas fa-eye-slash"><i class="fas fa-eye mx-2"></i></div>
                <div class="invalid-feedback">
                  <?php echo _("Please re-enter your new password."); ?>
                </div>
              </div>
            </div>
          </div>
          <?php echo $buttons ?>
          <?php if ($username == 'superadmin') : ?>
          <input type="hidden" name="table_data" value="" id="hidTD">
          <div class="cbi-section cbi-tblsection" id="page_auth" name="page_auth">
            <table class="table cbi-section-table" style="table-layout: auto" name="table_auth" id="table_auth">
              <tr class="tr cbi-section-table-titles">
                <th class="th cbi-section-table-cell"><?php echo _("Username"); ?></th>
                <th class="th cbi-section-table-cell" style="display:none"><?php echo _("Password"); ?></th>
                <th class="th cbi-section-table-cell"><?php echo _("Purview"); ?></th>
                <th class="th cbi-section-table-cell cbi-section-actions"></th>
                <th class="th cbi-section-table-cell cbi-section-actions"></th>
              </tr>
              <tr class="tr cbi-section-table-descr">
                <th class="th cbi-section-table-cell" ></th>
                <th class="th cbi-section-table-cell" ></th>
                <th class="th cbi-section-table-cell" ></th>
                <th class="th cbi-section-table-cell cbi-section-actions"></th>
              </tr>
              <?php
                $usernameList = array();
                foreach ($config as $key => $value) {
                  if (is_array($value)) {
                      if ($value['admin_user'] != 'admin' && $value['admin_user'] != 'superadmin') {
                        echo '<tbody>
                        <tr  class="tr cbi-section-table-descr">
                        <td style="text-align:center" name="user">'.$value['admin_user'].'</td>
                        <td style="display:none" name="password">'.$value['admin_pass'].'</td>
                        <td style="text-align:center" name="purview">'.$value['purview'].'</td>
                        <td style="width:10rem"><a href="javascript:void(0);" onclick="editDataAuth(this);" >Edit</a></td>
                        <td style="width:10rem"><a href="javascript:void(0);" onclick="delDataAuth(this);" >Del</a></td>
                        </tr>
                        </tbody>';
                      }
                      array_push($usernameList, $value['admin_user']);
                  }
                }
                $str = json_encode($usernameList);
              ?>
              <input type="hidden" name="username_list" id="username_list" value='<?php echo $str; ?>' id="hidTD">
            </table>
            <div class="cbi-section-create">
              <input type="button" class="cbi-button-add" name="popBox" value="Add" onclick="addDataAuth(); updateAllGroupCounts();">
            </div>
          </div>
          <div class="cbi-page-actions">
            <input type="submit" class="btn btn-outline btn-primary" value="<?php echo _("Save settings"); ?>" name="UpdateAdminSettings" />
          </div>
          <?php endif; ?>
        </form>
      </div><!-- /.card-body -->
      <div class="card-footer"></div>
    </div><!-- /.card -->
  </div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<?php if ($username == 'superadmin') : ?>
<style>
  .purview-toolbar { display: flex; align-items: center; gap: 8px; margin: 24px 0 10px; }
  .purview-toolbar span { font-weight: bold; margin-right: auto; }
  .purview-group { border: 1px solid #ddd; border-radius: 4px; margin-bottom: 6px; }
  .purview-group-header { display: flex; align-items: center; padding: 6px 10px; background: #f5f5f5; cursor: pointer; user-select: none; }
  .purview-group-header:hover { background: #ececec; }
  .purview-group-title { font-weight: bold; flex: 1; }
  .purview-group-count { color: #666; font-size: 0.85rem; margin-right: 10px; }
  .purview-group-actions button { margin-left: 4px; font-size: 0.8rem; padding: 2px 8px; }
  .purview-group-toggle { margin-left: 8px; color: #666; }
  .purview-group-body { display: none; padding: 4px 10px; }
</style>
<div id="popLayer"></div>
<div id="popBox" style="overflow:auto">
  <input hidden="hidden" name="page_type" id="page_type" value="0">
  <h4><?php echo _("Authentication Setting"); ?></h4>
  <div class="purview-toolbar">
    <span><?php echo _("Purview"); ?></span>
    <button type="button" class="cbi-button" onclick="toggleAllGroups(true)"><?php echo _("Expand All"); ?></button>
    <button type="button" class="cbi-button" onclick="toggleAllGroups(false)"><?php echo _("Collapse All"); ?></button>
  </div>
  <div class="cbi-section">
    <div class="cbi-value">
      <label class="cbi-value-title" for="auth.username"><?php echo _("Username"); ?></label>
      <input id="auth.username" type="text" class="cbi-input-text">
    </div>

    <div class="cbi-value">
      <label class="cbi-value-title" for="auth.password"><?php echo _("Password"); ?></label>
      <input id="auth.password" type="text" class="cbi-input-text">
    </div>

    <?php
      // Build purview groups with same model/feature conditions as sidebar.php
      $purview_groups = array();

      // Network
      $net_items = array();
      $net_items[] = array(_('Wired'), 'wired');
      if (file_exists('/dev/ttyUSB1') && isLteEnabled())
        $net_items[] = array(_('LTE'), 'lte');
      if (isRunning('wpa_supplicant'))
        $net_items[] = array(_('WiFi Client (WAN)'), 'wlan0');
      $net_items[] = array(_('LAN'), 'lan');
      if (file_exists('/sys/class/net/wlan0')) {
        $net_items[] = array(_('WiFi AP'), 'wifi');
        $net_items[] = array(_('WiFi Client'), 'wifi_client');
      }
      if (isBinExists("failoverd"))
        $net_items[] = array(_('Online Detection'), 'online_detection');
      if (isBinExists("lora_pkt_fwd"))
        $net_items[] = array(_('LoRaWAN'), 'lorawan');
      if (isBinExists("efw"))
        $net_items[] = array(_('Firewall'), 'firewall');
      if (!empty($net_items))
        $purview_groups[_('Network')] = $net_items;

      // Data Collect
      if (isBinExists("dctd")) {
        $dc_items = array();
        $dc_items[] = array(_('Basic'), 'basic');
        $dc_items[] = array(_('Interfaces'), 'interfaces');
        $dc_items[] = array(_('Modbus Rules'), 'modbus');
        $dc_items[] = array(_('ASCII Rules'), 'ascii');
        $dc_items[] = array(_('S7 Rules'), 's7');
        $dc_items[] = array(_('FX Rules'), 'fx');
        $dc_items[] = array(_('MC Rules'), 'mc');
        $dc_items[] = array(_('IEC104 Rules'), 'iec104');
        $dc_items[] = array(_('DNP3 Rules'), 'dnp3cli');
        $dc_items[] = array(_('OPCUA Rules'), 'opcuacli');
        $dc_items[] = array(_('BACnet Rules'), 'baccli');
        $dc_items[] = array(_('EtherNet/IP Rules'), 'ethernetip');
        $dc_items[] = array(_('Mbus Rules'), 'mbuscli');
        $dc_items[] = array(_('SNMP Rules'), 'snmpcli');
        $dc_items[] = array(_('IEC62056-21 Rules'), 'iec1107');
        $dc_items[] = array(_('DLMS Rules'), 'dlms');
        $dc_items[] = array(_('IEC61850 Rules'), 'iec61850cli');
        if (isIoExistts())
          $dc_items[] = array(_('IO'), 'io');
        $dc_items[] = array(_('System Parameters'), 'system_param');
        $dc_items[] = array(_('Reporting Center'), 'server');
        $dc_items[] = array(_('Modbus Slave'), 'modbus_slave');
        $dc_items[] = array(_('OPCUA Server'), 'opcua');
        if (isBinExists("bacserv"))
          $dc_items[] = array(_('BACnet Server'), 'bacnet');
        $dc_items[] = array(_('DNP3 Server'), 'dnp3');
        $dc_items[] = array(_('Data Monitoring'), 'datadisplay');
        $purview_groups[_('Data Collect')] = $dc_items;
      }

      // Protocol Convert
      if (isBinExists("router-mstp") || isBinExists("router-modbus")) {
        $pc_items = array();
        if (isBinExists("router-mstp"))
          $pc_items[] = array(_('BACnet Router'), 'bacnet_router');
        if (isBinExists("router-modbus"))
          $pc_items[] = array(_('Modbus Router'), 'modbus_router');
        if (!empty($pc_items))
          $purview_groups[_('Protocol Convert')] = $pc_items;
      }

      // Remote Access
      if (isBinExists("baseagent") || isBinExists("openvpn") || isBinExists("wg") || isBinExists("noip2")) {
        $ra_items = array();
        $tgt = getTarget();
        if (strpos($tgt, "IQEG") === false && strpos($tgt, "IQEC") === false)
          $ra_items[] = array(_('ThingsWing'), 'things_wing');
        if (isBinExists("noip2"))
          $ra_items[] = array(_('DDNS'), 'ddns');
        if (isBinExists("openvpn"))
          $ra_items[] = array(_('OpenVPN'), 'openvpn');
        if (isBinExists("wg") && isBinExists("wg-quick"))
          $ra_items[] = array(_('WireGuard'), 'wireguard');
        if (!empty($ra_items))
          $purview_groups[_('Remote Access')] = $ra_items;
      }

      // Services
      if (isBinExists("node-red") || isBinExists("dockerd") || isBinExists("chirpstack") || isBinExists("iotedge")) {
        $sv_items = array();
        if (isBinExists("node-red"))
          $sv_items[] = array(_('Node Red'), 'nodered');
        if (isBinExists("dockerd"))
          $sv_items[] = array(_('Docker'), 'docker');
        if (isBinExists("chirpstack"))
          $sv_items[] = array(_('ChirpStack'), 'chirpstack');
        if (isBinExists("iotedge"))
          $sv_items[] = array(_('Azure IoT Edge'), 'iotedge');
        if ((isBinExists("pip3") || isBinExists("python3")) && file_exists('/etc/raspap/api/'))
          $sv_items[] = array(_('RestAPI'), 'restapi');
        if (!empty($sv_items))
          $purview_groups[_('Services')] = $sv_items;
      }

      // System
      $sys_items = array();
      $sys_items[] = array(_('System'), 'system_info');
      $sys_items[] = array(_('Time Settings'), 'time_setting');
      if (isBinExists("gpsd"))
        $sys_items[] = array(_('GPS Location'), 'gps');
      if (isBinExists("ttyd") || file_exists("/usr/local/bin/ttyd"))
        $sys_items[] = array(_('Terminal'), 'terminal');
      if (isBinExists("scheduled"))
        $sys_items[] = array(_('Scheduled Tasks'), 'scheduled');
      $tgt = getTarget();
      if (isBinExists("chromium-browser") && strpos($tgt, 'EH607') !== false)
        $sys_items[] = array(_('HMI'), 'hmi');
      $sys_items[] = array(_('Authentication'), 'auth_conf');
      $sys_items[] = array(_('Backup/Restore'), 'backup_restore');
      $sys_items[] = array(_('Update/Restore'), 'backup_update');
      $purview_groups[_('System')] = $sys_items;

      $head_name = 'auth';
      $gid = 0;
      foreach ($purview_groups as $group_title => $items) {
        echo '<div class="purview-group" id="purview-group-' . $gid . '">';
        echo '<div class="purview-group-header" onclick="togglePurviewGroup(this)">';
        echo '<span class="purview-group-title">' . $group_title . '</span>';
        echo '<span class="purview-group-count">0/' . count($items) . '</span>';
        echo '<span class="purview-group-actions">';
        echo '<button type="button" class="cbi-button" onclick="event.stopPropagation(); groupSelectAll(this, true);">' . _('Select All') . '</button>';
        echo '<button type="button" class="cbi-button" onclick="event.stopPropagation(); groupSelectAll(this, false);">' . _('Clear All') . '</button>';
        echo '</span>';
        echo '<span class="purview-group-toggle">&#9654;</span>';
        echo '</div>';
        echo '<div class="purview-group-body">';
        foreach ($items as $item) {
          echo '<div class="cbi-value">
            <label class="cbi-value-title">' . $item[0] . '</label>
            <input type="checkbox" class="cbi-input-checkbox" name="' . $head_name . '.' . $item[1] . '" id="' . $head_name . '.' . $item[1] . '" value="1" onchange="updateGroupCount(this)"/>
          </div>';
        }
        echo '</div>';
        echo '</div>';
        $gid++;
      }
    ?>
  </div>
  <div class="right">
    <button class="cbi-button" onclick="closeBox()"><?php echo _("Dismiss"); ?></button>
    <button class="cbi-button cbi-button-positive important" onclick="saveDataAuth()"><?php echo _("Save"); ?></button>
  </div>
  <?php endif;?>
</div><!-- popBox -->
