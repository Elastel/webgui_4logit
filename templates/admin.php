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
            <?php echo CSRFTokenFieldTag() ?>
          <div class="cbi-section cbi-tblsection">
            <div class="cbi-value">
              <label class="cbi-value-title"><?php echo _("Old password"); ?></label>
              <input type="password" class="cbi-input-text" name="oldpass" id="oldpass" autocomplete="off"/>
            </div>
            <div class="cbi-value">
              <label class="cbi-value-title"><?php echo _("New password"); ?></label>
              <input type="password" class="cbi-input-text" name="newpass" id="newpass" autocomplete="off"/>
            </div>
            <div class="cbi-value">
              <label class="cbi-value-title"><?php echo _("Repeat new password"); ?></label>
              <input type="password" class="cbi-input-text" name="newpassagain" id="newpassagain" autocomplete="off"/>
            </div>
            <div class="cbi-page-actions">
              <input type="submit" class="btn btn-outline btn-primary" value="<?php echo _("Save settings"); ?>" name="UpdateAdminPassword" />
            </div>
            <?php if ($username == 'superadmin') : ?>
            <input type="hidden" name="table_data" value="" id="hidTD">
            <div class="cbi-section cbi-tblsection" id="page_auth" name="page_auth">
              <table class="table cbi-section-table" name="table_auth" id="table_auth">
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
                <input type="button" class="cbi-button-add" name="popBox" value="Add" onclick="addData()">
              </div>
            </div>
            <div class="cbi-page-actions">
              <input type="submit" class="btn btn-outline btn-primary" value="<?php echo _("Save settings"); ?>" name="UpdateAdminSettings" />
            </div>
            <?php endif; ?>
          </div>
        </form>
      </div><!-- /.card-body -->
      <div class="card-footer"></div>
    </div><!-- /.card -->
  </div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<?php if ($username == 'superadmin') : ?>
<div id="popLayer"></div>
<div id="popBox" style="overflow:auto">
  <input hidden="hidden" name="page_type" id="page_type" value="0">
  <h4><?php echo _("Authentication Setting"); ?></h4>
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
      $array_title = array('Basic', 'Interfaces', 'Modbus Rules', 'ASCII Rules', 'S7 Rules', 
        'FX Rules', 'MC Rules', 'IO', 'BACnet Client', 'Server', 'OPC UA', 'BACnet Server', 'Data Display', 
        'Terminal', 'GPS Location', 'Node Red', 'Docker');

      $head_name = 'auth';
      $array_name = array('basic', 'interfaces', 'modbus', 'ascii', 's7', 'fx', 'mc', 'io', 'bacnet_client', 
        'server', 'opcua', 'bacnet_server', 'datadisplay', 'terminal', 'gps', 'nodered', 'docker');

      $model = getModel();
      if ($model != 'EG500' || $model != 'EG410') {
        $key = array_search("IO", $array_title);
        array_splice($array_title, $key, 1); 
        unset($key);
        $key = array_search("io", $array_name);
        array_splice($array_name, $key, 1);
        unset($key);
        $key = array_search("GPS Location", $array_title);
        array_splice($array_title, $key, 1);
        unset($key);
        $key = array_search("gps", $array_name);
        array_splice($array_name, $key, 1);
      }

      for ($i = 0; $i < count($array_title); $i++) {
        echo '<div class="cbi-value">
          <label class="cbi-value-title">' . _($array_title[$i]) . '</label>
          <input type="checkbox" class="cbi-input-checkbox" name="'.$head_name.'.'.$array_name[$i].'" id="'.$head_name.'.'.$array_name[$i].'" value="1"/>
        </div>';
      } 
    ?>
  </div>
  <div class="right">
    <button class="cbi-button" onclick="closeBox()"><?php echo _("Dismiss"); ?></button>
    <button class="cbi-button cbi-button-positive important" onclick="saveDataAuth()"><?php echo _("Save"); ?></button>
  </div>
  <?php endif;?>
</div><!-- popBox -->
