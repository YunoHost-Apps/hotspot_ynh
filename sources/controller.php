<?php

function moulinette_get($var) {
  return htmlspecialchars(exec("sudo yunohost app setting hotspot ".escapeshellarg($var)));
}

function moulinette_set($var, $value) {
  return exec("sudo yunohost app setting hotspot ".escapeshellarg($var)." -v ".escapeshellarg($value));
}

function restart_service() {
  exec('sudo service ynh-hotspot stop');
  exec('sudo service ynh-hotspot start', $output, $retcode);

  return $retcode;
}

dispatch('/', function() {
  set('title', T_('Wifi Hotspot'));

  exec('ip link', $devs);
  $wifi_device = moulinette_get('wifi_device');
  $devs_list = "";

  foreach($devs AS $dev) {
    if(preg_match('/^[0-9]/', $dev)) {
      $dev = explode(':', $dev);
      $dev = trim($dev[1]);

      if($dev != 'lo') {
        $active = ($dev == $wifi_device) ? 'class="active"' : '';
        $devs_list .= "<li $active><a href='#'>$dev</a></li>\n";
      }
    }
  }

  set('wifi_ssid', moulinette_get('wifi_ssid'));
  set('wifi_passphrase', moulinette_get('wifi_passphrase'));
  set('wifi_channel', moulinette_get('wifi_channel'));
  set('wifi_device', $wifi_device);
  set('wifi_device_list', $devs_list);
  set('ip6_net', moulinette_get('ip6_net'));
  set('ip6_dns0', moulinette_get('ip6_dns0'));
  set('ip6_dns1', moulinette_get('ip6_dns1'));
  set('ip4_nat_prefix', moulinette_get('ip4_nat_prefix'));
  set('ip4_dns0', moulinette_get('ip4_dns0'));
  set('ip4_dns1', moulinette_get('ip4_dns1'));

  return render('settings.html.php');
});

dispatch_put('/settings', function() {
  moulinette_set('wifi_ssid', $_POST['wifi_ssid']);
  moulinette_set('wifi_passphrase', $_POST['wifi_passphrase']);
  moulinette_set('wifi_channel', $_POST['wifi_channel']);
  moulinette_set('wifi_device', $_POST['wifi_device']);
  moulinette_set('ip6_net', $_POST['ip6_net']);
  moulinette_set('ip6_dns0', $_POST['ip6_dns0']);
  moulinette_set('ip6_dns1', $_POST['ip6_dns1']);
  moulinette_set('ip4_nat_prefix', $_POST['ip4_nat_prefix']);
  moulinette_set('ip4_dns0', $_POST['ip4_dns0']);
  moulinette_set('ip4_dns1', $_POST['ip4_dns1']);

  $retcode = restart_service();

  if($retcode == 0) {
    flash('success', T_('Configuration updated and service successfully reloaded'));
  } else {
    flash('error', T_('Configuration updated but service reload failed'));
  }

  redirect_to('/');
});

dispatch('/lang/:locale', function($locale = 'en') {
  switch ($locale) {
    case 'fr':
      $_SESSION['locale'] = 'fr';
      break;

    default:
      $_SESSION['locale'] = 'en';
  }

  if(!empty($_GET['redirect_to'])) {
    redirect_to($_GET['redirect_to']);
  } else {
    redirect_to('/');
  }
});
