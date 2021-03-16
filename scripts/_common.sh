#!/bin/bash

#=================================================
# COMMON VARIABLES
#=================================================

pkg_dependencies="sipcalc hostapd iptables iw dnsmasq"
nonfree_firmware_packages="firmware-atheros firmware-realtek firmware-ralink firmware-libertas atmel-firmware firmware-zd1211"
free_firmware_packages="firmware-ath9k-htc"

#=================================================
# PERSONAL HELPERS
#=================================================

function check_armbian_nonfree_conflict()
{

  # If we're on armbian, force $firmware_nonfree
  # because armbian-firmware conflicts with firmware-misc-nonfree package
  if dpkg --list | grep -q armbian-firmware; then
    echo "You are running Armbian and firmware-misc-nonfree are known to conflict with armbian-firwmare. " >&2
    echo "The package firmware-misc-nonfree is a dependency of firmware-ralink, so firmware-ralink will NOT be installed" >&2
    echo "You can manually install firmware-ralink with 'sudo apt -o Dpkg::Options::=\"--force-overwrite\" firmware-ralink'" >&2
    nonfree_firmware_packages=$(echo $nonfree_firmware_packages | sed 's/ firmware-ralink//')
  fi

}

#=================================================
# EXPERIMENTAL HELPERS
#=================================================

#=================================================
# FUTURE OFFICIAL HELPERS
#=================================================
