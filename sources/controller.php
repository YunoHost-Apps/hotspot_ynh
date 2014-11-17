<?php

function moulinette_get($var) {
  return htmlspecialchars(exec('sudo yunohost app setting hotspot '.escapeshellarg($var)));
}

function moulinette_set($var, $value) {
  return exec('sudo yunohost app setting hotspot '.escapeshellarg($var).' -v '.escapeshellarg($value));
}

function stop_service() {
  exec('sudo service ynh-hotspot stop');
}

function start_service() {
  exec('sudo service ynh-hotspot start', $output, $retcode);

  return $retcode;
}

function service_status() {
  exec('sudo service ynh-hotspot status', $output);

  return $output;
}

function service_faststatus() {
  exec('sudo service hostapd status', $output, $retcode);

  return $retcode;
}

function ipv6_expanded($ip) {
  exec('ipv6_expanded '.escapeshellarg($ip), $output);

  return $output[0];
}

function ipv6_compressed($ip) {
  exec('ipv6_compressed '.escapeshellarg($ip), $output);

  return $output[0];
}

dispatch('/', function() {
  exec('sudo iwconfig', $devs);
  $wifi_device = moulinette_get('wifi_device');
  $devs_list = '';

  foreach($devs AS $dev) {
    if(preg_match('/802.11/', $dev)) {
      $dev = explode(' ', $dev);
      $dev = $dev[0];

      $active = ($dev == $wifi_device) ? 'class="active"' : '';
      $devs_list .= "<li $active><a href='#'>$dev</a></li>\n";
    }
  }

  $ip6_net = moulinette_get('ip6_net');
  $ip6_net = ($ip6_net == 'none') ? '' : $ip6_net;

  set('wifi_ssid', moulinette_get('wifi_ssid'));
  set('wifi_passphrase', moulinette_get('wifi_passphrase'));
  set('wifi_channel', moulinette_get('wifi_channel'));
  set('wifi_n', moulinette_get('wifi_n'));
  set('wifi_device', $wifi_device);
  set('wifi_device_list', $devs_list);
  set('ip6_net', $ip6_net);
  set('ip6_dns0', moulinette_get('ip6_dns0'));
  set('ip6_dns1', moulinette_get('ip6_dns1'));
  set('ip4_nat_prefix', moulinette_get('ip4_nat_prefix'));
  set('ip4_dns0', moulinette_get('ip4_dns0'));
  set('ip4_dns1', moulinette_get('ip4_dns1'));
  set('faststatus', service_faststatus() == 0);

  return render('settings.html.php');
});

dispatch_put('/settings', function() {
  exec('ip link show '.escapeshellarg($_POST['wifi_device']), $output, $retcode);
  $wifi_device_exists = ($retcode == 0);

  $ip6_net = empty($_POST['ip6_net']) ? 'none' : $_POST['ip6_net'];
  $ip6_addr = 'none';

  try {
    if(empty($_POST['wifi_ssid']) || empty($_POST['wifi_passphrase']) || empty($_POST['wifi_channel'])) {
      throw new Exception(T_('Your Wifi Hotspot needs a name, a password and a channel'));
    }

    if(strlen($_POST['wifi_passphrase']) < 8 || strlen($_POST['wifi_passphrase']) > 63) {
      throw new Exception(T_('Your password must from 8 to 63 characters (WPA2 passphrase)'));
    }

    if(preg_match('/[^[:print:]]/', $_POST['wifi_passphrase'])) {
      throw new Exception(T_('Only printable ASCII characters are permitted in your password'));
    }

    if(!$wifi_device_exists) {
      throw new Exception(T_('The wifi antenna interface seems not exist on the system'));
    }

    if($ip6_net != 'none') {
      $ip6_net = ipv6_expanded($ip6_net);
  
      if(empty($ip6_net)) {
        throw new Exception(T_('The IPv6 Delegated Prefix format looks bad'));
      }
  
      $ip6_blocs = explode(':', $ip6_net);
      $ip6_addr = "${ip6_blocs[0]}:${ip6_blocs[1]}:${ip6_blocs[2]}:${ip6_blocs[3]}:${ip6_blocs[4]}:${ip6_blocs[5]}:${ip6_blocs[6]}:42";
  
      $ip6_net = ipv6_compressed($ip6_net);
      $ip6_addr = ipv6_compressed($ip6_addr);
    }

    $ip6_dns0 = ipv6_expanded($ip6_dns0);

    if(empty($_POST['ip6_dns0'])) {
      throw new Exception(T_('The format of the first IPv6 DNS Resolver looks bad'));
    }

    $ip6_dns0 = ipv6_compressed($ip6_dns0);
    $ip6_dns1 = ipv6_expanded($ip6_dns1);

    if(empty($_POST['ip6_dns1'])) {
      throw new Exception(T_('The format of the second IPv6 DNS Resolver looks bad'));
    }

    $ip6_dns1 = ipv6_compressed($ip6_dns1);

    if(inet_pton($_POST['ip4_dns0']) === false) {
      throw new Exception(T_('The format of the first IPv4 DNS Resolver looks bad'));
    }

    if(inet_pton($_POST['ip4_dns1']) === false) {
      throw new Exception(T_('The format of the second IPv4 DNS Resolver looks bad'));
    }

    if(inet_pton("${_POST['ip4_nat_prefix']}.0") === false) {
      throw new Exception(T_('The format of the IPv4 NAT Prefix (/24) looks bad : x.x.x expected)'));
    }

    if(filter_var("${_POST['ip4_nat_prefix']}.0", FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== false) {
      throw new Exception(T_('The IPv4 NAT Prefix must be from a private range'));
    }

  } catch(Exception $e) {
    flash('error', $e->getMessage().T_(' (configuration not updated).'));
    goto redirect;
  }

  stop_service();

  moulinette_set('wifi_ssid', $_POST['wifi_ssid']);
  moulinette_set('wifi_passphrase', $_POST['wifi_passphrase']);
  moulinette_set('wifi_channel', $_POST['wifi_channel']);
  moulinette_set('wifi_n', isset($_POST['wifi_n']) ? 1 : 0);
  moulinette_set('wifi_device', $_POST['wifi_device']);
  moulinette_set('ip6_net', $ip6_net);
  moulinette_set('ip6_addr', $ip6_addr);
  moulinette_set('ip6_dns0', $_POST['ip6_dns0']);
  moulinette_set('ip6_dns1', $_POST['ip6_dns1']);
  moulinette_set('ip4_nat_prefix', $_POST['ip4_nat_prefix']);
  moulinette_set('ip4_dns0', $_POST['ip4_dns0']);
  moulinette_set('ip4_dns1', $_POST['ip4_dns1']);

  $retcode = start_service();

  if($retcode == 0) {
    flash('success', T_('Configuration updated and service successfully reloaded'));
  } else {
    flash('error', T_('Configuration updated but service reload failed'));
  }

  redirect:
  redirect_to('/');
});

dispatch('/status', function() {
  $status_lines = service_status();
  $status_list = '';

  foreach($status_lines AS $status_line) {
    if(preg_match('/^\[INFO\]/', $status_line)) {
      $status_list .= "<li class='status-info'>${status_line}</li>";
    }
    elseif(preg_match('/^\[OK\]/', $status_line)) {
      $status_list .= "<li class='status-success'>${status_line}</li>";
    }
    elseif(preg_match('/^\[WARN\]/', $status_line)) {
      $status_list .= "<li class='status-warning'>${status_line}</li>";
    }
    elseif(preg_match('/^\[ERR\]/', $status_line)) {
      $status_list .= "<li class='status-danger'>${status_line}</li>";
    }
  }

  echo $status_list;
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
