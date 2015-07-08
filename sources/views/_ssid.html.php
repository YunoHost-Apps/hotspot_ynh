<div class="panel panel-default ssid enabled" <?= $service_enabled == 0 ? 'style="display: none"' : '' ?>>
  <div class="panel-heading">
    <h3 class="panel-title" data-label="<?= _("Hotspot") ?>"><?= _("Hotspot") ?> <?= $ssid['id'] + 1 ?></h3>
  </div>

  <ul class="nav nav-tabs nav-justified">
    <li role="presentation" data-tab="wifi" class="active"><a href="#"><?= _("Wifi") ?></a></li>
    <li role="presentation" data-tab="ipv6"><a href="#"><?= _("IPv6") ?></a></li>
    <li role="presentation" data-tab="ipv4"><a href="#"><?= _("IPv4") ?></a></li>
  </ul>

  <!-- Wifi -->
  <div class="tabs tabwifi">
    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('Name (SSID)') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][wifi_ssid]" placeholder="myNeutralNetwork" value="<?= $ssid['wifi_ssid'] ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="wifi_secure" class="col-sm-3 control-label"><?= _('Secure') ?></label>
      <div class="col-sm-9 input-group-btn" data-toggle="tooltip" data-title="<?= _('Disabling the Secure Wifi allows everyone to join the hotspot and spy the traffic (but it\'s perfect for a PirateBox)') ?>">
        <div class="input-group">
          <input type="checkbox" class="form-control switch wifi_secure" name="ssid[<?= $ssid['id'] ?>][wifi_secure]" value="1" <?= $ssid['wifi_secure'] == 1 ? 'checked="checked"' : '' ?> />
        </div>
      </div>
    </div>

    <div class="form-group wifi_passphrase" <?= $ssid['wifi_secure'] == 0 ? 'style="display: none"' : '' ?>>
      <label class="col-sm-3 control-label"><?= _('Password (WPA2)') ?></label>
      <div class="input-group col-sm-9" style="padding: 0 15px">
        <input type="text" data-toggle="tooltip" data-title="<?= _('At least 8 characters') ?>" class="form-control" name="ssid[<?= $ssid['id'] ?>][wifi_passphrase]" placeholder="VhegT8oev0jZI" value="<?= $ssid['wifi_passphrase'] ?>" />
        <a class="btn input-group-addon wifiparty" data-toggle="tooltip" data-title="<?= _('Show to your friends how to access to your hotspot') ?>"><span class="glyphicon glyphicon-fullscreen"></span></a>
      </div>
    </div>
  </div>

  <!-- IPv6 -->
  <div class="tabs tabipv6" style="display: none">
    <?php if(empty($ssid['ip6_net'])): ?>
      <div class="alert alert-dismissible alert-warning fade in" style="margin: 2px 2px 17px" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong><?= _('Notice') ?>:</strong> <?= _("Currently, your wifi clients don't have IPv6 and it's a very bad thing. Ask your Internet Service Provider an IPv6 delegated prefix, or") ?>
        <a href="http://db.ffdn.org" class="alert-link"><?= _('change providers') ?></a>!
      </div>
    <?php endif; ?>

    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('Delegated prefix') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][ip6_net]" placeholder="2001:db8:42::" value="<?= $ssid['ip6_net'] ?>" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('First DNS resolver') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][ip6_dns0]" placeholder="2001:913::8" value="<?= $ssid['ip6_dns0'] ?>" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('Second DNS resolver') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][ip6_dns1]" placeholder="2001:910:800::40" value="<?= $ssid['ip6_dns1'] ?>" />
      </div>
    </div>
  </div>

  <!-- IPv4 -->
  <div class="tabs tabipv4" style="display: none">
    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('NAT prefix (/24)') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][ip4_nat_prefix]" placeholder="10.0.242" value="<?= $ssid['ip4_nat_prefix'] ?>" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('First DNS resolver') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][ip4_dns0]" placeholder="80.67.188.188" value="<?= $ssid['ip4_dns0'] ?>" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label"><?= _('Second DNS resolver') ?></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ssid[<?= $ssid['id'] ?>][ip4_dns1]" placeholder="80.67.169.12" value="<?= $ssid['ip4_dns1'] ?>" />
      </div>
    </div>
  </div>

  <div class="deletessid" style="display: none">
    <button type="button" class="btn btn-danger"><?= _("Delete") ?></button>
  </div>

  <div class="wifiparty_passphrase"><?php
    $pw = preg_replace('/[^0-9a-z ]/i', '<span-class="passother">$0</span>', $ssid['wifi_passphrase']);
    $pw = preg_replace('/\d/', '<span-class="passdigit">$0</span>', $pw);
    $pw = preg_replace('/ /', '<span class="passspace">&#x25AE;</span>', $pw);
    $pw = preg_replace('/span-class/', 'span class', $pw);

    echo $pw;
  ?></div>
</div>

