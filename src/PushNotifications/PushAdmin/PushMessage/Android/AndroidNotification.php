<?php
/**
Copyright 2020. Huawei Technologies Co., Ltd. All rights reserved.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */

namespace Huawei\PushNotifications\PushAdmin\PushMessage\Android;

use Exception;
use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\PushNotifications\PushAdmin\PushLogConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\ValidatorUtil;
use Huawei\PushNotifications\PushAdmin\NotificationPriority;
use Huawei\PushNotifications\PushAdmin\Visibility;

/**
 * optional for android config
 */
class AndroidNotification
{
    private $title;
    private $body;
    private $icon;
    private $color;
    private $sound;
    private $tag;
    private $clickAction;
    private $bodyLocKey;
    private $bodyLocArgs;
    private $titleLocKey;
    private $titleLocArgs;
    private $channelId;
    private $notifySummary;
    private $image;
    private $notifyIcon;

    /**
     * notification style:
     * 0：default
     * 1：big text
     * 2：big photo
     */
    private $style;
    private $bigTitle;
    private $bigBody;
    private $autoClear;
    private $notifyId;
    private $group;
    private $badge;
    private $ticker;
    private $autoCancel;
    private $when;
    private $importance;
    private $useDefaultVibrate;
    private $useDefaultLight;
    private $vibrateConfig;
    private $visibility;
    private $lightSettings;
    private $foregroundShow;
    private $fields;

    public function __construct()
    {
        $this->clickAction = array();
        $this->bodyLocArgs = array();
        $this->titleLocArgs = array();
        $this->badge = array();
        $this->lightSettings = array();
        $this->foregroundShow = true;
        $this->fields = array();
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function setBody($value)
    {
        $this->body = $value;
    }

    public function setIcon($value)
    {
        $this->icon = $value;
    }

    public function setColor($value)
    {
        $this->color = $value;
    }

    public function setSound($value)
    {
        $this->sound = $value;
    }

    public function setTag($value)
    {
        $this->tag = $value;
    }

    public function setClickAction($value)
    {
        $this->clickAction = $value;
    }

    public function setBodyLocKey($value)
    {
        $this->bodyLocKey = $value;
    }

    public function setBodyLocArgs($value)
    {
        $this->bodyLocArgs = $value;
    }

    public function setTitleLocKey($value)
    {
        $this->titleLocKey = $value;
    }

    public function setTitleLocArgs($value)
    {
        $this->titleLocArgs = $value;
    }

    public function setChannelId($value)
    {
        $this->channelId = $value;
    }

    public function setNotifySummary($value)
    {
        $this->notifySummary = $value;
    }

    // added
    public function setImage($value)
    {
        $this->image = $value;
    }

    public function setNotifyIcon($value)
    {
        $this->notifyIcon = $value;
    }

    public function setStyle($value)
    {
        $this->style = $value;
    }

    public function setBigTitle($value)
    {
        $this->bigTitle = $value;
    }

    public function setBigBody($value)
    {
        $this->bigBody = $value;
    }

    public function setAutoClear($value)
    {
        $this->autoClear = $value;
    }

    public function setNotifyId($value)
    {
        $this->notifyId = $value;
    }

    public function setGroup($value)
    {
        $this->group = $value;
    }

    public function setBadge($value)
    {
        $this->badge = $value;
    }

    public function setTicker($value)
    {
        $this->ticker = $value;
    }

    public function setAutoCancel($value)
    {
        $this->autoCancel = $value;
    }

    public function setWhen($value)
    {
        $this->when = $value;
    }

    public function setImportance($value)
    {
        $this->importance = $value;
    }

    public function setUseDefaultVibrate($value)
    {
        $this->useDefaultVibrate = $value;
    }

    public function setUseDefaultLight($value)
    {
        $this->useDefaultLight = $value;
    }

    public function setVibrateConfig($value)
    {
        $this->vibrateConfig = $value;
    }

    public function setVisibility($value)
    {
        $this->visibility = $value;
    }

    public function setLightSettings($value)
    {
        $this->lightSettings = $value;
    }

    public function setForegroundShow($value)
    {
        $this->foregroundShow = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        try {
            $this->checkParameter();
        } catch (Exception $e) {
            PushLogConfig::getSingleInstance()->LogMessage($e, Constants::HW_PUSH_LOG_ERROR_LEVEL);
            return;
        }

        $keys = array(
            'title',
            'body',
            'image',
            'icon',
            'color',
            'sound',
            'tag',
            'clickAction',
            'bodyLocKey',
            'bodyLocArgs',
            'titleLocKey',
            'titleLocArgs',
            'channelId',
            'notifySummary',
            'notifyIcon',
            'style',
            'bigTitle',
            'bigBody',
            'autoClear',
            'notifyId',
            'group',
            'badge',
            'ticker',
            'autoCancel',
            'when',
            'importance',
            'useDefaultVibrate',
            'useDefaultLight',
            'vibrateConfig',
            'visibility',
            'lightSettings',
            'foregroundShow'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function checkParameter()
    {
        if (empty($this->title)) {
            throw new Exception("title should be set");
        }
        if (empty($this->body)) {
            throw new Exception("body should be set");
        }
        
        if (! empty($this->color)) {
            if (false == ValidatorUtil::validatePattern(Constants::COLOR_PATTERN, $this->color)) {
                throw new Exception("Wrong color format, color must be in the form #RRGGBB");
            }
        }

        if (! empty($this->bodyLocArgs) && empty($this->bodyLocKey)) {
            throw new Exception("bodyLocKey is required when specifying bodyLocArgs");
        }

        if (! empty($this->titleLocArgs) && empty($this->titleLocKey)) {
            throw new Exception("titleLocKey is required when specifying titleLocArgs");
        }

        if (! empty($this->image)) {
            if (false == ValidatorUtil::validatePattern(Constants::URL_PATTERN, $this->image)) {
                throw new Exception("notifyIcon must start with https");
            }
        }

        if (($this->style) && (gettype($this->style) != "integer")) {
            throw new Exception("type of style is wrong.");
        }

        if (! in_array($this->style, array(
            0,
            1
        ))) {
            throw new Exception("style should be one of 0:default, 1: big text");
        }

        // importance
        if (! empty($this->importance) && ! in_array($this->importance, array(
            NotificationPriority::NOTIFICATION_PRIORITY_LOW,
            NotificationPriority::NOTIFICATION_PRIORITY_NORMAL,
            NotificationPriority::NOTIFICATION_PRIORITY_HIGH,
        ))) {
            throw new Exception("notification priority shouid be [LOW,NORMAL,HIGH]");
        }

        // vibrate_config
        if (! empty($this->vibrateConfig)) {
            foreach ($this->vibrateConfig as $key) {
                if (false == ValidatorUtil::validatePattern(Constants::VIBRATE_PATTERN, $key)) {
                    throw new Exception("Wrong vibrate timing format");
                }
            }
        }

        // visibility
        if (! empty($this->visibility) && ! in_array($this->visibility, array(
            Visibility::VISIBILITY_UNSPECIFIED,
            Visibility::PRIVATE_STR,
            Visibility::PUBLIC_STR,
            Visibility::SECRET_STR
        ))) {
            throw new Exception("visibility shouid be [VISIBILITY_UNSPECIFIED, PRIVATE, PUBLIC, SECRET]");
        }

        // auto_clear
        if (($this->autoClear) && (gettype($this->autoClear) != "integer")) {
            throw new Exception("type of auto_clear is wrong.");
        }
        // notify_id
        if (($this->notifyId) && (gettype($this->notifyId) != "integer")) {
            throw new Exception("type of notify_id is wrong.");
        }
    }
}
