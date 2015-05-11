# Wifi Hotspot
## Overview

**Warning: work in progress**

Hotspot wifi app for [YunoHost](http://yunohost.org/).

* Broadcast your own Wifi internet access in addition to your self-hosted web services.
* Without internet access, it's a [PirateBox](https://en.wikipedia.org/wiki/PirateBox).
* With the [VPN Client app for YunoHost](https://github.com/labriqueinternet/vpnclient_ynh), it's an encrypted Wifi internet access (eventually with [neutral access](https://en.wikipedia.org/wiki/Net_neutrality), without filters, and with IPv6, depending on your VPN provider).

This YunoHost app is a part of the "[La Brique Internet](http://labriqueinter.net)" project but can be used independently.

## Features

* WPA2 encryption
* 802.11n compliant
* IPv6 compliant (with a delegated prefix)
* Announce DNS resolvers (IPv6 with RDNSS/DHCPv6 and IPv4 with DHCPv4)
* Automatic clients configuration (IPv6 with SLAAC/DHCPv6 and IPv4 with DHCPv4)
* Set an IPv6 from your delegated prefix (*prefix::42*) on the server, to use for the AAAA records
* Web interface ([screenshot](https://raw.githubusercontent.com/labriqueinternet/hotspot_ynh/master/screenshot.png))

## Friendly apps

Some other YunoHost apps have this Hotspot wifi app as prerequisite, in order to offer a service through a wifi access point.

With a multissid wireless card (most can do that), you can create multiple access points.

For example, you can create 3 hotspots:

1. *PirateBox*
2. *torNetwork*
3. *neutralNetwork*

You can then install and configure 3 other dependent apps on your YunoHost:

1. [PirateBox](https://github.com/jvaubourg/piratebox_ynh) configured to use *PirateBox*,
2. [Tor Client](https://github.com/labriqueinternet/torclient_ynh/) configured to use *torNetwork*,
3. [VPN Client](https://github.com/labriqueinternet/vpnclient_ynh/) configured by default to use *neutralNetwork* because this hotspot is not used by another app in this case.

In this manner, with this example, you can provide 3 access points at the same time with 3 different services and only one wireless card.

## Prerequisites

This app works with a non-stable version of YunoHost.

Until this version is available (coming soon!) as an official stable release, you need to execute some commands before installing this app:

    # service bind9 stop
    # update-rc.d bind9 remove
    # apt-get install dnsmasq
