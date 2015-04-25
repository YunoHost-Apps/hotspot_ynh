# Wifi Hotspot
## Overview

**Warning: work in progress**

Hotspot wifi app for [YunoHost](http://yunohost.org/).

* Broadcast your own Wifi internet access in addition to your self-hosted web services.
* Without internet access, it's a [PirateBox](https://en.wikipedia.org/wiki/PirateBox).
* With the [VPN Client app for YunoHost](https://github.com/jvaubourg/vpnclient_ynh), it's an encrypted Wifi internet access (eventually with [neutral access](https://en.wikipedia.org/wiki/Net_neutrality), without filters, and with IPv6, depending on your VPN provider).

This YunoHost app is a part of the "[La Brique Internet](http://labriqueinter.net)" project but can be used independently.

## Features

* WPA2 encryption
* 802.11n compliant
* IPv6 compliant (with a delegated prefix)
* Announce DNS resolvers (IPv6 with RDNSS/DHCPv6 and IPv4 with DHCPv4)
* Automatic clients configuration (IPv6 with SLAAC/DHCPv6 and IPv4 with DHCPv4)
* Set an IPv6 from your delegated prefix (*prefix::42*) on the server, to use for the AAAA records
* Web interface ([screenshot](https://raw.githubusercontent.com/jvaubourg/hotspot_ynh/master/screenshot.png))

## Prerequisites

This app works with a non-stable version of YunoHost.

Until this version is available (coming soon!) as an official stable release, you need to execute some commands before installing this app:

    # service bind9 stop
    # update-rc.d bind9 remove
    # apt-get install dnsmasq
