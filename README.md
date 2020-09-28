# HMS Pushkit PHP Severdemo

## Table of Contents
 * [Introduction](#introduction)
 * [Installation](#installation)
 * [Configuration](#configuration)
 * [Supported Environments](#supported-environments)
 * [Sample Code](#sample-code)
 * [License](#license)
 
## Introduction
PHP sample code encapsulates APIs of the HUAWEI Push Kit server.It provides many sample 
PHP programs about quick access to HUAWEI Push Kit for your reference or usage.  
The following table describes packages of PHP sample code.

| Package        | Description
| :---           | :---
| __examples__   | Sample code files. Each PHP file can run independently.
| __push_admin__ | Package where APIs of the HUAWEI Push Kit server are <br> encapsulated.

## Installation

Before using PHP sample code, check whether the PHP environment has been installed.  

## Supported Environments

The PHP sample code is debugged based on the XAMPP (MySQL + PHP + PERL) 5.6.26 development suite.

## Configuration 

The following table describes parameters of the ____construct__ method.

| Parameter              | Description
| :---               | :---
| __appid__   | App ID, which is obtained from app information.
| __appsecret__ | 	Secret access key of an app, which is obtained from app information.
| __access_token__      | URL for the Huawei OAuth 2.0 service to obtain a token, <br>please refer to [Generating an App-Level Access Token](https://developer.huawei.com/consumer/en/doc/development/parts-Guides/generating_app_level_access_token).
| __hw_token_server__      | URL for accessing HUAWEI Push Kit, please refer to [Sending Messages](https://developer.huawei.com/consumer/en/doc/development/HMS-References/push-sendapi).

## Sample Code
Download PHP sample code in [Downloading Server Sample Code](https://developer.huawei.com/consumer/en/doc/push-sample-code-s).   
PHP sample code uses the Application structure in the push_admin package as the entry.   
Core methods in the Application structure are used to call APIs of the HUAWEI Push Kit server.  
The following table lists methods in Application.

| Method              | Description
| :---               | :---
| __push_send_msg__   | Sends a message to a device.
| __common_send_msg__ | Subscribes to a topic, unsubscribes from a topic,<br>and queries the list of topics subscribed by a device.
| ____construc__      | Constructor, which obtains key data for sending a message.

1.Send an Android data message.  
Code location: __examples/test_sample_push_passthrouth_msg.php__              

2.Send an Android notification message.  
Code location: __examples/test_sample_push_notification_msg.php__              

3.Send a message by topic.  
Code location: __examples/test_sample_push_topic_msg.php__

4.Send a message by conditions.  
Code location: __examples/test_sample_push_condition_msg.php__  

5.Send a message to a Huawei quick app.  
Code location: __examples/test_sample_push_instantce_app_msg.php__

6.Send a message through the WebPush agent.  
Code location: __examples/test_sample_push_webpush_msg.php__

7.Send a message through the APNs agent.  
Code location: __examples/test_sample_apns_msg.php__

8.Send a test message.  
Code location: __examples/test_sample_test_push_msg.php__

## Question or issues
If you want to evaluate more about HMS Core,
[r/HMSCore on Reddit](https://www.reddit.com/r/HuaweiDevelopers/) is for you to keep up with latest news about HMS Core, and to exchange insights with other developers.

If you have questions about how to use HMS samples, try the following options:
- [Stack Overflow](https://stackoverflow.com/questions/tagged/huawei-mobile-services) is the best place for any programming questions. Be sure to tag your question with 
`huawei-mobile-services`.
- [Huawei Developer Forum](https://forums.developer.huawei.com/forumPortal/en/home?fid=0101187876626530001) HMS Core Module is great for general questions, or seeking recommendations and opinions.

If you run into a bug in our samples, please submit an [issue](https://github.com/HMS-Core/hms-push-serverdemo-php/issues) to the Repository. Even better you can submit a [Pull Request](https://github.com/HMS-Core/hms-push-serverdemo-php/pulls) with a fix.

##  License
Pushkit PHP sample is licensed under the [Apache License, version 2.0](http://www.apache.org/licenses/LICENSE-2.0).
