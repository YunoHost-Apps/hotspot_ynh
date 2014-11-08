option domain-name-servers <TPL:IP4_DNS0>, <TPL:IP4_DNS1>;
default-lease-time 14440;
ddns-update-style none;
deny bootp;

shared-network <TPL:WIFI_DEVICE> {
  subnet <TPL:IP4_NAT_PREFIX>.0
  netmask 255.255.255.0 {
    option routers <TPL:IP4_NAT_PREFIX>.1;
    option subnet-mask 255.255.255.0;
    pool {
      range <TPL:IP4_NAT_PREFIX>.2 <TPL:IP4_NAT_PREFIX>.254;
    }
  }
}
