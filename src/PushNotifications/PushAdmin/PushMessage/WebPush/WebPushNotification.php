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

/**
 * function: WebPushNotification class  =>WebPushConfig(notification)
 *                                      =>PushMessage(webpush)
 */
namespace Huawei\PushNotifications\PushAdmin\PushMessage\WebPush;

use Exception;

class WebPushNotification
{
    private $title;
    private $body;
    private $icon;
    private $image;
    private $lang;
    private $tag;
    private $badge;
    private $dir;
    private $vibrate;
    private $renotify;
    private $requireInteraction;
    private $silent;
    private $timestamp;
    private $actions;
    private $fields;

    public function __construct()
    {
        $this->actions = array();
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

    public function setImage($value)
    {
        $this->image = $value;
    }

    public function setLang($value)
    {
        $this->lang = $value;
    }

    public function setTag($value)
    {
        $this->tag = $value;
    }

    public function setBadge($value)
    {
        $this->badge = $value;
    }
    
    public function setDir($value)
    {
        $this->dir = $value;
    }

    public function setVibrate($value)
    {
        $this->vibrate = $value;
    }

    public function setRenotify($value)
    {
        $this->renotify = $value;
    }

    public function setRequireInteraction($value)
    {
        $this->requireInteraction = $value;
    }
    
    public function setSilent($value)
    {
        $this->silent = $value;
    }

    public function setTimestamp($value)
    {
        $this->timestamp = $value;
    }

    public function setActions($value)
    {
        $this->actions = $value;
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
            echo $e;
        }

        $keys = array(
            'title',
            'body',
            'icon',
            'image',
            'lang',
            'tag',
            'badge',
            'dir',
            'vibrate',
            'renotify',
            'requireInteraction',
            'silent',
            'timestamp',
            'actions'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function checkParameter()
    {
        if (($this->renotify) && (gettype($this->renotify) != "boolean")) {
            throw new Exception("type of renotify is wrong.");
        }
        if (($this->requireInteraction) && (gettype($this->requireInteraction) != "boolean")) {
            throw new Exception("type of requireInteraction is wrong.");
        }
        if (($this->silent) && (gettype($this->silent) != "boolean")) {
            throw new Exception("type of silent is wrong.");
        }
    }
}
