<!--
注意：此 README 由 <https://github.com/YunoHost/apps/tree/master/tools/readme_generator> 自动生成
请勿手动编辑。
-->

# YunoHost 上的 Wifi Hotspot

[![集成程度](https://dash.yunohost.org/integration/hotspot.svg)](https://dash.yunohost.org/appci/app/hotspot) ![工作状态](https://ci-apps.yunohost.org/ci/badges/hotspot.status.svg) ![维护状态](https://ci-apps.yunohost.org/ci/badges/hotspot.maintain.svg)

[![使用 YunoHost 安装 Wifi Hotspot](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=hotspot)

*[阅读此 README 的其它语言版本。](./ALL_README.md)*

> *通过此软件包，您可以在 YunoHost 服务器上快速、简单地安装 Wifi Hotspot。*  
> *如果您还没有 YunoHost，请参阅[指南](https://yunohost.org/install)了解如何安装它。*

## 概况

* Broadcast a Wi-Fi access point from your self-hosted server
* Combine with the [VPN Client app](https://github.com/labriqueinternet/vpnclient_ynh) to obtain a VPN-protected WiFi


**分发版本：** 2.3.1~ynh1

## 截图

![Wifi Hotspot 的截图](./doc/screenshots/hotspot.png)

## 文档与资源

- 官方应用网站： <https://internetcu.be/>
- YunoHost 商店： <https://apps.yunohost.org/app/hotspot>
- 报告 bug： <https://github.com/YunoHost-Apps/hotspot_ynh/issues>

## 开发者信息

请向 [`testing` 分支](https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing) 发送拉取请求。

如要尝试 `testing` 分支，请这样操作：

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing --debug
或
sudo yunohost app upgrade hotspot -u https://github.com/YunoHost-Apps/hotspot_ynh/tree/testing --debug
```

**有关应用打包的更多信息：** <https://yunohost.org/packaging_apps>
