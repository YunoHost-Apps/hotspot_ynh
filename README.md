# Hotspot Wifi
## Overview

**Warning: work in progress**

**Warning: currently, there is no checking on input parameters, so be careful**

Hotspot wifi app for [YunoHost](http://yunohost.org/).

* Broadcast your own Wifi internet access in addition to your self-hosted web services.
* Without internet access, it's a [PirateBox](https://en.wikipedia.org/wiki/PirateBox).
* With the [VPN Client app for YunoHost](https://github.com/jvaubourg/vpnclient_ynh), it's an encrypted Wifi internet access (eventually with [neutral access](https://en.wikipedia.org/wiki/Net_neutrality), without filters, and with IPv6, depending on your VPN provider).

## Features

* WPA2 encryption
* 802.11n if your antenna is compliant
* IPv6 compliant (with a delegated prefix)
* Automatic clients configuration (IPv6 and IPv4)
* Announce DNS resolvers (IPv6 and IPv4)
* Set an IPv6 from your delegated prefix (*prefix::1*) on the server, to use for the AAAA records
* The internet provider can be a 3/4G connection with tethering
* Web interface ([screenshot](https://raw.githubusercontent.com/jvaubourg/hotspot_ynh/master/screenshot.png))
