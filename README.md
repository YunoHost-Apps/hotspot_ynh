# Hotspot Wifi
## Overview

Hotspot wifi app for [YunoHost](http://yunohost.org/).

* Broadcast your own Wifi internet access in addition to your self-hosted web services.
* Without internet access, it's a [PirateBox](https://en.wikipedia.org/wiki/PirateBox).
* With the [VPN Client app for YunoHost](https://github.com/jvaubourg/vpnclient_ynh), it's an encrypted Wifi internet access (eventually with [neutral access](https://en.wikipedia.org/wiki/Net_neutrality) without filters, and with IPv6, depending on your VPN provider).

Small computers like [Olimex](https://www.olimex.com) or [Raspberry PI](http://www.raspberrypi.org/) boxes and an USB Wifi dongle like [this one](https://www.olimex.com/Products/USB-Modules/MOD-WIFI-R5370-ANT/) is perfect for a nomade access with low power consumption.

## Features

* WPA2 encryption
* IPv6 compliant (with a delegated prefix)
* 802.11n if your antenna is compliant
* Automatic clients configuration (IPv6 and IPv4)
* Announce DNS resolvers (IPv6 and IPv4)
* The internet provider can be a 3/4G connection with tethering
* Web interface ([screenshot](https://raw.githubusercontent.com/jvaubourg/hotspot_ynh/master/screenshot.png))
