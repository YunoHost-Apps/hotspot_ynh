# Do DHCP and Router Advertisements for this subnet. Set the A bit in the RA
# so that clients can use SLAAC addresses as well as DHCP ones.
dhcp-range=interface:__WIFI_DEVICE__,__IP6_NET__,slaac,64,4h

# Send DHCPv6 option. Note [] around IPv6 addresses.
dhcp-option=option6:dns-server,__IP6_DNS__
