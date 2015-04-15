<!--
  Wifi Hotspot app for YunoHost 
  Copyright (C) 2015 Julien Vaubourg <julien@vaubourg.com>
  Contribute at https://github.com/jvaubourg/hotspot_ynh
  
  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.
  
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.
  
  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->

<div id="wifiparty_screen">
<div id="wifiparty_ssid_part">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default" id="wifiparty_close"><span class="glyphicon glyphicon-eye-close"></span></button>
    <button type="button" class="btn btn-default" id="wifiparty_zoomin_ssid"><span class="glyphicon glyphicon-zoom-in"></span></button>
    <button type="button" class="btn btn-default" id="wifiparty_zoomout_ssid"><span class="glyphicon glyphicon-zoom-out"></span></button>
  </div>

  <span id="wifiparty_ssid"><span class="glyphicon glyphicon-signal"></span> <?= $wifi_ssid ?></span>
</div>

<div class="btn-group" role="group">
  <button type="button" class="btn btn-default" id="wifiparty_zoomin_passphrase"><span class="glyphicon glyphicon-zoom-in"></span></button>
  <button type="button" class="btn btn-default" id="wifiparty_zoomout_passphrase"><span class="glyphicon glyphicon-zoom-out"></span></button>
</div>

<div id="wifiparty_passphrase"><?php
  $pw = preg_replace('/[^0-9a-z ]/i', '<span-class="passother">$0</span>', $wifi_passphrase);
  $pw = preg_replace('/\d/', '<span-class="passdigit">$0</span>', $pw);
  $pw = preg_replace('/ /', '<span class="passspace">&#x25AE;</span>', $pw);
  $pw = preg_replace('/span-class/', 'span class', $pw);
  echo $pw;
?></div>
</div>

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
          <h3 class="panel-title"><?= T_("Service") ?></h3>
        </div>

        <div style="padding: 14px 14px 0 10px">
          <div class="form-group">
            <label for="wifi_secure" class="col-sm-3 control-label"><?= T_('Hotspot Enabled') ?></label>
            <div class="col-sm-9 input-group-btn">
              <div class="input-group">
                <input type="checkbox" class="form-control switch" name="service_enabled" id="service_enabled" value="1" <?= $service_enabled == 1 ? 'checked="checked"' : '' ?> />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="panel panel-default enabled" <?= $service_enabled == 0 ? 'style="display: none"' : '' ?>>
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
            <label for="wifi_secure" class="col-sm-3 control-label"><?= T_('Secure') ?></label>
            <div class="col-sm-9 input-group-btn" data-toggle="tooltip" data-title="<?= T_('Disabling the Secure Wifi allows everyone to join the hotspot and spy the traffic (but it\'s perfect for a PirateBox)') ?>">
              <div class="input-group">
                <input type="checkbox" class="form-control switch" name="wifi_secure" id="wifi_secure" value="1" <?= $wifi_secure == 1 ? 'checked="checked"' : '' ?> />
              </div>
            </div>
          </div>
  
          <div class="form-group secure" <?= $wifi_secure == 0 ? 'style="display: none"' : '' ?>>
            <label for="wifi_passphrase" class="col-sm-3 control-label"><?= T_('Password (WPA2)') ?></label>
            <div class="input-group col-sm-9" style="padding: 0 15px">
              <input type="text" data-toggle="tooltip" data-title="<?= T_('At least 8 characters') ?>" class="form-control" name="wifi_passphrase" id="wifi_passphrase" placeholder="VhegT8oev0jZI" value="<?= $wifi_passphrase ?>" />
              <a class="btn input-group-addon" id="wifiparty" data-toggle="tooltip" data-title="<?= T_('Show to your friends how to access to your hotspot') ?>"><span class="glyphicon glyphicon-fullscreen"></span></a>
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

          <div class="form-group" style="display: none">
            <label for="wifi_n" class="col-sm-3 control-label"><?= T_('Wifi N') ?></label>
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

      <div class="panel panel-success enabled" <?= $service_enabled == 0 ? 'style="display: none"' : '' ?>>
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

      <div class="panel panel-danger enabled" <?= $service_enabled == 0 ? 'style="display: none"' : '' ?>>
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
<?php if($is_connected_through_hotspot): ?>
          <div class="alert alert-dismissible alert-warning fade in" role="alert" id="saveconfirmation">
            <strong><?= T_('Notice') ?>:</strong> <?= T_("You are currently connected through the wifi hotspot. Please, confirm the reloading, wait for the wifi disconnect/reconnect and go back here to check that everything is okay.") ?>
            <div id="confirm">
              <button type="submit" class="btn btn-default" data-toggle="tooltip" id="save" data-title="<?= T_('Reloading may take a few minutes. Be patient.') ?>"><?= T_('Confirm') ?></button> <img src="public/img/loading.gif" id="save-loading" alt="Loading..." />
            </div>
          </div>

          <button type="button" class="btn btn-default" id="saveconfirm"><?= T_('Save and reload') ?></button>
<?php else: ?>
          <button type="submit" class="btn btn-default" data-toggle="tooltip" id="save" data-title="<?= T_('Reloading may take a few minutes. Be patient.') ?>"><?= T_('Save and reload') ?></button> <img src="public/img/loading.gif" id="save-loading" alt="Loading..." />
<?php endif; ?>
        </div>
      </div>
    </form>
  </div>
</div>
