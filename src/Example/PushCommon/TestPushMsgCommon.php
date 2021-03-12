<?php
/**
 * Copyright 2020. Huawei Technologies Co., Ltd. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Huawei\Example\PushCommon;

use Huawei\PushNotifications\PushAdmin\AndroidConfigDeliveryPriority;
use Huawei\PushNotifications\PushAdmin\ApnConstant;
use Huawei\PushNotifications\PushAdmin\Application;
use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\PushNotifications\PushAdmin\NotificationPriority;
use Huawei\PushNotifications\PushAdmin\PushConfig;
use Huawei\PushNotifications\PushAdmin\PushLogConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\Android\AndroidConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\Android\AndroidNotification;
use Huawei\PushNotifications\PushAdmin\PushMessage\Android\Badge;
use Huawei\PushNotifications\PushAdmin\PushMessage\Android\ClickAction;
use Huawei\PushNotifications\PushAdmin\PushMessage\Android\LightSetting;
use Huawei\PushNotifications\PushAdmin\PushMessage\Android\LightSettingColor;
use Huawei\PushNotifications\PushAdmin\PushMessage\Apns\Alert;
use Huawei\PushNotifications\PushAdmin\PushMessage\Apns\ApnsConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\Apns\ApnsHeaders;
use Huawei\PushNotifications\PushAdmin\PushMessage\Apns\ApnsHmsOptions;
use Huawei\PushNotifications\PushAdmin\PushMessage\Apns\Aps;
use Huawei\PushNotifications\PushAdmin\PushMessage\InstanceApp\InstanceAppConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\InstanceApp\InstanceAppPushbody;
use Huawei\PushNotifications\PushAdmin\PushMessage\InstanceApp\InstanceAppRingtone;
use Huawei\PushNotifications\PushAdmin\PushMessage\Notification\Notification;
use Huawei\PushNotifications\PushAdmin\PushMessage\PushMessage;
use Huawei\PushNotifications\PushAdmin\PushMessage\WebPush\WebPushConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\WebPush\WebPushHeaders;
use Huawei\PushNotifications\PushAdmin\PushMessage\WebPush\WebPushHmsOptions;
use Huawei\PushNotifications\PushAdmin\PushMessage\WebPush\WebPushNotification;
use Huawei\PushNotifications\PushAdmin\PushMessage\WebPush\WebPushNotificationAction;

class TestPushMsgCommon
{
    // ordinal app
    private $appid;
    private $appsecret;
    // FOR PUSH MSG NOTIFICATION,PASSTHROUGH TOPIC/TOKEN/CONDITION
    public $hw_push_token_key;
    // FOR APN
    public $apn_push_token_key;
    // FOR WEBPUSH
    public $webpush_push_token_key;
    
    // fast app
    private $fast_appid;
    private $fast_appsecret;
    // fast app token
    public $fast_push_token;


    private $hw_token_server;
    private $hw_push_server;
    private $log_suffix_show_start = ".............................";
    private $log_suffix_show_end = "-----------------------------";
    private $push_msg_type;
    private $default_topic = 'defaultTopic';

    private $str_len = 35;

    public function __construct()
    {
        $pushConfig = PushConfig::getSingleInstance();
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_APPID", $this->str_len, '=') . ">" . $pushConfig->HW_APPID);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_APPSECRET", $this->str_len, '=') . ">" . $pushConfig->HW_APPSECRET);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_TOKEN_SERVER", $this->str_len, '=') . ">" . $pushConfig->HW_TOKEN_SERVER);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_PUSH_TOKEN_ARR", $this->str_len, '=') . ">" . $pushConfig->HW_PUSH_TOKEN_ARR);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("WEBPUSH_PUSH_TOKEN_ARR", $this->str_len, '=') . ">" . $pushConfig->WEBPUSH_PUSH_TOKEN_ARR);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("APN_PUSH_TOKEN_ARR", $this->str_len, '=') . ">" . $pushConfig->APN_PUSH_TOKEN_ARR);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_TOPIC_SUBSCRIBE_SERVER", $this->str_len, '=') . ">" . $pushConfig->HW_TOPIC_SUBSCRIBE_SERVER);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_TOPIC_UNSUBSCRIBE_SERVER", $this->str_len, '=') . ">" . $pushConfig->HW_TOPIC_UNSUBSCRIBE_SERVER);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_TOPIC_QUERY_SUBSCRIBER_SERVER", $this->str_len, '=') . ">" . $pushConfig->HW_TOPIC_QUERY_SUBSCRIBER_SERVER);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_FAST_APPID", $this->str_len, '=') . ">" . $pushConfig->HW_FAST_APPID);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_FAST_APPSECRET", $this->str_len, '=') . ">" . $pushConfig->HW_FAST_APPSECRET);
        PushLogConfig::getSingleInstance()->LogMessage(str_pad("HW_FAST_PUSH_TOKEN", $this->str_len, '=') . ">" . $pushConfig->HW_FAST_PUSH_TOKEN);
        
        $this->appsecret = $pushConfig->HW_APPSECRET;
        $this->appid = $pushConfig->HW_APPID;
        $this->hw_token_server = $pushConfig->HW_TOKEN_SERVER;
        $this->hw_push_server = $pushConfig->HW_PUSH_SERVER;
        $this->hw_push_token_key = $pushConfig->HW_PUSH_TOKEN_ARR;
        $this->apn_push_token_key = $pushConfig->APN_PUSH_TOKEN_ARR;
        $this->webpush_push_token_key = $pushConfig->WEBPUSH_PUSH_TOKEN_ARR;
        
        $this->fast_appsecret = $pushConfig->HW_FAST_APPSECRET;
        $this->fast_appid = $pushConfig->HW_FAST_APPID;
        $this->fast_push_token = $pushConfig->HW_FAST_PUSH_TOKEN;
    }

    public function sendPushMsgMessageByMsgType($msg_type, $topic = "")
    {
        $application_server = $this->hw_push_server;
        $this->printLogMethodOperate("push msg start" . $this->log_suffix_show_start, __FUNCTION__ . ':' . __LINE__);

        $this->push_msg_type = $msg_type;
        $message = $this->getMessageByMsgType($msg_type);

        $this->printLogMethodOperate("msg body:" . json_encode($message->getFields()), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        $application = $this->createApplication($application_server);
        $this->printLogMethodOperate("application server:" . json_encode($application->getApplicationFields()), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        $application->pushSendMsg($message->getFields());
        $this->printLogMethodOperate("push msg end" . $this->log_suffix_show_end, __FUNCTION__ . ':' . __LINE__);
    }

    public function sendPushMsgRealMessage($message, $push_msg_type="")
    {
        $this->printLogMethodOperate("sendPushMsgRealMessage start push_msg_type:" .$push_msg_type, __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        if (!empty($push_msg_type)) {
            $this->push_msg_type = $push_msg_type;
        }
        $this->printLogMethodOperate("sendPushMsgRealMessage start push_msg_type:" .$this->push_msg_type, __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        $application_server = $this->hw_push_server;
        $application = $this->createApplication($application_server);
        $this->printLogMethodOperate("application server:" . json_encode($application->getApplicationFields()), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        $application->pushSendMsg($message);
        $this->printLogMethodOperate("push msg end" . $this->log_suffix_show_end, __FUNCTION__ . ':' . __LINE__);
    }

    public function sendPushTopicMsgMessage($topic = "")
    {
        if (empty($topic)) {
            $topic = $this->default_topic;
        }
        $testTopicCommonSample = new TestTopicCommonSample($topic);

        $this->printLogMethodOperate("start subscribe topic:" . $topic, __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_INFO_LEVEL);
        // subscribe msg
        $testTopicCommonSample->sendTopicMessage(Constants::TOPIC_SUBSCRIBE_MSG_TYPE);
        // query subscribe msg
        $testTopicCommonSample->sendTopicMessage(Constants::TOPIC_SUBSCRIBE_QUERY_MSG_TYPE);
    }

    /**
     * $result==>{"msg":"success","code":"80000000","requestId":"157561883923402813000201",
     * "topics":[{"name":"defaultTopic","addDate":"2019-12-06"},
     * {"name":"push-test","addDate":"2019-12-06"},
     * {"name":"targetTopic","addDate":"2019-12-06"},
     * {"name":"weather","addDate":"2019-12-06"}]}
     */
    private function isTopicInTopicList($result, $topic)
    {
        $this->printLogMethodOperate("isTopicInTopicList topic[" . $topic . "],result:" . json_encode($result) . "", __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_INFO_LEVEL);
        if (empty($result)) {
            return false;
        }

        $arrResult = json_decode(json_encode($result), true);
        $this->printLogMethodOperate("isTopicInTopicList arrResult:" . json_encode($arrResult) . "][code:" . $arrResult["code"], __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        if (empty($arrResult["code"])) {
            return false;
        }
        $this->printLogMethodOperate("isTopicInTopicList code:" . $arrResult["code"], __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        if (! in_array($arrResult["code"], array(
            "80000000",
            80000000
        ))) {
            return false;
        }
        if (empty($arrResult["topics"])) {
            return false;
        }

        $topicArr = $arrResult["topics"];
        $this->printLogMethodOperate("isTopicInTopicList topicArr:" . json_encode($topicArr), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        if (empty($topicArr)) {
            return false;
        }

        foreach ($topicArr as $topicObject) {
            if ($topicObject["name"] == $topic) {
                return true;
            }
        }
        $this->printLogMethodOperate("isTopicInTopicList False,topic is not subscribe", __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        return false;
    }

    private function getDefaultAndroidNotificationContent($titel)
    {
        $prefixTitleData = '';
        switch ($this->push_msg_type) {
            case Constants::PUSHMSG_NOTIFICATION_MSG_TYPE:
                {
                    $prefixTitleData = ' notification ';
                    break;
                }
            case Constants::PUSHMSG_PASS_THROUGHT_MSG_TYPE:
                {
                    $prefixTitleData = ' passthrough ';
                    break;
                }

            case Constants::PUSHMSG_FASTAPP_MSG_TYPE:
                {
                    $prefixTitleData = ' fastapp ';
                    break;
                }
            case Constants::PUSHMSG_TOPIC_MSG_TYPE:
                {
                    $prefixTitleData = ' topic ';
                    break;
                }
            case Constants::PUSHMSG_CONDITION_MSG_TYPE:
                {
                    $prefixTitleData = ' condition ';
                    break;
                }

            case Constants::APN_MSG_TYPE:
                {
                    $prefixTitleData = ' apn ';
                    break;
                }
            case Constants::WEB_PUSH_MSG_TYPE:
                {
                    $prefixTitleData = ' webpush ';
                    break;
                }
        }

        return $prefixTitleData . $titel . $prefixTitleData;
    }

    private function createAndroidNotification()
    {
        // generate click_action msg body for android notification-3-click_action
        $click_action = new ClickAction();
        $click_action->setType(2);
        $click_action->setType(1);

        $click_action->setIntent("#Intent;compo=com.rvr/.Activity;S.W=U;end");
        $click_action->setAction("test add");
        $click_action->setUrl("https://www.baidu.com");
        $click_action->setRichResource("test rich resource");
        $click_action->buildFields();

        // generate Badge for android notification-3-badge
        $badge = new Badge();
        $badge->addNum(99);
        $badge->setClass("Classic");
        $badge->setNum(99);
        $badge->buildFields();

        // generate Light Settings for android notification-3-badge
        $lightSetting = new LightSetting();
        $lightSetting->setLightOnDuration("3.5");
        $lightSetting->setLightOffDuration("5S");
        // set light setting color
        $LightSettingColor = new LightSettingColor();
        $LightSettingColor->setGenFullcolor(0, 0, 1, 1);
        $LightSettingColor->buildFields();
        $lightSetting->setColor($LightSettingColor->getFields());
        $lightSetting->buildFields();

        // 构建android notification消息体-2 for android config
        $android_notification = new AndroidNotification();
        $android_notification->setTitle($this->getDefaultAndroidNotificationContent("default hw title "));
        $android_notification->setBody($this->getDefaultAndroidNotificationContent("default hw body"));
        $android_notification->setIcon("https://res.vmallres.com/pimages//common/config/logo/SXppnESYv4K11DBxDFc2.png");
        $android_notification->setColor("#AACCDD");
        $android_notification->setSound("https://att.chinauui.com/day_120606/20120606_7fcf2235b44f1eab0b4dadtAkAGMTBHK.mp3");
        $android_notification->setTag("tagBoom");
        $android_notification->setBodyLocKey("M.String.body");
        $android_notification->setBodyLocArgs(array(
            "Boy",
            "Dog"
        ));
        $android_notification->setTitleLocKey("M.String.title");
        $android_notification->setTitleLocArgs(array(
            "Girl",
            "Cat"
        ));
        $android_notification->setChannelId("RingRing");
        $android_notification->setNotifySummary("Some Summary");
        $android_notification->setImage("https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png");
        $android_notification->setStyle(0);
        $android_notification->setBigTitle("Big Boom Title");
        $android_notification->setBigBody("Big Boom Body");
        $android_notification->setAutoClear(86400000);
        $android_notification->setNotifyId(486);
        $android_notification->setGroup("Espace");
        $android_notification->setImportance(NotificationPriority::NOTIFICATION_PRIORITY_NORMAL);
        $android_notification->setTicker("i am a ticker");
        $android_notification->setAutoCancel(false);
        $android_notification->setWhen("2019-11-05");
        $android_notification->setUseDefaultVibrate(true);
        $android_notification->setUseDefaultLight(false);
        $android_notification->setVisibility("PUBLIC");
        $android_notification->setForegroundShow(true);
        $android_notification->setVibrateConfig(array(
            "1.5",
            "2.000000001",
            "3"
        ));
        $android_notification->setClickAction($click_action->getFields());
        $android_notification->setBadge($badge->getFields());
        $android_notification->setLightSettings($lightSetting->getFields());

        $android_notification->buildFields();

        return $android_notification;
    }

    private function createAndroidConfig()
    {
        $android_notification = $this->createAndroidNotification();

        $android_config = new AndroidConfig();
        $android_config->setCollapseKey(- 1);
        $android_config->setUrgency(AndroidConfigDeliveryPriority::PRIORITY_HIGH);
        $android_config->setTtl("1448s");
        $android_config->setBiTag("Trump");
        if ($this->push_msg_type == Constants::PUSHMSG_FASTAPP_MSG_TYPE) {
            $android_config->setFastAppTarget(1);
        } else {
            $android_config->setNotification($android_notification->getFields());
        }
        $android_config->buildFields();
        return $android_config;
    }

    private function createNotification()
    {
        $notification = new Notification("Big News", "This is a Big News!", "https://res.vmallres.com/pimages//common/config/logo/SXppnESYv4K11DBxDFc2_0.png");
        $notification->buildFields();
        return $notification;
    }

    private function createApnsConfig()
    {
        // ApnsHeaders
        $apnsHeaders = new ApnsHeaders();
        $apnsHeaders->setApnsTopic("hmspush");
        $apnsHeaders->setApnsPriority(ApnConstant::ANP_PRIORITY_SEND_IMMEDIATELY);
        $apnsHeaders->buildFields();

        // ApnHmsOptions
        $apnsHmsOptions = new ApnsHmsOptions();
        $apnsHmsOptions->setTargetUserType(ApnConstant::APN_TARGET_USER_TEST_USER);
        $apnsHmsOptions->buildFields();

        // Aps
        // Alert
        $alert = new Alert();
        $alert->setTitle("hw default ios message title");
        $alert->setBody("hw default ios message body");
        $alert->setActionLocKey("PLAY");
        $alert->buildFields();

        $aps = new Aps();
        $aps->setAlert($alert->getFields());
        $aps->setBadge(5);
        $aps->buildFields();

        $apnsConfig = new ApnsConfig();
        $apnsConfig->setHeaders($apnsHeaders->getFields());
        $apnsConfig->setHmsOptions($apnsHmsOptions->getFields());

        $apn_payload["aps"] = $aps->getFields();
        $apn_payload["acme1"] = "bar";
        $apn_payload["acme2"] = array(
            "bang",
            "whiz"
        );
        $apnsConfig->setPayload($apn_payload);

        $apnsConfig->buildFields();

        return $apnsConfig;
    }

    private function createWebPush()
    {
        $webPushConfig = new WebPushConfig();
        $webPushConfig->setData("test webpush data");

        $webPushHeaders = new WebPushHeaders();
        $webPushHeaders->setTopic("12313ceshi");
        $webPushHeaders->setTtl("990");
        $webPushHeaders->setUrgency(Constants::WEBPUSH_URGENCY_VERY_LOW);
        $webPushHeaders->buildFields();
        $webPushConfig->setHeaders($webPushHeaders->getFields());

        $webPushHmsOptions = new WebPushHmsOptions();
        $webPushHmsOptions->setLink("https://www.huawei.com/");
        $webPushHmsOptions->buildFields();
        $webPushConfig->setHmsOptions($webPushHmsOptions->getFields());

        $webPUshNotionfication = new WebPushNotification();
        $webPUshNotionfication->setTitle("notication string");
        $webPUshNotionfication->setBody("web push body");
        $webPUshNotionfication->setIcon("https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png");
        $webPUshNotionfication->setImage("https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png");
        $webPUshNotionfication->setLang("string");
        $webPUshNotionfication->setTag("string");
        $webPUshNotionfication->setBadge("string");
        $webPUshNotionfication->setDir("auto");
        $webPUshNotionfication->setVibrate(array(
            1,
            2,
            3
        ));
        $webPUshNotionfication->setRenotify(false);
        $webPUshNotionfication->setRequireInteraction(false);
        $webPUshNotionfication->setSilent(false);
        $webPUshNotionfication->setTimestamp(1545201266);
        $webPushNotificationAction = new WebPushNotificationAction();
        $webPushNotificationAction->setTitle("string");
        $webPushNotificationAction->setAction("123");
        $webPushNotificationAction->setIcon("https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png");
        $webPushNotificationAction->buildFields();
        $webPUshNotionfication->setActions(array(
            $webPushNotificationAction->getFields()
        ));
        $webPUshNotionfication->buildFields();
        $webPushConfig->setNotification($webPUshNotionfication->getFields());
        $webPushConfig->buildFields();

        return $webPushConfig;
    }

    private function printLogMethodOperate($dataFlow, $functionName = "", $logLevel = "")
    {
        $logModule = Constants::HW_PUSH_LOG_PUSH_MSG_MODULE;

        if (empty($logLevel)) {
            $logLevel = Constants::HW_PUSH_LOG_INFO_LEVEL;
        }

        if (empty($functionName)) {
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . ']' . $dataFlow, $logLevel, $logModule);
        } else {
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . ']' . '[' . $functionName . ']' . $dataFlow, $logLevel, $logModule);
        }
    }

    private function createApplication($application_server)
    {
        $this->printLogMethodOperate("createApplication push_msg_type:".$this->push_msg_type, __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        if ($this->push_msg_type == Constants::PUSHMSG_FASTAPP_MSG_TYPE) {
            $this->printLogMethodOperate("createApplication PUSHMSG_FASTAPP_MSG_TYPE", __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
            $application = new Application($this->fast_appid, $this->fast_appsecret, $this->hw_token_server, $application_server);
            return $application;
        }
        $application = new Application($this->appid, $this->appsecret, $this->hw_token_server, $application_server);
        return $application;
    }

    private function getMessageByMsgType($msg_type)
    {
        switch ($msg_type) {
            case Constants::PUSHMSG_NOTIFICATION_MSG_TYPE:
                {
                    return $this->createNotificationMsg();
                }
            case Constants::PUSHMSG_PASS_THROUGHT_MSG_TYPE:
                {
                    return $this->createPassThroughMsg();
                }

            case Constants::PUSHMSG_FASTAPP_MSG_TYPE:
                {
                    return $this->createFastAppMsg();
                }
            case Constants::PUSHMSG_TOPIC_MSG_TYPE:
                {
                    return $this->createTopicMsg();
                }
            case Constants::PUSHMSG_CONDITION_MSG_TYPE:
                {
                    return $this->createConditionMsg();
                }

            case Constants::APN_MSG_TYPE:
                {
                    return $this->createApnsMsg();
                }
            case Constants::WEB_PUSH_MSG_TYPE:
                {
                    return $this->createWebPushMsg();
                }
        }
    }
    
    private function createFastAppConfigNotificationData()
    {
        $instanceAppConfig = new InstanceAppConfig();
        $instanceAppConfig->setPushType(0);
        
        $instanceAppPushbody = new InstanceAppPushbody();
        $instanceAppPushbody->setTitle("test fast app");
        $instanceAppPushbody->setDescription("test fast app description");
        $instanceAppPushbody->setPage("/");
        $instanceAppPushbody->setParams(array(
            "key1"=>"test1",
            "key2"=>"test2"
        ));
        
        $instanceAppRingtone = new InstanceAppRingtone();
        $instanceAppRingtone->setBreathLight(true);
        $instanceAppRingtone->setVibration(true);
        $instanceAppRingtone->buildFields();
        
        $instanceAppPushbody->setRingtone($instanceAppRingtone->getFields());
        $instanceAppPushbody->buildFields();
        
        $instanceAppConfig->setPushBody($instanceAppPushbody->getFields());
        $instanceAppConfig->buildFields();
        
        return $instanceAppConfig;
    }
    
    private function createFastAppConfigPassThroughData()
    {
        $instanceAppConfig = new InstanceAppConfig();
        $instanceAppConfig->setPushType(1);
        
        $instanceAppPushbody = new InstanceAppPushbody();
        $instanceAppPushbody->setMessageId("111110001");
        $instanceAppPushbody->setData("hw default passthroug test");
        $instanceAppPushbody->buildFields();
        
        $instanceAppConfig->setPushBody($instanceAppPushbody->getFields());
        $instanceAppConfig->buildFields();
        
        return $instanceAppConfig;
    }

    private function createFastAppMsg()
    {
        $this->printLogMethodOperate("push msg notification start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();

        $message->setData($this->createFastAppConfigNotificationData()->getFields());

        $message->setAndroid($this->createAndroidConfig()
            ->getFields());
 
        $message->setToken(array(
            $this->fast_push_token
        ));

        $message->buildFields();
        $this->printLogMethodOperate("push msg notification end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }

    private function createNotificationMsg()
    {
        $this->printLogMethodOperate("push msg notification start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();

        $message->setAndroid($this->createAndroidConfig()
            ->getFields());
        $message->setNotification($this->createNotification()
            ->getFields());

        $message->setToken(array(
            $this->hw_push_token_key
        ));

        $message->buildFields();
        $this->printLogMethodOperate("push msg notification end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }

    private function createTopicMsg()
    {
        $this->printLogMethodOperate("push msg createTopicMsg start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();

        $message->setAndroid($this->createAndroidConfig()
            ->getFields());
        // $message->notification($this->createNotification()->buildFields());

        $message->setTopic($this->default_topic);

        $message->buildFields();
        $this->printLogMethodOperate("push msg createTopicMsg end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }

    private function createConditionMsg()
    {
        $this->printLogMethodOperate("push msg createTopicMsg start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();

        $message->setAndroid($this->createAndroidConfig()
            ->getFields());
        // $message->notification($this->createNotification()->buildFields());
        $message->setCondition("'defaultTopic' in topics");
        // $message->condition("'weather' in topics || ('TopicB' in topics && 'TopicC' in topics)");

        $message->buildFields();
        $this->printLogMethodOperate("push msg createTopicMsg end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }

    private function createPassThroughMsg()
    {
        $this->printLogMethodOperate("push msg passthrough start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();

        $message->setData("1111");
        $message->setToken(array(
            $this->hw_push_token_key
        ));

        $message->buildFields();
        $this->printLogMethodOperate("push msg passthrough end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }

    private function createApnsMsg()
    {
        $this->printLogMethodOperate("push msg apns start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();
        $apnsConfig = $this->createApnsConfig();
        $message->setApns($apnsConfig->getFields());

        $message->setToken(array(
            $this->apn_push_token_key
        ));
        $message->buildFields();

        $this->printLogMethodOperate("push msg apns end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }

    private function createWebPushMsg()
    {
        $this->printLogMethodOperate("push msg webpush start", __FUNCTION__ . ':' . __LINE__);
        $message = new PushMessage();

        $message->setWebpush($this->createWebPush()
            ->getFields());
        $message->setToken(array(
            $this->webpush_push_token_key
        ));

        PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . ']' . '[web-token:' . json_encode($message->getToken()) . ']', Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        $message->buildFields();

        $this->printLogMethodOperate("push msg webpush end", __FUNCTION__ . ':' . __LINE__);
        return $message;
    }
}
