# Wifi Hotspot
## Overview

**Warning: work in progress**

Hotspot wifi app for [YunoHost](http://yunohost.org/).

* Broadcast your own Wifi internet access in addition to your self-hosted web services.
* Without internet access, it's a [PirateBox](https://en.wikipedia.org/wiki/PirateBox).
* With the [VPN Client app for YunoHost](https://github.com/jvaubourg/vpnclient_ynh), it's an encrypted Wifi internet access (eventually with [neutral access](https://en.wikipedia.org/wiki/Net_neutrality), without filters, and with IPv6, depending on your VPN provider).

See the <a href="https://raw.githubusercontent.com/jvaubourg/hotspot_ynh/master/docs/box-project_french.pdf">box project<a/> explanations (<a href="https://en.wikipedia.org/wiki/Customer-premises_equipment">CPE</a> for ready-made self-hosting, with VPN access through wifi) in French. An example of hardware associated is the <a href="https://www.olimex.com/Products/OLinuXino/A20/A20-OLinuXino-LIME/open-source-hardware">A20-OLinuXino-LIME</a> with the <a href="https://www.olimex.com/Products/USB-Modules/MOD-WIFI-R5370-ANT/">MOD-WIFI-R5370-ANT</a>. See also the <a href="https://github.com/bleuchtang/olinuxino-a20-lime">YunoHost image project</a> for OLinuXino.

## Features

* WPA2 encryption
* 802.11n compliant
* IPv6 compliant (with a delegated prefix)
* Automatic clients configuration (IPv6 and IPv4)
* Announce DNS resolvers (IPv6 and IPv4)
* Set an IPv6 from your delegated prefix (*prefix::42*) on the server, to use for the AAAA records
* Web interface ([screenshot](https://raw.githubusercontent.com/jvaubourg/hotspot_ynh/master/screenshot.png))
