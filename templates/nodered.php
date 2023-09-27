<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <?php echo _("Node Red"); ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /.card-header -->

      <div class="card-body">
        <div class="row">
          <div class="col-sm-6 align-items-stretch">
            <div class="card h-100">
              <div class="card-body wireless">
                    <h4 class="card-title"><?php echo _("Node Red"); ?></h4>
                    <div class="row ml-1">
                        <div class="col-sm">
                        <div class="row mb-1">
                            <div class="col-xs-3" style="color: #858796; width: 10rem"><?php echo _("Version:"); ?></div><div class="col-xs-3"><?php echo $version[0]; ?></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-xs-3" style="color: #858796; width: 10rem"><?php echo _("Status:"); ?></div>
                            <div class="col-xs-3">
                                <?php echo _(($run_status[0] != null) ? "<font color=\"green\">Runing</font>" : "<font color=\"red\">Stop</font>"); ?>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-xs-3" style="color: #858796; width: 10rem"><?php echo _("URL Entry:"); ?></div>
                            <input class="btn btn-outline btn-primary" type="submit" value="Node-RED" onClick="window.open(window.location.protocol+'//'+window.location.host+':1880','nr');">
                        </div>
                        <form method="POST" action="nodered" role="form">
                          <?php echo CSRFTokenFieldTag() ?>
                          <div class="row mb-1">
                            <input class="btn btn-success" type="submit" value="<?php echo _("Restart"); ?>" name="restart" />
                          </div>
                        </form>
                        </div>
                    </div>
              </div><!-- /.card-body -->
            </div><!-- /.card -->
          </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
      </div><!-- /.card-body -->
    </div><!-- /.card -->
  </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
