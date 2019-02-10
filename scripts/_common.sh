#!/bin/bash

#
# Common variables
#

pkg_dependencies="php5-fpm sipcalc hostapd iptables iw dnsmasq rfkill"
nonfree_packages="firmware-linux-free firmware-linux-nonfree firmware-atheros firmware-realtek firmware-ralink firmware-libertas atmel-firmware zd1211-firmware"
free_packages="firmware-linux-free"

#
# Helper to start/stop/.. a systemd service from a yunohost context,
# *and* the systemd service itself needs to be able to run yunohost
# commands.
#
# Hence the need to release the lock during the operation
#
# usage : ynh_systemctl yolo restart
#
function ynh_systemctl()
{
  local ACTION="$1"
  local SERVICE="$2"
  local LOCKFILE="/var/run/moulinette_yunohost.lock"

  # Launch the action
  systemctl "$ACTION" "$SERVICE" &
  local SYSCTLACTION=$!

  # Save and release the lock...
  cp $LOCKFILE $LOCKFILE.bkp.$$
  ynh_secure_remove $LOCKFILE

  # Wait for the end of the action
  wait $SYSCTLACTION

  # Make sure the lock is released...
  while [ -f $LOCKFILE ]
  do
    sleep 0.1
  done

  # Restore the old lock
  mv $LOCKFILE.bkp.$$ $LOCKFILE
}
