<div class="tab-pane fade" id="com4">
  <div class="row">
    <div class="cbi-value">
      <label class="cbi-value-title"><?php echo _("Enabled"); ?></label>
      <input class="cbi-input-radio" id="com_enable4" name="com_enabled4" value="1" type="radio" checked onchange="enableCom(true, 4)">
      <label ><?php echo _("Enable"); ?></label>

      <input class="cbi-input-radio" id="com_disable4" name="com_enabled4" value="0" type="radio" onchange="enableCom(false, 4)">
      <label ><?php echo _("Disable"); ?></label>
    </div>

    <div id="page_com4" name="page_com4">
      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Baudrate"); ?></label>
        <select id="baudrate4" name="baudrate4" class="cbi-input-select">
          <option value="1200">1200</option>
          <option value="2400">2400</option>
          <option value="4800">4800</option>
          <option value="9600" selected="">9600</option>
          <option value="19200">19200</option>
          <option value="38400">38400</option>
          <option value="57600">57600</option>
          <option value="115200">115200</option>
          <option value="230400">230400</option>
        </select>
      </div> 

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Databit"); ?></label>
        <select id="databit4" name="databit4" class="cbi-input-select">
          <option value="7">7</option>
          <option value="8" selected="">8</option>
        </select>
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Stopbit"); ?></label>
        <select id="stopbit4" name="stopbit4" class="cbi-input-select">
          <option value="1" selected="">1</option>
          <option value="2">2</option>
        </select>
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Parity"); ?></label>
        <select id="parity4" name="parity4" class="cbi-input-select">
          <option value="N" selected="">None</option>
          <option value="O">Odd</option>
          <option value="E">Even</option>
        </select>
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Frame Interval"); ?></label>
        <input type="text" class="cbi-input-text" name="com_frame_interval4" id="com_frame_interval4" value="200" />
        <label class="cbi-value-description"><?php echo _("ms"); ?></label>
      </div>

      <div class="cbi-value">
        <label class="cbi-value-title"><?php echo _("Protocol"); ?></label>
        <select id="com_proto4" name="com_proto4" class="cbi-input-select" onchange="comProtocolChange(4)">
          <?php $i = 0; ?>
          <?php foreach($com_proto as $proto): ?>
            <?php if ($i == 0) { ?>
              <option value="<?php echo $i ?>" selected=""><?php echo $proto ?></option>
            <?php } else {?> 
              <option value="<?php echo $i ?>"><?php echo $proto ?></option>
            <?php } ?> 
            <?php $i++; ?>
          <?php endforeach ?>
        </select>
      </div>

      <div class="cbi-value" id="com_page_protocol_modbus4" name="com_page_protocol_modbus4">
        <label class="cbi-value-title"><?php echo _("Command Interval"); ?></label>
        <input type="text" class="cbi-input-text" name="com_cmd_interval4" id="com_cmd_interval4" value="2" />
        <label class="cbi-value-description"><?php echo _("ms"); ?></label>
      </div>

      <div class="cbi-value" id="com_page_protocol_transparent4" name="com_page_protocol_transparent4">
        <label class="cbi-value-title"><?php echo _("Reporting Center"); ?></label>
        <input type="text" class="cbi-input-text" name="com_report_center4" id="com_report_center4" />
        <label class="cbi-value-description"><?php echo _("1-2-3-4-5"); ?></label>
      </div>
    </div><!-- /.page_com -->
  </div><!-- /.row -->
</div><!-- /.tab-pane | basic tab -->

