# Wi-Fi Hotspot [![Build Status](https://travis-ci.org/labriqueinternet/hotspot_ynh.svg?branch=master)](https://travis-ci.org/labriqueinternet/hotspot_ynh) [![Integration level](https://dash.yunohost.org/integration/hotspot.svg)](https://dash.yunohost.org/appci/app/hotspot)

[![Install LaBriqueInterNet Hotspot with YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=hotspot)

This YunoHost app is a part of the "[La Brique Internet](http://labriqueinter.net)" project but can be used independently.

## Overview
Hotspot Wi-Fi app for [YunoHost](http://yunohost.org/).

* Broadcast your own Wi-Fi internet access in addition to your self-hosted web services.
* Without internet access, it's a [PirateBox](https://en.wikipedia.org/wiki/PirateBox).
* With the [VPN Client app for YunoHost](https://github.com/labriqueinternet/vpnclient_ynh), it's an encrypted Wi-Fi internet access (eventually with [neutral access](https://en.wikipedia.org/wiki/Net_neutrality), without filters, and with IPv6, depending on your VPN provider).

## Features

* WPA2 encryption
* 802.11n compliant
* IPv6 compliant (with a delegated prefix)
* Announce DNS resolvers (IPv6 with RDNSS/DHCPv6 and IPv4 with DHCPv4)
* Automatic clients configuration (IPv6 with SLAAC/DHCPv6 and IPv4 with DHCPv4)
* Set an IPv6 from your delegated prefix (*prefix::42*) on the server, to use for the AAAA records

## Screenshots

![Screenshot of the web interface](https://raw.githubusercontent.com/labriqueinternet/hotspot_ynh/master/screenshot.png)

## Friendly apps

Some other YunoHost apps have this Hotspot Wi-Fi app as prerequisite, in order to offer a service through a Wi-Fi access point.

With a multissid wireless card (most can do that), you can create multiple access points.

For example, you can create 3 hotspots:

1. *PirateBox*
2. *torNetwork*
3. *neutralNetwork*

You can then install and configure 3 other dependent apps on your YunoHost:

1. [PirateBox](https://github.com/labriqueinternet/piratebox_ynh) configured to use *PirateBox*,
2. [Tor Client](https://github.com/labriqueinternet/torclient_ynh/) configured to use *torNetwork*,
3. [VPN Client](https://github.com/labriqueinternet/vpnclient_ynh/) configured by default to use *neutralNetwork* because this hotspot is not used by another app in this case.

In this manner, with this example, you can provide 3 access points at the same time with 3 different services and only one wireless card.

## Prerequisites

* Debian Stretch
* YunoHost >= 3.2.0

