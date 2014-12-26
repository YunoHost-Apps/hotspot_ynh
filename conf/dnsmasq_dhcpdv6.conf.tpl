# Wifi Hotspot app for YunoHost 
# Copyright (C) 2015 Julien Vaubourg <julien@vaubourg.com>
# Contribute at https://github.com/jvaubourg/hotspot_ynh
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# 
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

# Do DHCP and Router Advertisements for this subnet. Set the A bit in the RA
# so that clients can use SLAAC addresses as well as DHCP ones.
dhcp-range=interface:<TPL:WIFI_DEVICE>,<TPL:IP6_NET>,slaac,64,4h

# Send DHCPv6 option. Note [] around IPv6 addresses.
dhcp-option=option6:dns-server,[<TPL:IP6_DNS0>],[<TPL:IP6_DNS1>]
