<h2><?= T_("Wifi Hotspot Configuration") ?></h2>
<?php if($faststatus): ?>
  <span class="label label-success" data-toggle="tooltip" data-title="<?= T_('This is a fast status. Click on More details to show the complete status.') ?>"><?= T_('Running') ?></span>
<?php else: ?>
  <span class="label label-danger" data-toggle="tooltip" data-title="<?= T_('This is a fast status. Click on More details to show the complete status.') ?>"><?= T_('Not Running') ?></span>
<?php endif; ?>

 &nbsp; <img src="public/img/loading.gif" id="status-loading" alt="Loading..." /><a href="#" id="statusbtn" data-toggle="tooltip" data-title="<?= T_('Loading complete status may take a few minutes. Be patient.') ?>"><?= T_('More details') ?></a>

<div id="status" class="alert alert-dismissible alert-info fade in" style="margin-top: 10px" role="alert">
  <button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <div id="status-text"></div>
</div>

<hr />

<div class="row">
  <div class="col-sm-offset-2 col-sm-8">
    <form method="post" enctype="multipart/form-data" action="?/settings" class="form-horizontal" role="form" id="form">
      <input type="hidden" name="_method" value="put" />

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?= T_("Wifi") ?></h3>
        </div>

        <div style="padding: 14px 14px 0 10px">
          <div class="form-group">
            <label for="wifi_ssid" class="col-sm-3 control-label"><?= T_('Name (SSID)') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="wifi_ssid" id="wifi_ssid" placeholder="myNeutralNetwork" value="<?= $wifi_ssid ?>" />
            </div>
          </div>
  
          <div class="form-group">
            <label for="wifi_passphrase" class="col-sm-3 control-label"><?= T_('Password (WPA2)') ?></label>
            <div class="col-sm-9">
              <input type="text" data-toggle="tooltip" data-title="<?= T_('At least 8 characters') ?>" class="form-control" name="wifi_passphrase" id="wifi_passphrase" placeholder="VhegT8oev0jZI" value="<?= $wifi_passphrase ?>" />
            </div>
          </div>
  
          <div class="form-group">
            <label for="wifi_channel" class="col-sm-3 control-label"><?= T_('Channel') ?></label>
            <div class="col-sm-9 input-group-btn">
              <div class="input-group">
                  <input type="text" name="wifi_channel" id="wifi_channel" value="<?= $wifi_channel ?>" style="display: none" />
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?= $wifi_channel ?> <span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-left" role="menu">
                    <li <?= $wifi_channel == 1 ? 'class="active"' : '' ?>><a href="#">1</a></li>
                    <li <?= $wifi_channel == 2 ? 'class="active"' : '' ?>><a href="#">2</a></li>
                    <li <?= $wifi_channel == 3 ? 'class="active"' : '' ?>><a href="#">3</a></li>
                    <li <?= $wifi_channel == 4 ? 'class="active"' : '' ?>><a href="#">4</a></li>
                    <li <?= $wifi_channel == 5 ? 'class="active"' : '' ?>><a href="#">5</a></li>
                    <li <?= $wifi_channel == 6 ? 'class="active"' : '' ?>><a href="#">6</a></li>
                    <li <?= $wifi_channel == 7 ? 'class="active"' : '' ?>><a href="#">7</a></li>
                    <li <?= $wifi_channel == 8 ? 'class="active"' : '' ?>><a href="#">8</a></li>
                    <li <?= $wifi_channel == 9 ? 'class="active"' : '' ?>><a href="#">9</a></li>
                    <li <?= $wifi_channel == 10 ? 'class="active"' : '' ?>><a href="#">10</a></li>
                    <li <?= $wifi_channel == 11 ? 'class="active"' : '' ?>><a href="#">11</a></li>
                  </ul>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="wifi_passphrase" class="col-sm-3 control-label"><?= T_('Wifi N') ?></label>
            <div class="col-sm-9 input-group-btn" data-toggle="tooltip" data-title="<?= T_('Only if your antenna is 802.11n compliant') ?>">
              <div class="input-group">
                <input type="checkbox" class="form-control switch" name="wifi_n" id="wifi_n" value="1" <?= $wifi_n == 1 ? 'checked="checked"' : '' ?> />
              </div>
            </div>
          </div>
  
          <div class="form-group">
            <label for="wifi_device" class="col-sm-3 control-label"><?= T_('Device') ?></label>
            <div class="col-sm-9 input-group-btn">
              <div class="input-group">
                  <input type="text" name="wifi_device" id="wifi_device" value="<?= $wifi_device ?>" style="display: none" />
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?= $wifi_device ?> <span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-left" role="menu">
                    <?= $wifi_device_list ?>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title" data-toggle="tooltip" data-title="<?= T_('Real Internet') ?>"><?= T_("IPv6") ?></h3>
        </div>

        <div style="padding: 14px 14px 0 10px">
          <?php if(empty($ip6_net)): ?>
            <div class="alert alert-dismissible alert-warning fade in" style="margin: 2px 2px 17px" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <strong><?= T_('Notice') ?>:</strong> <?= T_("Currently, your wifi clients don't have IPv6 and it's a very bad thing. Ask your Internet Service Provider an IPv6 delegated prefix, or") ?>
              <a href="http://db.ffdn.org" class="alert-link"><?= T_('change providers') ?></a>!
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="ip6_net" class="col-sm-3 control-label"><?= T_('Delegated prefix') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ip6_net" id="ip6_net" placeholder="2001:db8:42::" value="<?= $ip6_net ?>" />
            </div>
          </div>

          <div class="form-group">
            <label for="ip6_dns0" class="col-sm-3 control-label"><?= T_('First DNS resolver') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ip6_dns0" id="ip6_dns0" placeholder="2001:913::8" value="<?= $ip6_dns0 ?>" />
            </div>
          </div>

          <div class="form-group">
            <label for="ip6_dns1" class="col-sm-3 control-label"><?= T_('Second DNS resolver') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ip6_dns1" id="ip6_dns1" placeholder="2001:910:800::40" value="<?= $ip6_dns1 ?>" />
            </div>
          </div>
        </div>
      </div>

      <div class="panel panel-danger">
        <div class="panel-heading">
          <h3 class="panel-title" data-toggle="tooltip" data-title="<?= T_('Old Internet') ?>"><?= T_("IPv4") ?></h3>
        </div>

        <div style="padding: 14px 14px 0 10px">
          <div class="form-group">
            <label for="ip4_nat_prefix" class="col-sm-3 control-label"><?= T_('NAT prefix (/24)') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ip4_nat_prefix" id="ip4_nat_prefix" placeholder="10.0.242" value="<?= $ip4_nat_prefix ?>" />
            </div>
          </div>

          <div class="form-group">
            <label for="ip4_dns0" class="col-sm-3 control-label"><?= T_('First DNS resolver') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ip4_dns0" id="ip4_dns0" placeholder="80.67.188.188" value="<?= $ip4_dns0 ?>" />
            </div>
          </div>

          <div class="form-group">
            <label for="ip4_dns1" class="col-sm-3 control-label"><?= T_('Second DNS resolver') ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ip4_dns1" id="ip4_dns1" placeholder="80.67.169.12" value="<?= $ip4_dns1 ?>" />
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div style="text-align: center">
          <button type="submit" class="btn btn-default" data-toggle="tooltip" id="save" data-title="<?= T_('Reloading may take a few minutes. Be patient.') ?>"><?= T_('Save and reload') ?></button> <img src="public/img/loading.gif" id="save-loading" alt="Loading..." />
        </div>
      </div>
    </form>
  </div>
</div>
