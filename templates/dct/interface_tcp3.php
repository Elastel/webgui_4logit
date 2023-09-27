<div class="tab-pane fade" id="tcp3">
  <div class="row">
    <div class="cbi-value">
      <label class="cbi-value-title"><?php echo _("Enabled"); ?></label>
      <input class="cbi-input-radio" id="tcp_enable3" name="tcp_enabled3" value="1" type="radio" checked onchange="enableTcp(true, 3)">
      <label ><?php echo _("Enable"); ?></label>

      <input class="cbi-input-radio" id="tcp_disable3" name="tcp_enabled3" value="0" type="radio" onchange="enableTcp(false, 3)">
      <label ><?php echo _("Disable"); ?></label>
    </div>

    <div id="page_tcp3" name="page_tcp3">
      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Server Address"); ?></label>
        <input type="text" class="cbi-input-text" name="server_addr3" id="server_addr3" />
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Server Port"); ?></label>
        <input type="text" class="cbi-input-text" name="server_port3" id="server_port3" />
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Frame Interval"); ?></label>
        <input type="text" class="cbi-input-text" name="tcp_frame_interval3" id="tcp_frame_interval3" value="200" />
        <label class="cbi-value-description"><?php echo _("ms"); ?></label>
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Protocol"); ?></label>
        <select id="tcp_proto3" name="tcp_proto3" class="cbi-input-select" onchange="tcpProtocolChange(3)">
          <?php $i = 0; ?>
          <?php foreach($tcp_proto as $proto): ?>
            <?php if ($i == 0) { ?>
              <option value="<?php echo $i ?>" selected=""><?php echo $proto ?></option>
            <?php } else {?> 
              <option value="<?php echo $i ?>"><?php echo $proto ?></option>
            <?php } ?> 
            <?php $i++; ?>
          <?php endforeach ?>
        </select>
      </div>

      <div class="cbi-value" id="tcp_page_protocol_modbus3" name="tcp_page_protocol_modbus3">
        <label class="cbi-value-title"><?php echo _("Command Interval"); ?></label>
        <input type="text" class="cbi-input-text" name="tcp_cmd_interval3" id="tcp_cmd_interval3" value="2" />
        <label class="cbi-value-description"><?php echo _("ms"); ?></label>
      </div>

      <div class="cbi-value" id="tcp_page_protocol_transparent3" name="tcp_page_protocol_transparent3">
        <label class="cbi-value-title"><?php echo _("Reporting Center"); ?></label>
        <input type="text" class="cbi-input-text" name="tcp_report_center3" id="tcp_report_center3" />
        <label class="cbi-value-description"><?php echo _("1-2-3-4-5"); ?></label>
      </div>

      <div id="tcp_page_protocol_s73" name="tcp_page_protocol_s73">
        <div class="cbi-value">
          <label class="cbi-value-title"><?php echo _("Rack"); ?></label>
          <input type="text" class="cbi-input-text" name="rack3" id="rack3" />
        </div>
        <div class="cbi-value">
          <label class="cbi-value-title"><?php echo _("Slot"); ?></label>
          <input type="text" class="cbi-input-text" name="slot3" id="slot3" />
        </div>
      </div>
      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Connection Status"); ?></label>
        <?php 
            exec("uci -P /var/state get dct.connection.tcp_status2", $status);
        ?>
        <label id="connect_status3" name="connect_status3"><?php echo _(($status[0] != null) ? $status[0] : "-"); ?></label>
      </div>
    </div><!-- /.page_tcp -->
  </div><!-- /.row -->
</div><!-- /.tab-pane | basic tab -->

