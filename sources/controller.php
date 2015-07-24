<?php

/* Wifi Hotspot app for YunoHost 
 * Copyright (C) 2015 Julien Vaubourg <julien@vaubourg.com>
 * Contribute at https://github.com/labriqueinternet/hotspot_ynh
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function ynh_setting_get($setting) {
  $value = exec("sudo grep \"^$setting:\" /etc/yunohost/apps/hotspot/settings.yml");
  $value = preg_replace('/^[^:]+:\s*["\']?/', '', $value);
  $value = preg_replace('/\s*["\']$/', '', $value);

  return htmlspecialchars($value);
}

function ynh_setting_set($setting, $value) {
  return exec('sudo yunohost app setting hotspot '.escapeshellarg($setting).' -v '.escapeshellarg($value));
}

function stop_service() {
  exec('sudo systemctl stop ynh-hotspot');
}

function start_service() {
  exec('sudo systemctl start ynh-hotspot', $output, $retcode);

  return $retcode;
}

function service_status() {
  exec('sudo ynh-hotspot status', $output);

  return $output;
}

function service_faststatus() {
  exec('sudo systemctl is-active hostapd', $output, $retcode);

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

function iw_multissid($nic) {
  exec('sudo iw_multissid '.escapeshellarg($nic), $output);

  return $output[0];
}

function iw_devices() {
  exec('sudo iw_devices', $output);

  return getArray($output[0]);
}

function getArray($str) {
  return explode('|', $str);
}

function noneValue($str) {
  return ($str == 'none') ? '' : $str;
}

function is_connected_through_hotspot($ip6_net, $ip4_nat_prefix) {
  $ip = $_SERVER['REMOTE_ADDR'];

  foreach($ip6_net as $net) {
    $ip6_regex = '/^'.preg_quote(preg_replace('/::$/', '', $net)).':/';

    if(preg_match($ip6_regex, $ip)) {
      return true;
    }
  }

  foreach($ip4_nat_prefix as $prefix) {
    $ip4_regex = '/^'.preg_quote($prefix).'\./';

    if(preg_match($ip4_regex, $ip)) {
      return true;
    }
  }

  return false;
}

dispatch('/', function() {
  $ssids = array();
  $devs = iw_devices();
  $devs_list = '';

  $wifi_device = ynh_setting_get('wifi_device');
  $multissid = ynh_setting_get('multissid');
  $wifi_channel = ynh_setting_get('wifi_channel');

  foreach($devs AS $dev) {
    $dev_multissid = iw_multissid($dev);

    $active = ($dev == $wifi_device) ? 'class="active"' : '';
    $devs_list .= "<li $active data-multissid='$dev_multissid'><a href='#'>$dev</a></li>\n";
  }

  $wifi_ssid = getArray(ynh_setting_get('wifi_ssid'));
  $wifi_secure = getArray(ynh_setting_get('wifi_secure'));
  $wifi_passphrase = getArray(ynh_setting_get('wifi_passphrase'));
  $ip6_net = getArray(ynh_setting_get('ip6_net'));
  $ip6_dns0 = getArray(ynh_setting_get('ip6_dns0'));
  $ip6_dns1 = getArray(ynh_setting_get('ip6_dns1'));
  $ip4_nat_prefix = getArray(ynh_setting_get('ip4_nat_prefix'));
  $ip4_dns0 = getArray(ynh_setting_get('ip4_dns0'));
  $ip4_dns1 = getArray(ynh_setting_get('ip4_dns1'));

  for($i = 0; $i < $multissid; $i++) {
    $ssid = [
      'id' => $i,
      'wifi_ssid' => noneValue($wifi_ssid[$i]),
      'wifi_secure' => noneValue($wifi_secure[$i]),
      'wifi_passphrase' => noneValue($wifi_passphrase[$i]),
      'ip6_net' => noneValue($ip6_net[$i]),
      'ip6_dns0' => noneValue($ip6_dns0[$i]),
      'ip6_dns1' => noneValue($ip6_dns1[$i]),
      'ip4_nat_prefix' => noneValue($ip4_nat_prefix[$i]),
      'ip4_dns0' => noneValue($ip4_dns0[$i]),
      'ip4_dns1' => noneValue($ip4_dns1[$i]),
    ];

    array_push($ssids, $ssid);
  }

  $ip6_net = ynh_setting_get('ip6_net');
  $ip6_net = ($ip6_net == 'none') ? '' : getArray($ip6_net);
  $ip4_nat_prefix = getArray(ynh_setting_get('ip4_nat_prefix'));

  set('service_enabled', ynh_setting_get('service_enabled'));
  set('ssids', $ssids);
  set('wifi_device', $wifi_device);
  set('wifi_channel', $wifi_channel);
  set('wifi_device_list', $devs_list);
  set('faststatus', service_faststatus() == 0);
  set('is_connected_through_hotspot', is_connected_through_hotspot($ip6_net, $ip4_nat_prefix));

  return render('settings.html.php');
});

dispatch_put('/settings', function() {
  exec('ip link show '.escapeshellarg($_POST['wifi_device']), $output, $retcode);

  $wifi_device_exists = ($retcode == 0);
  $service_enabled = isset($_POST['service_enabled']) ? 1 : 0;
  $wifi_ssid_uniqueness = array();
  $ip4_nat_prefix_uniqueness = array();
  $ip6_net_uniqueness = array();
  $ssids = array();
  $id = 0;

  if($service_enabled == 1) {
    try {
      foreach($_POST['ssid'] as $key => $ssid) {
        $id = $key + 1;

        $ssid['ip6_net'] = empty($ssid['ip6_net']) ? 'none' : $ssid['ip6_net'];
        $ssid['ip6_addr'] = 'none';
        $ssid['wifi_secure'] = isset($ssid['wifi_secure']) ? 1 : 0;

        if(!$ssid['wifi_secure']) {
          $ssid['wifi_passphrase'] = 'none';
        }

        if(in_array($ssid['wifi_ssid'], $wifi_ssid_uniqueness)) {
          throw new Exception(_('All Wifi names must be unique'));
        } else {
          array_push($wifi_ssid_uniqueness, $ssid['wifi_ssid']);
        }
    
        if(in_array($ssid['ip4_nat_prefix'], $ip4_nat_prefix_uniqueness)) {
          throw new Exception(_('All IPv4 NAT prefixes must be unique'));
        } else {
          array_push($ip4_nat_prefix_uniqueness, $ssid['ip4_nat_prefix']);
        }

        if($ssid['ip6_net'] != 'none' && in_array($ssid['ip6_net'], $ip6_net_uniqueness)) {
          throw new Exception(_('All IPv6 delegated prefixes must be unique'));
        } else {
          array_push($ip6_net_uniqueness, $ssid['ip6_net']);
        }

        if(empty($ssid['wifi_ssid']) || empty($ssid['wifi_passphrase'])) {
          throw new Exception(_('Your Wifi Hotspot needs a name and a password'));
        }
     
        if($ssid['wifi_secure'] && (strlen($ssid['wifi_passphrase']) < 8 || strlen($ssid['wifi_passphrase']) > 63)) {
          throw new Exception(_('Your password must from 8 to 63 characters (WPA2 passphrase)'));
        }
     
        if($ssid['wifi_secure'] && preg_match('/[^[:print:]]/', $ssid['wifi_passphrase'])) {
          throw new Exception(_('Only printable ASCII characters are permitted in your password'));
        }
     
        if(!$wifi_device_exists) {
          throw new Exception(_('The wifi antenna interface seems not exist on the system'));
        }
     
        if($ssid['ip6_net'] != 'none') {
          $ssid['ip6_net'] = ipv6_expanded($ssid['ip6_net']);
      
          if(empty($ssid['ip6_net'])) {
            throw new Exception(_('The IPv6 Delegated Prefix format looks bad'));
          }
      
          $ip6_blocs = explode(':', $ssid['ip6_net']);
          $ssid['ip6_addr'] = "${ip6_blocs[0]}:${ip6_blocs[1]}:${ip6_blocs[2]}:${ip6_blocs[3]}:${ip6_blocs[4]}:${ip6_blocs[5]}:${ip6_blocs[6]}:42";
      
          $ssid['ip6_net'] = ipv6_compressed($ssid['ip6_net']);
          $ssid['ip6_addr'] = ipv6_compressed($ssid['ip6_addr']);
        }
     
        if(!empty($ssid['ip6_dns0'])) {
          $ssid['ip6_dns0'] = ipv6_expanded($ssid['ip6_dns0']);
     
          if(empty($ssid['ip6_dns0'])) {
            throw new Exception(_('The format of the first IPv6 DNS Resolver looks bad'));
          }
     
          $ssid['ip6_dns0'] = ipv6_compressed($ssid['ip6_dns0']);
     
          if(!empty($ssid['ip6_dns1'])) {
            $ssid['ip6_dns1'] = ipv6_expanded($ssid['ip6_dns1']);
      
            if(empty($ssid['ip6_dns1'])) {
               throw new Exception(_('The format of the second IPv6 DNS Resolver looks bad'));
            }
     
            $ssid['ip6_dns1'] = ipv6_compressed($ssid['ip6_dns1']);
          }
        }
     
        if(inet_pton($ssid['ip4_dns0']) === false) {
          throw new Exception(_('The format of the first IPv4 DNS Resolver looks bad'));
        }
     
        if(inet_pton($ssid['ip4_dns1']) === false) {
          throw new Exception(_('The format of the second IPv4 DNS Resolver looks bad'));
        }
     
        if(inet_pton("${ssid['ip4_nat_prefix']}.0") === false) {
          throw new Exception(_('The format of the IPv4 NAT Prefix (/24) looks bad : x.x.x expected)'));
        }
     
        if(filter_var("${ssid['ip4_nat_prefix']}.0", FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== false) {
          throw new Exception(_('The IPv4 NAT Prefix must be from a private range'));
        }

        array_push($ssids, $ssid);
      }
    } catch(Exception $e) {
      flash('error', _('Hotspot')." $id: ".$e->getMessage().' ('._('configuration not updated').').');
      goto redirect;
    }
  }

  stop_service();

  ynh_setting_set('service_enabled', $service_enabled);
  $settings = array();

  if($service_enabled == 1) {
    foreach($ssids as $ssid) {
      foreach($ssid as $setting => $value) {
        $settings[$setting] .= "$value|";
      }
    }

    ynh_setting_set('multissid', count($ssids));
    ynh_setting_set('wifi_device', $_POST['wifi_device']);
    ynh_setting_set('wifi_channel', $_POST['wifi_channel']);

    foreach($settings as $setting => $value) {
      ynh_setting_set($setting, preg_replace('/\|$/', '', $value));
    }

    $retcode = start_service();

    if($retcode == 0) {
      flash('success', _('Configuration updated and service successfully reloaded'));
    } else {
      flash('error', _('Configuration updated but service reload failed'));
    }

  } else {
      flash('success', _('Service successfully disabled'));
  }

  redirect:
  redirect_to('/');
});

dispatch('/status', function() {
  $status_lines = service_status();
  $status_list = '';

  foreach($status_lines AS $status_line) {
    if(preg_match('/^\[INFO\]/', $status_line)) {
      $status_list .= '<li class="status-info">'.htmlspecialchars($status_line).'</li>';
    }
    elseif(preg_match('/^\[OK\]/', $status_line)) {
      $status_list .= '<li class="status-success">'.htmlspecialchars($status_line).'</li>';
    }
    elseif(preg_match('/^\[WARN\]/', $status_line)) {
      $status_list .= '<li class="status-warning">'.htmlspecialchars($status_line).'</li>';
    }
    elseif(preg_match('/^\[ERR\]/', $status_line)) {
      $status_list .= '<li class="status-danger">'.htmlspecialchars($status_line).'</li>';
    }
  }

  echo $status_list;
});

dispatch('/lang/:locale', function($locale = 'en') {
  switch($locale) {
    case 'fr':
      $_SESSION['locale'] = 'fr';
    break;

    default:
      $_SESSION['locale'] = 'en';
  }

  redirect_to('/');
});
