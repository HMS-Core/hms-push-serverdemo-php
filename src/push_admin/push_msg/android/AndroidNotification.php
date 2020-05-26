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

namespace push_admin\push_msg\android;

include_once (dirname(__FILE__) . '/../../Constants.php');
include_once (dirname(__FILE__) . '/../ValidatorUtil.php');

use push_admin\ValidatorUtil;
use push_admin\Constants;
use push_admin\NotificationPriority;
use push_admin\Visibility;
use Exception;
use push_admin\PushLogConfig;

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

    private $click_action;

    private $body_loc_key;

    private $body_loc_args;

    private $title_loc_key;

    private $title_loc_args;

    private $channel_id;

    private $notify_summary;

    private $image;

    private $notify_icon;

    /**
     * notification style:
     * 0：default
     * 1：big text
     * 2：big photo
     */
    private $style;

    private $big_title;

    private $big_body;

    private $auto_clear;

    private $notify_id;

    private $group;

    private $badge;

    private $ticker;

    private $auto_cancel;

    private $when;

    private $importance;

    private $use_default_vibrate;

    private $use_default_light;

    private $vibrate_config;

    private $visibility;

    private $light_settings;

    private $foreground_show;

    private $fields;

    public function __construct()
    {
        $this->click_action = array();
        $this->body_loc_args = array();
        $this->title_loc_args = array();
        $this->badge = array();
        $this->light_settings = array();
        $this->foreground_show = true;
        $this->fields = array();
    }

    public function title($value)
    {
        $this->title = $value;
    }

    public function body($value)
    {
        $this->body = $value;
    }

    public function icon($value)
    {
        $this->icon = $value;
    }

    public function color($value)
    {
        $this->color = $value;
    }

    public function sound($value)
    {
        $this->sound = $value;
    }

    public function tag($value)
    {
        $this->tag = $value;
    }

    public function click_action($value)
    {
        $this->click_action = $value;
    }

    public function body_loc_key($value)
    {
        $this->body_loc_key = $value;
    }

    public function body_loc_args($value)
    {
        $this->body_loc_args = $value;
    }

    public function title_loc_key($value)
    {
        $this->title_loc_key = $value;
    }

    public function title_loc_args($value)
    {
        $this->title_loc_args = $value;
    }

    public function channel_id($value)
    {
        $this->channel_id = $value;
    }

    public function notify_summary($value)
    {
        $this->notify_summary = $value;
    }

    // added
    public function image($value)
    {
        $this->image = $value;
    }

    public function notify_icon($value)
    {
        $this->notify_icon = $value;
    }

    public function style($value)
    {
        $this->style = $value;
    }

    public function big_title($value)
    {
        $this->big_title = $value;
    }

    public function big_body($value)
    {
        $this->big_body = $value;
    }

    public function auto_clear($value)
    {
        $this->auto_clear = $value;
    }

    public function notify_id($value)
    {
        $this->notify_id = $value;
    }

    public function group($value)
    {
        $this->group = $value;
    }

    public function badge($value)
    {
        $this->badge = $value;
    }

    public function ticker($value)
    {
        $this->ticker = $value;
    }

    public function auto_cancel($value)
    {
        $this->auto_cancel = $value;
    }

    public function when($value)
    {
        $this->when = $value;
    }

    public function importance($value)
    {
        $this->importance = $value;
    }

    public function use_default_vibrate($value)
    {
        $this->use_default_vibrate = $value;
    }

    public function use_default_light($value)
    {
        $this->use_default_light = $value;
    }

    public function vibrate_config($value)
    {
        $this->vibrate_config = $value;
    }

    public function visibility($value)
    {
        $this->visibility = $value;
    }

    public function light_settings($value)
    {
        $this->light_settings = $value;
    }

    public function foreground_show($value)
    {
        $this->foreground_show = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        try {
            $this->check_parameter();
        } catch (Exception $e) {
            PushLogConfig::getSingleInstance()->LogMessage($e,Constants::HW_PUSH_LOG_ERROR_LEVEL);
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
            'click_action',
            'body_loc_key',
            'body_loc_args',
            'title_loc_key',
            'title_loc_args',
            'channel_id',
            'notify_summary',
            'notify_icon',
            'style',
            'big_title',
            'big_body',
            'auto_clear',
            'notify_id',
            'group',
            'badge',
            'ticker',
            'auto_cancel',
            'when',
            'importance',
            'use_default_vibrate',
            'use_default_light',
            'vibrate_config',
            'visibility',
            'light_settings',
            'foreground_show'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter()
    {
        if (empty($this->title))
        {
            throw new Exception("title should be set");
        }
        if (empty($this->body))
        {
            throw new Exception("body should be set");
        }
        
        if (! empty($this->color)) {
            if (FALSE == ValidatorUtil::validatePattern(Constants::COLOR_PATTERN, $this->color)) {
                throw new Exception("Wrong color format, color must be in the form #RRGGBB");
            }
        }

        if (! empty($this->body_loc_args) && empty($this->body_loc_key)) {
            throw new Exception("bodyLocKey is required when specifying bodyLocArgs");
        }

        if (! empty($this->title_loc_args) && empty($this->title_loc_key)) {
            throw new Exception("titleLocKey is required when specifying titleLocArgs");
        }

        if (! empty($this->image)) {
            if (FALSE == ValidatorUtil::validatePattern(Constants::URL_PATTERN, $this->image)) { 
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
        if (! empty($this->vibrate_config)) {
            foreach ($this->vibrate_config as $key) {
                if (FALSE == ValidatorUtil::validatePattern(Constants::VIBRATE_PATTERN, $key)) {
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
        if (($this->auto_clear) && (gettype($this->auto_clear) != "integer")) {
            throw new Exception("type of auto_clear is wrong.");
        }
        // notify_id
        if (($this->notify_id) && (gettype($this->notify_id) != "integer")) {
            throw new Exception("type of notify_id is wrong.");
        }
        

    }
}