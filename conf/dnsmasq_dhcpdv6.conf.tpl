# Do DHCP and Router Advertisements for this subnet. Set the A bit in the RA
# so that clients can use SLAAC addresses as well as DHCP ones.
dhcp-range=interface:<TPL:WIFI_DEVICE>,<TPL:IP6_NET>,slaac,64,4h

# Send DHCPv6 option. Note [] around IPv6 addresses.
dhcp-option=option6:dns-server,[<TPL:IP6_DNS0>],[<TPL:IP6_DNS1>]
