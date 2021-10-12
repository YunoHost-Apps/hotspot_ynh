#!/bin/bash

#=================================================
# COMMON VARIABLES
#=================================================

pkg_dependencies="sipcalc hostapd iw kmod"
nonfree_firmware_packages="firmware-atheros firmware-realtek firmware-ralink firmware-libertas atmel-firmware firmware-zd1211"
free_firmware_packages="firmware-ath9k-htc"

#=================================================
# PERSONAL HELPERS
#=================================================

function iw_devices()
{
  echo -n $(/sbin/iw dev | grep Interface | grep -v 'mon\.' | grep -v hotspot | awk '{ print $NF }') | tr ' ' '|'
}

function check_armbian_nonfree_conflict()
{

  # If we're on armbian, force $firmware_nonfree
  # because armbian-firmware conflicts with firmware-misc-nonfree package
  if dpkg --list | grep -q armbian-firmware; then
    echo "You are running Armbian and firmware-misc-nonfree are known to conflict with armbian-firwmare. " >&2
    echo "The package firmware-misc-nonfree is a dependency of firmware-ralink, so firmware-ralink will NOT be installed" >&2
    echo "You can manually install firmware-ralink with 'apt -o Dpkg::Options::=\"--force-overwrite\" firmware-ralink'" >&2
    nonfree_firmware_packages=$(echo $nonfree_firmware_packages | sed 's/ firmware-ralink//')
  fi

}


function hot_reload_usb_wifi_cards()
{
  modulesList="acx-mac80211 ar5523 ar9170usb at76c50x-usb at76_usb ath9k_htc carl9170 orinoco_usb p54usb prism2_usb r8712u r8192s_usb r8192u_usb rndis_wlan rt2500usb rt2800usb rt2870sta rt73usb rtl8187 rtl8192cu usb8xxx vt6656_stage zd1201 zd1211rw"
  modprobe --quiet --remove $modulesList || true
  possibleUsbDevicesNeedingReload=$(dmesg | grep -Pio '(?<=usb )[0-9-]+(?=:.*firmware)' | sort | uniq)
  for usbPath in $possibleUsbDevicesNeedingReload; do
    if [[ -f "/sys/bus/usb/devices/$usbPath/authorized" ]]; then
      echo "Try to reload driver for usb $usbPath" >&2
      echo 0 > /sys/bus/usb/devices/$usbPath/authorized
      echo 1 > /sys/bus/usb/devices/$usbPath/authorized
      # Wait for driver reloading
      sleep 2
    fi
  done
}

#=================================================
# EXPERIMENTAL HELPERS
#=================================================

#=================================================
# FUTURE OFFICIAL HELPERS
#=================================================
