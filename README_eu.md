<!--
Ohart ongi: README hau automatikoki sortu da <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>ri esker
EZ editatu eskuz.
-->

# Wifi Hotspot YunoHost-erako

[![Integrazio maila](https://dash.yunohost.org/integration/hotspot.svg)](https://dash.yunohost.org/appci/app/hotspot) ![Funtzionamendu egoera](https://ci-apps.yunohost.org/ci/badges/hotspot.status.svg) ![Mantentze egoera](https://ci-apps.yunohost.org/ci/badges/hotspot.maintain.svg)

[![Instalatu Wifi Hotspot YunoHost-ekin](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=hotspot)

*[Irakurri README hau beste hizkuntzatan.](./ALL_README.md)*

> *Pakete honek Wifi Hotspot YunoHost zerbitzari batean azkar eta zailtasunik gabe instalatzea ahalbidetzen dizu.*  
> *YunoHost ez baduzu, kontsultatu [gida](https://yunohost.org/install) nola instalatu ikasteko.*

## Aurreikuspena

* Broadcast a Wi-Fi access point from your self-hosted server
* Combine with the [VPN Client app](https://github.com/labriqueinternet/vpnclient_ynh) to obtain a VPN-protected WiFi


**Paketatutako bertsioa:** 2.3.1~ynh1

## Pantaila-argazkiak

![Wifi Hotspot(r)en pantaila-argazkia](./doc/screenshots/hotspot.png)

## Dokumentazioa eta baliabideak

- Aplikazioaren webgune ofiziala: <https://internetcu.be/>
- YunoHost Denda: <https://apps.yunohost.org/app/hotspot>
- Eman errore baten berri: <https://github.com/YunoHost-Apps/hotspot_ynh/issues>

## Garatzaileentzako informazioa

Bidali `pull request`a [`testing` abarrera](https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing).

`testing` abarra probatzeko, ondorengoa egin:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing --debug
edo
sudo yunohost app upgrade hotspot -u https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing --debug
```

**Informazio gehiago aplikazioaren paketatzeari buruz:** <https://yunohost.org/packaging_apps>
