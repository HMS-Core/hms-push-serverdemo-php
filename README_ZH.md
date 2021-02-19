# 华为推送服务服务端PHP示例代码

## 目录
 * [简介](#简介)
 * [安装](#安装)
 * [环境要求](#环境要求)
 * [配置](#配置)
 * [示例代码](#示例代码)
 * [授权许可](#授权许可)
 
## 简介
PHP示例代码对华为推送服务（HUAWEI Push Kit）服务端接口进行封装，包含丰富的示例程序，方便您参考或直接使用。
示例代码主要包括以下组成：

| 包名        | 说明
| :---           | :---
| __examples__   | 示例代码文件，每个PHP文件都可以独立运行
| __push_admin__ | 推送服务的服务端接口封装包

## 安装

使用本示例代码前，请确保您的设备上已安装PHP开发环境。

## 环境要求

本示例代码经过XAMPP (MySQL + PHP + PERL) 5.6.26开发套件调试。

## 配置

__construct方法包括如下参数：

| 参数              | 说明
| :---               | :---
| __appid__   | 应用ID，从应用消息中获取
| __appsecret__ | 	应用访问密钥，从应用信息中获取
| __access_token__      | 华为OAuth 2.0获取token的地址。具体请参考 [基于OAuth 2.0开放鉴权-客户端模式](https://developer.huawei.com/consumer/cn/doc/development/parts-Guides/generating_app_level_access_token).
| __hw_token_server__      | 推送服务的访问地址。具体请参考[推送服务-下行消息](https://developer.huawei.com/consumer/cn/doc/development/HMS-References/push-sendapi).

## 示例代码
请在[服务端示例代码](https://developer.huawei.com/consumer/cn/doc/push-sample-code-s)下载PHP示例代码。   
本示例代码以push_admin包中的Application结构体为入口。Application结构体中的核心方法完成了对推送服务服务端接口的调用。
Application包括如下方法：

| 方法             | 说明
| :---               | :---
| __push_send_msg__   | 向设备发送消息
| __common_send_msg__ | 订阅主题、退订主题、查询设备订阅的主题列表
| ____construc__      | 构造函数，获取发送消息的关键数据

1.	发送Android透传消息
代码位置: [examples/test_sample_push_passthrouth_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_push_passthrouth_msg.php)             

2.	发送Android通知栏消息
代码位置: [examples/test_sample_push_notification_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_push_notification_msg.php)

3.	基于主题发送消息
代码位置: [examples/test_sample_push_topic_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_push_topic_msg.php)

4.	基于条件发送消息 
代码位置: [examples/test_sample_push_condition_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_push_condition_msg.php)  

5.	向华为快应用发送消息 
代码位置: [examples/test_sample_push_instantce_app_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_push_instantce_app_msg.php)

6.	基于WebPush代理发送消息
代码位置: [examples/test_sample_push_webpush_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_push_webpush_msg.php)

7.	基于APNs代理发送消息
代码位置: [examples/test_sample_apns_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_apns_msg.php)

8.	发送测试消息.  
代码位置: [examples/test_sample_test_push_msg.php](https://github.com/HMS-Core/hms-push-serverdemo-php/blob/master/src/example/test_sample_test_push_msg.php)

## 技术支持
如果您对HMS Core还处于评估阶段，可在[Reddit社区](https://www.reddit.com/r/HuaweiDevelopers/)获取关于HMS Core的最新讯息，并与其他开发者交流见解。

如果您对使用HMS示例代码有疑问，请尝试：
- 开发过程遇到问题上[Stack Overflow](https://stackoverflow.com/questions/tagged/huawei-mobile-services)，在`huawei-mobile-services`标签下提问，有华为研发专家在线一对一解决您的问题。
- 到[华为开发者论坛](https://developer.huawei.com/consumer/cn/forum/blockdisplay?fid=18) HMS Core板块与其他开发者进行交流。

如果您在尝试示例代码中遇到问题，请向仓库提交[issue](https://github.com/HMS-Core/hms-push-serverdemo-php/issues)，也欢迎您提交[Pull Request](https://github.com/HMS-Core/hms-push-serverdemo-php/pulls)。

##  授权许可
华为推送服务PHP示例代码经过[Apache License, version 2.0](http://www.apache.org/licenses/LICENSE-2.0)授权许可。
