# Wifi Hotspot pour YunoHost

[![Niveau d'intégration](https://dash.yunohost.org/integration/hotspot.svg)](https://dash.yunohost.org/appci/app/hotspot) ![](https://ci-apps.yunohost.org/ci/badges/hotspot.status.svg) ![](https://ci-apps.yunohost.org/ci/badges/hotspot.maintain.svg)  
[![Installer Wifi Hotspot avec YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=hotspot)

*[Read this readme in english.](./README.md)*
*[Lire ce readme en français.](./README_fr.md)*

> *Ce package vous permet d'installer Wifi Hotspot rapidement et simplement sur un serveur YunoHost.
Si vous n'avez pas YunoHost, regardez [ici](https://yunohost.org/#/install) pour savoir comment l'installer et en profiter.*

## Vue d'ensemble

* Diffusez un point d'accès Wi-Fi depuis votre serveur auto-hébergé
* À combiner avec l'[app VPN Client](https://github.com/labriqueinternet/vpnclient_ynh) pour obtenir un accès internet aumatiquement protégé par votre VPN


**Version incluse :** 2.0~ynh2



## Captures d'écran

![](./doc/screenshots/hotspot.png)

## Documentations et ressources

* Site officiel de l'app : https://internetcu.be/
* Documentation YunoHost pour cette app : https://yunohost.org/app_hotspot
* Signaler un bug : https://github.com/YunoHost-Apps/hotspot_ynh/issues

## Informations pour les développeurs

Merci de faire vos pull request sur la [branche testing](https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing).

Pour essayer la branche testing, procédez comme suit.
```
sudo yunohost app install https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing --debug
ou
sudo yunohost app upgrade hotspot -u https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing --debug
```

**Plus d'infos sur le packaging d'applications :** https://yunohost.org/packaging_apps